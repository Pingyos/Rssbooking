<?php
require "fullcalendar.class.php";

//new object
$fullcalendar = new Fullcalendar();

//check data for show fullcalendar
if(isset($_GET['get_json'])){
	
	//call method get_fullcalendar
	$get_calendar = $fullcalendar->get_fullcalendar();

	foreach($get_calendar as $calendar){
		
		$json[] = array(
			'id'=>$calendar['id'],
			'title'=>$calendar['title'],
			'option_add'=>$calendar['option_add'],
            'name'=>$calendar['name'],
			'email'=>$calendar['email'],
			'tel'=>$calendar['tel'],
            'timeslot'=>$calendar['timeslot'],
			'date'=>$calendar['date'],
			'url'=>'javascript:get_modal('.$calendar['id'].');',
		);
	}
	
	//return JSON object
	echo json_encode($json);
}

//show edit data modal
if(isset($_POST['id'])){
	
	$get_data = $fullcalendar->get_fullcalendar_id($_POST['id']);
	
	echo'<div class="modal-body">
			<form id="edit_fullcalendar">
				  <div class="form-group">
					<label >Service Type</label>
					<input readonly type="text" class="form-control" name="title" value="'.$get_data['title'].'">
				  </div>
				  <div class="form-group">
					<label >Meeting Option</label>
					<input readonly type="text" class="form-control" name="option_add"  value="'.$get_data['option_add'].'">
				  </div>
				  <div class="form-group">
					<label >Booked by</label>
					<input readonly type="text" class="form-control" name="name" value="'.$get_data['name'].'">
				  </div>
                  <div class="form-group">
					<label >E-mail</label>
					<input readonly type="text" class="form-control" name="email" value="'.$get_data['email'].'">
				  </div>
                  <div class="form-group">
					<label >Tel</label>
					<input readonly type="text" class="form-control" name="tel" value="'.$get_data['tel'].'">
				  </div>
                  <div class="form-group">
					<label >Time</label>
					<input readonly type="text" class="form-control" name="timeslot" value="'.$get_data['timeslot'].'">
				  </div>
                  <div class="form-group">
					<label >Date</label>
					<input readonly type="text" class="form-control" name="date" value="'.$get_data['date'].'">
				  </div>
					<input type="hidden" name="edit_calendar_id" value="'.$get_data['id'].'">
				</form>
			</div>
		  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>';
}
