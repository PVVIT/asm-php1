<?php
include_once "DBUntil.php";
$db = new DBUntil();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['username']) || empty($_POST['username'])) {
        $errors['username'] = "Please enter username";
    } else {
        $username = $_POST['username'];
    }
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = "Please enter password";
    } else {
        $password = $_POST['password'];
    }
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = "Please enter email";
    } else {
        $email = $_POST['email'];
    }
    if (!isset($_POST['phone']) || empty($_POST['phone'])) {
        $errors['phone'] = "Please enter phone";
    } else {
        $phone = $_POST['phone'];
    }
    if (empty($errors)) {
        $db->insert("user", [
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'phone' => $phone
        ]);
        header("Location: login.php");
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

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" action="register.php" method="POST">
                                <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="username" id="exampleInputEmail"
                                        placeholder="Enter username">
                                        <?php
                                        if (isset($errors['username'])) {
                                            echo "<span class='text-danger' style='font-size: 12px; padding-left: 15px'>$errors[username]</span>";
                                        }
                                        ?>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail"
                                        placeholder="Enter email">
                                        <?php
                                        if (isset($errors['email'])) {
                                            echo "<span class='text-danger' style='font-size: 12px; padding-left: 15px'>$errors[email]</span>";
                                        }
                                        ?>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control form-control-user" name="phone" id="exampleInputEmail"
                                        placeholder="Enter phone">
                                        <?php
                                        if (isset($errors['phone'])) {
                                            echo "<span class='text-danger' style='font-size: 12px; padding-left: 15px'>$errors[phone]</span>";
                                        }
                                        ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" name="password" placeholder="Password">
                                        <?php
                                        if (isset($errors['password'])) {
                                            echo "<span class='text-danger' style='font-size: 12px; padding-left: 15px'>$errors[password]</span>";
                                        }
                                        ?>  
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" name="repassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                                <hr>
                                <a href="index.php" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.php" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
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

</body>

</html>