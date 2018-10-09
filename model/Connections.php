<?php
/**
 * created on 17-April-2018
 * developed by Roshan Bagde
 * project name onlineexamportal.com
 * module Connection
 */

    class Connection{
        public function createConnection(){
            $conn = mysqli_connect('localhost','root','','online_exam_portal');
            return $conn;
        }

        public function closeConnection($conn){
            mysqli_close($conn);
        }
	}
?>