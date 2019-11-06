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
  
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    $('#tabel-list').DataTable({
    "scrollY": "500px",
    "scrollCollapse": true
    });

    $('.dataTables_length').addClass('bs-select');

    $("a.btn-hapus").click(function(){
      var id = $(this).data('id');
      var r = confirm("Hapus catatan?");

      if (r == true) {
        window.location.href = "<?php echo base_url()."index.php/MainController/deleteCatatan/"; ?>"+id;
      } else {

      }
   
  });
    
    
  });
</script>

<body class="w3-light-grey">
<?php $this->load->view('view_header'); ?>

<div class="w3-main" style="margin-left:300px;margin-top:43px;">
  <hr>
  <br>
   <center>
<h2>Data Catatan Harian</h2>
<h4>Nama: <?= $_SESSION['nama']; ?></h4>
<div class="table-wrapper-scroll-y">
<table id="tabel-list" class="table table-bordered table-sm w3-white" cellspacing="0" width="100%" >
  <thead class="thead-light">
    <tr>
      <th class="th-sm">Tanggal</th>
      <th class="th-sm">Kuant</th>
      <th class="th-sm">Opsi</th>
    </tr>
  </thead>
  <tbody>
  <?php
    

    foreach ($data as $data) { 
      $tanggal = explode("-",$data['tanggal']);

      if ($tanggal[1] == 'Jan') {
        $bln = 1;
      }elseif ($tanggal[1] == 'Feb') {
        $bln = 2;
      }elseif ($tanggal[1] == 'Mar') {
        $bln = 3;
      }elseif ($tanggal[1] == 'Apr') {
        $bln = 4;
      }elseif ($tanggal[1] == 'May') {
        $bln = 5;
      }elseif ($tanggal[1] == 'Jun') {
        $bln = 6;
      }elseif ($tanggal[1] == 'Jul') {
        $bln = 7;
      }elseif ($tanggal[1] == 'Aug') {
        $bln = 8;
      }elseif ($tanggal[1] == 'Sep') {
        $bln = 9;
      }elseif ($tanggal[1] == 'Oct') {
        $bln = 10;
      }elseif ($tanggal[1] == 'Nov') {
        $bln = 11;
      }elseif ($tanggal[1] == 'Des') {
        $bln = 12;
      }

      ?>
      <tr>
      <td> <span style="display: none;"><?= $tanggal[2]."/".$bln."/".$tanggal[0]; ?></span> <?= $data['tanggal']; ?> </td>
      <td> <?= $data['kuant_harian']; ?> </td>
      <td td align="center" width="15%"> 
        <a href="<?php echo base_url()."index.php/MainController/viewListHarian/$data[tanggal]/"; ?>"><button class="btn btn-info">Lihat Selengkapnya</button></a>
      </td>
      </tr>
  <?php } ?>
  </tbody>
</table>    
</div>                      
</center>
<br><br><br>

</div>
</body>
</html>



