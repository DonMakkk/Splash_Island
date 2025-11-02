<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "splash_island_data");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $arrivalDate = $_POST["arrival"];
    $departureDate = $_POST["departure"];
    $roomQuantity = $_POST["room"];
    $adultGuestsQuantity = $_POST["adults"];
    $childrenGuestsQuantity = $_POST["children"];
    $message = $_POST["message"];
    $room_type = $_POST["room_type"]; // this must match the room_name in your DB
    $reference_number = rand(5000, 9999999);

    // Create JSON data for reservation
    $reservation = [
        "referenceNum" => $reference_number,
        "full_name" => $_SESSION['full_name'],
        "room_type" => $room_type,
        "arrival" => $arrivalDate,
        "departure" => $departureDate,
        "rooms" => $roomQuantity,
        "adults" => $adultGuestsQuantity,
        "child" => $childrenGuestsQuantity,
        "message" => $message
    ];
    $json_data = json_encode($reservation);

    $email = $_SESSION["email"];

    //Proceed only if logged in
    if ($_SESSION['login']) {
        // Get existing reservations of this user
        $result = $conn->query("SELECT reservation FROM user_account WHERE email = '$email'");
        $row = $result->fetch_assoc();
        $cart = $row['reservation'] ? json_decode($row['reservation'], true) : [];

        $cart[] = $reservation;
        $update_cart = json_encode($cart);

        
        $stmt = $conn->prepare("UPDATE user_account SET reservation = ? WHERE email = ?");
        $stmt->bind_param("ss", $update_cart, $email);
        $stmt->execute();

        
        $room_name = $conn->real_escape_string($room_type);

        // Check current available count
        $check = $conn->query("SELECT room_available FROM rooms_avaialbe WHERE room_name = '$room_name'");
        $data = $check->fetch_assoc();

        if ($data && $data['room_available'] >= $roomQuantity) {
            // Decrease the count
            $update = $conn->query("UPDATE rooms_avaialbe 
                                    SET room_available = room_available - $roomQuantity 
                                    WHERE room_name = '$room_name'");
        } else {
            echo "<script>alert('Sorry, $room_name is fully booked or not enough rooms left!');</script>";
            header("refresh:1;url=Bookingpage.php");
            exit();
        }

        echo "<script>alert('Room successfully reserved!');</script>";
        header("refresh:1;url=Bookingpage.php");
        exit();

    } else {
        echo "<script>alert('Please log in first!');</script>";
        header("refresh:1;url=signUpPage.php");
        exit();
    }

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
     <div class="container-fluid navDiv">
      <nav class="navbar navbar-expand-md">
        <a href="" class="navbar-brand overflow-hidden d-flex">
          <img src="../assets/logo.png" alt="" class="logo h-50" />
          <h3 class="ps-3 mt-3 fw-lighter">Splash Resort</h3>
        </a>
        <button
          class="navbar-toggler me-2"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#main-navigation"
        >
          <span class="navbar-toggler-icon burger-menu"></span>
        </button>
        <div class="collapse navbar-collapse pe-5" id="main-navigation">
          <ul class="navbar-nav ms-auto ps-5">
            <li class="nav-item nav-li">
              <a href="Homepage.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item nav-li">
              <a href="Amenitiespage.php" class="nav-link">Amenities</a>
            </li>
            <li class="nav-item nav-li">
              <a href="Contactpage.php" class="nav-link">Contact</a>
            </li>
            <li class="nav-item nav-li">
              <a href="Bookingpage.php" class="nav-link">Book Now</a>
            </li>
            <li class="nav-item nav-li">
              <button id="toggleMode" class="border-0 h-100 bg-transparent">
                <ion-icon name="sunny-outline"></ion-icon>
              </button>
            </li>
            <li class="nav-item nav-li mt-2 ms-2">
              <a href="Profilepage.php" id="toggleMode" class="border-0 h-100 bg-transparent">
                <ion-icon name="person-circle-outline"></ion-icon>
              </a>
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
         <div class="w-100">
  <label for="roomType" class="form-label fw-light">Select Room Type</label>
  <select class="form-select border-1 border-secondary" id="roomType" name="room_type">
    <option value="deluxe_warm_earth_suite">Deluxe Warm Earth Suite</option>
    <option value="primary_taupe_sanctuary	">Primary Taupe Sanctuary</option>
    <option value="primary_urban_quarters">Primary Urban Quarters</option>
    <option value="signarture_grand_king">Signature Grand King</option>
    <option value="exotic_haven">Exotic Haven </option>
  </select>
</div>

        <div class="d-flex flex-row gap-2 pe-2">
          <div class="w-50">
            <label for="">Date of Arrival</label>
           <input type="datetime-local" name="arrival" id="arrival" class="form-control ">
          </div>
        <div class="w-50">
          <label for="">Date of Departure</label>
           <input type="datetime-local" name="departure" id="departure" class="form-control">
          </div>
        </div>
        <!-- ROOM TYPE -->
     <div class="dropdown">
  <button class="btn w-100 dropdown-toggle border-1 border-secondary " type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
    Rooms
  </button>
  <ul class="dropdown-menu w-100 p-3" aria-labelledby="dropdownMenuButton2" id="reservationContainer">
  <div class="d-flex flex-column gap-2">
    <h6 class="dropdown-item fw-light">Max. 6 guests per room</h6>

    <!-- ROOM -->
    <div class="d-flex flex-row gap-2 ps-3 pe-2">
      <h6 class="fw-light pt-2">Room(s)</h6>
      <div class="d-flex flex-row justify-content-between ms-auto input-group w-50">
        <button class="btn btn-outline-secondary" type="button" id="room-minus">-</button>
        <input type="number" class="form-control text-center" value="1" min="1" id="room-input" name="room">
        <button class="btn btn-outline-secondary" type="button" id="room-plus">+</button>
      </div>
    </div>

    <!-- ADULT -->
    <div class="d-flex flex-row gap-2 ps-3 pe-2">
      <h6 class="fw-light pt-2">Adult(s)</h6>
      <div class="d-flex flex-row justify-content-between ms-auto input-group w-50">
        <button class="btn btn-outline-secondary" type="button" id="adult-minus">-</button>
        <input type="number" class="form-control text-center" value="1" min="1" id="adult-input" name="adults">
        <button class="btn btn-outline-secondary" type="button" id="adult-plus">+</button>
      </div>
    </div>

    <!-- CHILD -->
    <div class="d-flex flex-row gap-2 ps-3 pe-2">
      <h6 class="fw-light pt-2">Children (under 12)</h6>
      <div class="d-flex flex-row justify-content-between ms-auto input-group w-50">
        <button class="btn btn-outline-secondary" type="button" id="child-minus">-</button>
        <input type="number" class="form-control text-center" value="1" min="1" id="child-input" name="children">
        <button class="btn btn-outline-secondary" type="button" id="child-plus">+</button>
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
  </div>
</ul>
</div>
<input type="submit" value="Book now" class="form-control h-50 " >
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
    
    <script src="../../homepageScript.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
  // Prevent dropdown from closing when clicking inside it
  const dropdownMenu = document.querySelector('.dropdown-menu');
  dropdownMenu.addEventListener('click', function(event) {
    event.stopPropagation();
  });
});

