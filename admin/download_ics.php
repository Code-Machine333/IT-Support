<?php
session_start();

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Check if user is authenticated
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    http_response_code(401);
    header('Content-Type: text/html; charset=utf-8');
    echo "<h2>Unauthorized Access</h2>";
    echo "<p>You must be logged in to download ICS files.</p>";
    echo "<p><a href='index.php'>Login</a></p>";
    exit;
}

require_once 'generate_ics.php';

// Rate limiting (simple implementation)
$user_id = $_SESSION['user_id'];
$rate_limit_file = sys_get_temp_dir() . '/ics_download_' . $user_id . '.txt';
$current_time = time();
$rate_limit_window = 300; // 5 minutes
$max_downloads = 10; // Max 10 downloads per 5 minutes

if (file_exists($rate_limit_file)) {
    $downloads = json_decode(file_get_contents($rate_limit_file), true) ?: [];
    $downloads = array_filter($downloads, function($timestamp) use ($current_time, $rate_limit_window) {
        return ($current_time - $timestamp) < $rate_limit_window;
    });
    
    if (count($downloads) >= $max_downloads) {
        http_response_code(429);
        header('Content-Type: text/html; charset=utf-8');
        echo "<h2>Rate Limit Exceeded</h2>";
        echo "<p>Too many download requests. Please try again later.</p>";
        exit;
    }
    
    $downloads[] = $current_time;
    file_put_contents($rate_limit_file, json_encode($downloads));
} else {
    file_put_contents($rate_limit_file, json_encode([$current_time]));
}

// Collect and validate milestone/project data from request
$projectname   = $_REQUEST['projectname'] ?? '';
$milestone     = $_REQUEST['milestone'] ?? '';
$date_start    = $_REQUEST['date_start'] ?? '';
$date_end      = $_REQUEST['date_end'] ?? '';
$description   = $_REQUEST['description'] ?? '';
$timezone      = $_REQUEST['timezone'] ?? '';
$user_id       = $_SESSION['user_id']; // Use session user_id for security

// Validate required fields
if (empty($projectname) || empty($milestone)) {
    http_response_code(400);
    header('Content-Type: text/html; charset=utf-8');
    echo "<h2>Invalid Request</h2>";
    echo "<p>Project name and milestone are required.</p>";
    echo "<p><a href='javascript:history.back()'>Go Back</a></p>";
    exit;
}

// Sanitize inputs
$projectname = trim(htmlspecialchars($projectname, ENT_QUOTES, 'UTF-8'));
$milestone = trim(htmlspecialchars($milestone, ENT_QUOTES, 'UTF-8'));
$description = trim(htmlspecialchars($description, ENT_QUOTES, 'UTF-8'));

// Convert to date-only format for all-day events
if (!empty($date_start)) {
    $date_start = date('Y-m-d', strtotime($date_start));
}
if (!empty($date_end)) {
    $date_end = date('Y-m-d', strtotime($date_end));
}

// Build summary: {ProjectName}--{MilestoneName}
$summary = $projectname . '--' . $milestone;

$event_data = [
    'date_start'   => $date_start,
    'date_end'     => $date_end,
    'projectname'  => $summary, 
    'description'  => $description,
    'timezone'     => $timezone,
    'user_id'      => $user_id,
    'all_day'      => true  // Force all-day event
];

try {
    $icsContent = generateICSContent($event_data); 

    // Generate secure filename
    $base_name = preg_replace('/[^a-zA-Z0-9\s-]/', '', $projectname);
    $date_part = '';
    if (!empty($date_start)) {
        try {
            $date_part = (new DateTime($date_start))->format('Y-m-d');
        } catch (Exception $e) {
            $date_part = date('Y-m-d');
        }
    }
    $filename = strtolower(str_replace(' ', '_', trim($base_name)) . ($date_part ? '_' . $date_part : '')) . '.ics';
    
    // Security: Ensure filename is safe
    $filename = basename($filename);
    if (empty($filename) || $filename === '.ics') {
        $filename = 'milestone_' . date('Y-m-d') . '.ics';
    }

    // Set headers for ICS file to open directly in calendar
    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($icsContent));
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    header('Pragma: no-cache');

    echo $icsContent;
    exit;
} catch (Exception $e) {
    // Log error with more context
    error_log("ICS Generation Error for User {$user_id}: " . $e->getMessage() . " | Data: " . json_encode($event_data));
    
    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo "<h2>Error Generating ICS File</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Please try again or contact support if the problem persists.</p>";
    echo "<p><a href='javascript:history.back()'>Go Back</a></p>";
    exit;
}
