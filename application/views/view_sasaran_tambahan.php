<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<table width="100%" align="center" style="background-color:black;"><tr><td align="right"><img src="http://tvrijogja.com/utama/images/logo.png" width="100"></td><tr></table>
	<center>
		<h3>LIST JOBDESC</h3>
	<form method="POST" action="<?php echo base_url()."index.php/MainController/inputSasaranTambahan/"; ?>">
		<input type="hidden" name="nama" value="test dicoba">
		<table width="80%" class="table">
			<tr>
				<td colspan="3" align="center">TUGAS TAMBAHAN</td>
			</tr>
			<tr>
				<th>NO.</th>
				<th>JOBDESC</th>
				<th>TARGET JUMLAH PENGERJAAN</th>
			</tr>
			<?php

			for ($i=0; $i < $count_jobdesc_t; $i++) { ?>
				<tr>
					<td width="5%"><?= $i+1; ?></td>
					<td><input type="hidden" name="jobdesc_t[]" value="<?= $jobdesc_t[$i]; ?>"><?= $jobdesc_t[$i]; ?></td>
					<td align="center" width="20%"><input type="number" name="sasaran_t[]" value="0" align="center"></td>
				</tr>
			<?php
			}
			?>

		</table>
		
		<input type="submit" name="simpan" value="SIMPAN">
	</form>
	</center>
</body>
</html>