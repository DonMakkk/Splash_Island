<?php
  $conn = new mysqli("localhost", "root", "", "splash_island_data");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>