document.addEventListener("DOMContentLoaded", function() {
  function setupCounter(minusBtn, input, plusBtn, minValue = 1) {
    minusBtn.addEventListener("click", function() {
      let current = parseInt(input.value) || 0;
      if (current > minValue) input.value = current - 1;
    });

    plusBtn.addEventListener("click", function() {
      let current = parseInt(input.value) || 0;
      input.value = current + 1;
    });
  }

  // ROOM
  const roomMinus = document.querySelector('#room-minus');
  const roomInput = document.querySelector('#room-input');
  const roomPlus = document.querySelector('#room-plus');

  // ADULT
  const adultMinus = document.querySelector('#adult-minus');
  const adultInput = document.querySelector('#adult-input');
  const adultPlus = document.querySelector('#adult-plus');

  // CHILD
  const childMinus = document.querySelector('#child-minus');
  const childInput = document.querySelector('#child-input');
  const childPlus = document.querySelector('#child-plus');

  // Initialize
  setupCounter(roomMinus, roomInput, roomPlus, 1);
  setupCounter(adultMinus, adultInput, adultPlus, 1);
  setupCounter(childMinus, childInput, childPlus, 0);
});


  const arrival = document.getElementById("arrival");
  const departure = document.getElementById("departure");


  const today = new Date().toISOString().split("T")[0];
  arrival.min = today;
  departure.min = today;
  
  arrival.addEventListener("change", function() {
    departure.min = this.value;
   
  });
  
 
  
  const calculate_date = () => {
    const arrival_date =  new Date(arrival.value);
    const departure_date = new Date(departure.value);

    if(isNaN(arrival_date || isNaN(departure_date))){
      console.log("Enter both date");
      return;
    }

    const dif_time = departure_date - arrival_date;
    const days_of_stay = dif_time / (1000 * 60 * 60 * 24);

    console.log(days_of_stay);
  }
  departure.addEventListener("change", calculate_date);
</script>
      
  </body>
</html>

