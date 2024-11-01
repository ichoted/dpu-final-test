<?php
if (isset($_GET['no']) && $_GET['act'] == 'edit') {
    
    //single row query แสดงแค่ 1 รายการ   
    $stmtMemberDetail = $condb->prepare("SELECT * FROM tbl_doctor WHERE no=?");
    $stmtMemberDetail->execute([$_GET['no']]);
    $row = $stmtMemberDetail->fetch(PDO::FETCH_ASSOC);

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
                    <h1> ฟอร์มแก้ไขข้อมูลสินค้า </h1>
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
                                        <label class="col-sm-2">Gender</label>
                                        <div class="col-sm-2">
                                            <select name="sex" class="form-control" required>
                                                <option value="<?php echo $row['sex']; ?>"><?php echo $row['sex']; ?></option>
                                                <option disabled>-- เลือกข้อมูลใหม่ --</option>
                                                <option value="female">หญิง</option>
                                                <option value="male">ชาย</option>
                                                <option value="other">ไม่ระบุ</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">เลขบัตรประจำตัวประชาชน</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="people_id" class="form-control" minlength="13" maxlength="13" required placeholder="ระบุเลขบัตรประจำตัวประชาชน" value="<?php echo $row['people_id']; ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-2">ชื่อ-นามสกุล</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="doctor_name" class="form-control" maxlength="100" required placeholder="ระบุชื่อ-นามสกุล" value="<?php echo $row['doctor_name']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">สาขาที่เรียน</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="field_of_study" class="form-control" maxlength="100" required placeholder="ระบุสาขาที่เรียน" value="<?php echo $row['field_of_study']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">เงินเดือน</label>
                                        <div class="col-sm-7">
                                            <input type="number" name="salary" class="form-control" required placeholder="ระบุเงินเดือน" value="<?php echo $row['salary']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">Email</label>
                                        <div class="col-sm-7">
                                            <input type="email" name="doc_email" class="form-control" required placeholder="ระบุอีเมล์" value="<?php echo $row['doc_email']; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2">ภาพ Doctor</label>
                                        <div class="col-sm-7">
                                            <img src="../assets/uploads/<?php echo $row['profile_image']; ?>" width="200px">
                                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="no" value="<?php echo $row['no']; ?>">
                                            <input type="hidden" name="oldImg" value="<?php echo $row['profile_image']; ?>">
                                            <button type="submit" class="btn btn-primary"> บันทึก </button>
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
// echo '<pre>';
// print_r($_POST);
// exit;

if (isset($_POST['no'])) {
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
        $no = $_POST['no'];
        $upload = $_FILES['profile_image']['name'];

        //สร้างเงื่อนไขตรวจสอบการอัพโหลดไฟล์
        if ($upload == '') {
            //echo 'ไม่มีการอัพโหลดไฟล์'; 
            //sql update without upload file
            $stmtUpdateProduct = $condb->prepare("UPDATE tbl_doctor SET
            no=:no,
            sex=:sex,
            people_id=:people_id,
            doctor_name=:doctor_name,
            field_of_study=:field_of_study,
            salary=:salary,
            doc_email=:doc_email
            WHERE no=:no
    ");

            //bindParam
            $stmtUpdateProduct->bindParam(':no', $no, PDO::PARAM_STR);
            $stmtUpdateProduct->bindParam(':sex', $sex, PDO::PARAM_STR);
            $stmtUpdateProduct->bindParam(':people_id', $people_id, PDO::PARAM_STR);
            $stmtUpdateProduct->bindParam(':doctor_name', $doctor_name, PDO::PARAM_STR);
            $stmtUpdateProduct->bindParam(':field_of_study', $field_of_study, PDO::PARAM_STR);
            $stmtUpdateProduct->bindParam(':salary', $salary, PDO::PARAM_INT);
            $stmtUpdateProduct->bindParam(':doc_email', $doc_email, PDO::PARAM_STR);
            $result = $stmtUpdateProduct->execute();
            if ($result) {
                echo '<script>
                setTimeout(function() {
                  swal({
                      title: "ปรับปรุงข้อมูลสำเร็จ",
                      type: "success"
                  }, function() {
                      window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
                  });
                }, 1000);
            </script>';
            } //if


        } else {
            // echo 'มีการอัพโหลดไฟล์ใหม่';
            //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
            $date1 = date("Ymd_His");
            //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
            $numrand = (mt_rand());
            $product_image = (isset($_POST['profile_image']) ? $_POST['profile_image'] : '');

            //ตัดขื่อเอาเฉพาะนามสกุล
            $typefile = strrchr($_FILES['profile_image']['name'], ".");

            //    echo $typefile;
            //    exit;

            //สร้างเงื่อนไขตรวจสอบนามสกุลของไฟล์ที่อัพโหลดเข้ามา
            if ($typefile == '.jpg' || $typefile  == '.jpeg' || $typefile  == '.png') {
                //echo 'อัพโหลดไฟล์ไม่ถูกต้อง';
                //exit;

                //ลบภาพเก่า 
                unlink('../assets/uploads/' . $_POST['oldImg']);

                //โฟลเดอร์ที่เก็บไฟล์
                $path = "../assets/uploads/";
                //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
                $newname = $numrand . $date1 . $typefile;
                $path_copy = $path . $newname;
                //คัดลอกไฟล์ไปยังโฟลเดอร์
                move_uploaded_file($_FILES['profile_image']['tmp_name'], $path_copy);

                //sql update with upload file 
                $stmtUpdateProduct = $condb->prepare("UPDATE tbl_doctor SET
                no=:no,
                sex=:sex,
                people_id=:people_id,
                doctor_name=:doctor_name,
                field_of_study=:field_of_study,
                salary=:salary,
                doc_email=:doc_email,
                profile_image=:profile_image
                WHERE no=:no
            ");
                //bindParam
                $stmtUpdateProduct->bindParam(':no', $no, PDO::PARAM_STR);
                $stmtUpdateProduct->bindParam(':sex', $sex, PDO::PARAM_STR);
                $stmtUpdateProduct->bindParam(':people_id', $people_id, PDO::PARAM_STR);
                $stmtUpdateProduct->bindParam(':doctor_name', $doctor_name, PDO::PARAM_STR);
                $stmtUpdateProduct->bindParam(':field_of_study', $field_of_study, PDO::PARAM_STR);
                $stmtUpdateProduct->bindParam(':salary', $salary, PDO::PARAM_INT);
                $stmtUpdateProduct->bindParam(':doc_email', $doc_email, PDO::PARAM_STR);
                $stmtUpdateProduct->bindParam(':profile_image', $newname, PDO::PARAM_STR);
                $result = $stmtUpdateProduct->execute();
                if ($result) {
                    echo '<script>
                setTimeout(function() {
                  swal({
                      title: "ปรับปรุงข้อมูลสำเร็จ",
                      type: "success"
                  }, function() {
                      window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
                  });
                }, 1000);
            </script>';
                } //if

            } else { //อัพโหลดไฟล์ไม่ถุกต้อง
                echo '<script>
                setTimeout(function() {
                swal({
                    title: "คุณอัพโหลดไฟล์ไม่ถูกต้อง",
                    type: "error"
                }, function() {
                    window.location = "product.php?id=' . $id . '&act=edit";
                });
                }, 1000);
            </script>';
                //exit;
            } //else upload file
        } //else not upload file

    } //try
    //catch exception
    catch (Exception $e) {
        //echo 'Message: ' .$e->getMessage();
        //exit;
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