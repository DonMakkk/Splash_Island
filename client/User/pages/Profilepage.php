<?php
session_start();
if($_SESSION['email']){
include "../../../backend/databaseconfig.php";
$result = $conn->prepare("SELECT reservation FROM user_account WHERE email = ?");
$result->bind_param("s", $_SESSION["email"]);
$result->execute();
$data = null;
$dataResult = $result->get_result();
$emptyCart = null;
if($dataResult->num_rows > 0){
  $row = $dataResult->fetch_assoc();
  $json_data = $row["reservation"];

  $data = json_decode($json_data, true);

 
}else{
  $emptyCart = 'No reservations yet';
}
}else{
   header("Location: loginPage.php");
   exit();
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" href="../assets/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Splash Island</title>
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
          </ul>
        </div>
      </nav>
    </div>
   <main class="p-2">
    <div>
        <?php
        $user_info = $conn->prepare("SELECT full_name, email, phone_number FROM user_account WHERE email = ?");
        $user_info->bind_param("s",$_SESSION["email"]);
        $user_info->execute();
        $user_info = $user_info->get_result();
        while ($row = $user_info->fetch_assoc()) {
            echo "<h4>Name : ". $row['full_name']."</h4>";
            echo "<h4>Email&nbsp  : &nbsp". $row['email']."</h4>";
            echo "<h4>Phone&nbsp:  ". $row['phone_number']."</h4>";
        }
        ?>
    </div>
    <div class="d-flex flex-column gap-3 p-5 justify-content-center align-items-center">
        <h4 class="bg-primary w-100 p-2 text-light">Reservations:</h4>
      
            <?php
            if($dataResult->num_rows > 0){
             foreach ($data as $value){
              echo '<div class="border border-black  w-100 p-3  align-self-center">';
              echo '<h4>Room: ' . $value["rooms"] . "</h4>";
              echo '<h4> Arrival: ' . $value["arrival"] . "</h4>";
              echo '<h4> Depature: ' . $value["departure"] . "</h4>";
              echo '<h4> adult guests : ' . $value["adults"] . "</h4>";
              echo '<h4> child guests :' . $value["child"] . "</h4>";
              echo "<h5>Message: " . $value["message"] . "</h5>";
              echo '</div>';
             }
            }
            else{
              echo '<h1>' . $emptyCart  . '</h1>';
             }
            
            ?>
     
   </main>
    <footer class="p-3" >
      <div class="info d-flex gap-md-5 justify-content-center p-md-5 flex-wrap">
        <img src="../assets/logo.png" alt="" class="align-self-center" />
        <div class="d-block d-md-none mb-3 w-100">
          <button
            class="btn btn-none w-100 text-start text-white"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#findBookMobile"
          >
            Find & Book
            <ion-icon name="chevron-down-outline" class="ps-2 pt-1"></ion-icon>
          </button>
          <div class="collapse" id="findBookMobile">
            <ul class="list-unstyled ps-3 mb-0">
              <li>Our Destinations</li>
              <li>Find a Reservation</li>
              <li>Meeting & Events</li>
              <li>Restaurant's</li>
            </ul>
          </div>
        </div>
        <div class="d-block d-md-none mb-3 w-100">
          <button
            class="btn btn-none w-100 text-start text-white"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#circleMobile"
          >
            Splash Island Circle
            <ion-icon name="chevron-down-outline" class="ps-2 pt-1"></ion-icon>
          </button>
          <div class="collapse" id="circleMobile">
            <ul class="list-unstyled ps-3 mb-0">
              <li>Programmer Overview</li>
              <li>Join Splash Island Circle</li>
              <li>Account Overview</li>
              <li>FAQ</li>
              <li>Contact Us</li>
            </ul>
          </div>
        </div>
        <div class="d-block d-md-none mb-3 w-100">
          <button
            class="btn btn-none w-100 text-start text-white"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#aboutMobile"
          >
            About Splash Island
            <ion-icon name="chevron-down-outline" class="ps-2 pt-1"></ion-icon>
          </button>
          <div class="collapse" id="aboutMobile">
            <ul class="list-unstyled ps-3 mb-0">
              <li>About Us</li>
              <li>Our Resorts Brands</li>
              <li>Splash Island Centre</li>
              <li>Residences</li>
              <li>Contact Us</li>
            </ul>
          </div>
        </div>
        <div class="me-5 d-none d-md-block">
          <h4>Find & Book</h4>
          <ul class="list-unstyled">
            <li>Our Destinations</li>
            <li>Find a Reservation</li>
            <li>Meeting & Events</li>
            <li>Restaurant's</li>
          </ul>
        </div>
        <div class="me-5 d-none d-md-block">
          <h4>Splash Island Circle</h4>
          <ul class="list-unstyled">
            <li>Programmer Overview</li>
            <li>Join Splash Island Circle</li>
            <li>Account Overview</li>
            <li>FAQ</li>
            <li>Contact Us</li>
          </ul>
        </div>
        <div class="me-5 d-none d-md-block">
          <h4>About Splash Island</h4>
          <ul class="list-unstyled">
            <li>About Us</li>
            <li>Our Resorts Brands</li>
            <li>Splash Island Centre</li>
            <li>Residences</li>
            <li>Contact Us</li>
          </ul>
        </div>
      </div>
    </footer>
    <h5
      class="text-center fw-light w-100 p-3"
      style="font-size: 14px"
    >
      Privacy Policy | Terms & Conditions | Safety & Security | Supplier Code of
      Conduct | Cyber Security <br />
      © 2025 Splash Island Co. All Rights Reserved. ICP license: 22007722
    </h5>
    
    <script src="../../homepageScript.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
