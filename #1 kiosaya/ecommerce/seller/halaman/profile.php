<?php $title = 'Profile'; ?>
<link href="../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<h1 align="center">Profile</h1>

    <div class="col-sm-8" style="width : 100%;">

		<div class="table-responsive">
     		<table class="table" style="border:0;">
                <tr>
                    <td>Full Name</td>
                    <td>:</td>
                    <td><?php echo $row[0]['name']; ?></td>
                </tr>
                <tr>
					<td>Address</td>
                    <td>:</td>
                    <td><?php echo $row[0]['address']; ?></td>
                </tr>
                <tr>
                    <td>Province</td>
                    <td>:</td>
                    <?php
                    $table = 'provinces';
                    $field = '*';
                    $on = '';
                    $where = 'id='.$row[0]['provinceId'];
                    $db->select($table,$field,$on,$where);
                    $hasil = $db->getResult();
                    $decode = json_decode($hasil,true);
                    $rowProv = $decode['post'];
                     ?>
                    <td><?php echo $rowProv[0]['name']; ?></td>
                </tr>
				<tr>
                    <td>City</td>
                    <td>:</td>
                    <?php
                    $table = 'city';
                    $field = '*';
                    $on = '';
                    $where = 'id='.$row[0]['cityId'];
                    $db->select($table,$field,$on,$where);
                    $hasil = $db->getResult();
                    $decode = json_decode($hasil,true);
                    $rowCity = $decode['post'];
                     ?>
                    <td><?php echo $rowCity[0]['name']; ?></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>:</td>
                    <td> <?php echo $row[0]['phone']; ?> </td>
                </tr>
                <tr>
                  <td colspan="3"><a style="float : right;" data-target="#editProfile" data-toggle="modal" class="btn btn-success">Edit Profile</a></td>
                </tr>
            </table>
        </div>
	</div>

  <div id="editProfile" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- konten modal-->
      <div class="modal-content">
        <!-- heading modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Profile</h4>
        </div>
        <!-- body modal -->
        <div class="modal-body">
          <?php include '../seller/halaman/editProfile.php'; ?>
        </div>
      </div>
    </div>
  </div>
