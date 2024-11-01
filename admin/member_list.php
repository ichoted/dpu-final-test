<?php
//คิวรี่ข้อมูลสมาชิก
$queryMember = $condb->prepare("SELECT * FROM tbl_admin");
$queryMember->execute();
$rsMember = $queryMember->fetchAll();

// echo '<pre>';
// $queryMember->debugDumpParams();
// exit;
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>จัดการข้อมูลพนักงาน
            <a href="member.php?act=add" class="btn btn-primary">เพิ่มพนักงาน</a>
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
                    <th width="20%">Username</th>
                    <th width="40%">Name</th>
                    <th width="15%">Created</th>
                    <th width="10%">Edit</th>
                    <th width="5%" class="text-center">Edit</th>
                    <th width="5%" class="text-center">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1; //start number
                  foreach ($rsMember as $row) { ?>
                    <tr>
                      <td align="center"> <?php echo $i++ ?> </td>
                      <td><?= $row['a_username']; ?></td>
                      <td><?= $row['a_name']; ?></td>
                      
                      <!-- Format Date -->
                      <!-- <?php
                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $row['a_dateCreate']);
                      ?>
                      <td><?= $date ? $date->format('d/m/Y') : 'Invalid date'; ?></td> -->
                      
                      <!-- Display Date -->
                      <td><?= $row['a_dateCreate']; ?></td>
                      
                      <td align="center">
                        <a href="member.php?a_no=<?= $row['a_no']; ?>&act=editPwd" class="btn btn-info btn-sm">แก้รหัส</a>
                      </td>
                      <td align="center">
                        <a href="member.php?a_no=<?= $row['a_no']; ?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a>
                      </td>
                      <td align="center">
                        <a href="member.php?a_no=<?= $row['a_no']; ?>&act=delete" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล??');">ลบ</a>
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