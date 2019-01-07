<!-- BASIC AWAL 1-->

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
	<?php include 'sama/navigation.php';?>

		<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Daftar Peribahasa</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							Tabel Peribahasa
						</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>No</th>
										<th>Peribahasa</th>
										<th>Arti</th>
										<th>Kategori</th>
									</tr>
								</thead>
							
								
							<?php
								include "koneksi.php";
								$sql  = "SELECT * from tb_peribahasa";
								$tampil = mysqli_query($link,$sql);
								$no = 0;
								while($data = mysqli_fetch_array($tampil)){
								$no++;
								$id_kategori= $data["id_kategori"];
								$sql2 = "SELECT nama_kategori from tb_kategori where id_kategori = '$id_kategori'";
								$tampil2 = mysqli_query($link,$sql2);
							?>
							<tr>
								<td height="32"><?= $no;?></td>
								<td><?= $data["nama_peribahasa"];?></td>
								<td><?= $data["arti_peribahasa"];?></td>
								<?php while($data2 = mysqli_fetch_array($tampil2)){ ?>
								<td><?= $data2["nama_kategori"];}?></td>
							</tr>
							<?php
							} ?>
							
						</table>
                            
							<!-- /.panel-heading -->
                        <!-- /.panel-body -->
						</div>
						<!-- /.panel -->
                    
                    </div>
					
                    <!-- /.panel -->
                </div>
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