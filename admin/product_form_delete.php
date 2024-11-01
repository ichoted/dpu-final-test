<?php
require_once '../config/condb.php';

if (isset($_POST['no']) && isset($_POST['profile_image'])) {
    // Sweet Alert scripts and styles
    echo '<!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // exit;

    try {
        $no = $_POST['no'];
        $profile_image = $_POST['profile_image'];

        // Begin transaction
        $condb->beginTransaction();

        // Delete product from database
        $stmtDelProduct = $condb->prepare('DELETE FROM tbl_doctor WHERE no = :no');
        $stmtDelProduct->bindParam(':no', $no, PDO::PARAM_INT);
        $stmtDelProduct->execute();

        if ($stmtDelProduct->rowCount() == 1) {
            // Delete product image file
            $image_path = '../assets/uploads/' . $profile_image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            // Commit transaction
            $condb->commit();

            echo '<script>
            setTimeout(function() {
                swal({
                    title: "ลบข้อมูลสำเร็จ",
                    type: "success"
                }, function() {
                    window.location = "product.php";
                });
            }, 1000);
            </script>';
        } else {
            throw new Exception("ไม่พบข้อมูลสินค้าที่ต้องการลบ");
        }
    } catch (Exception $e) {
        // Rollback transaction
        $condb->rollBack();

        echo '<script>
        setTimeout(function() {
            swal({
                title: "เกิดข้อผิดพลาด",
                text: "' . $e->getMessage() . '",
                type: "error"
            }, function() {
                window.location = "product.php";
            });
        }, 1000);
        </script>';
    } finally {
        $condb = null; // Close database connection
    }
} else {
    echo '<script>
    setTimeout(function() {
        swal({
            title: "เกิดข้อผิดพลาด",
            text: "ไม่พบข้อมูลที่ต้องการลบ",
            type: "error"
        }, function() {
            window.location = "product.php";
        });
    }, 1000);
    </script>';
}
