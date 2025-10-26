<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" href="../assets/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Splash Resort</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Bitcount:wght@100..900&family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Edu+AU+VIC+WA+NT+Pre:wght@400..700&family=Lilita+One&family=Montserrat:wght@600&family=MuseoModerno:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="style.css" />
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <!-- NAVPART -->
      <div class="container-fluid navDiv ">
      <nav class="navbar navbar-expand-md ">
        <a href="" class="navbar-brand overflow-hidden d-flex" >
          <img src="../assets/logo.png" alt="" class="logo h-50" />
          <h3 class=" ps-3 mt-3 fw-lighter" >Splash Island</h3>
        </a>
        <button
          class="navbar-toggler me-2"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#main-navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pe-5" id="main-navigation">
          <ul class="navbar-nav ms-auto ps-5">
            <li class="nav-item nav-li">
              <a href="Homepage.php" class="nav-link ">Home</a>
            </li>
            <li class="nav-item nav-li">
              <a href="Amenitiespage.php" class="nav-link ">Amenities</a>
            </li>
            <li class="nav-item nav-li">
              <a href="Contactpage.php" class="nav-link ">Contact</a>
            </li>
            <li class="nav-item nav-li">
              <a href="Bookingpage.php" class="nav-link ">Book Now</a>
            </li>
              <li class="nav-item nav-li">
              <button id="toggleMode" class=" border-0 h-100 bg-transparent"><ion-icon name="sunny-outline"></ion-icon></button>
            </li>
              <li class="nav-item nav-li">
              <a href="Profilepage.php" class="nav-link"><ion-icon name="person-circle-outline" class="fs-4"></ion-icon></a>
            </li>
          </ul>
        </div>
      </nav>
    </div>

    <!-- Information and Reservation Info -->

<div class="Information">
  <div class="InfoDiv mx-auto p-4 rounded-3 border shadow text-center">
    <h3 class="fw-bold mb-4">Profile Information</h3>
    <div class="fw-bold d-flex flex-column align-items-center gap-3 mb-4">
      <div class="w-75 p-2 border rounded-2 shadow-sm text-start">
        <p>Name:</p>
        <p>Email:</p>
        <p>Phone Number:</p>
      </div>
    </div>
    <h3 class="fw-bold mb-4">Reservation Information</h3>
    <div class="fw-bold d-flex flex-column align-items-center gap-3">
      <div class="w-75 p-2 border rounded-2 shadow-sm text-start">
        <p>Date:</p> <p>Room Type:</p>
        <p>Arrival:</p> <p>Departure:</p>
        <p>Adults:</p> <p>Children:</p>
        <p>Message:</p>
      </div>
    </div>
  </div>
</div>

    <h5
      class="text-center fw-light w-100 p-3 "
      style="font-size: 14px"
    >
      Privacy Policy | Terms & Conditions | Safety & Security | Supplier Code of
      Conduct | Cyber Security <br />
      © 2025 Splash Island Co. All Rights Reserved. ICP license: 22007722
    </h5>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
 
        <script src="../../homepageScript.js"></script>
  </body>
</html>
