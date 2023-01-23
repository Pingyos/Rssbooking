<?php
class Fullcalendar {
 
    private $host = 'localhost'; //ชื่อ Host 
	   private $user = 'root'; //ชื่อผู้ใช้งาน ฐานข้อมูล
	   private $password = ''; // password สำหรับเข้าจัดการฐานข้อมูล
	   private $database = 'bookingcalendar'; //ชื่อ ฐานข้อมูล

	//function เชื่อมต่อฐานข้อมูล
	protected function connect(){
		
		$mysqli = new mysqli($this->host,$this->user,$this->password,$this->database);
			
			$mysqli->set_charset("utf8");

			if ($mysqli->connect_error) {

			    die('Connect Error: ' . $mysqli->connect_error);
			}

		return $mysqli;
	}
	
	//function show data in fullcalendar
	public function get_fullcalendar(){
		
		$db = $this->connect();
		$get_calendar = $db->query("SELECT * FROM db_res_sta");
		
		while($calendar = $get_calendar->fetch_assoc()){
			$result[] = $calendar;
		}
		
		if(!empty($result)){
			
			return $result;
		}
	}
	
	//show data in modal
	public function get_fullcalendar_id($get_id){
		
		$db = $this->connect();
		$get_user = $db->prepare("SELECT id,title,option_add,name,email,tel,timeslot,date FROM db_res_sta WHERE id = ?");
		$get_user->bind_param('i',$get_id);
		$get_user->execute();
		$get_user->bind_result($id,$title,$option_add,$name,$email,$tel,$timeslot,$date);
		$get_user->fetch();
		
		$result = array(
			'id'=>$id,
            'title'=>$title,
			'option_add'=>$option_add,
            'name'=>$name,
			'email'=>$email,
			'tel'=>$tel,
            'timeslot'=>$timeslot,
			'date'=>$date,            
		);
		
		return $result;
	}
	
	
}
?>