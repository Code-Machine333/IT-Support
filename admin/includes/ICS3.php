<?php
	header('Content-Type: text/calendar; charset=utf-8');
	header('Content-Disposition: attachment; filename="event.ics"');
	
	require_once("ics_generator3.php");

	$start_time = ($_REQUEST['date_start']);
	$end_time = ($_REQUEST['date_end']);
	$title = ($_REQUEST['projectname']);
	$description = ($_REQUEST['description']);
	$location = "TBD";

	$event = new ICSGenerator($start_time, $end_time, $title, $description, $location);
	$event->save();
?>
