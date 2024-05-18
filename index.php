<?php

include('controller.php');
$error = $errorPass = $errorEmail= "";
if(isset($_REQUEST['btnLogin'])){
  $controllerObj = new Controller();
  $error = $controllerObj->userLogin();
  
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
            <h2 class="p-3">Login</h2>
          </div>
          <div class="card-body">
            <form method="post">
              <div class="mb-4">
                <label for="username" class="form-label">Email</label>
                <input type="text" class="form-control" name="txtEmail" id="txtEmail" required/>
                <span class="error"> <?php echo $errorEmail; ?></span>
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="txtPassword" id="txtPassword" required/>
                <span class="error"> <?php echo $errorPass; ?></span>
              </div>
              <div class="mb-4">
                <label for="remember" class="form-label">Not a member? <a href="./signup.php">signup</a></label>

                <p class="text-danger text-center"><?php echo $error; ?></p>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn text-light main-bg" name="btnLogin">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>