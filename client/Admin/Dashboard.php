<?php
session_start();
include "../../backend/databaseconfig.php";
if($_SESSION['adminEmail'] ){
// DELETE Functionality for inquiries
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM user_inquiries WHERE id = $id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// FETCH all data
$sql = "SELECT id, full_name, email, date, phone_number, message FROM user_inquiries";
$result = $conn->query($sql);

// FETCH RESERVATION DATA FROM ALL USERS
$reservationSql = "SELECT reservation, email, full_name FROM user_account";
$reservationResult = $conn->query($reservationSql);
$reservationData = [];

if ($reservationResult->num_rows > 0) {
    while ($row = $reservationResult->fetch_assoc()) {
        $json_data = $row["reservation"];
        $decoded = json_decode($json_data, true);
        if (is_array($decoded)) {
            $reservationData = array_merge($reservationData, $decoded);
        }
    }
}

//  DELETE RESERVATION AND RESTORE ROOM COUNT
if (isset($_GET['deleteReservation'])) {
    $deleteRef = $_GET['deleteReservation'];

    // Fetch all users to find which one has this reservation
    $reservationSql = "SELECT email, reservation FROM user_account";
    $reservationResult = $conn->query($reservationSql);

    if ($reservationResult->num_rows > 0) {
        while ($row = $reservationResult->fetch_assoc()) {
            $email = $row["email"];
            $json_data = $row["reservation"];
            $decoded = json_decode($json_data, true);

            if (is_array($decoded)) {
                $updatedData = [];
                $found = false;
                $room_type = "";
                $room_qty = 0;

                // Loop through each reservation
                foreach ($decoded as $reservation) {
                    if ($reservation["referenceNum"] != $deleteRef) {
                        $updatedData[] = $reservation;
                    } else {
                        // Found reservation to delete
                        $found = true;
                        $room_type = $reservation["room_type"];
                        $room_qty = (int)$reservation["rooms"];
                    }
                }

                // If found, update user_account JSON
                if ($found) {
                    $newJson = json_encode($updatedData);
                    $updateQuery = "UPDATE user_account SET reservation='$newJson' WHERE email='$email'";
                    $conn->query($updateQuery);

                    // 🔹 Restore room availability
                    if (!empty($room_type) && $room_qty > 0) {
                        $room_type = $conn->real_escape_string($room_type);
                        $conn->query("
                            UPDATE rooms_available
                            SET room_available = room_available + $room_qty
                            WHERE room_name = '$room_type'
                        ");
                    }

                    break; // stop once reservation found and updated
                }
            }
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// FETCH ROOMS AND COTTAGE DATA
$roomsAvaialbleSql = "SELECT * FROM rooms_available";
$rooms_avaialble_result = $conn->query($roomsAvaialbleSql);

$cottageAvaialbleSql = "SELECT * FROM cottage_available";
$cottage_available_result = $conn->query($cottageAvaialbleSql);

// DISPLAY FUNCTIONS
  // DISPLAY FUNCTIONS
  function showInquiries($result)
  {
    if ($result->num_rows > 0) {
      while ($data = $result->fetch_assoc()) {
        $modalId = "deleteInquiryModal" . $data['id'];

        echo "<tr>";
        echo "<th scope='row'>" . $data['id'] . "</th>";
        echo "<td>" . htmlspecialchars($data['full_name']) . "</td>";
        echo "<td>" . htmlspecialchars($data['email']) . "</td>";
        echo "<td>" . htmlspecialchars($data['date']) . "</td>";
        echo "<td>" . htmlspecialchars($data['message']) . "</td>";

        echo "
        <td>
          <button type='button' class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#$modalId'>
            Delete
          </button>

          <div class='modal fade' id='$modalId' tabindex='-1' aria-labelledby='{$modalId}Label' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
              <div class='modal-content border-0 shadow'>
                <div class='modal-header bg-danger text-white'>
                  <h5 class='modal-title' id='{$modalId}Label'>Confirm Delete</h5>
                  <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
                </div>
                <div class='modal-body text-center'>
                  <p>Are you sure you want to delete this inquiry?</p>
                </div>
                <div class='modal-footer justify-content-center'>
                  <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                  <a href='?delete=" . urlencode($data["id"]) . "' class='btn btn-danger'>Yes, Delete</a>
                </div>
              </div>
            </div>
          </div>
        </td>";
        echo "</tr>";
      }
    } else {
      echo "<tr><td colspan='6' class='text-center text-muted'>No Data Yet</td></tr>";
    }
  }


function showReservationForRoom($reservationData)
{
    if (!empty($reservationData)) {
        $hasData = false;
        foreach ($reservationData as $data) {
            if (isset($data['room_type']) && in_array($data['room_type'], [
                'deluxe_warm_earth_suite',
                'primary_taupe_sanctuary',
                'primary_urban_quarters',
                'signature_grand_king',
                'exotic_haven'
            ])) {
                $hasData = true;
                echo "<tr>";
                echo "<td>" . htmlspecialchars($data['referenceNum']) . "</td>";
                echo "<td>" . htmlspecialchars($data['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($data['room_type']) . "</td>";
                echo "<td>" . htmlspecialchars($data['arrival']) . "</td>";
                echo "<td>" . htmlspecialchars($data['departure']) . "</td>";
                echo "<td>" . htmlspecialchars($data['days_of_stay']) . "</td>";
                echo "<td>" . htmlspecialchars($data['rooms']) . "</td>";
                echo "<td>" . htmlspecialchars($data['adults']) . "</td>";
                echo "<td>" . htmlspecialchars($data['child']) . "</td>";
                echo "<td>" . htmlspecialchars($data['price']) . "</td>";
                echo "<td>" . htmlspecialchars($data['message']) . "</td>";
               echo "
 <td>
      <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmDeleteModalForRoom'>
        Delete
      </button>

      <!-- Modal -->
      <div class='modal fade' id='confirmDeleteModalForRoom' tabindex='-1' aria-labelledby='confirmDeleteModalForRoom' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered'>
          <div class='modal-content border-0 shadow'>
            <div class='modal-header bg-danger text-white'>
              <h5 class='modal-title' id='confirmDeleteModalForRoom'>Confirm Delete</h5>
              <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body text-center'>
              <p>Are you sure you want to delete this room reservation?</p>
            </div>
            <div class='modal-footer justify-content-center'>
              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
              <a href='?delete=" . urlencode($data['referenceNum']) . "' class='btn btn-danger'>Yes, Delete</a>
            </div>
          </div>
        </div>
      </div>
    </td>
 
";

            }
        }
        if (!$hasData) {
            echo "<tr><td colspan='12' class='text-center text-muted'>No Room Reservations Yet</td></tr>";
        }
    } else {
        echo "<tr><td colspan='12' class='text-center text-muted'>No Data Yet</td></tr>";
    }
}


//Cottage reservation
function showReservationForCottage($reservationData)
{
    if (!empty($reservationData)) {
        $hasData = false;
        foreach ($reservationData as $data) {
            if (isset($data['cottage_type']) && in_array($data['cottage_type'], [
                'bamboo_beach_villa',
                'canopy_lagoon_suite',
                'deluxe_ocean_view',
                'oceanfront_overwater'
            ])) {
                $hasData = true;
                echo "<tr>";
                echo "<td>" . htmlspecialchars($data['referenceNum']) . "</td>";
                echo "<td>" . htmlspecialchars($data['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($data['cottage_type']) . "</td>";
                echo "<td>" . htmlspecialchars($data['cottage_arrivalDate']) . "</td>";
                echo "<td>" . htmlspecialchars($data['cottage_departureDate']) . "</td>";
                echo "<td>" . htmlspecialchars($data['days_of_stay']) . "</td>";
                echo "<td>" . htmlspecialchars($data['cottage']) . "</td>";
                echo "<td>" . htmlspecialchars($data['adults'] ?? $data['cottage_adults'] ?? 'N/A') . "</td>";
                echo "<td>" . htmlspecialchars($data['child'] ?? $data['cottage_children'] ?? 'N/A') . "</td>";
                echo "<td>" . htmlspecialchars($data['price']) . "</td>";
                echo "<td>" . htmlspecialchars($data['message']) . "</td>";
                  echo "
  <td>
    <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmDeleteCottageModal'>
      Delete
    </button>

    <!-- Cottage Delete Confirmation Modal -->
    <div class='modal fade' id='confirmDeleteCottageModal' tabindex='-1' aria-labelledby='confirmDeleteCottageModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content border-0 shadow'>
          <div class='modal-header bg-danger text-white'>
            <h5 class='modal-title' id='confirmDeleteCottageModalLabel'>Confirm Cottage Deletion</h5>
            <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body text-center'>
            <p>Are you sure you want to delete this cottage reservation?</p>
          </div>
          <div class='modal-footer justify-content-center'>
            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
            <a href='?deleteCottage=" . urlencode($data['referenceNum']) . "' class='btn btn-danger'>Yes, Delete</a>
          </div>
        </div>
      </div>
    </div>
  </td>
";

                echo "</tr>";
            }
        }
        if (!$hasData) {
            echo "<tr><td colspan='12' class='text-center text-muted'>No Cottage Reservations Yet</td></tr>";
        }
    } else {
        echo "<tr><td colspan='12' class='text-center text-muted'>No Data Yet</td></tr>";
    }
}


function showRoomAvailable($rooms_avaialble_result)
{
    if (!empty($rooms_avaialble_result)) {
        foreach ($rooms_avaialble_result as $data) {
            echo "<tr>";
            echo "<td>" . $data['id'] . "</td>";
            echo "<td>" . $data['room_name'] . "</td>";
            echo "<td>" . $data['room_available'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='text-center text-muted'>No Data Yet</td></tr>";
    }
}

function showCottageAvailable($cottage_available_result)
{
    if (!empty($cottage_available_result)) {
        foreach ($cottage_available_result as $data) {
            echo "<tr>";
              echo "<td>" . $data['id'] . "</td>";
            echo "<td>" . $data['cottage_name'] . "</td>";
            echo "<td>" . $data['cottage_available'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='text-center text-muted'>No Data Yet</td></tr>";
    }
}
}else{
      header("Location: adminLoginPage.php");
      exit();
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" href="/client/User/assets/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Splash Island</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
  </head>

  <body>
    <nav class="p-3 bg-black">
      <h2 class="text-white fw-bold">Splash Island</h2>
    </nav>

    <main class="d-flex flex-row" style="height: 100vh;">
      <!-- Sidebar -->
      <div class="d-flex flex-column p-3 text-white bg-dark h-100" style="width: 280px;">
        <h4 class="mb-4">Dashboard</h4>
        <form method="post">
          <button type="submit" name="inquiries" class="btn btn-outline-light mb-2 w-100 text-start">Inquiries</button>
          <button type="submit" name="reservations" class="btn btn-outline-light mb-2 w-100 text-start">Room Reservations</button>
           <button type="submit" name="cottage_reservations" class="btn btn-outline-light mb-2 w-100 text-start">Cottage Reservations</button>
          <button type="submit" name="roomsAvailable" class="btn btn-outline-light mb-2 w-100 text-start">Room Available</button>
          <button type="submit" name="cottageAvailable" class="btn btn-outline-light mb-2 w-100 text-start">Cottage Available</button>
        </form>
      </div>

      <!-- Table Section -->
      <div class="p-4 flex-grow-1">
        <table class="table table-striped">
          <thead class="table-dark">
            <?php
            if (isset($_POST['reservations'])) {
               echo ' <tr>
              <th>Reference Number</th>
              <th>Name</th>
              <th>Room Type</th>
              <th>Arrival Date</th>
              <th>Departure Date</th>
               <th>Total Days of Stay</th>
              <th>Rooms</th>
              <th>Adults</th>
              <th>Child</th>
              <th>Price</th>
              <th>Message</th>
              <th>Action</th>
            </tr>';
            }
            elseif (isset($_POST['cottage_reservations'])){
             echo ' <tr>
              <th>Reference Number</th>
              <th>Name</th>
              <th>Cottage Type</th>
              <th>Arrival Date</th>
              <th>Departure Date</th>
               <th>Total Days of Stay</th>
              <th>Rooms</th>
              <th>Adults</th>
              <th>Child</th>
              <th>Price</th>
              <th>Message</th>
              <th>Action</th>
            </tr>';
            }
            elseif (isset($_POST['roomsAvailable'])) {
               echo ' <tr>
              <th>ID</th>
              <th>Room Name</th>
              <th>Available Room</th>
            </tr>';
            }
            elseif (isset($_POST['cottageAvailable'])) {
               echo ' <tr>
             <th>ID</th>
              <th>Cottage Name</th>
              <th>Available Cottage</th>
            </tr>';
            }
            
            else {
                echo ' <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Date</th>
              <th>Message</th>
              <th>Action</th>
            </tr>';
            }
            ?>
          </thead>
          <tbody>
            <?php
            if (isset($_POST['reservations'])) {
               showReservationForRoom($reservationData);
            }
            elseif(isset($_POST['roomsAvailable'])){
              showRoomAvailable($rooms_avaialble_result);
            }
            elseif (isset($_POST['cottageAvailable'])) {
              showCottageAvailable($cottage_available_result);
            }
            elseif (isset($_POST['cottage_reservations'])){
             showReservationForCottage($reservationData);
            }
            else {
                showInquiries($result);
            }
            ?>
             
          </tbody>
        </table>
      </div>
    </main>
    </main>

    <!-- Bootstrap JS (required for modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

