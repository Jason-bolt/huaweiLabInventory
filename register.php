<?php
  session_start();
?>
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
    <!-- Login Page -->
    <section class="p-2">
      <div class="container">
        <div class="row g-0">
          <div class="col-lg-9 m-auto">
            <p class="display-4">Registration Form</p>
            <div class="card shadow rounded">
              <div class="card-body">
                <form action="assets/raw_php/registration_process.php" onsubmit="return validate_form()" method="POST" class="form">
                  <div class="row">
                    <div class="col-md-6">
                      <label class="m-2" for="lastName">Last Name</label>
                      <div class="form-group mb-3">
                        <input required
                          type="text"
                          class="form-control"
                          placeholder="Last name..."
                          id="lastName"
                          name="lastName"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="m-2" for="otherName">Other Names <small>(Please separate with space)</small></label>
                      <div class="form-group mb-3">
                        <input required
                          type="text"
                          class="form-control"
                          placeholder="Other names..."
                          id="otherName"
                          name="otherName"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label class="m-2" for="indexNumber">Index Number</label>
                      <div class="form-group mb-3">
                        <input required
                          type="text"
                          class="form-control"
                          placeholder="Index number..."
                          id="indexNumber"
                          name="indexNumber"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="m-2" for="lastName">Username</label>
                      <div class="form-group mb-3">
                        <input required
                          type="text"
                          class="form-control"
                          placeholder="Username..."
                          id="username"
                          name="username"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <label class="m-2" for="password">Password</label>
                      <div class="form-group mb-3">
                        <input required
                          type="password"
                          class="form-control"
                          id="password"
                          name="password"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label class="m-2" for="confirm_password">Confirm Password</label>
                      <div class="form-group mb-3">
                        <input required
                          type="password"
                          class="form-control"
                          id="confirm_password"
                          name="confirm_password"
                        />
                      </div>
                    </div>
                  </div>
                  
                    <br />
                    <input required
                      type="submit"
                      name="register_submit"
                      class="btn btn-dark rounded-pill"
                    />
                  <p class="mt-3"><a href="login.php">Login</a></p>
                </form>
              </div>
            </div>
            <div class="p-4">
              <a href="index.php" class="lead btn btn-secondary rounded-pill"
                ><i class="bi bi-chevron-left"></i> Back To Inventory</a
              >
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>

<!-- Registration Mistake Alert -->
<?php
    if (isset($_SESSION['register_message'])) {
?>
    <script>
        setTimeout(() => {alert('<?php echo($_SESSION['register_message']); ?>'); }, 500);
    </script>
<?php
    }$_SESSION['register_message'] = null;
?>

<script>
  function validate_form(){
    var lastName = document.getElementById('lastName').value;
    var otherName = document.getElementById('otherName').value;
    var indexNumber = document.getElementById('indexNumber').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirm_password = document.getElementById('confirm_password').value;

    if (lastName.trim() == '' || otherName.trim() == '' || indexNumber.trim() == '' || username.trim() == ''){
      alert("Fields can not be blank!");
      return false;
    }

    if (password !== confirm_password){
      alert("Passwords do not match!");
      return false;
    }
    
    if (password.length < 6){
      alert("Password is too short!");
      return false;
    }
  }
</script>
