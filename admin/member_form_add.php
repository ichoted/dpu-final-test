  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ฟอร์มเพิ่มข้อมูลพนักงาน </h1>
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
                        <input type="text" name="a_username" class="form-control" required placeholder="Username">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">Password</label>
                      <div class="col-sm-4">
                        <input type="password" name="a_password" class="form-control" required placeholder="Password">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2">ชื่อ นามสกุล</label>
                      <div class="col-sm-4">
                        <input type="text" name="a_name" class="form-control" minlength="5" maxlength="50" required placeholder="ชื่อ นามสกุล">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary"> เพิ่มข้อมูล </button>
                        <a href="member.php" class="btn btn-danger">ยกเลิก</a>
                      </div>
                    </div>

                  </div>
                  <!-- /.card-body -->

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
  //เช็ค input ที่ส่งมาจากฟอร์ม
  // echo '<pre>';
  // print_r($_POST);
  // exit;

  if (isset($_POST['a_username']) && isset($_POST['a_password']) && isset($_POST['a_name'])) {
    //echo 'ถูกเงื่อนไข ส่งข้อมูลมาได้';

    //trigger exception in a "try" block
    try {

      //ประกาศตัวแปรรับค่าจากฟอร์ม
      $a_username = $_POST['a_username'];
      $a_password = sha1($_POST['a_password']);
      $a_name = $_POST['a_name'];

      //เช็ค Username ซ้ำ
      //single row query แสดงแค่ 1 รายการ   
      $stmtMemberDetail = $condb->prepare("SELECT a_username FROM tbl_admin
                      WHERE a_username=:a_username
                      ");
      //bindParam
      $stmtMemberDetail->bindParam(':a_username', $a_username, PDO::PARAM_STR);
      $stmtMemberDetail->execute();
      $row = $stmtMemberDetail->fetch(PDO::FETCH_ASSOC);

      //นับจำนวนการคิวรี่ ถ้าได้ 1 คือ username ซ้ำ
      // echo $stmtMemberDetail->rowCount();
      // echo '<hr>';
      if ($stmtMemberDetail->rowCount() == 1) {
        //echo 'Username ซ้ำ';
        echo '<script>
                        setTimeout(function() {
                          swal({
                              title: "ชื่อ หรือ Username ซ้ำ !!",
                              text: "กรุณาเพิ่มข้อมูลใหม่อีกครั้ง",
                              type: "error"
                          }, function() {
                              window.location = "member.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                          });
                        }, 1000);
                    </script>';
      } else {
        //echo 'ไม่มี username ซ้ำ';
        //sql insert
        $stmtInsertMember = $condb->prepare("INSERT INTO tbl_admin
                    (
                      a_username,
                      a_password,
                      a_name
                    )
                    VALUES 
                    (
                      :a_username,
                      :a_password,
                      :a_name
                    )
                    ");

        //bindParam
        $stmtInsertMember->bindParam(':a_username', $a_username, PDO::PARAM_STR);
        $stmtInsertMember->bindParam(':a_password', $a_password, PDO::PARAM_STR);
        $stmtInsertMember->bindParam(':a_name', $a_name, PDO::PARAM_STR);
        $result = $stmtInsertMember->execute();

        $condb = null; //close connect db

        if ($result) {
          echo '<script>
                              setTimeout(function() {
                                swal({
                                    title: "เพิ่มข้อมูลสำเร็จ",
                                    type: "success"
                                }, function() {
                                    window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
                                });
                              }, 1000);
                          </script>';
        }
      } //เช็คข้อมูลซ้ำ
    } //try
    //catch exception
    catch (Exception $e) {
      // echo 'Message: ' .$e->getMessage();
      // exit;
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
  ?>