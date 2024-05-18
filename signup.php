<?php

include('controller.php');
$error = "";
if(isset($_REQUEST['btnSignup'])) {
  $controllerObj = new Controller();
  $error = $controllerObj->insert_user();
}
?>  
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="style.css">
</head>

<body class="main-bg">
  <!-- Login Form -->
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card shadow">
          <div class="card-title text-center border-bottom">
            <h2 class="p-3">Sign up</h2>
          </div>
          <div class="card-body">
            <form method="post">
            <div class="mb-4">
                <label for="username" class="form-label">Name</label>
                <input type="text" class="form-control" name="txtName" id="txtName" required/>
              </div>
              <div class="mb-4">
                <label for="username" class="form-label">Email</label>
                <input type="text" class="form-control" name="txtEmail" id="txtEmail" required/>
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="txtPassword" id="txtPassword" required />
              </div>
              <div class="mb-4">
                <label for="username" class="form-label">Contact Number</label>
                <input type="number" class="form-control" name="contact_number" id="contact_number" required/>
              </div>
              <div class="mb-4">
                <label for="remember" class="form-label">Already a member? <a href="./index.php">Login</a></label>
              </div>
              <p class="text-danger text-center"><?php echo $error; ?></p>
              <div class="d-grid">
                <button type="submit" class="btn text-light main-bg" name="btnSignup">Signup</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>