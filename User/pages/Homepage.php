<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../assets/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Splash Island</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bitcount:wght@100..900&family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Edu+AU+VIC+WA+NT+Pre:wght@400..700&family=Lilita+One&family=Montserrat:wght@600&family=MuseoModerno:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
    <!-- NAVPART -->
     <div class="container-fluid bg-dark">
         <nav class="navbar navbar-expand-md ">
        <a href="" class="navbar-brand overflow-hidden d-flex " >
            <img src="../assets/logo.png" alt="" class="logo h-50">
            <h3 class="text-white ps-3  mt-3 fw-lighter">Splash Island</h3>
        </a>
        <button class="navbar-toggler me-2 navbar-white" type="button" data-bs-toggle="collapse" data-bs-target="#main-navigation">
           <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pe-5" id="main-navigation">
            <ul class="navbar-nav  ms-auto ps-5 ">
                 <li class="nav-item nav-li"><a href="" class="nav-link text-white">Home</a></li>
                <li class="nav-item nav-li"><a href="" class="nav-link text-white">Amenities</a></li>
                <li class="nav-item nav-li"><a href="" class="nav-link text-white">Contact</a></li>
                <li class="nav-item nav-li"><a href="Bookingpage.php" class="nav-link text-white">Book Now</a></li>
            </ul>
        </div>
    </nav>
     </div>
   
    <!-- HERO SECTION -->
    <header>
    <div id="carouselExampleCaptions" class="carousel slide h-75">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../assets/headerBg.png" class="d-block w-100" alt="...">
     <div class="carousel-caption">
       <h5>Splash Island Resort Your Beachside Escape</h5>
<p>Wake up to ocean views from our cozy rooms and private cottages. Relax by the infinity pool, stroll the sandy shore, and book your perfect stay today. <a href="Bookingpage.php">Reserve now</a></p>

      </div>
    </div>
    <div class="carousel-item">
      <img src="../assets/Terraced Green Overlook.webp" class="d-block w-100" alt="...">
      <div class="carousel-caption">
        <h5>Rooms • Cottages • Pool • Beach View</h5>
<p>Choose from seaside rooms or tucked-away cottages with stunning beach vistas. Enjoy a crystal-clear pool, shoreline sunsets, and easy online reservations for a hassle-free getaway.</p>

      </div>
    </div>
    <div class="carousel-item">
      <img src="../assets/seaview.jpg" class="d-block w-100" alt="...">
     <div class="carousel-caption ">
       <h5>Book Your Beach Getaway</h5>
<p>Rooms and cottages with pool access and breathtaking beach views. Limited slots <a href="Bookingpage.php">reserve your dates</a> now!</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden z-3">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden z-3">Next</span>
  </button>
