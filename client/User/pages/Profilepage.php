<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Splash Island</title>
<link rel="icon" href="../assets/logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<style>
body {
  font-family: Roboto, sans-serif;
  background: #1b1f22;
  color: #fff;
  transition: 0.4s;
}
.light-mode { background: #f8f9fa; color: #000; }
.navDiv { background: #15181a; transition: 0.4s; }
.light-mode .navDiv { background: #fff; }
.nav-link { color: #fff !important; }
.light-mode .nav-link { color: #000 !important; }
.title-text { color: #fff; transition: 0.4s; }
.light-mode .title-text { color: #000; }

.InfoDiv {
  background: #2a2d31;
  border-radius: 10px;
  box-shadow: 0 0 15px rgba(0,0,0,.3);
  max-width: 600px;
  margin-top: 50px;
  transition: 0.4s;
}
.light-mode .InfoDiv { background: #fff; }
.infoBox {
  background: #212428;
  border: 1px solid #333;
  border-radius: 5px;
  padding: 8px 12px;
  margin-bottom: 10px;
}
.light-mode .infoBox { background: #f2f2f2; color: #000; }

.reference-number { font-weight: 600; color: #ccc; }
.light-mode .reference-number { color: #000; }
.footer { font-size: 14px; text-align: center; margin-top: 50px; color: #aaa; }
.light-mode .footer { color: #333; }

.profile-dropdown {
  position: absolute;
  top: 60px;
  right: 15px;
  display: none;
  flex-direction: column;
  width: 160px;
  background: #2a2d31;
  border: 1px solid #444;
  border-radius: 10px;
  padding: 8px;
  z-index: 1000;
}
.light-mode .profile-dropdown { background: #fff; border-color: #ddd; }
.profile-dropdown button {
  border: none;
  background: none;
  padding: 8px;
  text-align: left;
  color: #fff;
  border-radius: 5px;
}
.profile-dropdown button:hover { background: #000; color: #fff; }
.light-mode .profile-dropdown button { color: #000; }
.icon-btn {
  background: none;
  border: none;
  color: #fff;
  font-size: 22px;
  margin-left: 10px;
}
.light-mode .icon-btn { color: #000; }

/* --- MOBILE VIEW --- */
.navbar-toggler { border: none; background: none; color: #fff; font-size: 26px; }
.light-mode .navbar-toggler { color: #000; }

@media (max-width: 991px) {
  .navbar-collapse {
    background: #15181a;
    border-radius: 10px;
    padding: 15px;
    text-align: left;
  }
  .light-mode .navbar-collapse { background: #fff; }
  .navbar-collapse .nav-link { display: block; margin: 5px 0; }

  .mobile-icons {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
  }

  /* show dropdown below mobile icons */
  .profile-dropdown.mobile-show {
    position: relative;
    top: 5px;
    right: 0;
    display: flex !important;
    width: 100%;
    background: none;
    border: none;
    padding: 0;
  }
  .profile-dropdown.mobile-show button {
    background: #2a2d31;
    border-radius: 8px;
    margin-top: 5px;
    color: #fff;
  }
  .light-mode .profile-dropdown.mobile-show button {
    background: #eee;
    color: #000;
  }
}
</style>
</head>

<body>
<div class="container-fluid navDiv p-2">
  <nav class="navbar navbar-expand-lg d-flex justify-content-between align-items-center">
    <a href="Homepage.php" class="d-flex align-items-center text-decoration-none">
      <img src="../assets/logo.png" height="45">
      <h4 class="ms-2 fw-light mb-0 title-text">Splash Island</h4>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <ion-icon name="menu-outline"></ion-icon>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
      <ul class="navbar-nav align-items-lg-center">
        <li class="nav-item"><a href="Homepage.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="Amenitiespage.php" class="nav-link">Amenities</a></li>
        <li class="nav-item"><a href="Contactpage.php" class="nav-link">Contact</a></li>
        <li class="nav-item"><a href="Bookingpage.php" class="nav-link">Book Now</a></li>
      </ul>

      <!-- Desktop Icons -->
      <div class="d-none d-lg-flex align-items-center">
        <button id="themeToggle" class="icon-btn"><ion-icon name="sunny-outline"></ion-icon></button>
        <div class="position-relative">
          <button id="profileIcon" class="icon-btn"><ion-icon name="person-circle-outline"></ion-icon></button>
          <div class="profile-dropdown" id="profileDropdown">
            <button id="logoutBtn">Log Out</button>
            <button id="cancelBtn2">Cancel</button>
          </div>
        </div>
      </div>

      <!-- Mobile Icons (inside dropdown) -->
      <div class="d-lg-none mobile-icons">
        <button id="mobileThemeToggle" class="icon-btn"><ion-icon name="sunny-outline"></ion-icon></button>
        <button id="mobileProfile" class="icon-btn"><ion-icon name="person-circle-outline"></ion-icon></button>
        <div class="profile-dropdown" id="mobileDropdown">
          <button id="mobileLogout">Log Out</button>
          <button id="mobileCancel">Cancel</button>
        </div>
      </div>
    </div>
  </nav>
</div>

<!-- Info Section -->
<div class="container text-center">
  <div class="InfoDiv mx-auto p-4 text-start">
    <h4 class="fw-bold text-center mb-4">Profile Information</h4>
    <div class="infoBox"><b>Full Name:</b> Marco</div>
    <div class="infoBox"><b>Email:</b> qmbbunao</div>
    <div class="infoBox"><b>Phone:</b> 099992123</div>
  </div>

  <div class="InfoDiv mx-auto p-4 text-start mt-4">
    <h4 class="fw-bold text-center mb-4">Reservation Information</h4>
    <div class="infoBox"><b>Room Type:</b> Ocean View Deluxe</div>
    <div class="infoBox"><b>Adults:</b> 2</div>
    <div class="infoBox"><b>Children:</b> 1</div>
    <div class="infoBox"><b>Arrival Date:</b> November 15, 2025</div>
    <div class="infoBox"><b>Departure Date:</b> November 18, 2025</div>
    <div class="d-flex justify-content-between align-items-center mt-3">
      <div class="reference-number">Reference No: 31479425</div>
      <button class="btn btn-danger px-4" id="cancelBtn">Cancel</button>
    </div>
  </div>
</div>

<footer class="fw-light w-100 p-3 mt-5 footer">© 2025 Splash Island Co. All Rights Reserved.</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
const body=document.body;
const themeBtns=[document.getElementById("themeToggle"),document.getElementById("mobileThemeToggle")];
const profileBtns=[document.getElementById("profileIcon"),document.getElementById("mobileProfile")];
const profileDropdown=document.getElementById("profileDropdown");
const mobileDropdown=document.getElementById("mobileDropdown");

themeBtns.forEach(btn=>{
  btn.onclick=()=>{
    body.classList.toggle("light-mode");
    themeBtns.forEach(b=>{
      b.querySelector("ion-icon").name=body.classList.contains("light-mode")?"moon-outline":"sunny-outline";
    });
  };
});

profileBtns[0].onclick=()=>{
  profileDropdown.style.display=profileDropdown.style.display==="flex"?"none":"flex";
};
profileBtns[1].onclick=()=>{
  mobileDropdown.classList.toggle("mobile-show");
};

// Hide dropdowns if clicked outside
document.addEventListener("click",e=>{
  if(!profileDropdown.contains(e.target)&&!profileBtns[0].contains(e.target))
    profileDropdown.style.display="none";
  if(!mobileDropdown.contains(e.target)&&!profileBtns[1].contains(e.target))
    mobileDropdown.classList.remove("mobile-show");
});

// Buttons
document.getElementById("logoutBtn").onclick=()=>{if(confirm("Log out?"))location.href="Homepage.php";};
document.getElementById("mobileLogout").onclick=()=>{if(confirm("Log out?"))location.href="Homepage.php";};
document.getElementById("cancelBtn2").onclick=()=>profileDropdown.style.display="none";
document.getElementById("mobileCancel").onclick=()=>mobileDropdown.classList.remove("mobile-show");
document.getElementById("cancelBtn").onclick=()=>{if(confirm("Cancel reservation?"))location.href="Homepage.php";};
</script>
</body>
</html>
