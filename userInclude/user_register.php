<?php
session_start();
require_once "../Config/config.php";
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password  = $_POST['password'];

    $sql = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $sql->bindValue(
        ':email',
        $email
    );
    $sql->execute();
    $user = $sql->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo "<script>alert('Email Duplicated!');</script>";
    } else {
        $sql = $pdo->prepare("INSERT INTO users(name,email,password) VALUES (:name,:email,:password)");
        $result = $sql->execute(
            array(
                ':name' => $name, ':email' => $email, ':password' => $password
            )
        );
        if ($result) {
            echo "<script>alert('Successfully Registered.Now You can login!');window.location.href='user_login.php';</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog | Log in</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="../dist/css/adminlte.min.css?v=3.2.0">
</head>

<body class="wrap">
    <div class="login-box">
        <div class="login-logo">
            <h1 href=""><b>User</b>Login</h1>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-person"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button name="submit" type="submit" class="btn btn-primary btn-block">Register</button>
                            <a type="button" href="register.php" class="btn btn-light btn-block">Login</a>
                        </div>
                    </div>
                </form>



                <!-- <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p> -->
            </div>

        </div>
    </div>


    <script src="../plugins/jquery/jquery.min.js"></script>

    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../dist/js/adminlte.min.js?v=3.2.0"></script>
</body>

</html>