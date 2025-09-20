
<?php
	//from other page
	$start_time = ($_REQUEST['date_start']);
	$end_time = ($_REQUEST['date_end']);
	$title = ($_REQUEST['projectname']);
	$description = ($_REQUEST['description']);
	$location = "TBD";

	$event = new ICSGenerator($start_time, $end_time, $title, $description, $location);
	$event->save();
	
	// Get the local timezone of the computer
	$localTimeZone = date_default_timezone_get();
	
	// Create an event start and end time
	$eventStart = new DateTime($start_time);
	$eventEnd = new DateTime($end_time);
	
	// Format the event start and end time in UTC
	$eventStart->setTimezone(new DateTimeZone('UTC'));
	$eventEnd->setTimezone(new DateTimeZone('UTC'));
	
	// Format the event start and end time as strings
	$eventStartStr = $eventStart->format('Ymd\THis\Z');
	$eventEndStr = $eventEnd->format('Ymd\THis\Z');
	
	// Create the iCalendar content
	$ics = "BEGIN:VCALENDAR
	VERSION:2.0
	PRODID:-//Example//Example Calendar//EN
	BEGIN:VEVENT
	DTSTART:$eventStartStr
	DTEND:$eventEndStr
	SUMMARY:Example Event
	END:VEVENT
	END:VCALENDAR";
	
	// Set headers to force download
	header('Content-Type: text/calendar; charset=utf-8');
	header('Content-Disposition: attachment; filename=example.ics');
	
	// Output the iCalendar content
	echo $ics;
?>