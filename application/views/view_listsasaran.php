<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->load->view('template_cdn'); ?>
    <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.0/css/mdb.min.css" rel="stylesheet">

  <!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.0/js/mdb.min.js"></script>
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
</head>
<style>
  table.dataTable thead .sorting:after,
  table.dataTable thead .sorting:before,
  table.dataTable thead .sorting_asc:after,
  table.dataTable thead .sorting_asc:before,
  table.dataTable thead .sorting_asc_disabled:after,
  table.dataTable thead .sorting_asc_disabled:before,
  table.dataTable thead .sorting_desc:after,
  table.dataTable thead .sorting_desc:before,
  table.dataTable thead .sorting_desc_disabled:after,
  table.dataTable thead .sorting_desc_disabled:before {
  bottom: .5em;
  }
</style>
<script>
  $(document).ready(function () {

    $("select").click(function(){
    var nama = $(this).find(':selected').data('nama');
    var nip = $(this).find(':selected').data('nip');
    var jabatan = $(this).find(':selected').data('jabatan');
    var pangkat = $(this).find(':selected').data('pangkat');
    document.getElementById("nama_p").value = nama;
    document.getElementById("nip_p").value = nip;
    document.getElementById("jabatan_p").value = jabatan;
    document.getElementById("gol_p").value = pangkat;
    });
    
  });
</script>
<body class="w3-light-grey">
<?php $this->load->view('view_header'); ?>

<div class="w3-main" style="margin-left:300px;margin-top:43px;">
 
  <hr>

  <center>
<h2>Data Sasaran Kerja Pegawai</h2>
<h4>Nama: <?= $_SESSION['nama']; ?></h4>
<hr>
<center><h3>Tahun : <?= $tahun;?></h3></center>

<div class="table-responsive">
<table class="table w3-white">
    <thead class="thead-light">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">I.Kegiatan Tugas jabatan</th>
            <th scope="col">AK</th>
            <th scope="col">Kuant/Output</th>
            <th scope="col">Kual/Mutu</th>
            <th scope="col">Waktu</th>
            <th scope="col">Biaya</th>
        </tr>
    </thead>
    <tbody>
    <?php $no=1;
      foreach ($data_u as $data_u ) { ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $data_u['jobdesc']; ?></td>
            <td><?= '0'; ?></td>
            <td><?= $data_u['sasaran']; ?></td>
            <td><?= '100'; ?></td>
            <td><?= '12 Bulan'; ?></td>
            <td><?= ' '; ?></td>
          </tr>
          <?php
      } ?>

      <tr>
        <th scope="col">No.</th>
        <th scope="col">II.TUGAS TAMBAHAN DAN KREATIVITAS</th>
        <th scope="col">AK</th>
        <th scope="col">Kuant/Output</th>
        <th scope="col">Kual/Mutu</th>
        <th scope="col">Waktu</th>
        <th scope="col">Biaya</th>
      </tr>

      <?php $no=1;
      
      foreach ($data_t as $data_t) { ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $data_t['jobdesc']; ?></td>
            <td><?= '0'; ?></td>
            <td><?= $data_t['sasaran']; ?></td>
            <td><?= '100'; ?></td>
            <td><?= '12 Bulan'; ?></td>
            <td><?= ' '; ?></td>
          </tr>
          <?php
      } ?>
    
    </tbody>
</table>
<form action="<?php echo base_url()."index.php/ControllerRekap/doRekapSasaran/"; ?>" method="POST">
<div class="table-responsive md-form">
<table class="table w3-white" width="100%">
      <tr>
        <td width="50%">
        <table>
        <thead class="thead-light"><tr><th>PEJABAT PENILAI</th></tr></thead>
          <tr>
              <td>
                  <select name="id_kepala" class="mdb-select md-form form-control" width="100%">
                    <option value="" disabled selected>Pilih Kepala Bidang</option>
                  <?php
                    foreach ($data_kepala as $data_kepala) { ?>
                      <option value="<?= $data_kepala['id_pegawai']; ?>" class="kepbid" data-nama="<?= $data_kepala['nama']; ?>" data-pangkat="<?= $data_kepala['pangkat']; ?>"  data-nip="<?= $data_kepala['nip']; ?>" data-jabatan="<?= $data_kepala['jabatan']; ?>"><?= $data_kepala['nama']." - ".$data_kepala['jabatan']; ?></option>
                      <?php
                    }
                  ?>
                  
              </td>
              
          </tr>
          <tr><td><input type="text" name="nama_penilai" placeholder="Nama Penilai" id="nama_p" class="form-control"></td></tr>
          <tr><td><input type="text" name="nip_penilai" placeholder="NIP Penilai" id="nip_p" class="form-control"></td></tr>
          <tr><td><input type="text" name="golongan_penilai" placeholder="Pangkat/Gol. Ruang Penilai" id="gol_p" class="form-control"></td></tr>
          <tr><td><input type="text" name="jabatan_penilai" placeholder="Jabatan Penilai" id="jabatan_p" class="form-control"></td></tr>
          <tr><td><input type="text" name="unit_penilai" value="TVRI Stasiun D.I. Yogyakarta" class="form-control"></td></tr>
        
        </table>
        </td>
        <td width="50%">
        <table width="100%">
        <thead class="thead-light"><tr><th>PNS DINILAI</th></tr></thead>
        <tr><td><h6>Dimohon untuk mengisi kekurangan yang ada.<br> Terima kasih</h6></td></tr>
          <tr><td><input type="text" name="nama_dinilai" value="<?= $_SESSION['nama']; ?>" class="form-control"></td></tr>
          <tr><td><input type="text" name="nip_dinilai" value="<?= $_SESSION['nip']; ?>" class="form-control"></td></tr>
          <tr><td><input type="text" name="golongan_dinilai" value="<?= $_SESSION['pangkat']; ?>" class="form-control" require></td></tr>
          <tr><td><input type="text" name="jabatan_dinilai" value="<?= $_SESSION['jabatan']; ?>" class="form-control"></td></tr>
          <tr><td><input type="text" name="unit_dinilai" value="TVRI Stasiun D.I. Yogyakarta" class="form-control"></td></tr>
        
        </table>

        </td>
      </tr>

</table>
</div>

<h6>*Mohon setelah mengunduh memeriksa dan memasukkan kekurangan yang sekiranya belum terdapat dalam dokumen</h6>
</div> 
<?php

  if ($status==1) {
    ?> 
      <button type="submit" class="btn btn-info" ><i class="fas fa-download" style="color:white;"></i>&nbsp;Unduh SKP</button>
    <?php
  } else {
    ?>
      <a href="#" style="color:white;"><button class="btn btn-danger" disabed><i class="fas fa-download" style="color:white;"></i>&nbsp;Belum Ada Data</button></a>
    <?php
  }
  
?>
</form>
                     
</center>

  

  <!-- End page content -->
</div>
</body>
</html>



