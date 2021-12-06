<?php
session_start();
$_SESSION['validated'] = "False";
$user_level = "user";
include "assets/layouts/header.php";

if (!user_logged_in()){
  redirect_to('login.php');
}

// user id
$id = $_SESSION['user_id'];

$devices = get_all_devices();
$sensors = get_all_sensors();
$actuators = get_all_actuators();
$microcontrollers = get_all_microcontrollers();
$others = get_all_others();
$taken_devices = get_user_device_requests($id);

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
        $max_num = $device['device_quantity'] - $device['number_taken'];
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
                <div
                  class="
                    col-2
                    d-flex
                    justify-content-center
                    align-items-center
                    m-3
                  "
                >
                  <div class="">
                    <button
                      type="button"
                      class="btn btn-dark"
                      data-bs-toggle="modal"
                      data-bs-target="#requestDevice<?php echo $device['device_id']; ?>"
                    >
                      Request
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal for requesting device -->
        <div class="modal fade" id="requestDevice<?php echo $device['device_id']; ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content text-center">
              <div class="modal-header">
                <h5 class="modal-title">Request device</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                ></button>
              </div>
              <div class="modal-body">
                <form action="assets/raw_php/request_device.php" method="POST" class="form text-center">
                  <!-- Hidden ID -->
                  <input type="number" hidden value="<?php echo $device['device_id']; ?>" name="device_id">
                  <!-- Device name -->
                  <p><?php echo $device['device_name']; ?></p>
                  <!-- Device Quantity -->
                  <div class="form-group mb-4">
                    <label for="device_quantity" class="lead">
                        Quantity
                    </label>
                    <input
                      type="number"
                      name="device_quantity"
                      id="device_quantity"
                      class="form-control mb-4"
                      min="0"
                      max="<?php echo $max_num; ?>"
                    />
                  </div>
                  <input
                    type="submit"
                    name="request_device_submit"
                    class="btn btn-dark rounded-pill px-5"
                    value="Send Request"
                  />
                </form>
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
              $max_num = $device['device_quantity'] - $device['number_taken'];
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
                <div
                  class="
                    col-2
                    d-flex
                    justify-content-center
                    align-items-center
                    m-3
                  "
                >
                  <div class="">
                    <button
                      type="button"
                      class="btn btn-dark"
                      data-bs-toggle="modal"
                      data-bs-target="#requestDevice<?php echo $device['device_id']; ?>"
                    >
                      Request
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

              <!-- Modal for requesting device -->
            <div class="modal fade" id="requestDevice<?php echo $device['device_id']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content text-center">
                  <div class="modal-header">
                    <h5 class="modal-title">Request device</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form action="assets/raw_php/request_device.php" method="POST" class="form text-center">
                      <!-- Hidden ID -->
                      <input type="number" hidden value="<?php echo $device['device_id']; ?>" name="device_id">
                      <!-- Device name -->
                      <p><?php echo $device['device_name']; ?></p>
                      <!-- Device Quantity -->
                      <div class="form-group mb-4">
                        <label for="device_quantity" class="lead">
                            Quantity
                        </label>
                        <input
                          type="number"
                          name="device_quantity"
                          id="device_quantity"
                          class="form-control mb-4"
                          min="0"
                          max="<?php echo $max_num; ?>"
                        />
                      </div>
                      <input
                        type="submit"
                        name="request_device_submit"
                        class="btn btn-dark rounded-pill px-5"
                        value="Send Request"
                      />
                    </form>
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
          if (mysqli_num_rows($sensors) == 0){
            echo "<p class='lead'>No device added yet.</p>";
          }else{
            while ($device = mysqli_fetch_assoc($sensors)){
              $max_num = $device['device_quantity'] - $device['number_taken'];
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
                <div
                  class="
                    col-2
                    d-flex
                    justify-content-center
                    align-items-center
                    m-3
                  "
                >
                  <div class="">
                    <button
                      type="button"
                      class="btn btn-dark"
                      data-bs-toggle="modal"
                      data-bs-target="#requestDevice<?php echo $device['device_id']; ?>"
                    >
                      Request
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

              <!-- Modal for requesting device -->
            <div class="modal fade" id="requestDevice<?php echo $device['device_id']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content text-center">
                  <div class="modal-header">
                    <h5 class="modal-title">Request device</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form action="assets/raw_php/request_device.php" method="POST" onsubmit="return validate()" class="form text-center">
                      <!-- Hidden ID -->
                      <input type="number" hidden value="<?php echo $device['device_id']; ?>" name="device_id">
                      <!-- Device name -->
                      <p><?php echo $device['device_name']; ?></p>
                      <!-- Device Quantity -->
                      <div class="form-group mb-4">
                        <label for="device_quantity" class="lead">
                            Quantity
                        </label>
                        <input
                          type="number"
                          name="device_quantity"
                          id="device_quantity"
                          class="form-control mb-4"
                          min="0"
                          max="<?php echo $max_num; ?>"
                        />
                      </div>
                      <input
                        type="submit"
                        name="request_device_submit"
                        class="btn btn-dark rounded-pill px-5"
                        value="Send Request"
                      />
                    </form>
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
          if (mysqli_num_rows($actuators) == 0){
            echo "<p class='lead'>No device added yet.</p>";
          }else{
            while ($device = mysqli_fetch_assoc($actuators)){
              $max_num = $device['device_quantity'] - $device['number_taken'];
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
                <div
                  class="
                    col-2
                    d-flex
                    justify-content-center
                    align-items-center
                    m-3
                  "
                >
                  <div class="">
                    <button
                      type="button"
                      class="btn btn-dark"
                      data-bs-toggle="modal"
                      data-bs-target="#requestDevice<?php echo $device['device_id']; ?>"
                    >
                      Request
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

              <!-- Modal for requesting device -->
            <div class="modal fade" id="requestDevice<?php echo $device['device_id']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content text-center">
                  <div class="modal-header">
                    <h5 class="modal-title">Request device</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form action="assets/raw_php/request_device.php" method="POST" onsubmit="return validate()" class="form text-center">
                      <!-- Hidden ID -->
                      <input type="number" hidden value="<?php echo $device['device_id']; ?>" name="device_id">
                      <!-- Device name -->
                      <p><?php echo $device['device_name']; ?></p>
                      <!-- Device Quantity -->
                      <div class="form-group mb-4">
                        <label for="device_quantity" class="lead">
                            Quantity
                        </label>
                        <input
                          type="number"
                          name="device_quantity"
                          id="device_quantity"
                          class="form-control mb-4"
                          min="0"
                          max="<?php echo $max_num; ?>"
                        />
                      </div>
                      <input
                        type="submit"
                        name="request_device_submit"
                        class="btn btn-dark rounded-pill px-5"
                        value="Send Request"
                      />
                    </form>
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
              $max_num = $device['device_quantity'] - $device['number_taken'];
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
                <div
                  class="
                    col-2
                    d-flex
                    justify-content-center
                    align-items-center
                    m-3
                  "
                >
                  <div class="">
                    <button
                      type="button"
                      class="btn btn-dark"
                      data-bs-toggle="modal"
                      data-bs-target="#requestDevice<?php echo $device['device_id']; ?>"
                    >
                      Request
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

              <!-- Modal for requesting device -->
            <div class="modal fade" id="requestDevice<?php echo $device['device_id']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content text-center">
                  <div class="modal-header">
                    <h5 class="modal-title">Request device</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form action="assets/raw_php/request_device.php" method="POST" onsubmit="return validate()" class="form text-center">
                      <!-- Hidden ID -->
                      <input type="number" hidden value="<?php echo $device['device_id']; ?>" name="device_id">
                      <!-- Device name -->
                      <p><?php echo $device['device_name']; ?></p>
                      <!-- Device Quantity -->
                      <div class="form-group mb-4">
                        <label for="device_quantity" class="lead">
                            Quantity
                        </label>
                        <input
                          type="number"
                          name="device_quantity"
                          id="device_quantity"
                          class="form-control mb-4"
                          min="0"
                          max="<?php echo $max_num; ?>"
                        />
                      </div>
                      <input
                        type="submit"
                        name="request_device_submit"
                        class="btn btn-dark rounded-pill px-5"
                        value="Send Request"
                      />
                    </form>
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
    
    <!-- Modal for displaying devices the user has requested for -->
    <div class="modal fade" id="devicesIHave" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Devices I have requested for</h5>
            <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body">
                 
            <?php
              if (mysqli_num_rows($taken_devices) == 0){
            ?>
              <p class="p-0 m-0 text-danger"><small>Notify admin when returning the device(s) to have this cleared.</small></p>
              <hr />
            <?php
              }else{
                echo "<ul class='list-group list-group-flush'>";
                while ($taken_device = mysqli_fetch_assoc($taken_devices)){
            ?>
              <li class="list-group-item">
                <div> 
                  <div class="d-flex align-text-center justify-content-between mb-0">
                    <p class="m-0 p-0"><?php echo $taken_device['device_name']; ?></p>
                    <i class="bi bi-dash-lg"></i>
                    <p class="p-0 m-0">x<?php echo $taken_device['request_quantity']; ?></p>
                  </div>
                  <sup class="mt-0" style="font-size: 10px;"><?php echo $taken_device['request_status']; ?></sup>
                </div>
                <a href="assets/raw_php/delete_request.php?request_id=<?php echo $taken_device['request_id']; ?>" class="p-0 m-0 text-danger btn"><i class="bi bi-trash"></i> Delete request</a>
              </li>
            <?php
                }
              }
            ?>
<!--               
              <li class="list-group-item">
                <div>
                  <div class="d-flex align-text-center justify-content-between mb-0">
                    <p class="m-0 p-0">Lorem ipsum dolor sit amet consectetur</p>
                    <i class="bi bi-dash-lg"></i>
                    <p class="p-0 m-0">x3</p>
                  </div>
                  <sup class="mt-0" style="font-size: 10px;"><strong>Date taken:</strong> Wednesday 10th of November 2021 03:38:19 PM</sup>
                  <br />
                </div>
              </li> -->
              
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- **************************** SUMMARY BUTTON ************************* -->
    <section class="p-5 mt-5 text-center">
      <button class="btn btn-secondary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#deviceWithPeople">
        <i class="bi bi-card-list"></i> Summary devices ever taken
      </button>
    </section>

    <!-- Modal for displaying devices user ever took -->
    <div class="modal fade" id="deviceWithPeople" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content text-start">
          <div class="modal-header">
            <h5 class="modal-title">Device taken history</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body">
            <ul class="list-group list-group-flush">
              
              <li class="list-group-item">
                <div>
                  <div class="d-flex align-text-center justify-content-between mb-0">
                    <p class="m-0 p-0">Lorem ipsum dolor sit amet consectetur</p>
                    <i class="bi bi-dash-lg"></i>
                    <p class="p-0 m-0">x3</p>
                  </div>
                  <sup class="mt-0" style="font-size: 10px;"><strong>Date taken:</strong> Wednesday 10th of November 2021 03:38:19 PM</sup>
                  <br />
                  <sup class="mt-0" style="font-size: 10px;"><strong>Date returned:</strong> Wednesday 10th of November 2021 03:38:19 PM</sup>
                </div>
              </li>
              <li class="list-group-item">
                <div>
                  <div class="d-flex align-text-center justify-content-between mb-0">
                    <p class="m-0 p-0">Lorem ipsum dolor sit amet consectetur</p>
                    <i class="bi bi-dash-lg"></i>
                    <p class="p-0 m-0">x3</p>
                  </div>
                  <sup class="mt-0" style="font-size: 10px;"><strong>Date taken:</strong> Wednesday 10th of November 2021 03:38:19 PM</sup>
                  <br />
                  <sup class="mt-0" style="font-size: 10px;"><strong>Date returned:</strong> Wednesday 10th of November 2021 03:38:19 PM</sup>
                </div>
              </li>
              
            </ul>
          </div>
        </div>
      </div>
    </div>


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
    
    <!-- Request Device Alert -->
    <?php
        if (isset($_SESSION['request_device_message'])) {
    ?>
        <script>
            setTimeout(() => {alert('<?php echo($_SESSION['request_device_message']); ?>'); }, 500);
        </script>
    <?php
        }$_SESSION['request_device_message'] = null;
    ?>  
    
    <!-- Delete request Alert -->
    <?php
        if (isset($_SESSION['delete_request_message'])) {
    ?>
        <script>
            setTimeout(() => {alert('<?php echo($_SESSION['delete_request_message']); ?>'); }, 500);
        </script>
    <?php
        }$_SESSION['delete_request_message'] = null;
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

  function getMaxValue(){
    // Get select field
    var device = document.getElementById('device');
    // Get select options
    var options = device.options;
    // Get value of selected option id
    var maxVal = options[options.selectedIndex].id;
    // Get number field
    // Set max value
    numField = document.getElementById("device_count").max = maxVal;
  }

  function validate_password(){
    var password = document.getElementById('password_validate').value;
    if(password.trim() == ''){
      alert("Password filed cannot be left empty!");
      return false;
    }
  }
</script>