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

   })</script>
</head>
<body>
<!-- Top container -->
<table width="100%" align="center" style="background-color:black;"><tr><td align="right"><img src="http://tvrijogja.com/utama/images/logo.png" width="100"></td><tr></table>
	<h1 align="center" style="margin:0; padding:20px; font-family:calibri; font-size:30pt"> Catatan Harian </h1>
	<center>
	<form method="POST" action="<?php echo base_url()."index.php/MainController/editJobdesc/".$id_catatanharian; ?>" enctype="multipart/form-data">
		
			<h2><?= $data['jobdesc']; ?></h2>
			<div class="form-group">
		<table>
			<input type="hidden" name="jobdesc" value="<?= $data['jobdesc']; ?>">
			<tr>
				<td><label for="idTanggal">Tanggal</label><input type="text" id="idTanggal" name="tanggal" class="tanggal form-control" size="100" value="<?= $tanggal; ?>"></td> 
			</tr>
			<tr>
				
				<td><label for="idNosurat">Nomor Surat</label><input type="text" id="idNosurat" class="form-control" name="nosurat" size="100" value="<?= $data['nosurat']; ?>"></td> 
			</tr>
			<tr>
				<td><label for="idNamaka">Nama Kegiatan</label><input type="text" id="idNamaka" class="form-control" name="namaka" size="100" value="<?= $data['namakegiatan']; ?>"></td>
			</tr>
			<tr>
				
				<td><label for="idCatatan">Catatan</label><textarea name="catatan" id="idCatatan" class="form-control"  rows="10"><?= $data['catatan']; ?></textarea></td>
			</tr>
			<tr>
			    
				<td><label for="idLampiran">Lampiran</label><br>
				<?php 
				if (empty($data['lampiran'])) {
					echo "Tidak terdapat lampiran";
				}else{
					echo '<img src="data:image/jpeg;base64,'.base64_encode($data['lampiran']).'"  height="200px" width="140px" />';
				}
				?>
				<br><input type="file" class="form-control-file" id="idlampiran" name="lampiran"></td>
				
			</tr>
			<tr>
				<td colspan="3" align="center"><input type="submit" name="simpan" value="Simpan" class="btn btn-info"></td>
			</tr>
		</table>
		</div>
	
	</form>
	</center>

</body>
</html>