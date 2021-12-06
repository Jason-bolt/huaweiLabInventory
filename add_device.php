<?php
  session_start();
  include "assets/layouts/header.php";
  if ($_SESSION['validated'] != 'True'){
    redirect_to('index.php');
  }
?>

    <!-- Add Device -->
    <section class="p-5 bg-white text-dark">
      <div class="container">
        <div class="text-center">
          <div>
            <h3 class="display-4">Add Device</h3>
          </div>
        </div>
      </div>
    </section>

    <section class="p-2">
      <div class="container text-center">
        <div class="card col-md-10 col-lg-6 mx-auto shadow">
          <div class="card-body">
            <form action="assets/raw_php/add_device_process.php" method="GET" onsubmit="return validateForm()" class="form text-center">
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
        <a href="index.php#devices" class="btn btn-light my-4">
          <i class="bi bi-chevron-left"></i> Back to devices
        </a>
      </div>
    </section>

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

    <?php include('assets/layouts/footer.php'); ?>

<script>
  function validateForm(){
    var device_name = document.getElementById('device_name').value;
    var device_description = document.getElementById('device_description').value;
    var device_quantity = document.getElementById('device_quantity').value;

    if (device_name.trim() == '' || device_description.trim() == '' || device_quantity == ''){
      alert("Please fill all fields!");
      return false;
    }

    if (device_quantity == 0){
      alert("Device quantity cannot be 0");
      return false;
    }
  }
</script>