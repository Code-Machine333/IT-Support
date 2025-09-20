<?php
    class ICSGenerator {
        var $data;
        var $name;
        function __construct($start, $end, $name, $description, $location) {
            $this->name = $name;
            $this->data = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nDTSTART:".date("Ymd\THis\Z",strtotime($start))."\nDTEND:".date("Ymd\THis\Z",strtotime($end))."\nORGANIZER;CN=noreply@cescheduler.com:mailto:noreply@cescheduler.com\nLOCATION:".$location."\nTRANSP: TRANSPARENT\nSEQUENCE:0\nUID:\nDTSTAMP:".date("Ymd\THis\Z")."\nTITLE:".$name."\nDESCRIPTION:".$description."\nPRIORITY:5\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR\n";
        }
        /*public function save() {
            file_put_contents("downloads/".$this->name.".ics",$this->data); */
			
		public function save() {
			echo $this->data;
        }
    }
?>