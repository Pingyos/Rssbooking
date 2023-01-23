$(document).ready(function() {
	//show full calendar
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		editable: false,
		eventLimit: true, // allow "more" link when too many events
		events:{
			url:'json-event.php?get_json=get_json',
		}
	});
	
});

//show data for edit	
function get_modal(id){
	
	//trigger modal
	$("#trigger_modal").trigger('click');
	
	//call data from File json-event.php
	$.ajax({
		type:"POST",
		url:"json-event.php",
		data:{id:id},
		success:function(data){
			$("#get_calendar").html(data);
		}
	});
	
	return false;
}
