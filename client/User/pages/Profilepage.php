<?php
session_start();
 function logout(){
        session_unset();
        session_destroy();
        header("Location: Homepage.php");
        exit();
    }
    if(isset($_POST["logout"])){
        logout();
    }



if ($_SESSION['email']) {
    include "../../../backend/databaseconfig.php";
   if(isset($_POST['update'])){
            $updateId = $_GET['update'];
            $email = $_POST['email'];
            $full_name = $_POST['full_name'];
            $phone_number = $_POST['phone_number'];
            $updateQuery = $conn->prepare("UPDATE user_account SET full_name = ?, email = ?, phone_number = ? WHERE email = ?");
            $updateQuery->bind_param("ssss", $full_name,  $email, $phone_number, $_SESSION["email"]);
            $updateQuery->execute();
             $_SESSION["email"] = $email;

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    // Step 1: Get reservation JSON data for the logged-in user
    $result = $conn->prepare("SELECT reservation FROM user_account WHERE email = ?");
    $result->bind_param("s", $_SESSION["email"]);
    $result->execute();
    $dataResult = $result->get_result();

    $data = null;
    $emptyCart = null;
    
    
    if ($dataResult->num_rows > 0) {
        $row = $dataResult->fetch_assoc();
        $json_data = $row["reservation"];
        $data = json_decode($json_data, true);
        

        if (isset($_GET['delete'])) {
            $deleteId = $_GET['delete'];

            $updatedData = [];
            foreach ($data as $index => $reservation) {
                if ($reservation["referenceNum"] != $deleteId) {
                    $updatedData[] = $reservation;
                }
            }

            $newJson = json_encode($updatedData);
            $updateQuery = $conn->prepare("UPDATE user_account SET reservation = ? WHERE email = ?");
            $updateQuery->bind_param("ss", $newJson, $_SESSION["email"]);
            $updateQuery->execute();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        $emptyCart = 'No reservations yet';
    }
} else {
    header("Location: loginPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Splash Island</title>
  <link rel="icon" href="../assets/logo.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <link rel="stylesheet" href="Profilepage.css" />
  <style>
    /* Modal Styles */
    .modal-content {
      background: #2a2d31;
      color: #fff;
      border: 1px solid #444;
      border-radius: 10px;
    }
    
    .light-mode .modal-content {
      background: #fff;
      color: #000;
      border-color: #ddd;
    }
    
    .modal-header {
      border-bottom: 1px solid #444;
    }
    
    .light-mode .modal-header {
      border-bottom-color: #ddd;
    }
    
    .modal-footer {
      border-top: 1px solid #444;
    }
    
    .light-mode .modal-footer {
      border-top-color: #ddd;
    }
    
    .modal-body .form-control {
      background: #212428;
      border: 1px solid #333;
      color: #fff;
      border-radius: 5px;
    }
    
    .modal-body .form-control:focus {
      background: #212428;
      border-color: #555;
      color: #fff;
      box-shadow: 0 0 0 0.2rem rgba(255, 77, 77, 0.25);
    }
    
    .light-mode .modal-body .form-control {
      background: #f2f2f2;
      border-color: #ccc;
      color: #000;
    }
    
    .light-mode .modal-body .form-control:focus {
      background: #f2f2f2;
      border-color: #999;
      color: #000;
      box-shadow: 0 0 0 0.2rem rgba(255, 77, 77, 0.25);
    }
    
    .modal-body .form-label {
      color: #fff;
    }
    
    .light-mode .modal-body .form-label {
      color: #000;
    }
    
    .btn-close {
      filter: invert(1);
    }
    
    .light-mode .btn-close {
      filter: invert(0);
    }
  </style>
</head>

<body>
  <div class="container-fluid navDiv p-2">
    <nav class="navbar navbar-expand-lg d-flex justify-content-between align-items-center">
      <a href="Homepage.php" class="d-flex align-items-center text-decoration-none">
        <img src="../assets/logo.png" height="45" />
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

        <div class="d-none d-lg-flex align-items-center">
          <button id="themeToggle" class="icon-btn"><ion-icon name="sunny-outline"></ion-icon></button>
          <div class="dropdown">
            <button class="icon-btn" data-bs-toggle="dropdown" aria-expanded="false">
              <ion-icon name="person-circle-outline"></ion-icon>
            </button>
            <ul class="dropdown-menu dropdown-menu-end profile-dropdown">
              <li><button class="dropdown-item" onclick="if(confirm('Log out?')) location.href='Homepage.php'">Log Out</button></li>
              <li><button class="dropdown-item" data-bs-toggle="dropdown">Cancel</button></li>
            </ul>
          </div>
        </div>

        <div class="d-lg-none mobile-icons">
          <button id="mobileThemeToggle" class="icon-btn"><ion-icon name="sunny-outline"></ion-icon></button>
          <div class="dropdown">
            <button class="icon-btn" data-bs-toggle="dropdown" aria-expanded="false">
              <ion-icon name="person-circle-outline"></ion-icon>
            </button>
            <ul class="dropdown-menu profile-dropdown">
              <li><button class="dropdown-item" onclick="if(confirm('Log out?')) location.href='Homepage.php'">Log Out</button></li>
              <li><button class="dropdown-item" data-bs-toggle="dropdown">Cancel</button></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <div class="container text-center">
    <!-- Profile Information -->
    <div class="InfoDiv mx-auto p-4 text-start">
      <h4 class="fw-bold text-center mb-4">Profile Information</h4>
 <?php
          $user_info = $conn->prepare("SELECT full_name, email, phone_number FROM user_account WHERE email = ?");
        $user_info->bind_param("s", $_SESSION["email"]);
        $user_info->execute();
        $user_info = $user_info->get_result();
        while ($row = $user_info->fetch_assoc()) {
        echo '
        <div class="info-text">
        <span class="info-label">Full Name:</span>
        <span id="displayName">'. htmlspecialchars($row['full_name']) .'</span>
        </div>
        <div class="info-text">
        <span class="info-label"> Email:</span>
        <span id="displayEmail">'. htmlspecialchars($row['email']) . '</span>
        </div>
        <div class="info-text">
        <span class="info-label">Phone:</span>
        <span id="displayPhone">' . htmlspecialchars($row['phone_number']) .'</span>
        </div>
';
        }

        ?>
      </div>

      <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#profileModal">Customize</button>
      </div>
    </div>

    <!-- Reservation Information Divider -->
    <div class="ReservationDiv mx-auto p-3 text-center mt-4">
      <h5 class="fw-bold mb-0">Reservation Information</h5>
    </div>

    <!-- Reference Number Section -->
     <?php
     if ($dataResult->num_rows > 0 && !empty($data)) {
            foreach ($data as $value) {
               echo '
    <div class="InfoDiv mx-auto p-4 text-start mt-4 border">
      <h4 class="fw-bold text-center mb-4">Reference No: '. urlencode($value["referenceNum"]) .'</h4>
      <div class="info-text"><span class="info-label">Room Quantity:</span>'. htmlspecialchars($value["rooms"]) . '</div>
      <div class="info-text"><span class="info-label">Adults:</span>'. htmlspecialchars($value["adults"]) .'</div>
      <div class="info-text"><span class="info-label">Children:</span>' . htmlspecialchars($value["child"]) .'</div>
      <div class="info-text"><span class="info-label">Arrival Date:</span>'. htmlspecialchars($value["arrival"]) .'</div>
      <div class="info-text"><span class="info-label">Departure Date:</span>'. htmlspecialchars($value["departure"]) .'</div>
       <div class="info-text"><span class="info-label">Departure Date:</span>'. htmlspecialchars($value["message"]) .'</div>
      <div class="d-flex justify-content-between align-items-center mt-3">
       <a href="?delete=' . urlencode($value["referenceNum"]) . '" class="btn btn-sm btn-danger" ">Cancel</a>
      </div>
    </div>';
            }
        } else {
            echo '<h4>' . $emptyCart . '</h4>';
        }
   
    ?>
  </div>

  <!-- Profile Edit Modal -->
  <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <form method="post">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="profileModalLabel">Edit Profile Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editName" class="form-label fw-bold">Full Name:</label>
            <input type="text" class="form-control" id="editName" name="full_name">
          </div>
          <div class="mb-3">
            <label for="editEmail" class="form-label fw-bold">Email:</label>
            <input type="text" class="form-control" id="editEmail" name="email">
          </div>
          <div class="mb-3">
            <label for="editPhone" class="form-label fw-bold">Phone:</label>
            <input type="text" class="form-control" id="editPhone" name="phone_number">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success" id="saveBtn" name="update">Save Changes</button>
        </div>
      </div>
    </div>
      </form>
  </div>

  <footer class="fw-light w-100 p-3 mt-5 footer">© 2025 Splash Island Co. All Rights Reserved.</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Theme toggle functionality
    const toggleTheme = () => {
      document.body.classList.toggle("light-mode");
      const icon = document.body.classList.contains("light-mode") ? "moon-outline" : "sunny-outline";
      document.querySelectorAll("#themeToggle ion-icon, #mobileThemeToggle ion-icon").forEach(el => el.name = icon);
    };

    document.getElementById("themeToggle").onclick = toggleTheme;
    document.getElementById("mobileThemeToggle").onclick = toggleTheme;
  </script>
</body>
</html>