<?php
session_start();
include_once '../Controller/ScheduleController.php';
include_once '../Controller/config.php'; // Include database connection

// Create a ScheduleController object
$scheduleController = new ScheduleController($db);

// Fetch the existing schedule from the database
$scheduleData = $scheduleController->getSchedule();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Schedule - FitTrack</title>
    <link rel="icon" type="image/x-icon" href="../Public/images/icon.png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Public/css/aos.css">
    <link rel="stylesheet" href="../Public/css/main.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>

<body>
    <?php include 'Partials/navbar.php'; ?>

    <section class="schedule-edit section" id="schedule-edit">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 text-center">
                    <h6 data-aos="fade-up">Edit your Gym Schedule</h6>
                    <h2 class="text-white" data-aos="fade-up" data-aos-delay="200">Update Your Workout Timetable</h2>
                </div>
                <div class="col-lg-12 py-5 col-md-12 col-12">
                    <form action="update_schedule.php" method="POST">
                        <table class="table table-bordered table-responsive schedule-table" data-aos="fade-up" data-aos-delay="300">
                            <thead class="thead-light">
                                <th><i class="fa fa-calendar"></i></th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </thead>
                            <tbody>
                                <?php foreach ($scheduleData as $timeSlot): ?>
                                    <tr>
                                        <td><small><?= $timeSlot['time']; ?></small></td>
                                        <td>
                                            <input type="text" name="mon_<?= $timeSlot['id']; ?>" value="<?= $timeSlot['mon']; ?>" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="tue_<?= $timeSlot['id']; ?>" value="<?= $timeSlot['tue']; ?>" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="wed_<?= $timeSlot['id']; ?>" value="<?= $timeSlot['wed']; ?>" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="thu_<?= $timeSlot['id']; ?>" value="<?= $timeSlot['thu']; ?>" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="fri_<?= $timeSlot['id']; ?>" value="<?= $timeSlot['fri']; ?>" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="sat_<?= $timeSlot['id']; ?>" value="<?= $timeSlot['sat']; ?>" class="form-control">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Update Schedule</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'Partials/footer.php'; ?>

    <!-- SCRIPTS -->
    <script src="../Public/js/jquery.min.js"></script>
    <script src="../Public/js/bootstrap.min.js"></script>
    <script src="../Public/js/aos.js"></script>
    <script src="../Public/js/smoothscroll.js"></script>
    <script src="../Public/js/custom.js"></script>
</body>

</html>
