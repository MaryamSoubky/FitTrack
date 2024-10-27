<!DOCTYPE html>
<html lang="en">

<head>
    <title>FitTrack</title>
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
    <?php include 'Partials/navbar.php';?>

    <section class="hero d-flex flex-column justify-content-center align-items-center" id="home">
        <div class="bg-overlay">
            <div class="container">
                <div class="row">

                    <div class="col-lg-8 col-md-10 mx-auto col-12">
                        <div class="hero-text mt-5 text-center">
                            <h6 data-aos="fade-up" data-aos-delay="300">New way to build a healthy lifestyle!</h6>
                            <h1 class="text-white" data-aos="fade-up" data-aos-delay="500">Improve your body with FitTrack</h1>
                            <a href="classes.php" class="btn custom-btn mt-3" data-aos="fade-up" data-aos-delay="600">Get started</a>
                            <a href="about.php" class="btn custom-btn bordered mt-3" data-aos="fade-up" data-aos-delay="700">Learn more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="feature" id="feature">
        <div class="container">
            <div class="row">

                <div class="d-flex flex-column justify-content-center ml-lg-auto mr-lg-5 col-lg-5 col-md-6 col-12">
                    <h2 class="mb-3 text-white" data-aos="fade-up">New to the FitTrack?</h2>
                    <h6 class="mb-4 text-white" data-aos="fade-up">Your membership is up to 2 months FREE (300EGP per month)</h6>

                    <p data-aos="fade-up" data-aos-delay="200">FitTrack is the way to change and get your body in its best version! Subscribe with us to join the family.</p>
                    <a href="#" class="btn custom-btn bg-color mt-3" data-aos="fade-up" data-aos-delay="300"
                        data-toggle="modal" data-target="#membershipForm">Become a member today</a>
                </div>

                <div class="mr-lg-auto mt-3 col-lg-4 col-md-6 col-12">
                    <div class="about-working-hours">
                        <div>

                            <h2 class="mb-4 text-white" data-aos="fade-up" data-aos-delay="500">Working hours</h2>

                            <strong class="d-block" data-aos="fade-up" data-aos-delay="600">Sunday : Closed</strong>

                            <strong class="mt-3 d-block" data-aos="fade-up" data-aos-delay="700">Monday -
                                Friday</strong>

                            <p data-aos="fade-up" data-aos-delay="800">7:00 AM - 10:00 PM</p>

                            <strong class="mt-3 d-block" data-aos="fade-up" data-aos-delay="700">Saturday</strong>

                            <p data-aos="fade-up" data-aos-delay="800">6:00 AM - 4:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="schedule section" id="schedule">
               <div class="container">
                    <div class="row">
                         <div class="col-lg-12 col-12 text-center">
                              <h6 data-aos="fade-up">our weekly GYM schedules</h6>
                              <h2 class="text-white" data-aos="fade-up" data-aos-delay="200">Workout Timetable</h2>
                         </div>
                         <div class="col-lg-12 py-5 col-md-12 col-12">
                              <table class="table table-bordered table-responsive schedule-table" data-aos="fade-up"
                                  data-aos-delay="300">
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
                                      <tr>
                                          <td><small>7:00 am</small></td>
                                          <td>
                                              <strong>Cardio</strong>
                                              <span>7:00 am - 9:00 am</span>
                                          </td>
                                          <td>
                                              <strong>Power Fitness</strong>
                                              <span>7:00 am - 9:00 am</span>
                                          </td>
                                          <td></td>
                                          <td></td>
                                          <td>
                                              <strong>Yoga Section</strong>
                                              <span>7:00 am - 9:00 am</span>
                                          </td>
                                      </tr>

                                      <tr>
                                          <td><small>9:00 am</small></td>
                                          <td></td>
                                          <td></td>
                                          <td>
                                              <strong>Boxing</strong>
                                              <span>8:00 am - 9:00 am</span>
                                          </td>
                                          <td>
                                              <strong>Areobic</strong>
                                              <span>8:00 am - 9:00 am</span>
                                          </td>
                                          <td></td>
                                          <td>
                                              <strong>Cardio</strong>
                                              <span>8:00 am - 9:00 am</span>
                                          </td>
                                      </tr>

                                      <tr>
                                          <td><small>11:00 am</small></td>
                                          <td></td>
                                          <td>
                                              <strong>Boxing</strong>
                                              <span>11:00 am - 2:00 pm</span>
                                          </td>
                                          <td>
                                              <strong>Areobic</strong>
                                              <span>11:30 am - 3:30 pm</span>
                                          </td>
                                          <td></td>
                                          <td>
                                              <strong>Body work</strong>
                                              <span>11:50 am - 5:20 pm</span>
                                          </td>
                                      </tr>

                                      <tr>
                                          <td><small>2:00 pm</small></td>
                                          <td>
                                              <strong>Boxing</strong>
                                              <span>2:00 pm - 4:00 pm</span>
                                          </td>
                                          <td>
                                              <strong>Power lifting</strong>
                                              <span>3:00 pm - 6:00 pm</span>
                                          </td>
                                          <td></td>
                                          <td>
                                              <strong>Cardio</strong>
                                              <span>6:00 pm - 9:00 pm</span>
                                          </td>
                                          <td></td>
                                          <td>
                                              <strong>Crossfit</strong>
                                              <span>5:00 pm - 7:00 pm</span>
                                          </td>
                                        </tr>
                                   </tbody>
                              </table>
                         </div>
                         <button class="btn custom-btn bordered mt-3" data-aos="fade-up" data-aos-delay="700">Edit Schedule</button>
                    </div>
               </div>
          </section>


    <?php include 'Partials/footer.php';?>

    <div class="modal fade" id="membershipForm" tabindex="-1" role="dialog" aria-labelledby="membershipFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h2 class="modal-title" id="membershipFormLabel">Membership Form</h2>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="membership-form webform" role="form">
                        <input type="text" class="form-control" name="cf-name" placeholder="John Doe">

                        <input type="email" class="form-control" name="cf-email" placeholder="Johndoe@gmail.com">

                        <input type="tel" class="form-control" name="cf-phone" placeholder="123-456-7890"
                            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>

                        <textarea class="form-control" rows="3" name="cf-message"
                            placeholder="Additional Message"></textarea>

                        <button type="submit" class="form-control" id="submit-button" name="submit">Submit
                            Button</button>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="signup-agree">
                            <label class="custom-control-label text-small text-muted" for="signup-agree">I agree to the
                                <a href="#">Terms &amp;Conditions</a>
                            </label>
                        </div>
                    </form>
                </div>

                <div class="modal-footer"></div>

            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="../Public/js/jquery.min.js"></script>
    <script src="../Public/js/bootstrap.min.js"></script>
    <script src="../Public/js/aos.js"></script>
    <script src="../Public/js/smoothscroll.js"></script>
    <script src="../Public/js/custom.js"></script>

</body>

</html>