<?php
include_once "DBUntil.php";
$db = new DBUntil();
$errors = [];
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (!isset($_POST['name']) || empty($_POST['name'])) {
          $errors['name'] = "Name is required";
     } else {
          $name = $_POST['name'];
     }

     if (!isset($_POST['price']) || empty($_POST['price'])) {
          $errors['price'] = "Price is required";
     } else {
          $price = $_POST['price'];
     }

     if ($_FILES["picture"]) {
          $uploadDir = "./uploads/";
          $uploadFile = $uploadDir . basename($_FILES["picture"]["name"]);

          $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
          if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
               $errors['picture'] = "Chỉ chấp nhận các tệp ảnh JPG, JPEG, PNG & GIF.";
          }

          if (move_uploaded_file($_FILES["picture"]["tmp_name"], $uploadFile)) {
               $imageUrl = $uploadFile;
          } else {
               $errors['picture'] = "Có lỗi xảy ra khi tải lên tập tin.";
          }
     }

     if (count($errors) == 0 && isset($imageUrl)) {
          $db->insert("product", ["name" => $name, "picture" => $imageUrl, "price" => $price]);
          $_SESSION['success_message'] = "Dữ liệu đã được thêm thành công!";
          header("Location: product.php");
          exit();
     }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="description" content="">
     <meta name="author" content="">

     <title>SB Admin 2 - Product</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
     <!-- Custom fonts for this template-->
     <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
     <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

     <!-- Custom styles for this template-->
     <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

     <!-- Page Wrapper -->
     <div id="wrapper">

          <!-- Sidebar -->
          <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

               <!-- Sidebar - Brand -->
               <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                    <div class="sidebar-brand-icon rotate-n-15">
                         <i class="fas fa-laugh-wink"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
               </a>

               <!-- Divider -->
               <hr class="sidebar-divider my-0">

               <!-- Nav Item - Dashboard -->
               <li class="nav-item active">
                    <a class="nav-link" href="index.php">
                         <i class="fas fa-fw fa-user-alt"></i>
                         <span>User</span></a>
               </li>
               <li class="nav-item active">
                    <a class="nav-link" href="product.php">
                         <i class="fas fa-fw fa-list-alt"></i>
                         <span>Product</span></a>
               </li>
               <li class="nav-item active">
                    <a class="nav-link" href="category.php">
                         <i class="fas fa-fw fa-tachometer-alt"></i>
                         <span>Category</span></a>
               </li>
          </ul>
          <!-- End of Sidebar -->

          <!-- Content Wrapper -->
          <div id="content-wrapper" class="d-flex flex-column">

               <!-- Main Content -->
               <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                         <!-- Sidebar Toggle (Topbar) -->
                         <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                              <i class="fa fa-bars"></i>
                         </button>

                         <!-- Topbar Search -->
                         <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                              <div class="input-group">
                                   <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                   <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                             <i class="fas fa-search fa-sm"></i>
                                        </button>
                                   </div>
                              </div>
                         </form>

                         <!-- Topbar Navbar -->
                         <ul class="navbar-nav ml-auto">

                              <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                              <li class="nav-item dropdown no-arrow d-sm-none">
                                   <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-search fa-fw"></i>
                                   </a>
                                   <!-- Dropdown - Messages -->
                                   <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                        <form class="form-inline mr-auto w-100 navbar-search">
                                             <div class="input-group">
                                                  <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                                  <div class="input-group-append">
                                                       <button class="btn btn-primary" type="button">
                                                            <i class="fas fa-search fa-sm"></i>
                                                       </button>
                                                  </div>
                                             </div>
                                        </form>
                                   </div>
                              </li>

                              <!-- Nav Item - Alerts -->
                              <li class="nav-item dropdown no-arrow mx-1">
                                   <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bell fa-fw"></i>
                                        <!-- Counter - Alerts -->
                                        <span class="badge badge-danger badge-counter">3+</span>
                                   </a>
                                   <!-- Dropdown - Alerts -->
                                   <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                        <h6 class="dropdown-header">
                                             Alerts Center
                                        </h6>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                             <div class="mr-3">
                                                  <div class="icon-circle bg-primary">
                                                       <i class="fas fa-file-alt text-white"></i>
                                                  </div>
                                             </div>
                                             <div>
                                                  <div class="small text-gray-500">December 12, 2019</div>
                                                  <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                             </div>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                             <div class="mr-3">
                                                  <div class="icon-circle bg-success">
                                                       <i class="fas fa-donate text-white"></i>
                                                  </div>
                                             </div>
                                             <div>
                                                  <div class="small text-gray-500">December 7, 2019</div>
                                                  $290.29 has been deposited into your account!
                                             </div>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                             <div class="mr-3">
                                                  <div class="icon-circle bg-warning">
                                                       <i class="fas fa-exclamation-triangle text-white"></i>
                                                  </div>
                                             </div>
                                             <div>
                                                  <div class="small text-gray-500">December 2, 2019</div>
                                                  Spending Alert: We've noticed unusually high spending for your account.
                                             </div>
                                        </a>
                                        <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                   </div>
                              </li>

                              <!-- Nav Item - Messages -->
                              <li class="nav-item dropdown no-arrow mx-1">
                                   <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-envelope fa-fw"></i>
                                        <!-- Counter - Messages -->
                                        <span class="badge badge-danger badge-counter">7</span>
                                   </a>
                                   <!-- Dropdown - Messages -->
                                   <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                        <h6 class="dropdown-header">
                                             Message Center
                                        </h6>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                             <div class="dropdown-list-image mr-3">
                                                  <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                                  <div class="status-indicator bg-success"></div>
                                             </div>
                                             <div class="font-weight-bold">
                                                  <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                                       problem I've been having.</div>
                                                  <div class="small text-gray-500">Emily Fowler · 58m</div>
                                             </div>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                             <div class="dropdown-list-image mr-3">
                                                  <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                                  <div class="status-indicator"></div>
                                             </div>
                                             <div>
                                                  <div class="text-truncate">I have the photos that you ordered last month, how
                                                       would you like them sent to you?</div>
                                                  <div class="small text-gray-500">Jae Chun · 1d</div>
                                             </div>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                             <div class="dropdown-list-image mr-3">
                                                  <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                                  <div class="status-indicator bg-warning"></div>
                                             </div>
                                             <div>
                                                  <div class="text-truncate">Last month's report looks great, I am very happy with
                                                       the progress so far, keep up the good work!</div>
                                                  <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                             </div>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                             <div class="dropdown-list-image mr-3">
                                                  <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                                  <div class="status-indicator bg-success"></div>
                                             </div>
                                             <div>
                                                  <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                                       told me that people say this to all dogs, even if they aren't good...</div>
                                                  <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                             </div>
                                        </a>
                                        <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                                   </div>
                              </li>

                              <div class="topbar-divider d-none d-sm-block"></div>

                              <!-- Nav Item - User Information -->
                              <li class="nav-item dropdown no-arrow">
                                   <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                                   </a>
                                   <!-- Dropdown - User Information -->
                                   <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="#">
                                             <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                             Profile
                                        </a>
                                        <a class="dropdown-item" href="#">
                                             <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                             Settings
                                        </a>
                                        <a class="dropdown-item" href="#">
                                             <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                             Activity Log
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                             <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                             Logout
                                        </a>
                                   </div>
                              </li>

                         </ul>
                    </nav>
                    <!-- chỗ thêm sản phẩm  -->
                    <div class="container-xl">

                         <form action="add-product.php" method="post" enctype="multipart/form-data">
                              <h3>Add Product</h3>
                              <div class="mb-3">
                                   <label for="pwd" class="form-label">Name:</label>
                                   <input type="text" class="form-control form-control-user" name="name" placeholder="Enter Name">
                                   <?php
                                   if (isset($errors['name'])) {
                                        echo "<span class='text-danger' style='font-size: 15px; padding-left: 14px'>$errors[name]</span>";
                                   }
                                   ?>
                              </div>
                              <div class="mb-3">
                                   <label for="picture" class="form-label">Picture:</label>
                                   <input type="file" class="form-control form-file" name="picture">
                                   <?php
                                   if (isset($errors['picture'])) {
                                        echo "<span class='text-danger' style='font-size: 15px; padding-left: 14px'>$errors[picture]</span>";
                                   }
                                   ?>
                              </div>
                              <div class="mb-3">
                                   <label for="pwd" class="form-label">Price:</label>
                                   <input type="text" class="form-control form-control-user" name="price" placeholder="Enter Price">
                                   <?php
                                   if (isset($errors['price'])) {
                                        echo "<span class='text-danger' style='font-size: 15px; padding-left: 14px'>$errors[price]</span>";
                                   }
                                   ?>
                              </div>
                              <button type="submit" class="btn btn-primary">Add Product</button>
                         </form>
                    </div>
                    <!-- <kết thúc  -->
               </div>
               <!-- End of Main Content -->

               <!-- Footer -->
               <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                         <div class="copyright text-center my-auto">
                              <span>Copyright &copy; Your Website 2021</span>
                         </div>
                    </div>
               </footer>
               <!-- End of Footer -->

          </div>
          <!-- End of Content Wrapper -->

     </div>
     <!-- End of Page Wrapper -->

     <!-- Scroll to Top Button-->
     <a class="scroll-to-top rounded" href="#page-top">
          <i class="fas fa-angle-up"></i>
     </a>

     <!-- Logout Modal-->
     <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                         <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                         </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                         <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                         <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
               </div>
          </div>
     </div>

     <!-- Bootstrap core JavaScript-->
     <script src="vendor/jquery/jquery.min.js"></script>
     <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

     <!-- Core plugin JavaScript-->
     <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

     <!-- Custom scripts for all pages-->
     <script src="js/sb-admin-2.min.js"></script>

     <!-- Page level plugins -->
     <script src="vendor/chart.js/Chart.min.js"></script>

     <!-- Page level custom scripts -->
     <script src="js/demo/chart-area-demo.js"></script>
     <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>