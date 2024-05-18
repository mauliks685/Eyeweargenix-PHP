
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Eyeweargenix</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/custom.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
  </head>

  <body>
    <header class="site-header">
      <div class="container">
        <h1 tabindex="0" class="logo">
          <a href="home.php">
            <img src="assets/img/logo.png" alt="Eyeweargenix" />
          </a>
        </h1>

        <nav tabindex="1" class="navbar navbar-expand-lg ms-auto">
          <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="products.php">Products</a>
                </li>
                
                <li class="nav-item">
                  <a class="nav-link" href="cart.php">Cart</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link"><?php 
                        echo $_SESSION['email']; ?></a>
                </li>

                
                <li class="nav-item">
                  <a class="nav-link" href="logout.php">Logout</a>
                </li>

              </ul>
            </div>

          </div>
        </nav>
      </div>
    </header>
