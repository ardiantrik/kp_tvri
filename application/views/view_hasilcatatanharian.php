
<!DOCTYPE html>
<html>
<head>
	<title> Hasil Catatan Harian</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<table width="100%" align="center" style="background-color:black;"><tr><td align="right"><img src="http://tvrijogja.com/utama/images/logo.png" width="100"></td><tr></table>
	<h1 align="center" style="margin:0; padding:20px; font-family:calibri; font-size:30pt"> Hasil Catatan Harian </h1>
	<center><h2>Review Jobdesk</h2>
	<form method="POST" action="<?php echo base_url()."index.php/MainController/inputJobdesc/"; ?>">
		<table class="table table-hover table-bordered">
			<thead class="thead-dark">
			<tr>
				<th>No.</th>
				<th>Tanggal</th>
				<th>No. Surat</th>
				<th>Nama Kegiatan</th>
				<th>Catatan</th>
				<th>Lampiran</th>
			</tr>
			</thead>
		<?php for ($i=0; $i < $count_jobdesc ; $i++) { 
			?>
			<tr>
				<input type="hidden" name="jobdesc[]" value="<?= $jobdesc[$i];?>">
				<td><?= $i+1; ?></td>
				<td><input type="hidden" name="tanggal[]" value="<?= $tanggal[$i];?>"><?= $tanggal[$i];?></td>
				<td><input type="hidden" name="nosurat[]" value="<?= $nosurat[$i];?>"><?= $nosurat[$i];?></td>
				<td><input type="hidden" name="namaka[]" value="<?= $namaka[$i];?>"><?= $namaka[$i];?></td>
				<td style="text-align: left; max-width: 300px; min-width: 150px; word-wrap: break-word;"><input type="hidden" name="catatan[]" value="<?= $catatan[$i];?>"><?= $catatan[$i];?></td>
				<?php
					if (empty($lampiran[$i])) { ?>
						<input type="hidden" name="lampiran[]">	
						<td>Tidak Ada Lampiran</td>
						<?php
					}else {
						$img= file_get_contents($lampiran[$i]);
						//echo base64_decode($img);
						 ?>
						<td>
							<img src="data:img/jpeg;base64,<?= base64_encode($img);?>">
							<input type="hidden" name="lampiran[]" value="<?= base64_encode($img); ?>">
						</td>
						<?php
					}
				?>
				
			</tr>
			<?php } ?>
		</table>
		<input type="submit" value="SIMPAN" name="btn-submit" style="width: 10%;height: 25%;">
	</form>
	</center>
</body>
</html>