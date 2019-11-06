<!DOCTYPE html>
<html>
<head>
	<title>Catatan Harian</title>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script>
   $(document).ready(function(){
	   $(".tanggal").datepicker({
	   	 dateFormat: 'dd-M-yy' 
	   });

	   $("a.page").click(function(){
    	var id = $(this).data('page');
    	$(".catatan_harian").hide();
    	$("#"+id).show(); 
  		});

	   $("a.btn").click(function(){
    	var id = $(this).data('page');
    	$(".catatan_harian").hide();
    	$("#"+id).show(); 
    	
  		});
   })</script>
</head>
<body>
<table width="100%" align="center" style="background-color:black;"><tr><td align="right"><img src="http://tvrijogja.com/utama/images/logo.png" width="100"></td><tr></table>
	<h1 align="center" style="margin:0; padding:20px; font-family:calibri; font-size:30pt"> Catatan Harian </h1>
	<center>
	<form method="POST" action="<?php echo base_url()."index.php/MainController/viewHasilCatatan/"; ?>" enctype="multipart/form-data">
	<?php
	for ($i=0; $i < $count_jobdesc; $i++) { 
		if ($i==0) { ?>
			<div class="catatan_harian form-group" id="<?= $i+1; ?>">
			<?php
		}else{ ?>
			<div class="catatan_harian form-group" id="<?= $i+1; ?>" style="display: none;">
			<?php
		}
		?>
		
			<h2><?= $jobdesc[$i]; ?></h2>
		
		<table>
			<input type="hidden" name="jobdesc[]" value="<?= $jobdesc[$i]; ?>">
			<tr>
				<td><label for="idTanggal<?= $i;?>">Tanggal</label><input type="text" id="idTanggal<?= $i;?>" name="tanggal[]" class="tanggal form-control" size="100" required/></td> 
			</tr>
			<tr>
				<td><label for="idNosurat">Nomor Surat</label><input type="text" id="idNosurat" class="form-control" name="nosurat[]" size="100" required></td> 
			</tr>
			<tr>
				<td><label for="idNamaka">Nama Kegiatan</label><input type="text" id="idNamaka" class="form-control" name="namaka[]" size="100" required></td>
			</tr>
			<tr>
				<td><label for="idCatatan">Catatan</label><textarea name="catatan[]" id="idCatatan" class="form-control"  rows="10" required></textarea></td>
				
			</tr>
			<tr>
				<td><label for="idLampiran">Lampiran</label><input type="file" class="form-control-file" id="idlampiran" name="lampiran[]"></td>
			</tr>
			<tr>
				<?php
				if ($i==0 && $count_jobdesc>1) { ?>
					<td></td>
					<td></td>
					<td align="right"><a class="btn btn-info" href="#" data-page="<?= $i+2; ?>">Lanjut</a></td>
					<?php
				}elseif ($i==0 && $count_jobdesc==1) { ?>
					<td></td>
					<td></td>
					<td align="right"><input type="submit" name="simpan" value="Simpan" class="btn btn-info"></td>
					<?php
				}elseif ($i==$count_jobdesc-1) { ?>
					<td align="left"><a class="btn btn-info" href="#" data-page="<?= $i; ?>">Kembali</a></td>
					<td></td>
					<td align="right"><input type="submit" name="simpan" value="Simpan" class="btn btn-info"></td>
					<?php
				}else{ ?>
					<td align="left"><a class="btn btn-info" href="#" data-page="<?= $i; ?>">Kembali</a></td>
					<td></td>
					<td align="right"><a class="btn btn-info" href="#" data-page="<?= $i+2; ?>">Lanjut</a></td>
					<?php
				}

				?>	
			</tr>
		</table>
			
		</div>
	<?php
	}


	?>
	
	</form>
	<ul class="pagination pagination-lg">
						<?php
						for ($i=1; $i <= $count_jobdesc ; $i++) { ?>
							<li><a class="page" href="#" data-page="<?= $i; ?>"><?= $i; ?></a></li>
						<?php	
						}

						?>
					</ul>
	</center>

</body>
</html>