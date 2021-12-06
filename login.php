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
      <div class="container text-center">
        <div class="row g-0 my-4">
          <div class="col-md-9 col-lg-5 m-auto">
            <p class="display-4">Login Form</p>
            <div class="card shadow rounded">
              <div class="card-body">
                <form action="assets/raw_php/login_process.php" method="POST" class="form">
                  <label class="m-2" for="username">Username</label>
                  <div class="form-group mb-3">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Username"
                      id="username"
                      name="username"
                    />
                  </div>
                  <label class="m-2" for="password">Password</label>
                  <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" />
                  </div>
                  <br />
                  <input
                    type="submit"
                    name="login_submit"
                    class="btn btn-dark mt-2 rounded-pill"
                  />
                  <p class="mt-2"><a href="register.php">Register user</a></p>
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

  <!-- <form action="#" method="GET">
    <input type="date" name="date">
    <input type="submit">
  </form> -->
</html>

<!-- Login Mistake Alert -->
<?php
    if (isset($_SESSION['login_notice'])) {
?>
    <script>
        setTimeout(() => {alert('<?php echo($_SESSION['login_notice']); ?>'); }, 500);
    </script>
<?php
    }$_SESSION['login_notice'] = null;
?>