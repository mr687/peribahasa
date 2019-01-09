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
					<div id="contentperibahasa" class="hidden">
						
					</div>
				</div>
            </div>
                </div> 
            </div>
		</div>	
		<?php include 'sama/footer.php';?>
	</body>
	<script>
		function getdata(){
			$("#contentperibahasa").addClass("hidden");
			$(".loader").removeClass("hidden");
			var kata = $("#kata").val();
			$.post(
				"controller/proses.php",
				{kata:kata})
			.done(function(data){
				$(".loader").addClass("hidden");
				$("#contentperibahasa").removeClass("hidden");
				$("#contentperibahasa").html(data);
			});
		}
	</script>
	<?php if($_GET['kata']): ?>
		<script>
			$("input[name=submit]").click();
		</script>
	<?php endif; ?>
</html>
	
