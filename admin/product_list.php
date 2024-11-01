<?php
//คิวรี่ข้อมูลสมาชิก
$queryproduct = $condb->prepare("SELECT * FROM tbl_doctor");
$queryproduct->execute();
$rsproduct = $queryproduct->fetchAll();
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>จัดการข้อมูล
            <a href="product.php?act=add" class="btn btn-primary">เพิ่มข้อมูล</a>
          </h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped table-sm">
                <thead>
                  <tr class="table-info">
                    <th width="5%" class="text-center">No.</th>
                    <th width="10%">ภาพ</th>
                    <th width="45%">ชื่อ-นามสกุล</th>
                    <th width="20%">สาขาที่เรียน</th>
                    <th width="5%" class="text-center">แก้ไข</th>
                    <th width="5%" class="text-center">ลบ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1; //start number
                  foreach ($rsproduct as $row) { ?>
                    <tr>
                      <td align="center"> <?php echo $i++ ?> </td>
                      <td><img src="../assets/uploads/<?= $row['profile_image']; ?>" width="100%"></td>
                      <td><?= $row['doctor_name']; ?></td>
                      <td><?= $row['field_of_study']; ?></td>
                      <td align="center">
                        <a href="product.php?no=<?= $row['no']; ?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a>
                      </td>
                      <td align="center">
                      <form action="product_form_delete.php" method="post">
                        <input type="hidden" name="no" value="<?=$row['no'];?>">
                        <input type="hidden" name="profile_image" value="<?=$row['profile_image'];?>">
                        <button type="submit" name="actions" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล??');">ลบ</button>
                      </form>
                    </td>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->