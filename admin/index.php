<?php
include('../controller.php');
session_start(); 
$controllerObj = new Controller();
$products = $controllerObj->getProducts();


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
        <!-- toogle JS start -->
        
        <script>
        document.addEventListener('DOMContentLoaded', function () {
    const toggleSwitches = document.querySelectorAll('.toggle-approval');

    toggleSwitches.forEach(function (toggleSwitch) {
        toggleSwitch.addEventListener('change', function () {
            const productId = toggleSwitch.dataset.productId;
            const isChecked = toggleSwitch.checked;

            // Send an AJAX request to update the database
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Handle the success response
                        console.log(xhr.responseText);
                        alert('Product visibility value updated!');
                    } else {
                        // Handle the error response
                        alert('Error updating product visibility value!');
                    }
                }
            };
            xhr.open('GET', 'product_approval.php?productId=' + productId + '&isChecked=' + isChecked, true);
            xhr.send();
        });
    });
});
        </script>



        <!-- toogle JS end -->
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
                        <h1 class="mt-4">Dashboard</h1>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Active Products
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Image</th>
                                            <th>Qty Available</th>
                                            <th>Price</th>
                                            <th>Active / In-Active</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <!-- <tr>
                                            <th>Product Name</th>
                                            <th>Qty Available</th>
                                            <th>Price</th>
                                            <th>Active / In-Active</th>
                                            <th>Action</th>
                                        </tr> -->
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                        
                                            foreach($products as $product){
                                                echo '<tr>';
                                                echo '<td>' . $product['productName'] . '</td>';
                                                echo '<td><img src="' . $product['productImg'] . '" alt="' . $product['productName'] . '" style="max-width: 100px; max-height: 100px;"></td>';
                                                echo '<td>' . $product['quantityAvailable'] . '</td>';
                                                echo '<td>' . $product['price'] . '</td>';
                                                // echo '<td><input type="checkbox" class="toggle-approval" data-product-id="' . $product['productID'] . '" ' . ($product['isProductApproved'] ? 'checked' : '') . ' data-toggle="toggle" data-on="Approved" data-off="Not Approved" data-onstyle="success" data-offstyle="danger"></td>';
                                                echo '<td>';
                                                echo '<div class="form-check form-switch form-switch-sm">';
                                                echo '<input class="form-check-input toggle-approval" type="checkbox" id="approvalSwitch' . $product['productID'] . '" data-product-id="' . $product['productID'] . '" ' . ($product['isProductApproved'] ? 'checked' : '') . '>';
                                                // echo $product['isProductApproved'] ? 'On' : 'Off';
                                                echo '</div>';
                                                echo '</td>';
                                                echo '<td><button type="button" class="btn btn-primary" onclick="location.href=\'edit_product.php?product_id=' . $product['productID'] . '\'">Edit</button></td>';
                                                echo '<td><button type="button" class="btn btn-danger" onclick="location.href=\'delete_product.php?product_id=' . $product['productID'] . '\'">Delete</button></td>';
                                                echo '</tr>';
                                            }
                                        ?>
                                        <!-- <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr> -->
                                    </tbody>
                                </table>
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
