<!-- BASIC AWAL 1-->
<?php
require_once('Enhanced_CS.php');
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
							<form method="post" action="">
							<input type="text" name="kata" id="kata" size="100" value="<?php if(isset($_POST['kata'])){ echo $_POST['kata']; }else{ echo '';}?>">
							<input class="btnForm" type="submit" name="submit" value="Cari"/>
							</form>
							<?php include 'textpre/preprocessing.php'; ?>
							
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
	</body>
</html>
	
