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
          <link rel="stylesheet" href="../Public/css/main.css">
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
                              <p data-aos="fade-up" data-aos-delay="800"><i class="fa fa-map-marker mr-1"></i> 120-240 Rio de
                              Janeiro - State of Rio de Janeiro, Brazil</p>
                              <!-- How to change your own map point
                               1. Go to Google Maps
	                          2. Click on your location point
                               3. Click "Share" and choose "Embed map" tab
	                          4. Copy only URL and paste it within the src="" field below -->
                              <div class="google-map" data-aos="fade-up" data-aos-delay="900">
                                   <iframe src="https://maps.google.com/maps?q=Av.+Lúcio+Costa,+Rio+de+Janeiro+-+RJ,+Brazil&t=&z=13&ie=UTF8&iwloc=&output=embed"
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
