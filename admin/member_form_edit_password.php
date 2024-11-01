<?php
if (isset($_GET['a_no']) && $_GET['act'] == 'editPwd') {
    // Single row query to display only 1 record
    $stmtMemberDetail = $condb->prepare("SELECT * FROM tbl_admin WHERE a_no=?");
    $stmtMemberDetail->execute([$_GET['a_no']]);
    $row = $stmtMemberDetail->fetch(PDO::FETCH_ASSOC);

    // If the query fails, stop execution
    if ($stmtMemberDetail->rowCount() != 1) {
        exit();
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Password</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <div class="card card-primary">
                            <!-- form start -->
                            <form action="" method="post">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2">Username</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="a_username" class="form-control" value="<?php echo $row['a_username']; ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">New Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" name="NewPassword" class="form-control" minlength="6" maxlength="10" placeholder="Enter New Password">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">Confirm Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" name="ConfirmPassword" class="form-control" minlength="6" maxlength="10" required placeholder="Enter Confirm New Password">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="a_no" value="<?php echo $row['a_no']; ?>">
                                            <button type="submit" class="btn btn-primary">Confirm</button>
                                            <a href="member.php" class="btn btn-danger">Cancel</a>
                                        </div>
                                    </div>
                                </div> <!-- /.card-body -->
                            </form>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $a_no = $_POST['a_no'];
                                $newPassword = $_POST['NewPassword'];
                                $confirmPassword = $_POST['ConfirmPassword'];

                                if ($newPassword === $confirmPassword) {
                                    $hashedPassword = sha1($newPassword);

                                    try {
                                        $stmt = $condb->prepare("UPDATE tbl_admin SET a_password = :a_password WHERE a_no = :a_no");
                                        $stmt->bindParam(':a_password', $hashedPassword, PDO::PARAM_STR);
                                        $stmt->bindParam(':a_no', $a_no, PDO::PARAM_INT);
                                        $result = $stmt->execute();

                                        if ($result) {
                                            echo '<script>
                                                setTimeout(function() {
                                                    swal({
                                                        title: "Changed Password Success",
                                                        type: "success"
                                                    }, function() {
                                                        window.location = "member.php";
                                                    });
                                                }, 1000);
                                            </script>';
                                        }
                                    } catch (Exception $e) {
                                        echo '<script>
                                            setTimeout(function() {
                                                swal({
                                                    title: "Something went wrong!",
                                                    text: "Try again",
                                                    type: "error"
                                                });
                                            }, 1000);
                                        </script>';
                                    }
                                } else {
                                    echo '<script>
                                        setTimeout(function() {
                                            swal({
                                                title: "Password not match!",
                                                text: "Enter again",
                                                type: "error"
                                            });
                                        }, 1000);
                                    </script>';
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
