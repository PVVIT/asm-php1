<?php
include_once "DBUntil.php";
$db = new DBUntil();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $id = $_POST['id'];
     $name = $_POST['name'];

     $data = array(
          'id' => $id,
          'name' => $name
     );
     $db->update("category", $data, "id = :id");
     $_SESSION['success_message'] = "Dữ liệu đã được thay đổi thành công!";
     header("Location: category.php");
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

     <title>SB Admin 2 - Blank</title>

     <!-- Custom fonts for this template-->
     <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
     <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

     <!-- Custom styles for this template-->
     <link href="css/sb-admin-2.min.css" rel="stylesheet">

     <style>
          /* Tùy chỉnh kiểu CSS nếu cần */
          body,
          html {
               height: 100%;
          }

          .full-height {
               height: 100%;
          }
     </style>

</head>

<body id="page-top">

     <!-- form-update -->
     <div class="d-flex justify-content-center align-items-center">
          <div class="container">
               <form action="update-category.php" method="POST"><br>
                    <h3>Update</h3>
                    <div class="mb-3">
                         <label for="pwd" class="form-label">ID:</label>
                         <input type="text" class="form-control form-control-user" name="id" value="<?php echo $_GET['id']; ?>">
                    </div>
                    <div class="mb-3">
                         <label for="pwd" class="form-label">Name:</label>
                         <input type="text" class="form-control form-control-user" name="name" value="<?php echo $_GET['name']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
               </form>
          </div>
     </div>

     <!-- Các tập tin script Bootstrap -->
     <script src="vendor/jquery/jquery.min.js"></script>
     <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
     <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
     <script src="js/sb-admin-2.min.js"></script>

</body>

</html>