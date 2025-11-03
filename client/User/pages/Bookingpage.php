<?php
session_start();
include "../../../backend/databaseconfig.php";

// ROOM RESERVATION PART
if (isset($_POST["room_submit"])) {
    
    // Collect form data
    $arrivalDate = $_POST["arrival"];
    $departureDate = $_POST["departure"];
    $roomQuantity = $_POST["room"];
    $adultGuestsQuantity = $_POST["adults"];
    $childrenGuestsQuantity = $_POST["children"];
    $message = $_POST["message"];
    $room_type = trim($_POST["room_type"]); // FIXED: trim to remove hidden spaces/tabs
    $reference_number = rand(5000, 9999999);
    $total_price = 2;
    $start = new DateTime($arrivalDate);
    $end = new DateTime($departureDate);
    $interval = $start->diff($end);
    $total_days = $interval->days;

    //PRICE UPDATE
    if($room_type == "deluxe_warm_earth_suite"){
       $total_price = (2000 *  $roomQuantity) * $total_days;
    }
    elseif($room_type == "primary_taupe_sanctuary"){
       $total_price = (3000 *  $roomQuantity) * $total_days;
    }
    elseif($room_type == "primary_urban_quarters"){
       $total_price = (4000 *  $roomQuantity) * $total_days;
    }
    elseif($room_type == "signature_grand_king"){
       $total_price = (5000 *  $roomQuantity) * $total_days;
    }
    elseif($room_type == "exotic_haven"){
       $total_price = (6000 *  $roomQuantity) * $total_days;
    } else {
       $total_price = 1;
    }

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
        "message" => $message,
        "price" => $total_price,
        "days_of_stay" =>  $total_days
    ];
    

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
        $check = $conn->query("SELECT room_available FROM rooms_available WHERE room_name = '$room_name'");
        $data = $check->fetch_assoc();

        if ($data && $data['room_available'] >= $roomQuantity) {
            // Decrease the count
            $update = $conn->query("UPDATE rooms_available 
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
}

//COTTAGE PART 
if (isset($_POST["cottage_submit"])) {
    
    // Collect form data
    $cottage_arrivalDate = $_POST["cottage_arrival"];
    $cottage_departureDate = $_POST["cottage_departure"];
    $cottage_roomQuantity = $_POST["cottage"];
    $cottage_adultGuestsQuantity = $_POST["cottage_adults"];
    $cottage_childrenGuestsQuantity = $_POST["cottage_children"];
    $cottage_message = $_POST["cottage_message"];
    $cottage_type = trim($_POST["cottage_type"]); // FIXED: trim to remove hidden spaces/tabs
    $cottage_reference_number = rand(5000, 9999999);
    $cottage_total_price = 2;
    $cottage_start = new DateTime($cottage_arrivalDate);
    $cottage_end = new DateTime($cottage_departureDate);
    $cottage_interval = $cottage_start->diff($cottage_end);
    $cottage_total_days = $cottage_interval->days;

    //PRICE UPDATE
    if($cottage_type == "Bamboo_Beach_Villa"){
       $cottage_total_price = (2000 *  $cottage_roomQuantity) * $cottage_total_days;
    }
    elseif($cottage_type == "Canopy_Lagoon_Suite"){
       $cottage_total_price = (3000 *  $cottage_roomQuantity) * $cottage_total_days;
    }
    elseif($cottage_type == "Deluxe_Ocean_View"){
       $cottage_total_price = (4000 *  $cottage_roomQuantity) * $cottage_total_days;
    }
    elseif($cottage_type == "Oceanfront_Overwater"){
       $cottage_total_price = (5000 *  $cottage_roomQuantity) * $cottage_total_days;
    } else {
      $cottage_total_price = 1;
    }

    // Create JSON data for reservation
    $reservation = [
        "referenceNum" => $cottage_reference_number,
        "full_name" => $_SESSION['full_name'],
        "cottage_type" => $cottage_type,
        "cottage_arrivalDate" => $cottage_arrivalDate,
        "cottage_departureDate" =>$cottage_departureDate,
        "cottage" => $cottage_roomQuantity,
        "adults" => $cottage_adultGuestsQuantity,
        "child" =>   $cottage_childrenGuestsQuantity,
        "message" =>   $cottage_message,
        "price" => $cottage_total_price,
        "days_of_stay" =>  $cottage_total_days
    ];
    

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

      

        // Check current available count
        $check = $conn->query("SELECT cottage_available FROM cottage_available WHERE cottage_name = '$cottage_type'");
        $data = $check->fetch_assoc();

        if ($data && $data['cottage_available'] >=  $cottage_roomQuantity) {
            // Decrease the count
            $update = $conn->query("UPDATE cottage_available 
                                    SET cottage_available = cottage_available - $cottage_roomQuantity 
                                    WHERE cottage_name = '$cottage_type'");
        } else {
            echo "<script>alert('Sorry, $cottage_type is fully booked or not enough rooms left!');</script>";
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
}
$conn->close();
?>

<!--  FRONT END CODE AREA -->
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
    <header class="justify-content-center d-flex bookingHeader">
       <div id="carouselExampleCaptions" class="carousel slide h-75">
        <div class="carousel-indicators">
          <button
            type="button"
            data-bs-target="#carouselExampleCaptions"
            data-bs-slide-to="0"
            class="active"
            aria-current="true"
            aria-label="Slide 1"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleCaptions"
            data-bs-slide-to="1"
            aria-label="Slide 2"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleCaptions"
            data-bs-slide-to="2"
            aria-label="Slide 3"
          ></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../assets/headerBg.png" class="d-block w-100" alt="..." />
            <div class="carousel-caption">
              <h5>Splash Resort Your Beachside Escape</h5>
              <p>
                Wake up to ocean views from our cozy rooms and private cottages.
                Relax by the infinity pool, stroll the sandy shore, and book
                your perfect stay today.
                <a href="Bookingpage.php">Reserve now</a>
              </p>
            </div>
          </div>
          <div class="carousel-item">
            <img
              src="../assets/TerracedGreenOverlook.webp"
              class="d-block w-100"
              alt="..."
            />
            <div class="carousel-caption">
              <h5>Rooms • Cottages • Pool • Beach View</h5>
              <p>
                Choose from seaside rooms or tucked-away cottages with stunning
                beach vistas. Enjoy a crystal-clear pool, shoreline sunsets, and
                easy online reservations for a hassle-free getaway.
              </p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../assets/seaview.jpg" class="d-block w-100" alt="..." />
            <div class="carousel-caption">
              <h5>Book Your Beach Getaway</h5>
              <p>
                Rooms and cottages with pool access and breathtaking beach
                views. Limited slots
                <a href="Bookingpage.php">reserve your dates</a> now!
              </p>
            </div>
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden z-3">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden z-3">Next</span>
        </button>
      </div>
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
<input type="submit" value="Book now" name="room_submit" class="form-control h-50 " >
    </form>
    </main>
    <!-- cottage -->
     <header class="justify-content-center d-flex bookingHeader">
       <div id="carouselExampleCaptions" class="carousel slide h-75">
        <div class="carousel-indicators">
          <button
            type="button"
            data-bs-target="#carouselExampleCaptions"
            data-bs-slide-to="0"
            class="active"
            aria-current="true"
            aria-label="Slide 1"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleCaptions"
            data-bs-slide-to="1"
            aria-label="Slide 2"
          ></button>
          <button
            type="button"
            data-bs-target="#carouselExampleCaptions"
            data-bs-slide-to="2"
            aria-label="Slide 3"
          ></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../assets/headerBg.png" class="d-block w-100" alt="..." />
            <div class="carousel-caption">
              <h5>Splash Resort Your Beachside Escape</h5>
              <p>
                Wake up to ocean views from our cozy rooms and private cottages.
                Relax by the infinity pool, stroll the sandy shore, and book
                your perfect stay today.
                <a href="Bookingpage.php">Reserve now</a>
              </p>
            </div>
          </div>
          <div class="carousel-item">
            <img
              src="../assets/TerracedGreenOverlook.webp"
              class="d-block w-100"
              alt="..."
            />
            <div class="carousel-caption">
              <h5>Rooms • Cottages • Pool • Beach View</h5>
              <p>
                Choose from seaside rooms or tucked-away cottages with stunning
                beach vistas. Enjoy a crystal-clear pool, shoreline sunsets, and
                easy online reservations for a hassle-free getaway.
              </p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="../assets/seaview.jpg" class="d-block w-100" alt="..." />
            <div class="carousel-caption">
              <h5>Book Your Beach Getaway</h5>
              <p>
                Rooms and cottages with pool access and breathtaking beach
                views. Limited slots
                <a href="Bookingpage.php">reserve your dates</a> now!
              </p>
            </div>
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden z-3">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#carouselExampleCaptions"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden z-3">Next</span>
        </button>
      </div>
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
    <form action="Bookingpage.php" method="post" class="d-flex flex-column gap-3 p-4 border text-center bookingPageForm justify-content-between ms-auto h-75">
  <h5>Book a Cottage</h5>
  <p>Rates from <b>PHP 5,999</b> per night</p>
  <hr>
  <h4>Plan your Cottage Stay</h4>

  <!-- COTTAGE TYPE -->
  <div class="w-100">
    <label for="cottageType" class="form-label fw-light">Select Cottage Type</label>
    <select class="form-select border-1 border-secondary" id="cottageType" name="cottage_type" required>
      <option value="bamboo_beach_villa">Bamboo Beach Villa</option>
      <option value="canopy_lagoon_suite">Canopy Lagoon Suite</option>
      <option value="deluxe_ocean_view">Deluxe Ocean View</option>
      <option value="oceanfront_overwater">Oceanfront Overwater</option>
    </select>
  </div>

  <!-- DATES -->
  <div class="d-flex flex-row gap-2 pe-2">
    <div class="w-50">
      <label for="">Date of Arrival</label>
      <input type="datetime-local" name="cottage_arrival" class="form-control" required>
    </div>
    <div class="w-50">
      <label for="">Date of Departure</label>
      <input type="datetime-local" name="cottage_departure" class="form-control" required>
    </div>
  </div>

  <!-- QUANTITY & GUESTS -->
  <div class="dropdown">
    <button class="btn w-100 dropdown-toggle border-1 border-secondary" type="button" id="dropdownMenuCottage" data-bs-toggle="dropdown" aria-expanded="false">
      Cottage Details
    </button>
    <ul class="dropdown-menu w-100 p-3" aria-labelledby="dropdownMenuCottage" id="cottageContainer">
      <div class="d-flex flex-column gap-2">
        <h6 class="dropdown-item fw-light">Max. 8 guests per cottage</h6>

        <!-- COTTAGE QUANTITY -->
        <div class="d-flex flex-row gap-2 ps-3 pe-2">
          <h6 class="fw-light pt-2">Cottage(s)</h6>
          <div class="d-flex flex-row justify-content-between ms-auto input-group w-50">
            <button class="btn btn-outline-secondary" type="button" id="cottage-minus">-</button>
            <input type="number" class="form-control text-center" value="1" min="1" id="cottage-input" name="cottage">
            <button class="btn btn-outline-secondary" type="button" id="cottage-plus">+</button>
          </div>
        </div>

        <!-- ADULT -->
        <div class="d-flex flex-row gap-2 ps-3 pe-2">
          <h6 class="fw-light pt-2">Adult(s)</h6>
          <div class="d-flex flex-row justify-content-between ms-auto input-group w-50">
            <button class="btn btn-outline-secondary" type="button" id="cottage-adult-minus">-</button>
            <input type="number" class="form-control text-center" value="1" min="1" id="cottage-adult-input" name="cottage_adults">
            <button class="btn btn-outline-secondary" type="button" id="cottage-adult-plus">+</button>
          </div>
        </div>

        <!-- CHILD -->
        <div class="d-flex flex-row gap-2 ps-3 pe-2">
          <h6 class="fw-light pt-2">Children (under 12)</h6>
          <div class="d-flex flex-row justify-content-between ms-auto input-group w-50">
            <button class="btn btn-outline-secondary" type="button" id="cottage-child-minus">-</button>
            <input type="number" class="form-control text-center" value="0" min="0" id="cottage-child-input" name="cottage_children">
            <button class="btn btn-outline-secondary" type="button" id="cottage-child-plus">+</button>
          </div>
        </div>

        <li><hr class="dropdown-divider"></li>
        <textarea
          name="cottage_message"
          id="cottage_message"
          style="resize: none"
          placeholder="Your Message"
          class="p-1 h-50 text-black"
        ></textarea>
      </div>
    </ul>
  </div>

  <!-- SUBMIT -->
  <input type="submit" value="Book Cottage" name="cottage_submit" class="form-control h-50">
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
  
 
  
  
</script>
      
  </body>
</html>
