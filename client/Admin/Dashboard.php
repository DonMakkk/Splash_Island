<?php
    include "../../backend/databaseconfig.php";

    $sql = "SELECT id, full_name, email, date, phone_number, message FROM user_inquiries";
    $result = $conn->query($sql);
    
    if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM user_inquiries WHERE ID=$id");
  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
  
  function showInquiries(){

  }
  function showReservation(){
    
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
    <link rel="stylesheet" href="../User/pages/style.css" />
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
  </head>
<body>
<nav class="p-3 bg-black"><h2 class="text-white fw-bold">Splash Island</h2></nav>
<main class="d-flex flex-row " style="height: 100vh;">
  
  <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
      <span class="fs-4">Sidebar</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="#" class="nav-link  btns" aria-current="page">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
          Inquires
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link  text-white btns">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
          Reservation
        </a>
      </li>
      <li>
        <a href="#" class="nav-link text-white btns">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
          Orders
        </a>
      </li>
      <li>
        <a href="#" class="nav-link text-white btns">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
          Rooms Available
        </a>
      </li>
      <li>
        <a href="#" class="nav-link text-white  btns">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
          Cottage Available
        </a>
      </li>
    </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong>mdo</strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
        <li><a class="dropdown-item" href="#">New project...</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
        <li><a class="dropdown-item" href="#">Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">Sign out</a></li>
      </ul>
    </div>
  </div>
  <!-- TODO BODY -->
<table class="table h-100">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Date</th>
      <th scope="col">Message</th>
    </tr>
  </thead>
  <tbody  id="messageContainer">
    <?php
       if ($result->num_rows > 0 ) {
            while ($data = $result->fetch_assoc()) {

               echo "<tr>";
               echo "<th scope='row'> ". $data['id'] . "</th>";
               echo "<td>". $data['full_name'] . "</td>";
               echo "<td>" . $data['email'] . "</td>";
               echo "<td>" . $data['date'] . "</td>";
               echo  "<td>" . $data['message'] . "</td>";
               echo "<td>";
               echo '<a href="?delete=' . $data["id"] . '" class="btn btn-sm btn-danger" " ">Delete</a>';
               echo '</td>';
               echo"</tr>";
            }
        } else {
              echo "<tr>";
               echo "<th scope='row'> No Data Yet</th>";
               echo "<td>No Data Yet</td>";
               echo "<td>No Data Yet</td>";
               echo "<td>No Data Yet</td>";
               echo  "<td>No Data Yet</td>";
             
               echo"</tr>";
        }
        ?>
  </tbody>
</table>


</div>
</main>
</div>
  <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
    <script src="../script.js"></script>
  </body>
</html>
