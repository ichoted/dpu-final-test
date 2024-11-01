<?php
if (isset($_GET['a_no']) && $_GET['act'] == 'edit') {

  //single row query แสดงแค่ 1 รายการ   
  $stmtMemberDetail = $condb->prepare("SELECT * FROM tbl_admin WHERE a_no=?");
  $stmtMemberDetail->execute([$_GET['a_no']]);
  $row = $stmtMemberDetail->fetch(PDO::FETCH_ASSOC);

  // echo '<pre>';
  // print_r($row);    
  // exit;

  //ถ้าคิวรี่ผิดพลาดให้หยุดการทำงาน
  if ($stmtMemberDetail->rowCount() != 1) {
    exit();
  }
} //isset
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ฟอร์มแก้ไขข้อมูลพนักงาน </h1>
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

                  <!-- Starting Username -->
                  <div class="form-group row">
                    <label class="col-sm-2">Username</label>
                    <div class="col-sm-4">
                      <input type="text" name="a_username" class="form-control" value="<?php echo $row['a_username']; ?>" required disabled>
                    </div>
                  </div>
                  <!-- Ending Username -->

                   <!-- Starting Name -->
                   <div class="form-group row">
                    <label class="col-sm-2">Name</label>
                    <div class="col-sm-4">
                      <input type="text" name="a_name" class="form-control" value="<?php echo $row['a_name']; ?>" required>
                    </div>
                  </div>
                  <!-- Ending Name -->

                   <!-- Starting Phone -->
                   <!-- <div class="form-group row">
                    <label class="col-sm-2">Phone</label>
                    <div class="col-sm-4">
                      <input type="number" minlength="10" maxlength="10" name="phone" class="form-control" required>
                    </div>
                  </div> -->
                  <!-- Ending Phone -->


                  <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                      <input type="hidden" name="a_no" value="<?php echo $row['a_no']; ?>">
                      <button type="submit" class="btn btn-primary"> ปรับปรุงข้อมูล </button>
                      <a href="member.php" class="btn btn-danger">ยกเลิก</a>
                    </div>
                  </div>

                </div> <!-- /.card-body -->

              </form>

              <?php

              // echo '<pre>';
              // print_r($_POST);
              // exit;

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

<?php
// echo '<pre>';
// print_r($_POST);
//exit;

if (isset($_POST['a_no'])) {

  // echo 'เข้ามาในเงื่อนไขได้';
  // exit;

  //trigger exception in a "try" block
  try {

    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $a_no = $_POST['a_no'];
    $a_name = $_POST['a_name'];

    //sql update
    $stmtUpdate = $condb->prepare("UPDATE tbl_admin SET                   
                    a_name=:a_name
                    WHERE a_no=:a_no
                    ");
    //bindParam
    $stmtUpdate->bindParam(':a_no', $a_no, PDO::PARAM_INT);
    $stmtUpdate->bindParam(':a_name', $a_name, PDO::PARAM_STR);

    $result = $stmtUpdate->execute();

    $condb = null; //close connect db

    if ($result) {
      echo '<script>
                             setTimeout(function() {
                              swal({
                                  title: "แก้ไขข้อมูลสำเร็จ",
                                  type: "success"
                              }, function() {
                                  window.location = "member.php";
                              });
                            }, 1000);
                        </script>';
    }
  } //try
  //catch exception
  catch (Exception $e) {
    // echo 'Message: ' .$e->getMessage();
    // exit;
    echo '<script>
                           setTimeout(function() {
                            swal({
                                title: "เกิดข้อผิดพลาด",
                                text: "กรุณาติดต่อผู้ดูแลระบบ/Username ซ้ำ !!",
                                type: "error"
                            }, function() {
                                window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
                            });
                          }, 1000);
                      </script>';
  } //catch


} //isset

//window.location = "member.php?id='.$id.'&act=edit"; //หน้าที่ต้องการให้กระโดดไป
?>