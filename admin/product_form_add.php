<?php
//คิวรี่ข้อมูลหมวดหมู่สินค้า
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1> ฟอร์มเพิ่มข้อมูล Doctor </h1>
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
              <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">

                  <div class="form-group row">
                    <label class="col-sm-2">เพศ</label>
                    <div class="col-sm-2">
                      <select name="sex" class="form-control">
                        <option value="">เลือก</option>
                        <option value="female">หญิง</option>
                        <option value="male">ชาย</option>
                        <option value="other">ไม่ระบุ</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">เลขบัตรประจำตัวประชาชน</label>
                    <div class="col-sm-4">
                      <input type="text" name="people_id" class="form-control" minlength="13" maxlength="13" required placeholder="ระบุเลขบัตรประจำตัวประชาชน">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="col-sm-2">ชื่อ-นามสกุล</label>
                    <div class="col-sm-7">
                      <input type="text" name="doctor_name" class="form-control" maxlength="100" required placeholder="ระบุชื่อ-นามสกุล">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">สาขาที่เรียน</label>
                    <div class="col-sm-7">
                      <input type="text" name="field_of_study" class="form-control" maxlength="100" required placeholder="ระบุสาขาที่เรียน">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">เงินเดือน</label>
                    <div class="col-sm-7">
                      <input type="number" name="salary" class="form-control" required placeholder="ระบุเงินเดือน">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">Email</label>
                    <div class="col-sm-7">
                      <input type="email" name="doc_email" class="form-control" required placeholder="ระบุอีเมล์">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">ภาพ Doctor</label>
                    <div class="col-sm-7">
                      <input type="file" name="profile_image" class="form-control" accept="image/*">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-4">
                      <button type="submit" class="btn btn-primary"> เพิ่มข้อมูล </button>
                      <a href="product.php" class="btn btn-danger">ยกเลิก</a>
                    </div>
                  </div>

                </div> <!-- /.card-body -->

              </form>
              <?php
              // echo '<pre>';
              // print_r($_POST);
              // echo '<hr>';
              // print_r($_FILES);
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
//     echo '<pre>';
//     print_r($_POST);
//  exit;

if (isset($_POST['sex']) && isset($_POST['people_id']) && isset($_POST['doctor_name']) && isset($_POST['field_of_study']) && isset($_POST['salary']) && isset($_POST['doc_email'])) {
  //echo 'ถูกเงื่อนไข ส่งข้อมูลมาได้';


  //trigger exception in a "try" block
  try {

    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $sex = $_POST['sex'];
    $people_id = $_POST['people_id'];
    $doctor_name = $_POST['doctor_name'];
    $field_of_study = $_POST['field_of_study'];
    $salary = $_POST['salary'];
    $doc_email = $_POST['doc_email'];


    //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
    $date1 = date("Ymd_His");
    //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
    $numrand = (mt_rand());
    $profile_image = (isset($_POST['profile_image']) ? $_POST['profile_image'] : '');
    $upload = $_FILES['profile_image']['name'];

    //มีการอัพโหลดไฟล์
    if ($upload != '') {
      //ตัดขื่อเอาเฉพาะนามสกุล
      $typefile = strrchr($_FILES['profile_image']['name'], ".");

      //สร้างเงื่อนไขตรวจสอบนามสกุลของไฟล์ที่อัพโหลดเข้ามา
      if ($typefile == '.jpg' || $typefile  == '.jpeg' || $typefile  == '.png') {

        //โฟลเดอร์ที่เก็บไฟล์
        $path = "../assets/uploads/";
        //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
        $newname = $numrand . $date1 . $typefile;
        $path_copy = $path . $newname;
        //คัดลอกไฟล์ไปยังโฟลเดอร์
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $path_copy);


        //sql insert
        $stmtInsertProduct = $condb->prepare("INSERT INTO tbl_doctor
                    (
                      sex,
                      people_id,
                      doctor_name,
                      field_of_study,
                      salary,
                      doc_email,
                      profile_image
                    )
                    VALUES 
                    (
                      :sex,
                      :people_id,
                      :doctor_name,
                      :field_of_study,
                      :salary,
                      :doc_email,
                      '$newname'                     
                    )
                    ");

        //bindParam
        $stmtInsertProduct->bindParam(':sex', $sex, PDO::PARAM_STR);
        $stmtInsertProduct->bindParam(':people_id', $people_id, PDO::PARAM_STR);
        $stmtInsertProduct->bindParam(':doctor_name', $doctor_name, PDO::PARAM_STR);
        $stmtInsertProduct->bindParam(':field_of_study', $field_of_study, PDO::PARAM_STR);
        $stmtInsertProduct->bindParam(':salary', $salary, PDO::PARAM_INT);
        $stmtInsertProduct->bindParam(':doc_email', $doc_email, PDO::PARAM_STR);
        $result = $stmtInsertProduct->execute();
        $condb = null; //close connect db

        //เงื่อนไขตรวจสอบการเพิ่มข้อมูล
        if ($result) {
          echo '<script>
                            setTimeout(function() {
                              swal({
                                  title: "เพิ่มข้อมูลสำเร็จ",
                                  type: "success"
                              }, function() {
                                  window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
                              });
                            }, 1000);
                        </script>';
        } //if

      } else { //ถ้าไฟล์ที่อัพโหลดไม่ตรงตามที่กำหนด
        echo '<script>
                                setTimeout(function() {
                                  swal({
                                      title: "คุณอัพโหลดไฟล์ไม่ถูกต้อง",
                                      type: "error"
                                  }, function() {
                                      window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
                                  });
                                }, 1000);
                            </script>';
      } //else ของเช็คนามสกุลไฟล์

    } // if($upload !='') {
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
                          window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
                      });
                    }, 1000);
                </script>';
  } //catch
} //isset
?>