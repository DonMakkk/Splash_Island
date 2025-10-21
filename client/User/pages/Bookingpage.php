<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POTS"){
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "splash_island_data";

$full_name = $_POST["full_name"];
$email = $_POST["email"];
$phone_num = $_POST["phone_num"];
$date = $_POST["date"];
$message = $_POST["message"];

$reservation = [];
$json_data = json_encode($reservation);

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "INSERT INTO `user_message`(`name`, `email`, `phone_number`, `date`, `message`) 
        VALUES ('$full_name', '$email', '$phone_num', '$date', '$message')";


$result = $conn->query($sql);
echo $result;
$conn->close();
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
   <!-- FORM AREA -->
    <header class="p-md-5 justify-content-center d-flex bookingHeader">
      <img src="../assets/DeluxeWarmEarthSuite.jpg" alt="" class="w-100 object-fit-cover">
    </header>
    <main class="p-5 d-md-flex flex-md-row d-sm-flex flex-sm-column w-100 gap-5 p-md-5">
      <div>
        <h1>Deluxe Warm Earth Suite</h1>
        <p>Escape the everyday and embrace tranquility in our Deluxe Warm Earth Suite. Unwind with the soothing ambiance of your well-appointed room, featuring a plush king-size bed perfect for restful nights. Enjoy a complimentary selection of herbal teas, designed to enhance your relaxation. From this peaceful retreat to a refreshing start to your day, let Splash Island's Deluxe Warm Earth Suite be your sanctuary.</p>
        <b>This offer includes:</b>
        <ul>
          <li>Daily breakfast (adult persons subject to booking).</li>
          <li>Stay in our Deluxe Warm Earth Suite.</li>
          <li>Complimentary access to our Relaxation Lounge, including a selection of herbal teas.</li>
          <li>Complimentary access to our Fitness Center and outdoor swimming pool.</li>
          <li>Complimentary parking (one vehicle per room, per night).</li>
          <li>In compliance with environmental regulations, from January 1, 2025, Splash Island will no longer provide disposable personal amenities in guest rooms. We recommend bringing your own toiletries. Thank you for your understanding.</li>
        </ul>
        <p>Booking opens on September 25 at 12:00 noon. Limited availability—reserve early!</p>
        <p>Reservation hotline: (02) 2376-3266</p>
      </div>
    <form action="Bookingpage.php" method="post" class=" d-flex  flex-column gap-3 p-4  border  text-center bookingPageForm justify-content-between ms-auto h-75" >
        <!-- FULL NAME -->
         <h5>Book this Offer</h5>
         <p>Rates from <b>PHP 29,999</b> for nights</p>
         <hr>
         <h4>Plan your Visit</h4>
      
        <!-- DATE -->
        <div class="d-flex flex-row gap-2 pe-2">
          <div class="w-50">
            <label for="">Date of Arrival</label>
           <input type="datetime-local" name="" id="arrival" class="form-control ">
          </div>
        <div class="w-50">
          <label for="">Date of Departure</label>
           <input type="datetime-local" name="" id="departure" class="form-control">
          </div>
        </div>
        <!-- ROOM TYPE -->
     <div class="dropdown">
  <button class="btn w-100 dropdown-toggle border-1 border-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
    Rooms
  </button>
  <ul class="dropdown-menu w-100 p-3" aria-labelledby="dropdownMenuButton2" id="reservationContainer">
   <div class="d-flex flex-column gap-2">   <!--  Main room wanted to add -->
    <h6 class="dropdown-item  fw-light">Max. 6 gusets per room</h6>
    <div class="d-flex flex-row gap-2 ps-3 pe-2">
      <h6 class="fw-light pt-2">Room(s)</h6>
      <div class="d-flex flex-row justify-content-between ms-auto input-group w-50"> <button class="btn btn-outline-secondary" type="button" id="minus-button">-</button>
      <input type="number" class="form-control text-center" value="1" min="1" id="quantity-input" name="room-quantity">
      <button class="btn btn-outline-secondary" type="button" id="plus-button">+</button>
    </div>
   </div>
   <div class="d-flex flex-row gap-2 ps-3 pe-2">
      <h6 class="fw-light pt-2 ">Adult(s)</h6>
      <div class="d-flex flex-row justify-content-between ms-auto input-group w-50"> <button class="btn btn-outline-secondary" type="button" id="minus-button">-</button>
      <input type="number" class="form-control text-center" value="1" min="1" id="quantity-input" name="adult-quantity">
      <button class="btn btn-outline-secondary" type="button" id="plus-button">+</button>
    </div>
</div>
   <div class="d-flex flex-row gap-2 ps-3 pe-2">
      <h6 class="fw-light pt-2 ">Children (under 12)</h6>
      <div class="d-flex flex-row justify-content-between ms-auto input-group w-50"> <button class="btn btn-outline-secondary" type="button" id="minus-button">-</button>
      <input type="number" class="form-control text-center" value="1" min="1" id="quantity-input" name="children-quantity">
      <button class="btn btn-outline-secondary" type="button" id="plus-button">+</button>
    </div>
</div>
    <li><hr class="dropdown-divider"></li>
   <textarea
            name="message"
            id="messagearea"
            style="resize: none"
            placeholder="Your Message"
            class="p-1 h-50 text-black"
          ></textarea>

 
  </ul>




</div>
<input type="submit" value="Book now" class="form-control h-50 " id="reservationBookBtn" >
    </form>
    </main>
    <!-- FOOTER PART -->

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
    <p><?php echo $_SESSION['email']; ?></p>
    <script src="../../homepageScript.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
    <script>
  const arrival = document.getElementById("arrival");
  const departure = document.getElementById("departure");

  // Optional: prevent selecting past dates
  const today = new Date().toISOString().split("T")[0];
  arrival.min = today;
  departure.min = today;

  // When arrival changes, set that as the minimum for departure
  arrival.addEventListener("change", function() {
    departure.min = this.value;
  });
</script>
       <script src="bookingPageScript.js"></script>
  </body>
</html>

