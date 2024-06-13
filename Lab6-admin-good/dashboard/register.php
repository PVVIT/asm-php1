<?php
session_start();
include_once 'DBUntil.php';
$db = new DBUntil();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     if (!isset($_POST['username']) || empty($_POST['username'])) {
          $errors['username'] = "Username is required";
     } else {
          $username = $_POST['username'];
          $_SESSION['username'] = $username;
     }
     if (!isset($_POST['email']) || empty($_POST['email'])) {
          $errors['email'] = "Email is required";
     } else {
          $email = $_POST['email'];
          $_SESSION['email'] = $email;
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               $errors['email'] = "Invalid email format";
          }
     }
     if (!isset($_POST['password']) || empty($_POST['password'])) {
          $errors['password'] = "Password is required";
     } else {
          $password = $_POST['password'];
          $_SESSION['password'] = $password;
     }

     if (!isset($_POST['phone']) || empty($_POST['phone'])) {
          $errors['phone'] = "Phone is required";
     } else {
          $phone = $_POST['phone'];
          $_SESSION['phone'] = $phone;
          if (!preg_match('/^[0-9]+$/', $phone)) {
               $errors['phone'] = "Invalid phone format";
          }
     }

     if (!isset($_POST['role']) || empty($_POST['role'])) {
          $errors['role'] = "Role is required";
     } else {
          $role = $_POST['role'];
          $_SESSION['role'] = $role;
     }

     if (isset($_FILES['avatar']) && !$_FILES['avatar']['error'] > UPLOAD_ERR_OK) {
          $target_dir = __DIR__ . "/uploads/";
          $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
          $IMAGE_TYPES = array('jpg', 'jpeg', 'png');

          if (!in_array($imageFileType, $IMAGE_TYPES)) {
               $errors['avatar'] = "avatar type must is image format";
          }

          if (
               $_FILES['avatar']["size"] > 1000000
          ) {
               $errors['avatar'] = "avatar too large";
          }

          var_dump($imageFileType);
     } else {
          $avatar = null;
     }

     if (count($errors) == 0) {
          $avatar = null;
          // upload 
          if (isset($_FILES['avatar']) && !$_FILES['avatar']['error'] > UPLOAD_ERR_OK) {
               if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                    $avatar = htmlspecialchars(basename($_FILES["avatar"]["name"]));
                    echo "The file " . htmlspecialchars(basename($_FILES["avatar"]["name"])) . " has been uploaded.";
               } else {
                    echo "Sorry, there was an error uploading your file.";
               }
          }


          $isCreate = $db->insert('user', array(
               "username" => $username,
               "password" => $password,
               "email" => $email,
               "role" => $role,
               "phone" => $phone
          ));
          $_SESSION['success_message'] = "Đăng thành công";
          header("Location: login.php");
     }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
     <title>ASM</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
     /* General form styling */
     form {
          max-width: 600px;
          margin: auto;
          padding: 20px;
          border: 1px solid #ccc;
          border-radius: 10px;
          background-color: #f9f9f9;
          box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
     }

     /* Input fields styling */
     form .form-control,
     form .form-select {
          width: 100%;
          padding: 10px;
          margin-top: 5px;
          margin-bottom: 15px;
          border-radius: 5px;
          border: 1px solid #ccc;
          box-sizing: border-box;
          font-size: 16px;
     }

     /* Labels styling */
     form label {
          font-weight: bold;
          margin-bottom: 5px;
          display: inline-block;
     }

     /* Error message styling */
     form .text-danger {
          display: block;
          margin-top: 5px;
          font-size: 14px;
     }

     /* Button styling */
     form .btn {
          width: 100%;
          padding: 10px;
          border: none;
          border-radius: 5px;
          background-color: #007bff;
          color: white;
          font-size: 18px;
          cursor: pointer;
     }

     form .btn:hover {
          background-color: #0056b3;
     }
</style>

<body>

     <div class="container mt-3">

          <form action="register.php" method="post" enctype="multipart/form-data">
               <h2>Register form</h2>
               <div class="mb-3 mt-3">
                    <label for="email">Username:</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter username" name="username">
                    <?php
                    if (isset($errors['username'])) {
                         echo "<span class='text-danger' style='font-size: 15px;'>$errors[username]</span>";
                    }
                    ?>
               </div>
               <div class="mb-3 mt-3">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
                    <?php
                    if (isset($errors['email'])) {
                         echo "<span class='text-danger' style='font-size: 15px;'>$errors[email]</span>";
                    }
                    ?>
               </div>
               <div class="mb-3 mt-3">
                    <label for="email">Phone:</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter phone" name="phone">
                    <?php
                    if (isset($errors['phone'])) {
                         echo "<span class='text-danger' style='font-size: 15px;'>$errors[phone]</span>";
                    }
                    ?>
               </div>
               <div class="mb-3">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
                    <?php
                    if (isset($errors['password'])) {
                         echo "<span class='text-danger' style='font-size: 15px;'>$errors[password]</span>";
                    }
                    ?>
               </div>
               <div class="mb-3">
                    <label for="role">Role:</label>
                    <select class="form-select" name="role">
                         <option value=""></option>
                         <option value="admin">Admin</option>
                         <option value="user">User</option>
                    </select>
                    <?php
                    if (isset($errors['role'])) {
                         echo "<span class='text-danger' style='font-size: 15px;'>$errors[role]</span>";
                    }
                    ?>
               </div>
               <a href="login.php">Đăng nhập</a> <br>
               <button type="submit" class="btn btn-primary">Submit</button>
          </form>
     </div>

</body>

</html>