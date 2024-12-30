<?php
session_start();
include_once '../Controller/PageAccessController.php';
?>

<!DOCTYPE html>
<html lang="en">
     <head>
          <title>Contact Us</title>
          <link rel="icon" type="image/x-icon" href="../Public/images/icon.png">
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=Edge">
          <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
          <link rel="stylesheet" href="../Public/css/bootstrap.min.css">
          <link rel="stylesheet" href="../Public/css/font-awesome.min.css">
          <link rel="stylesheet" href="../Public/css/aos.css">
     </head>
     <body>
          <?php include 'Partials/navbar.php';?>
          <section class="contact section" id="contact">
               <div class="container">
                    <div class="row">
                         <div class="ml-auto col-lg-5 col-md-6 col-12">
                              <h2 class="mb-4 pb-2" data-aos="fade-up" data-aos-delay="200">Feel free to ask anything</h2>
                              <form action="#" method="post" class="contact-form webform" data-aos="fade-up" data-aos-delay="400"
                              role="form">
                                   <input type="text" class="form-control" name="cf-name" placeholder="Name">
                                   <input type="email" class="form-control" name="cf-email" placeholder="Email">
                                   <textarea class="form-control" rows="5" name="cf-message" placeholder="Message"></textarea>
                                   <button type="submit" class="form-control" id="submit-button" name="submit">Send
                                   Message</button>
                              </form>
                         </div>
                         <div class="mx-auto mt-4 mt-lg-0 mt-md-0 col-lg-5 col-md-6 col-12">
                              <h2 class="mb-4" data-aos="fade-up" data-aos-delay="600">Where you can <span>find us</span></h2>
                              <p data-aos="fade-up" data-aos-delay="800"><i class="fa fa-map-marker mr-1"></i> miu</p>
                              
                              <div class="google-map" data-aos="fade-up" data-aos-delay="900">
                                   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3449.403346256985!2d31.48939097506606!3d30.16847011268473!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14581bab30f3291d%3A0x1b138aefe2d8bedb!2sMisr%20International%20University%20(MIU)!5e0!3m2!1sen!2seg!4v1729741568658!5m2!1sen!2seg"

                                   width="1920" height="250" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                              </div>
                         </div>
                    </div>
               </div>
          </section> 
          <?php include 'Partials/footer.php';?>
          <script src="js/jquery.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="js/aos.js"></script>
          <script src="js/smoothscroll.js"></script>
          <script src="js/custom.js"></script>
     </body>
</html>
