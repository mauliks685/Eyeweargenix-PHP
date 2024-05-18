<?php
include('../controller.php');
session_start();
if(isset($_POST['btnEditProduct'])){
    $controllerObj = new Controller();
    $controllerObj->editProduct();
}
if(isset($_REQUEST['product_id'])){
    $controllerObj = new Controller();
    $products = $controllerObj->getProductById();


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Eyeweargenix</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="products.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                Add Products
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php 
                        echo $_SESSION['email']; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Products</h1>
                        <div class="card mb-4">
                            <div class="card-header" style="background-color: black; color: white; ">
                                <i class="fas fa-table me-1"></i>
                                Edit Products
                            </div>
                            <div class="card-body" style="background-color: lightgray;">
                                <form method="post" enctype="multipart/form-data">
                                    <?php 
                                    if($products) {
                                        ?>
                                        <input type="hidden" class="form-control" name="productID" value="<?php echo $products['productID']; ?>" id="productID" required>
                                        <div class="row mb-3">
                                        <label for="productName" class="col-sm-2 col-form-label">Product Name</label>
                                        <div class="col-sm-10">
                                        <input type="text" class="form-control" name="productName" value="<?php echo $products['productName']; ?>" id="productName" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="productImg" class="col-sm-2 col-form-label">Image</label>
                                        <div class="col-sm-10">
                                        <input type="file" class="form-control-file" name="productImg" id="productImg" accept="image/*" required>

                                        <img src="<?php echo $products['productImg']; ?>" alt="<?php echo $products['productName']; ?>" style="max-width: 100px; max-height: 100px;">

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="productQtyAvailable" class="col-sm-2 col-form-label">Qunatity</label>
                                        <div class="col-sm-10">
                                        <input type="number" class="form-control" name="productQtyAvailable" id="productQtyAvailable" value="<?php echo $products['quantityAvailable']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="productPrice" class="col-sm-2 col-form-label">Price (CAD)</label>
                                        <div class="col-sm-10">
                                        <input type="number" class="form-control" name="productPrice" id="productPrice" value="<?php echo $products['price']; ?>" pattern="\d+(\.\d{2})?" required>
                                        </div>
                                    </div>
                                        
                                        
                                        
                                    <button type="submit" name="btnEditProduct" class="btn btn-secondary">Edit Product</button>
                                    <?php
                                    }
                                }
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Eyeweargenix 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>