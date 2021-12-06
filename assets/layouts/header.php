<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Huawei Lab Inventory</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css"
      integrity="sha384-7ynz3n3tAGNUYFZD3cWe5PDcE36xj85vyFkawcF6tIwxvIecqKvfwLiaFdizhPpN"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <header class="header">
      <nav class="navbar navbar-expand-lg bg-light navbar-light fixed-top shadow">
        <div class="container">
          <div class="navbar-brand">HUAWEI LAB INVENTORY</div>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navMenu"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a href="#devices" class="nav-link">All Devices</a>
              </li>
              <li class="nav-item">
                <a href="#microcontrollers" class="nav-link"
                  >Microcontrollers</a
                >
              </li>
              <li class="nav-item">
                <a href="#sensors" class="nav-link">Sensors</a>
              </li>
              <li class="nav-item">
                <a href="#actuators" class="nav-link">Actuators</a>
              </li>
              <li class="nav-item">
                <a href="#others" class="nav-link">Others</a>
              </li>
              <?php
                if ($user_level == "admin"){
              ?>
                <li class="nav-item">
                  <button
                    class="btn btn-dark"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#addDevice"
                  >
                    Add Device
                  </button>
                </li>
              <?php
                } else if ($user_level == "user"){
              ?>
                <li class="nav-item">
                  <button
                    class="btn btn-dark"
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#devicesIHave"
                  >
                    Requested Devices
                  </button>
                </li>
              <?php
                } else {
                  ?>
                    <li class="nav-item">
                      <a href="login.php" class="btn btn-dark">Login</a>
                    </li>
                  <?php
                    }
              ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <?php
      include "assets/db/db.php";
      include "assets/functions/functions.php";
    ?>
