<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8' />
			<link href='http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css'  rel='stylesheet' />
			<link href='http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.print.css'  rel='stylesheet' media='print' />

			<!-- Latest compiled and minified CSS -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

			<!-- Optional theme -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
			<style>
				#calendar{
					margin-top:10px;
				}
			</style>
	</head>
	<body>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div id='calendar'></div>
				</div>
			</div>
		</div>

			<span id="trigger_modal" data-toggle="modal" data-target="#calendar_modal"></span>

				<div class="modal fade" id="calendar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Date Booking</h4>
					  </div>
							<div id="get_calendar"></div>
					</div>
				  </div>
				</div>
					
		<!-- Javascript -->
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src='https://fullcalendar.io/js/fullcalendar-2.4.0/lib/moment.min.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js'></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

  <!-- นำเข้า script File -->
  <script src='script.js'></script>	
	</body>
</html>