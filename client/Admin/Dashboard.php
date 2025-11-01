<?php
include "../../backend/databaseconfig.php";

// DELETE Functionality
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM user_inquiries WHERE id = $id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// FETCH all data
$sql = "SELECT id, full_name, email, date, phone_number, message FROM user_inquiries";
$result = $conn->query($sql);

//FETCH THE RESERVATIONS DATA
$reservationSql = "SELECT reservation, email, full_name FROM user_account";
$reservationResult = $conn->query($reservationSql);
$reservationData = []; // Combine all reservations here

if ($reservationResult->num_rows > 0) {
    while ($row = $reservationResult->fetch_assoc()) {
        $json_data = $row["reservation"];
        $decoded = json_decode($json_data, true);
        if (is_array($decoded)) {
            $reservationData = array_merge($reservationData, $decoded);
        }
    }
}

  if (isset($_GET['deleteReservation'])) {
    $deleteRef = $_GET['deleteReservation'];

    // Get all users
    $reservationSql = "SELECT email, reservation FROM user_account";
    $reservationResult = $conn->query($reservationSql);

    if ($reservationResult->num_rows > 0) {
        while ($row = $reservationResult->fetch_assoc()) {
            $email = $row["email"];
            $full_name =  $row["full_name"];
            $json_data = $row["reservation"];
            $decoded = json_decode($json_data, true);

            if (is_array($decoded)) {
                $updatedData = [];
                $found = false;

                // Loop through each reservation
                foreach ($decoded as $reservation) {
                    if ($reservation["referenceNum"] != $deleteRef) {
                        $updatedData[] = $reservation;
                    } else {
                        $found = true;
                    }
                }

                // If a reservation was found and deleted, update the database
                if ($found) {
                    $newJson = json_encode($updatedData);
                    $updateQuery = "UPDATE user_account SET reservation='$newJson' WHERE email='$email'";
                    $conn->query($updateQuery);
                    break; // Stop after deleting the matching one
                }
            }
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$roomsAvaialbleSql = "SELECT * FROM rooms_avaialbe";
$rooms_avaialble_result = $conn->query($roomsAvaialbleSql);
// Functions (you can expand these later)
function showInquiries($result)
{
    if ($result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th scope='row'>" . $data['id'] . "</th>";
            echo "<td>" . $data['full_name'] . "</td>";
            echo "<td>" . $data['email'] . "</td>";
            echo "<td>" . $data['date'] . "</td>";
            echo "<td>" . $data['message'] . "</td>";
            echo "<td><a href='?delete=" . $data["id"] . "' class='btn btn-sm btn-danger'>Delete</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='text-center text-muted'>No Data Yet</td></tr>";
    }
}

function showReservation($reservationData)
{
     if (!empty($reservationData)) {
        foreach($reservationData as $data) {
            echo "<tr>";
            echo "<td>" . $data['referenceNum'] . "</td>";
            echo "<td>" . $data['full_name'] . "</td>";
            echo "<td>" . $data['arrival'] . "</td>";
            echo "<td>" . $data['departure'] . "</td>";
            echo "<td>" . $data['rooms'] . "</td>";
            echo "<td>" . $data['adults'] . "</td>";
            echo "<td>" . $data['child'] . "</td>";
            echo "<td>" . $data['message'] . "</td>";
            echo "<td><a href='?deleteReservation=" . $data["referenceNum"] . "' class='btn btn-sm btn-danger'>Delete</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='text-center text-muted'>No Data Yet</td></tr>";
    }
}

function showRoomAvailable($rooms_avaialble_result )
{
     if (!empty($rooms_avaialble_result )) {
        foreach($rooms_avaialble_result as $data) {
            echo "<tr>";
            echo "<td>" . $data['deluxe_warm_earth_suite'] . "</td>";
            echo "<td>" . $data['primary_taupe_sanctuary'] . "</td>";
            echo "<td>" . $data['primary_urban_quarters'] . "</td>";
            echo "<td>" . $data['signarture_grand_king'] . "</td>";
            echo "<td>" . $data['exotic_haven'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='text-center text-muted'>No Data Yet</td></tr>";
    }
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
      <div class="d-flex flex-column p-3 text-white bg-dark" style="width: 280px;">
        <h4 class="mb-4">Dashboard</h4>
        <form method="post">
          <button type="submit" name="inquiries" class="btn btn-outline-light mb-2 w-100 text-start">Inquiries</button>
          <button type="submit" name="reservations" class="btn btn-outline-light mb-2 w-100 text-start">Reservations</button>
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
              <th>Arrival Date</th>
              <th>Departure Date</th>
              <th>Rooms</th>
              <th>Adults</th>
              <th>Child</th>
              <th>Message</th>
              <th>Action</th>
            </tr>';
            }
            elseif (isset($_POST['roomsAvailable'])) {
               echo ' <tr>
              <th>Deluxe Warm Earth Suite</th>
              <th>Primary Taupe Sanctuary</th>
              <th>Primary Urban Quarters</th>
              <th>Signature Grand King</th>
              <th>Deluxe Warm Earth Suite</th>
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
                showReservation($reservationData);
            }
            elseif(isset($_POST['roomsAvailable'])){
              showRoomAvailable($rooms_avaialble_result);
            }
            else {
                showInquiries($result);
            }
            ?>
             
          </tbody>
        </table>
      </div>
    </main>
  </body>
</html>
