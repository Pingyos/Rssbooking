<?php
$mysqli = new mysqli('localhost', 'root', '', 'bookingcalendar');
if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $stmt = $mysqli->prepare("select * from db_editor where date = ?");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row['timeslot'];
            }

            $stmt->close();
        }
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $option_add = $_POST['option_add'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $timeslot = $_POST['timeslot'];
    $stmt = $mysqli->prepare("select * from db_editor where date = ? AND timeslot=?");
    $stmt->bind_param('ss', $date, $timeslot);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $msg = "<div class='alert alert-danger'>booking failed</div>";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO db_editor (name,title,option_add,timeslot,email,tel,date) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param('sssssss', $name, $title, $option_add, $timeslot, $email, $tel, $date);
            $stmt->execute();
            $msg = "<div class='alert alert-success'>Booking Success</div>";
            $bookings[] = $timeslot;
            $stmt->close();
            $mysqli->close();

            $sToken = ["xUOt704coJ0X5arBn4VQoYF21CXZqGog9U3203irQnw", "8PPDAcWCl4MNf0VXoSYpRzbb1GmwJvmDkrjnobQmk97"];
            $sMessage = "Update Booking\r\n";
            $sMessage .= "Date: " . $date . "\n";
            $sMessage .= "Time: " . $timeslot . "\n";
            $sMessage .= "\n";
            $sMessage .= "Service Type: \n";
            $sMessage .= $title . "\n";
            $sMessage .= "\n";
            $sMessage .= "Meeting Option \n";
            $sMessage .= $option_add . "\n";
            $sMessage .= "\n";
            $sMessage .= "Booked by: " . $name . "\n";
            $sMessage .= "E-mail: " . $email . "\n";
            $sMessage .= "Tel: " . $tel . "\n";
            $sMessage .= "\n";
            $sMessage .= "https://www.RSSbooking/editorenglishhours/calendar_edit.php \n";

            function notify_message($sMessage, $Token)
            {
                $chOne = curl_init();
                curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($chOne, CURLOPT_POST, 1);
                curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
                $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $Token . '',);
                curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($chOne);
                if (curl_error($chOne)) {
                    echo 'error:' . curl_error($chOne);
                }
                curl_close($chOne);
            }
            foreach($sToken as $Token){
                notify_message($sMessage,$Token);
            }
        }
    }
}


$duration = 60;
$cleanup = 0;
$start = "09:00";
$end = "16:00";


function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime("$start");
    $end = new DateTime("$end");
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();
    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }
        $slots[] = $intStart->format("H:iA") . "_" . $endPeriod->format("H:iA");
    }
    return $slots;
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">

</head>

<body>
    <div class="container">
        <h1 class="text-center">Booking for Date: <?php echo date('Y-m-d', strtotime($date)); ?></h1>
        <div class="row">
            <div class="col-md-12 col-12 mt-2">
                <?php echo isset($msg) ? $msg : ""; ?>
            </div>
            <?php $timeslots = timeslots($duration, $cleanup, $start, $end,);
            foreach ($timeslots as $ts) {
            ?>
                <div class="col-md-2 col-12 mt-2">
                    <div class="form-group"></div>
                    <?php if (in_array($ts, $bookings)) { ?>
                        <button class="col-md- col-12 mt-2 btn btn-danger"><?php echo $ts; ?></button><br>
                    <?php } else { ?>
                        <button class="col-md- col-12 mt-2 btn btn-success book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class=" modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <form action="" method="post">
                            <div class="form-group">
                                <table for="">Date</table>
                                <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                            </div>
                            <div class="form-group">
                                <table for="">Service Type</table>
                                <select name="title" class="form-control" required>
                                    <option 1="">Editor English Hours</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <table for="">Meeting Option</table>
                                <select name="option_add" class="form-control" required>
                                    <option 1="">Zoom meeting</option>
                                    <option 2="">Face-to-face meeting</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <table for="">Name</table>
                                <input required type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <table for="">Email</table>
                                <input required type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <table for="">Tel</table>
                                <input required type="text" name="tel" class="form-control">
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(".book").click(function() {
            var timeslot = $(this).attr('data-timeslot');
            $("#slot").html(timeslot);
            $("#timeslot").val(timeslot);
            $("#myModal").modal('show');
        });
    </script>
</body>

</html>