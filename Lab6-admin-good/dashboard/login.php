<?php
include_once "DBUntil.php";
session_start();
$db = new DBUntil();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (!isset($_POST['username']) || empty($_POST['username'])) {
          $errors['username'] = "Please enter username";
     } else {
          $username = $_POST['username'];
          $_SESSION['username'] = $username;
     }
     if (!isset($_POST['password']) || empty($_POST['password'])) {
          $errors['password'] = "Please enter password";
     } else {
          $password = $_POST['password'];
     }

     if (count($errors) == 0) {
          if ($db->select("SELECT * FROM user WHERE username = :username AND password = :password", array('username' => $username, 'password' => $password))) {
               $_SESSION['username'] = $username;
               $_SESSION['success-message'] = "Login thành công";
               header("Location:../fruitables-main/index.php");
               exit();
          } else {
               $errors['login'] = "Invalid username or password";
          }
     }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
     <title>Bootstrap Example</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
        body {
            background-color: #f7f7f7;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-control {
            border-radius: 4px;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
        }
        .text-danger {
            font-size: 0.875em;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>

<body>

     <div class="container mt-3">
          <h2>Login form</h2>
          <form action="login.php" method="post" class="forgot-password.php">
               <div class="mb-3 mt-3">
                    <label for="email">Username:</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter username" name="username">
               <?php
               if (isset($errors['username'])) {
                    echo "<p class='text-danger'>" . $errors['username'] . "</p>";
               }
               ?>
               </div>
               <div class="mb-3">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
               <?php
               if (isset($errors['password'])) {
                    echo "<p class='text-danger'>" . $errors['password'] . "</p>";
               }
               ?>
               </div>
               <a type="submit" value="forgot" href="forgot-password.php">Forgot password</a>
               <br><a href="register.php">Đăng ký</a><br>
               <button type="submit" class="btn btn-primary">Submit</button>
               <?php
               if (isset($errors['login'])) {
                    echo "<p class='text-danger'>" . $errors['login'] . "</p>";
               }
               ?>
          </form>
     </div>

</body>

</html>