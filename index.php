<?php

session_start();

//connect database 
require_once 'config/condb.php';

if (isset($_POST['btn']) && $_POST['btn'] === 'login' && isset($_POST['a_username']) && isset($_POST['a_password'])) {
    $a_username = $_POST['a_username'];
    $a_password = sha1($_POST['a_password']);

    $stmtAdminDetail = $condb->prepare("
        SELECT a_no, a_username, a_password, a_name, a_dateCreate 
        FROM tbl_admin
        WHERE a_username = :a_username AND a_password = :a_password");

    $stmtAdminDetail->bindParam(':a_username', $a_username, PDO::PARAM_STR);
    $stmtAdminDetail->bindParam(':a_password', $a_password, PDO::PARAM_STR);
    $stmtAdminDetail->execute();
    $row = $stmtAdminDetail->fetch(PDO::FETCH_ASSOC);

    if ($stmtAdminDetail->rowCount() == 1) {
        $_SESSION['admin_no'] = $row['a_no'];
        $_SESSION['admin_name'] = $row['a_name'];
        header('Location: admin/');
    } else {
       //TODO Add alert
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    <style>
        .transparent-card {
            background-color: rgba(200, 200, 200, 0.5);
            border: 2;
        }
    </style>
</head>

<body>

    <div class="container" style="margin-top: 150px;">
        <div class="row">
            <div class="col-md-4"></div>

            <div class="card col-md-4 p-4 transparent-card">
                <h3 class="text-black text-center mb-4" style="font-family: 'Sixtyfour Convergence', sans-serif;">LOGIN</h3>

                <form action="index.php" method="post">
                    <div class="row">
                        <input type="text" name="a_username" class="form-control" required placeholder="Username">
                    </div>
                    <br>
                    <div class="row">
                        <input type="password" name="a_password" class="form-control" required placeholder="Password">
                    </div>
                    <br>
                    <div class="row">
                        <button type="submit" name="btn" value="login" class="btn btn-dark">Login</button>
                    </div>
                    <br>
                </form>

                <div class="row">
                    <h6 class="text-dark">[user: admin_1][pass: 111111]</h6>
                </div>
            </div>
        </div>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
    </script>
</body>

</html>
