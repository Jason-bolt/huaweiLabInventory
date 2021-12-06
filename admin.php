<?php
  session_start();
  $_SESSION['validated'] = "False";
  $user_level = "admin";
  include "assets/layouts/header.php";

  if (!admin_logged_in()){
    redirect_to('login.php');
  }

  $devices = get_all_devices();
  $sensors = get_all_sensors();
  $actuators = get_all_actuators();
  $microcontrollers = get_all_microcontrollers();
  $others = get_all_others();
  $taken_devices = get_all_user_device_requests();
  $users_with_devices = get_all_users_with_devices();
  $device_taken_history = get_device_taken_history();
  $device_history = get_device_history();

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
                      data-bs-target="#editDevice<?php echo $device['device_id']; ?>"
                    >
                      Edit
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal for editing device -->
        <div class="modal fade" id="editDevice<?php echo $device['device_id']; ?>" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content text-center">
              <div class="modal-header">
                <h5 class="modal-title">Edit Device</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                ></button>
              </div>
              <div class="modal-body">
                <form action="assets/raw_php/update_device.php?admin" method="POST" onsubmit="return validate()" class="form text-center">
                  <!-- Hidden ID -->
                  <input type="number" hidden value="<?php echo $device['device_id']; ?>" name="device_id">
                  <!-- Device name -->
                  <div class="form-group mb-4">
                    <label for="device_name" class="lead"> Device Name </label>
                    <input
                      type="text"
                      name="device_name"
                      id="device_name"
                      class="form-control"
                      value="<?php echo $device['device_name']; ?>"
                    />
                  </div>
                  <!-- Device description -->
                  <div class="form-group">
                    <label for="device_description" class="lead">
                      Device Description
                    </label>
                    <textarea
                      name="device_description"
                      id="device_description"
                      rows="3"
                      class="form-control mb-4"
                    ><?php echo $device['device_description']; ?></textarea>
                  </div>
                  <!-- Device type -->
                  <div class="form-group mb-4">
                    <label for="device_type" class="lead"> Device Type </label>
                    <select name="device_type" class="form-control mb-4">
                      <?php
                        if ($device['device_type'] == 'microcontroller'){
                      ?>
                        <option value="microcontroller" selected>Microcontroller</option>
                        <option value="sensor">Sensor</option>
                        <option value="actuator">Actuator</option>
                        <option value="other">Other</option>
                      <?php
                        }else if ($device['device_type'] == 'sensor'){
                      ?>
                        <option value="microcontroller">Microcontroller</option>
                        <option value="sensor" selected>Sensor</option>
                        <option value="actuator">Actuator</option>
                        <option value="other">Other</option>
                      <?php
                        }else if ($device['device_type'] == 'actuator'){
                      ?>
                        <option value="microcontroller">Microcontroller</option>
                        <option value="sensor">Sensor</option>
                        <option value="actuator" selected>Actuator</option>
                        <option value="other">Other</option>
                      <?php
                        }else if ($device['device_type'] == 'other'){
                      ?>
                        <option value="microcontroller">Microcontroller</option>
                        <option value="sensor">Sensor</option>
                        <option value="actuator">Actuator</option>
                        <option value="other" selected>Other</option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Device Quantity -->
                  <div class="form-group mb-4">
                    <label for="device_quantity" class="lead">
                      Device Quantity
                    </label>
                    <input
                      type="number"
                      name="device_quantity"
                      id="device_quantity"
                      class="form-control mb-4"
                      min="0"
                      value="<?php echo $device['device_quantity']; ?>"
                    />
                  </div>
                  <input
                    type="submit"
                    name="update_device_submit"
                    class="btn btn-dark rounded-pill px-5"
                  />
                </form>
                <a href="assets/raw_php/delete_device.php?device_id=<?php echo $device['device_id']; ?>" onclick="return confirm('You are deleting the device completely from the platform!');" class="btn btn-danger rounded-pill mt-3">Delete device</a>
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
                      data-bs-target="#editDevice<?php echo $device['device_id']; ?>"
                    >
                      Edit
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

              <!-- Modal for editing device -->
            <div class="modal fade" id="editDevice<?php echo $device['device_id']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content text-center">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Device</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form action="assets/raw_php/update_device.php?admin" method="POST" onsubmit="return validate()" class="form text-center">
                      <!-- Hidden ID -->
                      <input type="number" hidden value="<?php echo $device['device_id']; ?>" name="device_id">
                      <!-- Device name -->
                      <div class="form-group mb-4">
                        <label for="device_name" class="lead"> Device Name </label>
                        <input
                          type="text"
                          name="device_name"
                          id="device_name"
                          class="form-control"
                          value="<?php echo $device['device_name']; ?>"
                        />
                      </div>
                      <!-- Device description -->
                      <div class="form-group">
                        <label for="device_description" class="lead">
                          Device Description
                        </label>
                        <textarea
                          name="device_description"
                          id="device_description"
                          rows="3"
                          class="form-control mb-4"
                        ><?php echo $device['device_description']; ?></textarea>
                      </div>
                      <!-- Device type -->
                      <div class="form-group mb-4">
                        <label for="device_type" class="lead"> Device Type </label>
                        <select name="device_type" class="form-control mb-4">
                          <?php
                            if ($device['device_type'] == 'microcontroller'){
                          ?>
                            <option value="microcontroller" selected>Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'sensor'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor" selected>Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'actuator'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator" selected>Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'other'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other" selected>Other</option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>
                      <!-- Device Quantity -->
                      <div class="form-group mb-4">
                        <label for="device_quantity" class="lead">
                          Device Quantity
                        </label>
                        <input
                          type="number"
                          name="device_quantity"
                          id="device_quantity"
                          class="form-control mb-4"
                          min="0"
                          value="<?php echo $device['device_quantity']; ?>"
                        />
                      </div>
                      <!-- Device Password -->
                      <div class="form-group mb-4">
                        <label for="password" class="lead"> Password </label>
                        <input
                          type="password"
                          name="password"
                          id="password"
                          class="form-control"
                          min="0"
                        />
                        <p class="small">Enter password to save changes</p>
                      </div>
                      <input
                        type="submit"
                        name="update_device_submit"
                        class="btn btn-dark rounded-pill px-5"
                      />
                    </form>
                    <a href="assets/raw_php/delete_device.php?device_id=<?php echo $device['device_id']; ?>" onclick="return confirm('You are deleting the device completely from the platform!');" class="btn btn-danger rounded-pill mt-3">Delete device</a>
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
                      data-bs-target="#editDevice<?php echo $device['device_id']; ?>"
                    >
                      Edit
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

              <!-- Modal for editing device -->
            <div class="modal fade" id="editDevice<?php echo $device['device_id']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content text-center">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Device</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form action="assets/raw_php/update_device.php?admin" method="POST" onsubmit="return validate()" class="form text-center">
                      <!-- Hidden ID -->
                      <input type="number" hidden value="<?php echo $device['device_id']; ?>" name="device_id">
                      <!-- Device name -->
                      <div class="form-group mb-4">
                        <label for="device_name" class="lead"> Device Name </label>
                        <input
                          type="text"
                          name="device_name"
                          id="device_name"
                          class="form-control"
                          value="<?php echo $device['device_name']; ?>"
                        />
                      </div>
                      <!-- Device description -->
                      <div class="form-group">
                        <label for="device_description" class="lead">
                          Device Description
                        </label>
                        <textarea
                          name="device_description"
                          id="device_description"
                          rows="3"
                          class="form-control mb-4"
                        ><?php echo $device['device_description']; ?></textarea>
                      </div>
                      <!-- Device type -->
                      <div class="form-group mb-4">
                        <label for="device_type" class="lead"> Device Type </label>
                        <select name="device_type" class="form-control mb-4">
                          <?php
                            if ($device['device_type'] == 'microcontroller'){
                          ?>
                            <option value="microcontroller" selected>Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'sensor'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor" selected>Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'actuator'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator" selected>Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'other'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other" selected>Other</option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>
                      <!-- Device Quantity -->
                      <div class="form-group mb-4">
                        <label for="device_quantity" class="lead">
                          Device Quantity
                        </label>
                        <input
                          type="number"
                          name="device_quantity"
                          id="device_quantity"
                          class="form-control mb-4"
                          min="0"
                          value="<?php echo $device['device_quantity']; ?>"
                        />
                      </div>
                      <!-- Device Password -->
                      <div class="form-group mb-4">
                        <label for="password" class="lead"> Password </label>
                        <input
                          type="password"
                          name="password"
                          id="password"
                          class="form-control"
                          min="0"
                        />
                        <p class="small">Enter password to save changes</p>
                      </div>
                      <input
                        type="submit"
                        name="update_device_submit"
                        class="btn btn-dark rounded-pill px-5"
                      />
                    </form>
                    <a href="assets/raw_php/delete_device.php?device_id=<?php echo $device['device_id']; ?>" onclick="return confirm('You are deleting the device completely from the platform!');" class="btn btn-danger rounded-pill mt-3">Delete device</a>
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
                      data-bs-target="#editDevice<?php echo $device['device_id']; ?>"
                    >
                      Edit
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

              <!-- Modal for editing device -->
            <div class="modal fade" id="editDevice<?php echo $device['device_id']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content text-center">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Device</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form action="assets/raw_php/update_device.php?admin" method="POST" onsubmit="return validate()" class="form text-center">
                      <!-- Hidden ID -->
                      <input type="number" hidden value="<?php echo $device['device_id']; ?>" name="device_id">
                      <!-- Device name -->
                      <div class="form-group mb-4">
                        <label for="device_name" class="lead"> Device Name </label>
                        <input
                          type="text"
                          name="device_name"
                          id="device_name"
                          class="form-control"
                          value="<?php echo $device['device_name']; ?>"
                        />
                      </div>
                      <!-- Device description -->
                      <div class="form-group">
                        <label for="device_description" class="lead">
                          Device Description
                        </label>
                        <textarea
                          name="device_description"
                          id="device_description"
                          rows="3"
                          class="form-control mb-4"
                        ><?php echo $device['device_description']; ?></textarea>
                      </div>
                      <!-- Device type -->
                      <div class="form-group mb-4">
                        <label for="device_type" class="lead"> Device Type </label>
                        <select name="device_type" class="form-control mb-4">
                          <?php
                            if ($device['device_type'] == 'microcontroller'){
                          ?>
                            <option value="microcontroller" selected>Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'sensor'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor" selected>Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'actuator'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator" selected>Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'sensor'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other" selected>Other</option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>
                      <!-- Device Quantity -->
                      <div class="form-group mb-4">
                        <label for="device_quantity" class="lead">
                          Device Quantity
                        </label>
                        <input
                          type="number"
                          name="device_quantity"
                          id="device_quantity"
                          class="form-control mb-4"
                          min="0"
                          value="<?php echo $device['device_quantity']; ?>"
                        />
                      </div>
                      <!-- Device Password -->
                      <div class="form-group mb-4">
                        <label for="password" class="lead"> Password </label>
                        <input
                          type="password"
                          name="password"
                          id="password"
                          class="form-control"
                          min="0"
                        />
                        <p class="small">Enter password to save changes</p>
                      </div>
                      <input
                        type="submit"
                        name="update_device_submit"
                        class="btn btn-dark rounded-pill px-5"
                      />
                    </form>
                    <a href="assets/raw_php/delete_device.php?device_id=<?php echo $device['device_id']; ?>" onclick="return confirm('You are deleting the device completely from the platform!');" class="btn btn-danger rounded-pill mt-3">Delete device</a>
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
    <section class="p-2 pb-5">
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
                      data-bs-target="#editDevice<?php echo $device['device_id']; ?>"
                    >
                      Edit
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

              <!-- Modal for editing device -->
            <div class="modal fade" id="editDevice<?php echo $device['device_id']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content text-center">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Device</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form action="assets/raw_php/update_device.php?admin" method="POST" onsubmit="return validate()" class="form text-center">
                      <!-- Hidden ID -->
                      <input type="number" hidden value="<?php echo $device['device_id']; ?>" name="device_id">
                      <!-- Device name -->
                      <div class="form-group mb-4">
                        <label for="device_name" class="lead"> Device Name </label>
                        <input
                          type="text"
                          name="device_name"
                          id="device_name"
                          class="form-control"
                          value="<?php echo $device['device_name']; ?>"
                        />
                      </div>
                      <!-- Device description -->
                      <div class="form-group">
                        <label for="device_description" class="lead">
                          Device Description
                        </label>
                        <textarea
                          name="device_description"
                          id="device_description"
                          rows="3"
                          class="form-control mb-4"
                        ><?php echo $device['device_description']; ?></textarea>
                      </div>
                      <!-- Device type -->
                      <div class="form-group mb-4">
                        <label for="device_type" class="lead"> Device Type </label>
                        <select name="device_type" class="form-control mb-4">
                          <?php
                            if ($device['device_type'] == 'microcontroller'){
                          ?>
                            <option value="microcontroller" selected>Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'sensor'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor" selected>Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'actuator'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator" selected>Actuator</option>
                            <option value="other">Other</option>
                          <?php
                            }else if ($device['device_type'] == 'other'){
                          ?>
                            <option value="microcontroller">Microcontroller</option>
                            <option value="sensor">Sensor</option>
                            <option value="actuator">Actuator</option>
                            <option value="other" selected>Other</option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>
                      <!-- Device Quantity -->
                      <div class="form-group mb-4">
                        <label for="device_quantity" class="lead">
                          Device Quantity
                        </label>
                        <input
                          type="number"
                          name="device_quantity"
                          id="device_quantity"
                          class="form-control mb-4"
                          min="0"
                          value="<?php echo $device['device_quantity']; ?>"
                        />
                      </div>
                      <!-- Device Password -->
                      <div class="form-group mb-4">
                        <label for="password" class="lead"> Password </label>
                        <input
                          type="password"
                          name="password"
                          id="password"
                          class="form-control"
                          min="0"
                        />
                        <p class="small">Enter password to save changes</p>
                      </div>
                      <input
                        type="submit"
                        name="update_device_submit"
                        class="btn btn-dark rounded-pill px-5"
                      />
                    </form>
                    <a href="assets/raw_php/delete_device.php?device_id=<?php echo $device['device_id']; ?>" onclick="return confirm('You are deleting the device completely from the platform!');" class="btn btn-danger rounded-pill mt-3">Delete device</a>
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

    <!-- Modal for adding new device -->
    <div class="modal fade" id="addDevice" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content text-center">
          <div class="modal-header">
            <h5 class="modal-title">Add New Device</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body">
          <form action="assets/raw_php/add_device_process.php?admin" method="POST" onsubmit="return validateForm()" class="form text-center mb-3">
            <div class="form-group mb-4">
              <label for="device_name" class="lead"> Device Name </label>
              <input
                type="text"
                name="device_name"
                id="device_name"
                class="form-control"
              />
            </div>
            <div class="form-group">
              <label for="device_description" class="lead">
                Device Description
              </label>
              <textarea
                name="device_description"
                id="device_description"
                rows="3"
                class="form-control mb-4"
              ></textarea>
            </div>
            <div class="form-group mb-4">
              <label for="device_type" class="lead"> Device Type </label>
              <select name="device_type" class="form-control mb-4">
                <option value="microcontroller" selected>Microcontroller</option>
                <option value="sensor">Sensor</option>
                <option value="actuator">Actuator</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-group mb-4">
              <label for="device_quantity" class="lead">
                Device Quantity
              </label>
              <input
                type="number"
                name="device_quantity"
                id="device_quantity"
                class="form-control mb-4"
                min="0"
                value="0"
              />
            </div>
            <input
              type="submit"
              name="add_device_submit"
              class="btn btn-dark rounded-pill px-5"
            />
          </form>
          </div>
        </div>
      </div>
    </div>

    <!-- ********************* SUMMARY ******************* -->
    <section class="container mt-5">
      <div class="row g-4">
        <div class="col-lg">
          <!-- People with devices button -->
          <div class="text-center" id="people_with_devices">
            <button class="btn btn-secondary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#deviceWithPeople">
              <i class="bi bi-card-list"></i> Summary of people with devices
            </button>
          </div>
        </div>

        <div class="col-lg">
          <!-- Requests for devices -->
          <div class="text-center" id="requests_button">
            <button class="btn btn-secondary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#deviceRequests">
              <i class="bi bi-list"></i> All device requests
            </button>
          </div>
        </div>
        
        <div class="col-lg">
          <!-- History of devices ever_taken -->
          <div class="text-center" id="requests_button">
            <button class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#deviceTakenHistory">
              <i class="bi bi-calendar-range"></i> History of devices taken
            </button>
          </div>
        </div>
        
        <div class="col-lg">
          <!-- History of devices ever -->
          <div class="text-center" id="requests_button">
            <button class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#deviceHistory">
              <i class="bi bi-archive"></i> Device archive
            </button>
          </div>
        </div>
              
      </div>
    </section>

    <!-- Modal for displaying devices with people -->
    <div class="modal fade" id="deviceWithPeople" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content text-start">
          <div class="modal-header">
            <h5 class="modal-title">People With Devices</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body">
            <?php
              if (mysqli_num_rows($users_with_devices) == 0){
                echo "<p class='lead'>No device has been taken</p>";
              }else{
                echo "<ul class='list-group list-group-flush'>";
                while ($user_with_device = mysqli_fetch_assoc($users_with_devices)){
                  $name = $user_with_device['last_name'] . " " . $user_with_device['other_names'];
            ?>
              <li class="list-group-item">
                <p class="m-0 h6"><?php echo $name; ?></p>
                <div>
                  <div class="d-flex align-text-center justify-content-between mb-0">
                    <p class="m-0 p-0"><?php echo $user_with_device['device_name']; ?></p>
                    <i class="bi bi-dash-lg"></i>
                    <p class="p-0 m-0">x3</p>
                  </div>
                  <sup class="mt-0" style="font-size: 10px;">Date taken: <?php echo $user_with_device['dt_date_taken']; ?></sup>
                  <p><a href="assets/raw_php/device_returned.php?dt_id=<?php echo $user_with_device['dt_id']; ?>&numTaken=<?php echo $user_with_device['number_taken']; ?>&quantity=<?php echo $user_with_device['dt_quantity']; ?>&device_id=<?php echo $user_with_device['device_id']; ?>" class="text-dark btn btn-secondary text-white rounded-pill py-1">Device returned <i class="bi bi-arrow-bar-left"></i></a></p>
                </div>
              </li>
            <?php
                }
              }
            ?>
          
            <!-- <ul class="list-group list-group-flush">
              
              <li class="list-group-item">
                <p class="m-0 h6">Person's name</p>
                <div>
                  <div class="d-flex align-text-center justify-content-between mb-0">
                    <p class="m-0 p-0">Lorem ipsum dolor sit amet consectetur</p>
                    <i class="bi bi-dash-lg"></i>
                    <p class="p-0 m-0">x3</p>
                  </div>
                  <sup class="mt-0" style="font-size: 10px;">Date taken: 01/01/2021</sup>
                  <p><a href="#" class="text-dark btn btn-secondary text-white rounded-pill py-1">Device returned <i class="bi bi-arrow-bar-left"></i></a></p>
                </div>
              </li>

            </ul> -->
          </div>
        </div>
      </div>
    </div>
    <!-- ./Modal for displaying devices with people -->
    


    <!-- Modal for displaying user device requests -->
    <div class="modal fade" id="deviceRequests" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content text-start">
          <div class="modal-header">
            <h5 class="modal-title">All device requests</h5>
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
              <p class="lead">No Request made yet</p>
            <?php
              }else{
                echo "<ul class='list-group list-group-flush'>";
                while ($taken_device = mysqli_fetch_assoc($taken_devices)){
                  $name = $taken_device['last_name'] . " " . $taken_device['other_names'];
            ?>
              <li class="list-group-item">
                <p class="m-0 h6"><?php echo $name; ?></p>
                <div>
                  <div class="d-flex align-text-center justify-content-between mb-3">
                    <p class="m-0 p-0"><?php echo $taken_device['device_name']; ?></p>
                    <i class="bi bi-dash-lg"></i>
                    <p class="p-0 m-0">x<?php echo $taken_device['request_quantity']; ?></p>
                  </div>
                  <p>
                    <a href="assets/raw_php/accept_request.php?request_id=<?php echo $taken_device['request_id']; ?>" class="text-dark btn btn-secondary text-white rounded-pill py-1">Accept request <i class="bi bi-check-lg"></i></a>
                    <a href="assets/raw_php/decline_request.php?request_id=<?php echo $taken_device['request_id']; ?>" class="text-dark btn btn-secondary text-white rounded-pill py-1">Decline request <i class="bi bi-x-lg"></i></a>
                  </p>
                </div>
              </li>
            <?php
                }
              }
            ?>

            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- ./Modal for displaying devices with people -->
    

    <!-- Modal for displaying history of devices taken -->
    <div class="modal fade" id="deviceTakenHistory" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content text-start">
          <div class="modal-header">
            <h5 class="modal-title">History of devices taken</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body">
            
            <?php
              if (mysqli_num_rows($device_taken_history) == 0){
                echo "<p class='lead'>No history yet</p>";
              }else{
                echo "<ul class='list-group list-group-flush'>";
                while ($history = mysqli_fetch_assoc($device_taken_history)){
                  $name = $history['last_name'] . " " . $history['other_names'];
            ?>
              <li class="list-group-item">
                <p class="m-0 h6"><?php echo $name; ?></p>
                <div>
                  <div class="d-flex align-text-center justify-content-between mb-0">
                    <p class="m-0 p-0"><?php echo $history['device_name']; ?></p>
                    <i class="bi bi-dash-lg"></i>
                    <p class="p-0 m-0">x3</p>
                  </div>
                  <sup class="mt-0" style="font-size: 10px;">Date taken: <?php echo $history['dt_date_taken']; ?></sup>
                  <br />
                  <sup class="mt-0" style="font-size: 10px;">Date returned: <?php echo $history['dt_date_returned']; ?></sup>
                </div>
              </li>
            <?php
                }
              }
            ?>

            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- ./Modal for displaying history of devices taken -->


    <!-- Modal for displaying history of devices -->
    <div class="modal fade" id="deviceHistory" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content text-start">
          <div class="modal-header">
            <h5 class="modal-title">History of devices in the lab</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body">
            
            <?php
              if (mysqli_num_rows($device_history) == 0){
                echo "<p class='lead'>No history yet</p>";
              }else{
                echo "<ul class='list-group list-group-flush'>";
                while ($history = mysqli_fetch_assoc($device_history)){
            ?>
              <li class="list-group-item">
                <p class="m-0 h6"><?php echo $history['device_name']; ?></p>
                <div>
                  <div class="mb-0">
                    <p class="m-0 p-0"><?php echo $history['device_description']; ?></p>
                  </div>
                  <sup class="mt-0 btn-dark rounded-pill px-2" style="font-size: 10px;"><?php echo $history['device_type']; ?></sup>
                  <sup class="mt-0">Quantity: <?php echo $history['device_quantity']; ?></sup>
                </div>
              </li>
            <?php
                }
              }
            ?>

            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- ./Modal for displaying history of devices taken -->


    <!-- Add Device Alert -->
    <?php
        if (isset($_SESSION['add_device_message'])) {
    ?>
        <script>
            setTimeout(() => {alert('<?php echo($_SESSION['add_device_message']); ?>'); }, 500);
        </script>
    <?php
        }$_SESSION['add_device_message'] = null;
    ?>  
    
    <!-- Update Device Alert -->
    <?php
        if (isset($_SESSION['update_device_message'])) {
    ?>
        <script>
            setTimeout(() => {alert('<?php echo($_SESSION['update_device_message']); ?>'); }, 500);
        </script>
    <?php
        }$_SESSION['update_device_message'] = null;
    ?>  
    
    <!-- Accept Request Alert -->
    <?php
        if (isset($_SESSION['accept_request_message'])) {
    ?>
        <script>
            setTimeout(() => {alert('<?php echo($_SESSION['accept_request_message']); ?>'); }, 500);
        </script>
    <?php
        }$_SESSION['accept_request_message'] = null;
    ?> 
    
    <!-- Decline Request Alert -->
    <?php
        if (isset($_SESSION['decline_request_message'])) {
    ?>
        <script>
            setTimeout(() => {alert('<?php echo($_SESSION['decline_request_message']); ?>'); }, 500);
        </script>
    <?php
        }$_SESSION['decline_request_message'] = null;
    ?> 
    
    <!-- Device Returned Alert -->
    <?php
        if (isset($_SESSION['device_returned_message'])) {
    ?>
        <script>
            setTimeout(() => {alert('<?php echo($_SESSION['device_returned_message']); ?>'); }, 500);
        </script>
    <?php
        }$_SESSION['device_returned_message'] = null;
    ?> 
    
    <!-- Device Deleted Alert -->
    <?php
        if (isset($_SESSION['delete_device_message'])) {
    ?>
        <script>
            setTimeout(() => {alert('<?php echo($_SESSION['delete_device_message']); ?>'); }, 500);
        </script>
    <?php
        }$_SESSION['delete_device_message'] = null;
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