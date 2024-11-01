<?php

if (isset($_GET['a_no']) && $_GET['act'] == 'delete') {
    //trigger exception in a "try" block
    try {

        $a_no = $_GET['a_no'];

        $stmtDeltype = $condb->prepare('DELETE FROM tbl_admin WHERE a_no=:a_no');
        $stmtDeltype->bindParam(':a_no', $a_no, PDO::PARAM_INT);
        $stmtDeltype->execute();

        $condb = null; //close connect db
        //echo 'จำนวน row ที่ลบได้ ' .$stmtDeltype->rowCount();
        if ($stmtDeltype->rowCount() == 1) {
            echo '<script>
            setTimeout(function() {
            swal({
                title: "ลบข้อมูลสำเร็จ",
                type: "success"
            }, function() {
                window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
            });
        }, 1000);
    </script>';
            exit;
        }
    } //try
    //catch exception
    catch (Exception $e) {
        //echo 'Message: ' .$e->getMessage();
        echo '<script>
            setTimeout(function() {
            swal({
                title: "เกิดข้อผิดพลาด",
                type: "error"
            }, function() {
              window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
            });
        }, 1000);
    </script>';
    } //catch
} //isset
