<!-- BASIC AWAL 1-->
<?php
require_once('Enhanced_CS.php');
require_once('kmp/kmp.php');
require_once('koneksi.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'sama/header.php';?>

	<style>
		.loader {
			border: 8px solid #f3f3f3;
			border-radius: 50%;
			border-top: 8px solid blue;
			border-bottom: 8px solid blue;
			width: 70px;
			height: 70px;
			-webkit-animation: spin 2s linear infinite;
			animation: spin 2s linear infinite;
		}

		@-webkit-keyframes spin {
			0% { -webkit-transform: rotate(0deg); }
			100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
	</style>
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
							<form id="form1" method="post" action="">
								<input type="text" name="kata" id="kata" size="100" value="<?php if(isset($_GET['kata'])){ echo $_GET['kata']; }else{ echo '';}?>">
								<input class="btnForm" type="button" onclick="getdata()" name="submit" value="Cari"/>
							</form>
						</div>

                    </div>
				</div>
				<div class="col-lg-12">
					<div class="loader hidden"></div>
					<div id="ctn" class="panel-body hidden">
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>No</th>
									<th>Peribahasa</th>
									<th>Arti</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
						<div id="wrapp" class="hidden">
							<br>
							<br>
							<h3>Peribahasa Serupa</h3>
							<hr>
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example2">
								<thead>
									<tr>
										<th>No</th>
										<th>Peribahasa</th>
										<th>Arti</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			
            </div>
                </div> 
            </div>
		</div>	
		<?php include 'sama/footer.php';?>
	</body>

	<script>
		$(document).ready(function(){
			$('#dataTables-example').DataTable({responsive:true});
			$('#dataTables-example2').DataTable({responsive:true});
		});
	</script>

	<script>
		function getdata(){
			$(".loader").removeClass("hidden");
			$("#ctn").addClass("hidden");
			var table = $("#dataTables-example").DataTable();
			var table2 = $("#dataTables-example2").DataTable();
			table.clear();
			table2.clear();
			var kataa = $("#kata").val();
			$.post('controller/proses.php', {kata : kataa}, function(response) {
				if(response["status"] == "sukses"){
					$(".loader").addClass("hidden");
					$("#ctn").removeClass("hidden");
					var length = Object.keys(response["data"]).length;
					for(var i = 0; i < length; i++){
						var data = response["data"][i];
						$('#dataTables-example').dataTable().fnAddData( [
							i + 1,
							data.nama_peribahasa,
							data.arti_peribahasa
						]);
					}
					
					var len = Object.keys(response["relate"]).length;
					if(len > 0){
						$("#wrapp").removeClass('hidden');
						for(var i = 0; i < len; i++){
							var data = response["relate"][i];
							$('#dataTables-example2').dataTable().fnAddData( [
								i + 1,
								data.nama_peribahasa,
								data.arti_peribahasa
							]);
						}
					}else{
						$("#wrapp").addClass('hidden');
					}
				}

			},'json');
		}
	</script>
	
	<?php if(isset($_GET['kata'])): ?>
		<script>
			$("input[name=submit]").click();
		</script>
	<?php endif; ?>
</html>
	
