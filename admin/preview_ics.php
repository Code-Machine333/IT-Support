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
    echo "<p>You must be logged in to preview ICS files.</p>";
    echo "<p><a href='index.php'>Login</a></p>";
    exit;
}

require_once 'generate_ics.php';

// Collect and validate milestone/project data from request
$projectname   = $_REQUEST['projectname'] ?? '';
$milestone     = $_REQUEST['milestone'] ?? '';
$date_start    = $_REQUEST['date_start'] ?? '';
$date_end      = $_REQUEST['date_end'] ?? '';
$description   = $_REQUEST['description'] ?? '';
$timezone      = $_REQUEST['timezone'] ?? '';
$user_id       = $_SESSION['user_id'];

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
    
    // Display as HTML preview
    header('Content-Type: text/html; charset=utf-8');
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ICS Preview - <?php echo htmlspecialchars($summary); ?></title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
            .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .header { border-bottom: 2px solid #007cba; padding-bottom: 15px; margin-bottom: 20px; }
            .event-info { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
            .event-info h3 { margin-top: 0; color: #007cba; }
            .event-info p { margin: 5px 0; }
            .ics-content { background: #f8f9fa; border: 1px solid #ddd; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 12px; white-space: pre-wrap; max-height: 400px; overflow-y: auto; }
            .buttons { margin-top: 20px; text-align: center; }
            .btn { display: inline-block; padding: 10px 20px; margin: 5px; text-decoration: none; border-radius: 5px; font-weight: bold; }
            .btn-primary { background: #007cba; color: white; }
            .btn-secondary { background: #6c757d; color: white; }
            .btn-success { background: #28a745; color: white; }
            .btn:hover { opacity: 0.8; }
            .all-day-badge { background: #28a745; color: white; padding: 2px 8px; border-radius: 3px; font-size: 12px; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>📅 Calendar Event Preview</h1>
                <p>Review your calendar event before adding it to your calendar</p>
            </div>
            
            <div class="event-info">
                <h3><?php echo htmlspecialchars($summary); ?></h3>
                <p><strong>Start Date:</strong> <?php echo htmlspecialchars($date_start); ?></p>
                <p><strong>End Date:</strong> <?php echo htmlspecialchars($date_end); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($description ?: 'No description'); ?></p>
                <p><strong>Timezone:</strong> <?php echo htmlspecialchars($timezone); ?></p>
                <p><strong>Event Type:</strong> <span class="all-day-badge">ALL DAY EVENT</span></p>
            </div>
            
            <h3>ICS File Content:</h3>
            <div class="ics-content"><?php echo htmlspecialchars($icsContent); ?></div>
            
            <div class="buttons">
                <a href="download_ics.php?date_start=<?php echo urlencode($date_start); ?>&date_end=<?php echo urlencode($date_end); ?>&projectname=<?php echo urlencode($projectname); ?>&milestone=<?php echo urlencode($milestone); ?>&description=<?php echo urlencode($description); ?>&timezone=<?php echo urlencode($timezone); ?>" class="btn btn-success">📥 Download ICS File</a>
                <a href="javascript:history.back()" class="btn btn-secondary">← Go Back</a>
                <button onclick="window.close()" class="btn btn-primary">✕ Close Preview</button>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
} catch (Exception $e) {
    // Log error with more context
    error_log("ICS Preview Error for User {$user_id}: " . $e->getMessage() . " | Data: " . json_encode($event_data));
    
    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo "<h2>Error Generating ICS Preview</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Please try again or contact support if the problem persists.</p>";
    echo "<p><a href='javascript:history.back()'>Go Back</a></p>";
    exit;
}
?>
