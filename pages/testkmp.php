<!-- BASIC AWAL 1-->

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'sama/header.php';?>
</head>

<body>
	<?php include 'sama/navigation.php';?>

		<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cari Peribahasa</h1>
                </div>
				<div class="col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">                            
						<!-- /.panel-heading -->
                        <!-- /.panel-body -->
						<div class="form-group">
							Input Text <br><br>
							<form method="post" action="">
							<input type="text" name="kata" id="kata" size="100" value="<?php if(isset($_POST['kata'])){ echo $_POST['kata']; }else{ echo '';}?>">
							<input class="btnForm" type="submit" name="submit" value="Cari"/>
							</form>
							<?php include 'kmp/index.php'; ?>
							
							<!--///////////////////////-->
							
							<div class="row">
								<div class="col-lg-12">
										<!-- /.panel-heading -->
										<div class="panel-body">
											 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
												<thead>
													<tr>
														<th>No</th>
														<th>Peribahasa</th>
														<th>Arti</th>
														
													</tr>
												</thead>
											
												
											<?php
												include "koneksi.php";
												$sql  = "SELECT * from periba";
												$tampil = mysqli_query($link,$sql);
												$no = 0;
												while($data = mysqli_fetch_array($tampil)){
												$no++;
												
											?>
											<tr>
												<td height="32"><?= $no;?></td>
												<td><?= $data["nama_peribahasa"];?></td>
												<td><?= $data["arti_peribahasa"];?></td>
												
											</tr>
											<?php
											} ?>
											
										</table>
											
											<!-- /.panel-heading -->
										<!-- /.panel-body -->
										</div>
										<!-- /.panel -->
									
									
									
									<!-- /.panel -->
								</div>
							</div>
							
							<!--/////////////////////-->
							
						</div>
						
                    </div>
						 
				</div>
						<!-- /.panel -->
                    
            </div>
					
                    <!-- /.panel -->
                </div> 
				
                <!-- /.col-lg-12 -->
            </div>
		</div>	
		<?php include 'sama/footer.php';?>
		
		<!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
	
	<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
</body>
</html>
	
