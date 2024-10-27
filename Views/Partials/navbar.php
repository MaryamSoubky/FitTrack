<!DOCTYPE html>
<html lang="en">
  <head>
    <link href="../Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Public/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <style>
      .navbar {
      background: var(--dark-color);
      padding: 1rem;
      }
      
      .navbar-expand-lg .navbar-nav .nav-link {
      padding-right: 1.5rem;
      padding-left: 1.5rem;
      }

      nav .navbar-brand {
        color: var(--white-color);
        font-size: 2.5rem;
        font-weight: 700;
        line-height: normal;
        padding-top: 0;
      }
  
      .nav-item .nav-link {
        display: block;
        color: var(--white-color);
        font-size: var(--menu-font-size);
        font-weight: var(--font-weight-normal);
        text-transform: uppercase;
        padding: 2px 6px;
      }
      .nav-item .nav-link.active,
      .nav-item .nav-link:hover {
        color: var(--primary-color);
      }
  
      .navbar .social-icon li a {
        color: var(--white-color);
      }
  
      .navbar-toggler {
        border: 0;
        padding: 0;
        cursor: pointer;
        margin: 0 10px 0 0;
        width: 30px;
        height: 35px;
        outline: none;
      }
  
      .navbar-toggler:focus {
        outline: none;
      }
  
      .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
        background: transparent;
      }
  
      .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before,
      .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
        transition: top 300ms 50ms ease, -webkit-transform 300ms 350ms ease;
        transition: top 300ms 50ms ease, transform 300ms 350ms ease;
        transition: top 300ms 50ms ease, transform 300ms 350ms ease, -webkit-transform 300ms 350ms ease;
        top: 0;
      }
  
      .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
        transform: rotate(45deg);
      }
  
      .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
        transform: rotate(-45deg);
      }
  
      .navbar-toggler .navbar-toggler-icon {
        background: var(--primary-color);
        transition: background 10ms 300ms ease;
        display: block;
        width: 30px;
        height: 2px;
        position: relative;
      }
  
      .navbar-toggler .navbar-toggler-icon::before,
      .navbar-toggler .navbar-toggler-icon::after {
        transition: top 300ms 350ms ease, -webkit-transform 300ms 50ms ease;
        transition: top 300ms 350ms ease, transform 300ms 50ms ease;
        transition: top 300ms 350ms ease, transform 300ms 50ms ease, -webkit-transform 300ms 50ms ease;
        position: absolute;
        right: 0;
        left: 0;
        background: var(--primary-color);
        width: 30px;
        height: 2px;
        content: '';
      }
  
      .navbar-toggler .navbar-toggler-icon::before {
        top: -8px;
      }
  
      .navbar-toggler .navbar-toggler-icon::after {
        top: 8px;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.html">FitTrack</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-lg-auto">
              <li class="nav-item">
                <a href="../Views/home.php" class="nav-link smoothScroll">Home</a>
              </li>
              <li class="nav-item">
                <a href="../Views/goal_view.php" class="nav-link smoothScroll">goal tracker</a>
              </li>
              <li class="nav-item">
                <a href="../Views/workouts.php" class="nav-link smoothScroll">Workouts</a>
              </li>
              <li class="nav-item">
                <a href="../Views/schedules.php" class="nav-link smoothScroll">Schedule</a>
              </li>
              <li class="nav-item">
                <a href="../Views/about.php" class="nav-link smoothScroll">About Us</a>
              </li>
              <li class="nav-item">
                <a href="../Views/contact.php" class="nav-link smoothScroll">Contact Us</a>
              </li>
            </ul>
            <ul class="social-icon ml-lg-3">
              <li><a href="#" class="fa fa-facebook"></a></li>
              <li><a href="#" class="fa fa-twitter"></a></li>
              <li><a href="#" class="fa fa-instagram"></a></li>
            </ul>
          </div>
      </div>
    </nav>
      <script src="../Public/js/jquery.min.js"></script>
      <script src="../Public/js/bootstrap.min.js"></script>
      <script src="../Public/js/aos.js"></script>
      <script src="../Public/js/smoothscroll.js"></script>
      <script src="../Public/js/custom.js"></script>
  </body>
</html>