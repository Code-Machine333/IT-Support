<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

function getUserTimezone($request, $user_profile = null) {
    // Priority 1: Explicit timezone in request
    if (isset($request['timezone']) && !empty($request['timezone'])) {
        return validateTimezone($request['timezone']);
    }
    
    // Priority 2: User profile timezone
    if ($user_profile && isset($user_profile['timezone'])) {
        return validateTimezone($user_profile['timezone']);
    }
    
    // Priority 3: Fetch from database if user_id provided
    if (isset($request['user_id']) && !empty($request['user_id'])) {
        $user_id = intval($request['user_id']);
        if ($user_id <= 0) {
            return 'America/Chicago';
        }
        
        include('includes/dbconnection.php');
        
        // Use prepared statement to prevent SQL injection
        $stmt = mysqli_prepare($con, "SELECT t.timezone FROM tbluser u 
                                     LEFT JOIN tbltimezone t ON u.timezone = t.id 
                                     WHERE u.ID = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($result && $row = mysqli_fetch_row($result)) {
                $user_tz = $row[0] ?: 'America/Chicago';
                mysqli_stmt_close($stmt);
                mysqli_close($con);
                return validateTimezone($user_tz);
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($con);
    }
    
    // Fallback: use America/Chicago when nothing provided
    return 'America/Chicago';
}

function validateTimezone($timezone) {
    // Map database timezone names to PHP timezone identifiers
    $timezone_map = [
        // Database timezone values to PHP timezone identifiers
        'America/Eastern' => 'America/New_York',
        'America/Central' => 'America/Chicago',
        'US/Mountain' => 'America/Denver',
        'US Pacific' => 'America/Los_Angeles',
        'US/Alaska' => 'America/Anchorage',
        'US/Hawaii' => 'Pacific/Honolulu',
        'UTC' => 'UTC'
    ];
    
    // Convert database timezone to PHP timezone
    $php_timezone = isset($timezone_map[$timezone]) ? $timezone_map[$timezone] : $timezone;
    
    // Validate timezone exists
    if (!in_array($php_timezone, DateTimeZone::listIdentifiers())) {
        return 'America/Chicago';
    }
    
    return $php_timezone;
}


function parseEventDates($date_start, $date_end, $timezone, $all_day = false) {
    // Validate timezone (already validated in getUserTimezone)
    if (!in_array($timezone, DateTimeZone::listIdentifiers())) {
        throw new Exception("Invalid timezone: {$timezone}");
    }

    if ($all_day) {
        // For all-day events, use date-only format
        $local_start = new DateTime($date_start);
        $local_end = new DateTime($date_end);
        
        // For all-day events, end date should be the same as milestone end date
        // No need to add extra day
        
        return [
            'utc_start' => null, // Not used for all-day
            'utc_end' => null,   // Not used for all-day
            'local_start' => $local_start,
            'local_end' => $local_end,
            'all_day' => true
        ];
    } else {
        // For timed events, treat provided dates as occurring in the requested timezone
        $user_tz = new DateTimeZone($timezone);
        $local_start = new DateTime($date_start, $user_tz);
        $local_end = new DateTime($date_end, $user_tz);

        // Also compute UTC stamps for DTSTAMP/servers
        $utc_start = clone $local_start; $utc_start->setTimezone(new DateTimeZone('UTC'));
        $utc_end = clone $local_end; $utc_end->setTimezone(new DateTimeZone('UTC'));

        return [
            'utc_start' => $utc_start,
            'utc_end' => $utc_end,
            'local_start' => $local_start,
            'local_end' => $local_end,
            'all_day' => false
        ];
    }
}

/**
 * Determine if the input dates represent an all-day event.
 * Rules:
 * - If either date string is in YYYY-MM-DD format (no time), treat as all-day
 * - Or if both start and end times are at 00:00:00 and represent whole days
 */
//

function formatAttendees($attendees) {
    if (empty($attendees) || !is_array($attendees)) {
        return '';
    }
    
    $formatted = '';
    foreach ($attendees as $attendee) {
        $email = isset($attendee['email']) ? $attendee['email'] : '';
        $name = isset($attendee['name']) ? $attendee['name'] : '';
        $role = isset($attendee['role']) ? $attendee['role'] : 'REQ-PARTICIPANT';
        
        if (!empty($email)) {
            $formatted .= "ATTENDEE;ROLE={$role};CN=\"{$name}\":mailto:{$email}\r\n";
        }
    }
    
    return $formatted;
}

function formatRecurrence($recurrence) {
    if (empty($recurrence) || !is_array($recurrence)) {
        return '';
    }
    
    $freq = isset($recurrence['freq']) ? $recurrence['freq'] : 'DAILY';
    $interval = isset($recurrence['interval']) ? $recurrence['interval'] : 1;
    $count = isset($recurrence['count']) ? $recurrence['count'] : '';
    $until = isset($recurrence['until']) ? $recurrence['until'] : '';
    $byday = isset($recurrence['byday']) ? $recurrence['byday'] : '';
    
    $rrule = "RRULE:FREQ={$freq};INTERVAL={$interval}";
    
    if (!empty($count)) {
        $rrule .= ";COUNT={$count}";
    }
    
    if (!empty($until)) {
        $until_date = new DateTime($until);
        $rrule .= ";UNTIL=" . $until_date->format('Ymd\THis\Z');
    }
    
    if (!empty($byday)) {
        $rrule .= ";BYDAY={$byday}";
    }
    
    return $rrule . "\r\n";
}


function validateInput($request) {
    $required = ['date_start', 'date_end', 'projectname'];
    foreach ($required as $field) {
        if (!isset($request[$field]) || empty(trim($request[$field]))) {
            throw new Exception("Missing required field: {$field}");
        }
    }
    
    // Validate dates
    if (!validateDate($request['date_start'])) {
        throw new Exception("Invalid start date format. Expected: YYYY-MM-DD or YYYY-MM-DD HH:MM:SS");
    }
    
    if (!validateDate($request['date_end'])) {
        throw new Exception("Invalid end date format. Expected: YYYY-MM-DD or YYYY-MM-DD HH:MM:SS");
    }
    
    // Validate project name length
    if (strlen(trim($request['projectname'])) > 255) {
        throw new Exception("Project name too long. Maximum 255 characters allowed.");
    }
    
    // Validate description length
    if (isset($request['description']) && strlen($request['description']) > 1000) {
        throw new Exception("Description too long. Maximum 1000 characters allowed.");
    }
    
    return true;
}

function validateDate($date) {
    if (empty($date)) return false;
    
    // Try different date formats
    $formats = ['Y-m-d H:i:s', 'Y-m-d', 'Y-m-d H:i', 'Y-m-d\TH:i:s'];
    
    foreach ($formats as $format) {
        $d = DateTime::createFromFormat($format, $date);
        if ($d && $d->format($format) === $date) {
            return true;
        }
    }
    
    return false;
}

function sanitizeInput($input) {
    if (is_string($input)) {
        return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
    }
    return $input;
}

function generateICSContent($request, $user_profile = null) {
    // Validate input
    validateInput($request);
    
    // Sanitize input
    $request = array_map('sanitizeInput', $request);
    
    $timezone = getUserTimezone($request, $user_profile);
    $all_day = isset($request['all_day']) ? $request['all_day'] : false;
    
    $dates = parseEventDates($request['date_start'], $request['date_end'], $timezone, $all_day);
    
    $uid = uniqid() . '@' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
    $created = new DateTime('now', new DateTimeZone('UTC'));
    
    if ($dates['all_day']) {
        // All-day events use date-only format
        $start_ics = $dates['local_start']->format('Ymd');
        $end_ics = $dates['local_end']->format('Ymd');
    } else {
        // Timed events use datetime format
        $start_ics = $dates['local_start']->format('Ymd\THis');
        $end_ics = $dates['local_end']->format('Ymd\THis');
    }
    $created_ics = $created->format('Ymd\THis\Z');
    
    // Helper to escape RFC5545 TEXT values
    $escape = function($text) {
        return str_replace(['\\', ';', ',', "\n", "\r"], ['\\\\', '\\;', '\\,', '\\n', '\\r'], (string)$text);
    };

    $title = $escape($request['projectname']);
    $description = isset($request['description']) ? $escape($request['description']) : '';
    $location = isset($request['location']) ? $escape($request['location']) : '';
    $organizer_email = isset($request['organizer_email']) ? trim($request['organizer_email']) : '';
    $organizer_name = isset($request['organizer_name']) ? $escape($request['organizer_name']) : '';
    
    $ics_content = "BEGIN:VCALENDAR\r\n";
    $ics_content .= "VERSION:2.0\r\n";
    $ics_content .= "PRODID:-//ICS Generator//PHP//EN\r\n";
    $ics_content .= "CALSCALE:GREGORIAN\r\n";
    $ics_content .= "METHOD:PUBLISH\r\n";


    // Add VTIMEZONE with basic rules so clients know the zone
    $tzid = $timezone;
    
    // Calendar-level metadata (helps Apple/Google)
    $ics_content .= "X-WR-CALNAME:" . $title . "\r\n";
    $ics_content .= "X-WR-TIMEZONE:" . $tzid . "\r\n";
    $ics_content .= "BEGIN:VTIMEZONE\r\n";
    $ics_content .= "TZID:" . $tzid . "\r\n";
    
    // Add timezone rules for common US timezones
    if ($tzid === 'America/Chicago') {
        $ics_content .= "BEGIN:STANDARD\r\n";
        $ics_content .= "DTSTART:19701101T020000\r\n";
        $ics_content .= "RRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU\r\n";
        $ics_content .= "TZOFFSETFROM:-0500\r\n";
        $ics_content .= "TZOFFSETTO:-0600\r\n";
        $ics_content .= "TZNAME:CST\r\n";
        $ics_content .= "END:STANDARD\r\n";
        $ics_content .= "BEGIN:DAYLIGHT\r\n";
        $ics_content .= "DTSTART:19700308T020000\r\n";
        $ics_content .= "RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU\r\n";
        $ics_content .= "TZOFFSETFROM:-0600\r\n";
        $ics_content .= "TZOFFSETTO:-0500\r\n";
        $ics_content .= "TZNAME:CDT\r\n";
        $ics_content .= "END:DAYLIGHT\r\n";
    } elseif ($tzid === 'America/New_York') {
        $ics_content .= "BEGIN:STANDARD\r\n";
        $ics_content .= "DTSTART:19701101T020000\r\n";
        $ics_content .= "RRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU\r\n";
        $ics_content .= "TZOFFSETFROM:-0400\r\n";
        $ics_content .= "TZOFFSETTO:-0500\r\n";
        $ics_content .= "TZNAME:EST\r\n";
        $ics_content .= "END:STANDARD\r\n";
        $ics_content .= "BEGIN:DAYLIGHT\r\n";
        $ics_content .= "DTSTART:19700308T020000\r\n";
        $ics_content .= "RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU\r\n";
        $ics_content .= "TZOFFSETFROM:-0500\r\n";
        $ics_content .= "TZOFFSETTO:-0400\r\n";
        $ics_content .= "TZNAME:EDT\r\n";
        $ics_content .= "END:DAYLIGHT\r\n";
    } elseif ($tzid === 'UTC') {
        $ics_content .= "BEGIN:STANDARD\r\n";
        $ics_content .= "DTSTART:19700101T000000\r\n";
        $ics_content .= "TZOFFSETFROM:+0000\r\n";
        $ics_content .= "TZOFFSETTO:+0000\r\n";
        $ics_content .= "TZNAME:UTC\r\n";
        $ics_content .= "END:STANDARD\r\n";
    }
    $ics_content .= "END:VTIMEZONE\r\n";
    $ics_content .= "BEGIN:VEVENT\r\n";
    $ics_content .= "UID:{$uid}\r\n";
    $ics_content .= "DTSTAMP:{$created_ics}\r\n";
    
    if ($dates['all_day']) {
        // All-day events don't use TZID
        $ics_content .= "DTSTART:{$start_ics}\r\n";
        $ics_content .= "DTEND:{$end_ics}\r\n";
    } else {
        // Timed events use TZID
        $ics_content .= "DTSTART;TZID={$tzid}:{$start_ics}\r\n";
        $ics_content .= "DTEND;TZID={$tzid}:{$end_ics}\r\n";
    }
    $ics_content .= "SUMMARY:{$title}\r\n";
    
    if (!empty($description)) {
        $ics_content .= "DESCRIPTION:{$description}\r\n";
    }
    if (!empty($location)) {
        $ics_content .= "LOCATION:{$location}\r\n";
    }
    if (!empty($organizer_email)) {
        $org = "ORGANIZER";
        if (!empty($organizer_name)) {
            $org .= ";CN=\"{$organizer_name}\"";
        }
        $ics_content .= $org . ":mailto:" . $organizer_email . "\r\n";
    }
    // No URL in original simplified format
    

    if (isset($request['attendees']) && is_array($request['attendees'])) {
        $ics_content .= formatAttendees($request['attendees']);
    }
    
    if (isset($request['recurrence']) && is_array($request['recurrence'])) {
        $ics_content .= formatRecurrence($request['recurrence']);
    }
    // No CATEGORIES/PRIORITY in original simplified format
    
    $ics_content .= "STATUS:CONFIRMED\r\n";
    $ics_content .= "SEQUENCE:0\r\n";
    $ics_content .= "TRANSP:TRANSPARENT\r\n"; // Free time - doesn't block calendar

    // Add a default reminder 15 minutes before (most clients support VALARM)
    $ics_content .= "BEGIN:VALARM\r\n";
    $ics_content .= "TRIGGER:-PT15M\r\n";
    $ics_content .= "ACTION:DISPLAY\r\n";
    $ics_content .= "DESCRIPTION:Reminder\r\n";
    $ics_content .= "END:VALARM\r\n";
    $ics_content .= "END:VEVENT\r\n";
    $ics_content .= "END:VCALENDAR\r\n";
    
    return $ics_content;
}

function outputICSFile($content, $filename = 'event.ics') {
    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($content));
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    echo $content;
    exit;
}

function generateICSFile($request_data, $user_profile = null) {
    try {
        $ics_content = generateICSContent($request_data, $user_profile);
        return $ics_content;
    } catch (Exception $e) {
        throw $e;
    }
}


function downloadICSFile($request_data, $user_profile = null) {
    try {
        $ics_content = generateICSContent($request_data, $user_profile);
        // Friendly filename: {projectname}_{YYYY-MM-DD}.ics
        $base_name = preg_replace('/[^a-zA-Z0-9\s-]/', '', $request_data['projectname']);
        $date_part = '';
        if (!empty($request_data['date_start'])) {
            $date_part = (new DateTime($request_data['date_start']))->format('Y-m-d');
        }
        $filename = strtolower(str_replace(' ', '_', trim($base_name)) . ($date_part ? '_' . $date_part : '')) . '.ics';
        outputICSFile($ics_content, $filename);
    } catch (Exception $e) {
        header('Content-Type: text/html; charset=utf-8');
        echo "<h2>Error Generating ICS File</h2>";
        echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><a href='generate_ics.php'>Back to ICS Generator</a></p>";
    }
}


function generateCSRFToken() {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Only run main code if this file is called directly (not included)
if (basename($_SERVER['PHP_SELF']) === 'generate_ics.php') {
    session_start();
    
    // Security headers
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    
    try {
        $request_data = $_POST ?: $_GET ?: $_REQUEST;
        
        if (empty($request_data)) {
            $csrf_token = generateCSRFToken();
            echo "<!DOCTYPE html>
            <html>
            <head>
                <title>ICS File Generator</title>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <style>
                    body { font-family: Arial, sans-serif; margin: 40px; }
                    .form-group { margin: 15px 0; }
                    label { display: block; margin-bottom: 5px; font-weight: bold; }
                    input, textarea, select { width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
                    button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
                    button:hover { background: #005a87; }
                    .error { color: red; margin: 10px 0; }
                    .success { color: green; margin: 10px 0; }
                    pre { background: #f5f5f5; padding: 15px; border-radius: 4px; overflow-x: auto; }
                </style>
            </head>
            <body>";
            
            echo "<h2>ICS File Generator</h2>";
            echo "<p>Generate iCalendar (.ics) files for events and milestones.</p>";
            
            echo "<form method='POST' action=''>";
            echo "<input type='hidden' name='csrf_token' value='{$csrf_token}'>";
            echo "<div class='form-group'>";
            echo "<label for='projectname'>Project Name *</label>";
            echo "<input type='text' id='projectname' name='projectname' required>";
            echo "</div>";
            
            echo "<div class='form-group'>";
            echo "<label for='date_start'>Start Date/Time *</label>";
            echo "<input type='datetime-local' id='date_start' name='date_start' required>";
            echo "</div>";
            
            echo "<div class='form-group'>";
            echo "<label for='date_end'>End Date/Time *</label>";
            echo "<input type='datetime-local' id='date_end' name='date_end' required>";
            echo "</div>";
            
            echo "<div class='form-group'>";
            echo "<label for='description'>Description</label>";
            echo "<textarea id='description' name='description' rows='3'></textarea>";
            echo "</div>";
            
            echo "<div class='form-group'>";
            echo "<label for='timezone'>Timezone</label>";
            echo "<select id='timezone' name='timezone'>";
            echo "<option value=''>Auto-detect</option>";
            echo "<option value='America/New_York'>Eastern Time (EST/EDT)</option>";
            echo "<option value='America/Chicago'>Central Time (CST/CDT)</option>";
            echo "<option value='America/Denver'>Mountain Time (MST/MDT)</option>";
            echo "<option value='America/Los_Angeles'>Pacific Time (PST/PDT)</option>";
            echo "<option value='America/Anchorage'>Alaska Time (AKST/AKDT)</option>";
            echo "<option value='Pacific/Honolulu'>Hawaii Time (HST)</option>";
            echo "<option value='UTC'>UTC</option>";
            echo "</select>";
            echo "</div>";
            
            echo "<button type='submit'>Generate ICS File</button>";
            echo "</form>";
            
            echo "<h3>Example Usage:</h3>";
            $example_request = [
                'date_start' => '2025-08-06 15:00:00',
                'date_end' => '2025-08-06 16:30:00',
                'projectname' => 'Team Meeting',
                'description' => 'Weekly team sync to discuss project progress.',
                'timezone' => 'America/New_York'
            ];
            echo "<pre>" . htmlspecialchars(json_encode($example_request, JSON_PRETTY_PRINT)) . "</pre>";
            
            echo "</body></html>";
            exit;
        }
        
        // Validate CSRF token for POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($request_data['csrf_token']) || !validateCSRFToken($request_data['csrf_token'])) {
                throw new Exception("Invalid CSRF token. Please try again.");
            }
        }
        
        downloadICSFile($request_data);
        
    } catch (Exception $e) {
        header('Content-Type: text/html; charset=utf-8');
        echo "<h2>Error Generating ICS File</h2>";
        echo "<p class='error'><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><a href='generate_ics.php'>Back to ICS Generator</a></p>";
    }
}
?> 