</div>
   </header>
    <!-- MAIN PART -->
    <main class="bg-dark pb-3">
    <h3 class="text-center pt-3  fw-lighter">Amenities</h3>
    
    <div class="roomsContainer ">
    <h2 class="ms-5 fw-light">Rooms</h2>
    <div class="card-container p-5 d-md-flex gap-2 d-grid mb-sm-5  p-3 overflow-x-scroll">
        <div class="card card-body overflow-hidden bg-dark border-secondary">
            <img src="../assets/Deluxe Warm Earth Suite.jpg" alt="">
            <h4 class="pt-3 ">Deluxe Warm Earth Suite</h4>
            <p>Deluxe Warm Earth Suite offers a comfortable and practical stay. The room features a plush king-size bed, a cozy sitting area, and essential amenities, providing a relaxing and convenient environment.</p>
        </div>
        <div class="card card-body overflow-hidden bg-dark border-secondary">
            <img src="../assets/Primary Taupe Sanctuary.jpg" alt="">
             <h4 class="pt-3 ">Primary Taupe Sanctuary</h4>
            <p>Primary Taupe Sanctuary offers a warm and inviting experience. The room features a plush king-size bed, a comfortable chaise lounge, and elegant decor, creating a relaxing and sophisticated ambiance.</p>
        </div>
       <div class="card card-body overflow-hidden bg-dark border-secondary">
            <img src="../assets/Primary Urban Quarters.jpg" alt="">
             <h4 class="pt-3 ">Primary Urban Quarters</h4>
            <p>Primary Urban Quarters offers a relaxing and refined experience. The room features a plush king-size bed, comfortable armchairs, and elegant decor, creating a tranquil and sophisticated ambiance.</p>
        </div>
         <div class="card card-body overflow-hidden bg-dark border-secondary">
            <img src="../assets/Signature Grand King.jpg" alt="">
             <h4 class="pt-3 ">Signature Grand King</h4>
            <p>Signature Grand King offers a luxurious urban retreat with sophisticated decor. The room features a plush king-size bed, a comfortable seating area, and elegant furnishings, creating a stylish and relaxing ambiance.</p>
        </div>
         <div class="card card-body overflow-hidden bg-dark border-secondary">
            <img src="../assets/Signature Tropical Design.jpg" alt="">
             <h4 class="pt-3 ">Deluxe Warm Earth Suite</h4>
            <p>Exotic Haven Resort offers a luxurious, culturally rich experience. The room features a comfortable king-size bed, elegant wall art, and native-inspired accents, creating a tranquil and sophisticated ambiance.</p>
        </div>
        </div>
    </div>

    <!-- Cottages -->
    <div class="cottagesContainer ">
    <h2 class="ms-5 fw-light text-end pe-5">Cottages</h2>
    <div class="card-container  d-md-flex gap-2 d-grid mb-sm-5  p-5 overflow-x-scroll">
        <div class="card card-body overflow-hidden bg-dark border-secondary">
            <img src="../assets/Bamboo Beach Villa.jpg" alt="">
            <h4 class="pt-3 ">Bamboo Beach Villa</h4>
            <p>Bamboo Beach Villa offers unparalleled luxury with meticulously designed suites featuring breathtaking views. Each suite comfortably accommodates up to four people, boasting a king-size bed, a sophisticated living area, and contemporary bathrooms with premium fixtures like a walk-in shower and soaking tub. Guests enjoy a private balcony, a fully equipped kitchen, and personalized concierge services.</p>
           
        </div>
        <div class="card card-body overflow-hidden bg-dark border-secondary">
            <img src="../assets/Canopy Lagoon Suite.jpg" alt="">
            <h4 class="pt-3 ">Canopy Lagoon Suite</h4>
            <p>offers a luxurious beachfront escape with stunning ocean views. The villa features a four-poster bed draped in elegant white curtains, a comfortable seating area, and direct access to a private balcony overlooking the turquoise waters. The spacious interior is complemented by modern amenities and a serene ambiance, perfect for a relaxing getaway.</p>
        </div>
       <div class="card card-body overflow-hidden bg-dark border-secondary ">
            <img src="../assets/Deluxe Ocean View Room.jpg" alt="">
            <h4 class="pt-3">Deluxe Ocean View Room</h4>
            <p>Deluxe Ocean View Room offers a serene and luxurious escape with stunning ocean views. The room features a comfortable king-size bed, a cozy seating area, and a private balcony overlooking the turquoise waters. The interior is elegantly designed with warm wood accents and modern amenities, creating a perfect blend of comfort and sophistication for an unforgettable getaway.</p>
        </div>
         <div class="card card-body overflow-hidden bg-dark border-secondary">
            <img src="../assets/Oceanfront Overwater Haven.jpg" alt="">
            <h4 class="pt-3" >Oceanfront Overwater Haven</h4>
            <p>Oceanfront Overwater Haven offers a luxurious overwater retreat with breathtaking sunset views. The villa features a plush king-size bed, a cozy daybed with decorative pillows, and a private deck with lounge chairs overlooking the ocean. The warm wooden interiors and elegant decor create a serene and sophisticated ambiance for an unforgettable stay.</p>
        </div>
        </div>
    </div>
     <h2 class="text-center fw-light">Restaurant</h2>
     <div class="restaurantSection row gap-5 g-3 g-lg-5 p-2 p-lg-5 p-4">
        <section class="restaurantDesctription order-2 order-md-1 col-12 col-md-4 mb-5 pt-md-3 ps-md-5">
    <h4>Fresh Flavors of the Sea</h4>
    <p>Experience signature seafood cuisine at Splash Island, where every dish is crafted with the flavors of the ocean and a view of the waves.</p>
    <button class="w-50 p-3 border-1 bg-dark border-white">Learn More</button>
        </section>
        <img src="../assets/restaurant.png" alt="" class="order-1 order-md-1 col-12 col-md-4 h-md-100 h-sm-25 ms-md-5">
     </div>
    <h2 class="text-center fw-light">Swimming Pool</h2>
     <div class="restaurantSection row gap-5 g-3 g-lg-5 p-2 p-lg-5 p-4">
        <img src="../assets/pool.png" alt="" class="order-1 order-md-1 col-12 col-md-4 h-md-100 h-sm-25 ms-md-5">
        <section class="restaurantDesctription order-2 order-md-1 col-12 col-md-4 mb-5 ps-md-5 ps-sm-0">
    <h4>Crystal-Clear Swimming Pool</h4>
    <p>Take a refreshing dip in our sparkling pool, perfect for family fun or a relaxing swim after a day at the beach.</p>
    <button class="w-50 p-3 border-1 bg-dark border-white">Learn More</button>
        </section>
     </div>
      <h1 class="text-center mt-md-5">GET IN TOUCH</h1>
      <p class="text-center">Have questions? We'd love to hear from you!</p>
     <div class="messageform d-flex justify-content-center align-content-center text-center mt-3 p-md-5">
      <form action="post" class="d-flex flex-column gap-3 w-50">
    
        <div class="d-md-flex flex-md-row w-100 gap-2" >
        <input type="text" name="username" id="" placeholder="Full Name" class=" w-100">
        <input type="email" name="address" placeholder="Email Address" class=" w-100 mt-3 mt-md-0">
        </div>
        <div class="d-md-flex flex-md-row gap-2 ">
        <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Phone Number" class=" w-100">
        <input type="date" name="" id="" class=" w-100 mt-3 mt-md-0">
        </div>
        <textarea name="" id="messagearea" style="resize:none" placeholder="Your Message" class="p-1 h-50"></textarea>
        <input type="submit" value="SEND MESSAGE" class="w-sm-50 w-md-25  align-self-center p-2 rounded bg-dark border-white text-white">
      </form>
     </div>
     
    </main>
    <!-- FOOTER PART -->

   <footer class="p-3" style="background: #3e3e3eff;">
    
  <div class="info d-flex gap-md-5 justify-content-center p-md-5 flex-wrap">
    <img src="../assets/logo.png" alt="" class="align-self-center">
    <div class="d-block d-md-none mb-3 w-100">
      <button class="btn btn-none w-100 text-start text-white" type="button" data-bs-toggle="collapse" data-bs-target="#findBookMobile">
        Find & Book <ion-icon name="chevron-down-outline" class="ps-2 pt-1"></ion-icon>
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
      <button  class="btn btn-none w-100 text-start text-white" type="button" data-bs-toggle="collapse" data-bs-target="#circleMobile">
        Splash Island Circle <ion-icon name="chevron-down-outline" class="ps-2 pt-1"></ion-icon>
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
      <button  class="btn btn-none w-100 text-start text-white"type="button" data-bs-toggle="collapse" data-bs-target="#aboutMobile">
        About Splash Island <ion-icon name="chevron-down-outline" class="ps-2 pt-1"></ion-icon>
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
    <h5 class="text-center fw-light w-100 p-3 bg-dark text-white" style="font-size:14px;">Privacy Policy | Terms & Conditions | Safety & Security | Supplier Code of Conduct | Cyber Security <br>
© 2025 Splash Island Co. All Rights Reserved. ICP license: 22007722</h5>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>