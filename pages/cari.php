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
								<input type="text" name="kata" id="kata" size="100" value="<?php if(isset($_POST['kata'])){ echo $_POST['kata']; }else{ echo '';}?>">
								<input class="btnForm" type="button" onclick="getdata()" name="submit" value="Cari"/>
							</form>
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
		function getdata(){
			var kata = $("#kata").val();
			$.post(
				"controller/proses.php",
				{kata:kata})
			.done(function(data){
				alert(data);
			});
		}
	</script>
</html>
	
