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
    $room_to_restore = null;
    $quantity_to_restore = 0;

    // Find and remove the canceled reservation
      foreach ($data as $index => $reservation) {
        if (($reservation["referenceNum"] ?? $reservation["cottage_reference_number"]) == $deleteId) {
            
            // Detect if this is a cottage or a room
            if (isset($reservation["cottage_type"])) {
                $isCottage = true;
                $item_to_restore = $reservation["cottage_type"];
                $quantity_to_restore = $reservation["cottage"] ?? 0;
            } else {
                $isCottage = false;
                $item_to_restore = $reservation["room_type"];
                $quantity_to_restore = $reservation["room"] ?? 0;
            }

        } else {
            $updatedData[] = $reservation; // Keep other reservations
        }
    }

    // Update JSON reservations
    $newJson = json_encode($updatedData);
    $updateQuery = $conn->prepare("UPDATE user_account SET reservation = ? WHERE email = ?");
    $updateQuery->bind_param("ss", $newJson, $_SESSION["email"]);
    $updateQuery->execute();

    //  Add the canceled rooms back to available count
    if ($room_to_restore && $quantity_to_restore > 0) {
        $restore = $conn->prepare("
            UPDATE rooms_available 
            SET room_available = room_available + ? 
            WHERE room_name = ?
        ");
        $restore->bind_param("is", $quantity_to_restore, $room_to_restore);
        $restore->execute();
    }

   
    header("refresh:1;url=" . $_SERVER['PHP_SELF']);
    exit;
}

    } else {
        $emptyCart = 'No reservations yet';
    }
} else {
    header("Location: loginPage.php");
    exit();
}
if (isset($_POST['logout'])) {
    destroySession();
    header("Location: login.php");
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
    
  </style>
</head>

<body>
  <div class="container-fluid navDiv p-2">
    <nav class="navbar navbar-expand-lg d-flex justify-content-between align-items-center">
      <a href="Homepage.php" class="navbar-brand overflow-hidden d-flex">
        <img src="../assets/logo.png" height="50" />
        <h4 class="ms-2 fw-light mb-0 title-text">Splash Resort</h4>
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
              <form method="post">
              <li><button class="dropdown-item" name="logout" onclick="if(confirm('Log out?')) location.href='Homepage.php'">Log Out</button></li>
              </form>
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
  

    <!-- Reference Number Section -->
     <?php
if ($dataResult->num_rows > 0 && !empty($data)) {
  echo '  <div class="ReservationDiv mx-auto p-3 text-center mt-4">
      <h5 class="fw-bold mb-0">Reservation Information</h5>
    </div>';
    foreach ($data as $value) {
        echo '
<div class="InfoDiv mx-auto p-4 text-start mt-4 border rounded-3 shadow-sm bg-light" style="max-width: 600px;">
  <h4 class="fw-bold text-center mb-4 text-primary">
    Reference No: ' . htmlspecialchars($value["referenceNum"] ?? $value["cottage_reference_number"]) . '
  </h4>

  <div class="info-text mb-2">
    <span class="info-label fw-semibold text-secondary">Quantity:</span>
    <span class="ms-2">' . htmlspecialchars($value["rooms"] ?? $value["cottage"] ?? "N/A") . '</span>
  </div>

  <div class="info-text mb-2">
    <span class="info-label fw-semibold text-secondary">Type:</span>
    <span class="ms-2">' . htmlspecialchars(str_replace("_", " ", $value["room_type"] ?? $value["cottage_type"] ?? "N/A")) . '</span>
  </div>

  <div class="info-text mb-2">
    <span class="info-label fw-semibold text-secondary">Adults:</span>
    <span class="ms-2">' . htmlspecialchars($value["adults"] ?? $value["cottage_adults"] ?? "N/A") . '</span>
  </div>

  <div class="info-text mb-2">
    <span class="info-label fw-semibold text-secondary">Children:</span>
    <span class="ms-2">' . htmlspecialchars($value["child"] ?? $value["cottage_children"] ?? "N/A") . '</span>
  </div>

  <div class="info-text mb-2">
    <span class="info-label fw-semibold text-secondary">Arrival Date:</span>
    <span class="ms-2">' . htmlspecialchars($value["arrival"] ?? $value["cottage_arrivalDate"] ?? "N/A") . '</span>
  </div>

  <div class="info-text mb-2">
    <span class="info-label fw-semibold text-secondary">Departure Date:</span>
    <span class="ms-2">' . htmlspecialchars($value["departure"] ?? $value["cottage_departureDate"] ?? "N/A") . '</span>
  </div>

  <div class="info-text mb-2">
    <span class="info-label fw-semibold text-secondary">Message:</span>
    <span class="ms-2">' . htmlspecialchars($value["message"] ?? $value["cottage_message"] ?? "N/A") . '</span>
  </div>

  <div class="info-text mb-2">
    <span class="info-label fw-semibold text-secondary">Price:</span>
    <span class="ms-2">₱' . htmlspecialchars($value["price"] ?? "N/A") . '</span>
  </div>

  <div class="d-flex justify-content-center mt-4">
   <!-- Cancel Button that triggers modal -->
<div class="d-flex justify-content-center mt-4">
  <button 
    type="button" 
    class="btn btn-danger btn-sm px-4 rounded-pill shadow-sm"
    data-bs-toggle="modal" 
    data-bs-target="#cancelModal' . htmlspecialchars($value["referenceNum"] ?? $value["cottage_reference_number"]) . '">
    Cancel Reservation
  </button>
</div>

<!-- Modal for this reservation -->
<div class="modal fade" 
     id="cancelModal' . htmlspecialchars($value["referenceNum"] ?? $value["cottage_reference_number"]) . '" 
     tabindex="-1" 
     aria-labelledby="cancelModalLabel" 
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold" id="cancelModalLabel">Confirm Cancellation</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="fs-5 mb-2">Are you sure you want to cancel this reservation?</p>
        <p class="text-muted small">Reference No: ' . htmlspecialchars($value["referenceNum"] ?? $value["cottage_reference_number"]) . '</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <a href="?delete=' . urlencode($value["referenceNum"] ?? $value["cottage_reference_number"]) . '" class="btn btn-danger">Yes, Cancel</a>
      </div>
    </div>
  </div>
</div>

  </div>
</div>';

    }
} else {
    echo '<h4 class="text-center"> No Reservations Yet </h4>';
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