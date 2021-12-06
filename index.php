<?php
session_start();
$_SESSION['validated'] = "False";
// Level of user
$user_level = "none";
include "assets/layouts/header.php";

// echo password_encrypt('iotdevlab21');

$devices = get_all_devices();
$sensors = get_all_sensors();
$actuators = get_all_actuators();
$microcontrollers = get_all_microcontrollers();
$others = get_all_others();

?>

    <!-- All Devices -->
    <section class="p-5 bg-dark text-white mb-5" id="devices">
      <div class="container">
        <div class="text-center">
          <div>
            <h3 class="display-4">All Devices</h3>
          </div>
        </div>
      </div>
    </section>

    <!-- Cards for all devices -->
    <section class="p-2">
      <div class="container">
        <div class="row g-4">
          <!-- Beginning of loop -->
    <?php
    if (mysqli_num_rows($devices) == 0){
      echo "<p class='lead'>No device added yet.</p>";
    }else{
      while ($device = mysqli_fetch_assoc($devices)){
    ?>
          <div class="col-md-6 text-center">
            <div class="card">
              <div class="row my-auto">
                <div class="col">
                  <div class="card-body">
                    <div class="accordion accordion-flush">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#device<?php echo $device['device_id']; ?>"
                          >
                            <?php echo $device['device_name']; ?>
                          </button>
                        </h2>
                        <div
                          id="device<?php echo $device['device_id']; ?>"
                          class="accordion-collapse collapse"
                          data-bs-parent="#device<?php echo $device['device_id']; ?>"
                        >
                          <div class="accordion-body text-start">
                            <!-- Device type -->
                            <p class="text-uppercase my-1 h6 mb-3"><sub><strong><?php echo $device['device_type']; ?></strong></sub></p>
                            <!-- Device description -->
                            <?php echo $device['device_description']; ?>
                            <!-- Number taken -->
                            <p class="mb-0 mt-3">Quantity: <span class="badge bg-secondary"><?php echo $device['device_quantity']; ?></span></p>
                            <p class="mb-0">Number taken: <span class="badge bg-dark"><?php echo $device['number_taken']; ?></span></p>
                          </div>
                          <div class="h6 text-secondary">
                            <sub>Date modified: <?php echo $device['date_modified']; ?></sub>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
    <?php
      }
    }
    ?>
          <!-- ./End of loop -->
         
        </div>
      </div>
    </section>

    <!-- ************************* All Microcontrollers ******************************* -->
    <section class="p-5 bg-secondary text-white my-5" id="microcontrollers">
      <div class="container">
        <div class="text-center">
          <div>
            <h3 class="display-4">Microcontrollers</h3>
          </div>
        </div>
      </div>
    </section>

    <!-- Cards for all microcontrollers -->
    <section class="p-2">
      <div class="container">
        <div class="row g-4">
          <!-- Beginning of loop -->
          <?php
          if (mysqli_num_rows($microcontrollers) == 0){
            echo "<p class='lead'>No device added yet.</p>";
          }else{
            while ($device = mysqli_fetch_assoc($microcontrollers)){
              
          ?>
          <div class="col-md-6 text-center">
            <div class="card">
              <div class="row my-auto">
                <div class="col">
                  <div class="card-body">
                    <div class="accordion accordion-flush">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#microcontroller<?php echo $device['device_id']; ?>"
                          >
                            <?php echo $device['device_name']; ?>
                          </button>
                        </h2>
                        <div
                          id="microcontroller<?php echo $device['device_id']; ?>"
                          class="accordion-collapse collapse"
                          data-bs-parent="#device<?php echo $device['device_id']; ?>"
                        >
                          <div class="accordion-body text-start">
                            <!-- Device type -->
                            <p class="text-uppercase my-1 h6 mb-3"><sub><strong><?php echo $device['device_type']; ?></strong></sub></p>
                            <!-- Device description -->
                            <?php echo $device['device_description']; ?>
                            <!-- Number taken -->
                            <p class="mb-0 mt-3">Quantity: <span class="badge bg-secondary"><?php echo $device['device_quantity']; ?></span></p>
                            <p class="mb-0">Number taken: <span class="badge bg-dark"><?php echo $device['number_taken']; ?></span></p>
                          </div>
                          <div class="h6 text-secondary">
                            <sub>Date modified: <?php echo $device['date_modified']; ?></sub>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
          }
        }
        ?>
          <!-- ./End of loop -->
        </div>
      </div>
    </section>
    <!-- ************************ All Sensors ************************* -->
    <section class="p-5 bg-secondary text-white my-5" id="sensors">
      <div class="container">
        <div class="text-center">
          <div>
            <h3 class="display-4">Sensors</h3>
          </div>
        </div>
      </div>
    </section>

    <!-- Cards for all sensors -->
    <section class="p-2">
      <div class="container">
        <div class="row g-4">
          <!-- Beginning of loop -->
          <?php
          if (mysqli_num_rows($others) == 0){
            echo "<p class='lead'>No device added yet.</p>";
          }else{
            while ($device = mysqli_fetch_assoc($sensors)){
              
          ?>
          <div class="col-md-6 text-center">
            <div class="card">
              <div class="row my-auto">
                <div class="col">
                  <div class="card-body">
                    <div class="accordion accordion-flush">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#sensor<?php echo $device['device_id']; ?>"
                          >
                            <?php echo $device['device_name']; ?>
                          </button>
                        </h2>
                        <div
                          id="sensor<?php echo $device['device_id']; ?>"
                          class="accordion-collapse collapse"
                          data-bs-parent="#device<?php echo $device['device_id']; ?>"
                        >
                          <div class="accordion-body text-start">
                            <!-- Device type -->
                            <p class="text-uppercase my-1 h6 mb-3"><sub><strong><?php echo $device['device_type']; ?></strong></sub></p>
                            <!-- Device description -->
                            <?php echo $device['device_description']; ?>
                            <!-- Number taken -->
                            <p class="mb-0 mt-3">Quantity: <span class="badge bg-secondary"><?php echo $device['device_quantity']; ?></span></p>
                            <p class="mb-0">Number taken: <span class="badge bg-dark"><?php echo $device['number_taken']; ?></span></p>
                          </div>
                          <div class="h6 text-secondary">
                            <sub>Date modified: <?php echo $device['date_modified']; ?></sub>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
          }
        }
        ?>
          <!-- ./End of loop -->
        </div>
      </div>
    </section>

    <!-- ************************ All Actuators ************************ -->
    <section class="p-5 bg-secondary text-white my-5" id="actuators">
      <div class="container">
        <div class="text-center">
          <div>
            <h3 class="display-4">Actuators</h3>
          </div>
        </div>
      </div>
    </section>

    <!-- Cards for all actuators -->
    <section class="p-2">
      <div class="container">
        <div class="row g-4">
          <!-- Start of loop -->
          <?php
          if (mysqli_num_rows($others) == 0){
            echo "<p class='lead'>No device added yet.</p>";
          }else{
            while ($device = mysqli_fetch_assoc($actuators)){
              
          ?>
          <div class="col-md-6 text-center">
            <div class="card">
              <div class="row my-auto">
                <div class="col">
                  <div class="card-body">
                    <div class="accordion accordion-flush">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#actuators<?php echo $device['device_id']; ?>"
                          >
                            <?php echo $device['device_name']; ?>
                          </button>
                        </h2>
                        <div
                          id="actuators<?php echo $device['device_id']; ?>"
                          class="accordion-collapse collapse"
                          data-bs-parent="#device<?php echo $device['device_id']; ?>"
                        >
                          <div class="accordion-body text-start">
                            <!-- Device type -->
                            <p class="text-uppercase my-1 h6 mb-3"><sub><strong><?php echo $device['device_type']; ?></strong></sub></p>
                            <!-- Device description -->
                            <?php echo $device['device_description']; ?>
                            <!-- Number taken -->
                            <p class="mb-0 mt-3">Quantity: <span class="badge bg-secondary"><?php echo $device['device_quantity']; ?></span></p>
                            <p class="mb-0">Number taken: <span class="badge bg-dark"><?php echo $device['number_taken']; ?></span></p>
                          </div>
                          <div class="h6 text-secondary">
                            <sub>Date modified: <?php echo $device['date_modified']; ?></sub>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
          }
        }
        ?>
          <!-- ./End of loop -->
        </div>
      </div>
    </section>

    <!-- *********************** All Others ************************ -->
    <section class="p-5 bg-secondary text-white my-5" id="others">
      <div class="container">
        <div class="text-center">
          <div>
            <h3 class="display-4">Others</h3>
          </div>
        </div>
      </div>
    </section>

    <!-- Cards for all others -->
    <section class="p-2">
      <div class="container">
        <div class="row g-4">
          <!-- Start of loop -->
          <?php
          if (mysqli_num_rows($others) == 0){
            echo "<p class='lead'>No device added yet.</p>";
          }else{
            while ($device = mysqli_fetch_assoc($others)){
              
          ?>
          <div class="col-md-6 text-center">
            <div class="card">
              <div class="row my-auto">
                <div class="col">
                  <div class="card-body">
                    <div class="accordion accordion-flush">
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                          <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#other<?php echo $device['device_id']; ?>"
                          >
                            <?php echo $device['device_name']; ?>
                          </button>
                        </h2>
                        <div
                          id="other<?php echo $device['device_id']; ?>"
                          class="accordion-collapse collapse"
                          data-bs-parent="#device<?php echo $device['device_id']; ?>"
                        >
                          <div class="accordion-body text-start">
                            <!-- Device type -->
                            <p class="text-uppercase my-1 h6 mb-3"><sub><strong><?php echo $device['device_type']; ?></strong></sub></p>
                            <!-- Device description -->
                            <?php echo $device['device_description']; ?>
                            <!-- Number taken -->
                            <p class="mb-0 mt-3">Quantity: <span class="badge bg-secondary"><?php echo $device['device_quantity']; ?></span></p>
                            <p class="mb-0">Number taken: <span class="badge bg-dark"><?php echo $device['number_taken']; ?></span></p>
                          </div>
                          <div class="h6 text-secondary">
                            <sub>Date modified: <?php echo $device['date_modified']; ?></sub>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
          }
        }
        ?>
          <!-- ./End of loop -->
        </div>
      </div>
    </section>
    
    <!-- Update Device Alert -->
    <?php
        if (isset($_SESSION['add_person_message'])) {
    ?>
        <script>
            setTimeout(() => {alert('<?php echo($_SESSION['add_person_message']); ?>'); }, 500);
        </script>
    <?php
        }$_SESSION['add_person_message'] = null;
    ?>  

<?php
include "assets/layouts/footer.php";
?>

<script>
  // function validate(){
  //   var password = document.getElementById('password').value;
  //   if(password.trim() == ''){
  //     alert("Password filed cannot be left empty!");
  //     return false;
  //   }
  // }

  // function getMaxValue(){
  //   // Get select field
  //   var device = document.getElementById('device');
  //   // Get select options
  //   var options = device.options;
  //   // Get value of selected option id
  //   var maxVal = options[options.selectedIndex].id;
  //   // Get number field
  //   // Set max value
  //   numField = document.getElementById("device_count").max = maxVal;
  // }

  // function validate_password(){
  //   var password = document.getElementById('password_validate').value;
  //   if(password.trim() == ''){
  //     alert("Password filed cannot be left empty!");
  //     return false;
  //   }
  // }
</script>