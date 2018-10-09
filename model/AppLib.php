<?php 

    class Validations{

    }

    class Format{
        public function formatDateTime($date){
            $dt = datetime::createfromformat('Y-m-d H:i:s',$date);
            $fdt = $dt->format('j-M-Y h:i A');
            return $fdt;
        }

        public function formatDate($date){
            $dt = datetime::createfromformat('Y-m-d',$date);
            $fdt = $dt->format('j-M-Y');
            return $fdt;
        }

        public static function getCurrentDateTime(){
            date_default_timezone_set('Asia/Calcutta');
            $date = date('Y-m-d H:i:s');
            return $date;
        }


        public static function getCurrentDate(){
            date_default_timezone_set('Asia/Calcutta');
            $date = date('Y-m-d');
            return $date;
        }

        public static function dateDiff($date1,$date2){
            $fromDate = datetime::createfromformat('Y-m-d',$date1);
            $toDate = datetime::createfromformat('Y-m-d',$date2);
            //$dateDiff = $toDate - $fromDate;
            $dateDiff =  $fromDate->diff($toDate);
            return $dateDiff;
        }

        public static function datetimeDiff($date1,$date2){
            $fromDate = datetime::createfromformat('Y-m-d H:i:s',$date1);
            $toDate = datetime::createfromformat('Y-m-d H:i:s',$date2);
            echo $dateDiff = $toDate-$fromDate;
            return round($dateDiff / (60*60*24));
        }
        
        public function addDayswithdate($date,$days){

    		$date = strtotime("+".$days." days", strtotime($date));
    		return  date("Y-m-d", $date);

	}
	
	public static function sendMailAdmin($to,$subject,$message){
	
	
	
	
     	
              // echo mail($email, 'Welcome', $body, 'From:admin@bluecrystalrecruitment.com');
               
               $headers = array("From: admin@bluecrystalrecruitment.com",
    			"Reply-To: admin@bluecrystalrecruitment.com",
    			"X-Mailer: PHP/" . PHP_VERSION
		);
	$headers = implode("\r\n", $headers);
	mail($to, $subject, $message, $headers);
	}
	
	public static function sendMailInfo($to,$subject,$message){
		$headers = array("From: info@bluecrystalrecruitment.com",
    			"Reply-To: admin@bluecrystalrecruitment.com",
    			"X-Mailer: PHP/" . PHP_VERSION
		);
		$headers = implode("\r\n", $headers);
		mail($to, $subject, $message, $headers);
	
	}

    }
?>