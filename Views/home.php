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



    <section class="about section" id="about">
               <div class="container">
                    <div class="row">
                         <div class="mt-lg-5 mb-lg-0 mb-4 col-lg-5 col-md-10 mx-auto col-12">
                              <h2 class="mb-4" data-aos="fade-up" data-aos-delay="300">Hello, we are FitTrack</h2>
                              <p data-aos="fade-up" data-aos-delay="400">FitTrack is a fitness tracker and goal management platform designed to help users stay on top of their health and fitness objectives. It allows users to monitor their workouts, track progress, and set personalized fitness goals. The platform offers features such as schedule management, workout logging, and progress tracking, providing users with the tools to achieve their fitness milestones efficiently.</p>
                              <p data-aos="fade-up" data-aos-delay="500">If you have any inquiries regarding FitTrack, you can <a rel="nofollow" href="contact.php" target="_parent">contact us</a> immediately. Thank you.</p>
                         </div>
                         <div class="ml-lg-auto col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="700">
                              <div class="team-thumb">
                                   <img src="../Public/images/team/team-image.jpg" class="img-fluid" alt="Trainer">
                                   <div class="team-info d-flex flex-column">
                                        <h3>Mary Yan</h3>
                                        <span>Yoga Instructor</span>
                                        <ul class="social-icon mt-3">
                                             <li><a href="#" class="fa fa-twitter"></a></li>
                                             <li><a href="#" class="fa fa-instagram"></a></li>
                                        </ul>
                                   </div>
                              </div>
                         </div>
                    <div class="mr-lg-auto mt-5 mt-lg-0 mt-md-0 col-lg-3 col-md-6 col-12" data-aos="fade-up"
                    data-aos-delay="800">
                         <div class="team-thumb">
                              <img src="../Public/images/team/team-image01.jpg" class="img-fluid" alt="Trainer">
                              <div class="team-info d-flex flex-column">
                                   <h3>Catherina</h3>
                                   <span>Body trainer</span>
                                   <ul class="social-icon mt-3">
                                        <li><a href="#" class="fa fa-instagram"></a></li>
                                        <li><a href="#" class="fa fa-facebook"></a></li>
                                   </ul>
                              </div>
                         </div>
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