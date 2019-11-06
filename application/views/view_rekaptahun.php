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
    
  });
</script>

<body class="w3-light-grey">
<?php $this->load->view('view_header'); ?>

<div class="w3-main" style="margin-left:300px;margin-top:43px;">
 
  <hr>

  <center>
<h2>Data Rekap Tahunan</h2>
<h4>Nama: <?= $_SESSION['nama']; ?></h4>
<hr>
<center><h3>Tahun: <?= $tahun; ?></h3></center>

<div class="table-responsive">
<table class="table w3-white">
    <thead class="thead-light">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">I.Kegiatan Tugas jabatan</th>
            <th scope="col">Kuant/Output</th>
        </tr>
    </thead>
    <tbody>
    <?php $no=1;
      foreach ($data_u as $data_u ) { ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $data_u['jobdesc_u']; ?></td>
            <td><?= $data_u['dikerjakan_u']; ?></td>
          </tr>
          <?php
      } ?>

      <tr>
        <th scope="col">No.</th>
        <th scope="col">II.TUGAS TAMBAHAN DAN KREATIVITAS</th>
        <th scope="col">Kuant/Output</th>
      </tr>

      <?php $no=1;
      
      foreach ($data_t as $data_t) { ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= $data_t['jobdesc_t']; ?></td>
            <td><?= $data_t['dikerjakan_t']; ?></td>
          </tr>
          <?php
      } ?>
    
    </tbody>
</table>
</div> 

  <form method="POST" action="<?php echo base_url()."index.php/ControllerRekap/doRekapTahun/"; ?>">
  <table>
  <tr>
      <td>
            <select name="id_kepala" class="mdb-select md-form form-control" width="100%" required>
              <option value="" disabled selected>Pilih Kepala Bidang</option>
            <?php
              foreach ($data_kepala as $data_kepala) { ?>
                <option value="<?= $data_kepala['id_pegawai']; ?>" ><?= $data_kepala['nama']." - ".$data_kepala['jabatan']; ?></option>
                <?php
              }
            ?>
      </td>
  </tr>
  <tr>
  
  <td align="center">
  <?php

  if ($status==1) {
    ?> 
      <button type="submit" class="btn btn-info" ><i class="fas fa-download" style="color:white;"></i>&nbsp;Unduh Penilaian SKP</button>
    <?php
  } else {
    ?>
      <a href="#" style="color:white;"><button class="btn btn-danger" disabed><i class="fas fa-download" style="color:white;"></i>&nbsp;Belum Ada Data</button></a>
    <?php
  }
  
?>
  </td>
  </tr>
  
  </table>
  
  
  </form>

                    
</center>

  

  <!-- End page content -->
</div>
</body>
</html>



