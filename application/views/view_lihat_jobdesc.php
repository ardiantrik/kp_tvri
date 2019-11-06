<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->load->view('template_cdn'); ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
.dropdown-submenu {
  position: relative;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}

</style>
</head>
<body class="w3-light-grey">
<?php $this->load->view('view_header'); ?>

<div class="w3-main" style="margin-left:300px;margin-top:43px;">
 
  <hr>
  <div class="container">   
  <form method="POST" action="<?php echo base_url()."index.php/MainController/doCatatanHarian/"; ?>">                              
  <h3>TUGAS UTAMA</h3>
  
    <table width="90%">
          <?php
          foreach ($data_u as $data) {
            ?>
            <tr>
            <td><input type="checkbox" name="jobdesc[]" value="<?= $data['jobdesc']; ?>"></td><td><?= $data['jobdesc']; ?></td>
            </tr>
           <?php
          }
    ?>
    </table>
  
  </table>
  

  <h3>TUGAS TAMBAHAN</h3>
  <table width="90%">
          <?php
          foreach ($data_t as $data) {
            ?>
            <tr>
            <td><input type="checkbox" name="jobdesc[]" value="<?= $data['jobdesc']; ?>"></td><td><?= $data['jobdesc']; ?></td>
            </tr>
           <?php
          }
    ?>
    </table>
    <hr>
  <input type="submit" name="lanjut" value="LANJUT" style="width: 10%;height: 25%;">
  
  </form>
<p><p><p>
  <br>
  <hr>
    <button id="show_tambah" type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-plus"></span> Tambah Tugas?
  </button>
  <br><br>
<div id="dihidden" style="display: none;">
    <h2><i class="fa fa-plus-square"></i>MENAMBAH TUGAS TAMBAHAN</h2>   
    <h4 id="id-bidang">Pilih Bidang dibawah ini</h4>
    <div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">PILIH BIDANG
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li class="dropdown-submenu">
        <a class="test" tabindex="-1">MANAJEMEN<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a class="bidang_t" href="#" data-id="11" data-bidang="MANAJEMEN/KEPALA STASIUN">KEPALA STASIUN</a></li>
          <li><a class="bidang_t" href="#" data-id="12" data-bidang="MANAJEMEN/KEPALA BAGIAN UMUM">KEPALA BAGIAN UMUM</a></li>
          <li><a class="bidang_t" href="#" data-id="13" data-bidang="MANAJEMEN/KEPALA BIDANG BERITA">KEPALA BIDANG BERITA</a></li>
          <li><a class="bidang_t" href="#" data-id="14" data-bidang="MANAJEMEN/KEPALA BIDANG KEUANGAN">KEPALA BIDANG KEUANGAN</a></li>
          <li><a class="bidang_t" href="#" data-id="15" data-bidang="MANAJEMEN/KEPALA BIDANG TEKNIK">KEPALA BIDANG TEKNIK</a></li>
        </ul>
      </li>
      <li class="dropdown-submenu">
        <a class="test" tabindex="-1" href="#">UMUM<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="dropdown-submenu">
            <a class="test" href="#">SDM<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="bidang_t" href="#" data-id="211" data-bidang="UMUM/SDM/KEPALA SUB BAGIAN SDM">KEPALA SUB BAGIAN SDM</a></li>
              <li><a class="bidang_t" href="#" data-id="212" data-bidang="UMUM/SDM/SEKRETARIS KEPALA STASIUN">SEKRETARIAS KEPALA STASIUN</a></li>
              <li><a class="bidang_t" href="#" data-id="213" data-bidang="UMUM/SDM/STAF">STAF</a></li>
              <li><a class="bidang_t" href="#" data-id="214" data-bidang="UMUM/SDM/PENGADMINISTRASIAN UMUM">PENGADMINISTRASIAN UMUM</a></li>
              <li><a class="bidang_t" href="#" data-id="215" data-bidang="UMUM/SDM/HUMAS DAN PROTOKOL">HUMAS DAN PROTOKOL</a></li>
              <li><a class="bidang_t" href="#" data-id="216" data-bidang="UMUM/SDM/KESEJAHTERAAN/RUMAH TANGGA">KESEJAHTERAAN/RUMAH TANGGA</a></li>
            </ul>
          </li>
          <li class="dropdown-submenu">
            <a class="test" href="#">PERLENGKAPAN<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="bidang_t" href="#" data-id="221" data-bidang="UMUM/PERLENGKAPAN/KEPALA SUB BAGIAN PERLENGKAPAN">KEPALA SUB BAGIAN PERLENGKAPAN</a></li>
              <li><a class="bidang_t" href="#" data-id="222" data-bidang="UMUM/PERLENGKAPAN/PENGADMINISTRASI">PENGADMINISTRASI</a></li>
              <li><a class="bidang_t" href="#" data-id="223" data-bidang="UMUM/PERLENGKAPAN/PENGELOLA PENATAUSAHAAN BARANG MILIK NEGARA">PENGELOLA PENATAUSAHAAN BARANG MILIK NEGARA</a></li>
              <li><a class="bidang_t" href="#" data-id="224" data-bidang="UMUM/PERLENGKAPAN/KOORDINATOR KEBERSIHAN">KOORDINATOR KEBERSIHAN</a></li>
              <li><a class="bidang_t" href="#" data-id="225" data-bidang="UMUM/PERLENGKAPAN/KOORDINATOR KENDARAAN DINAS">KOORDINATOR KENDARAAN DINAS</a></li>
              <li><a class="bidang_t" href="#" data-id="226" data-bidang="UMUM/PERLENGKAPAN/PENGEMUDI">PENGEMUDI</a></li>
              <li><a class="bidang_t" href="#" data-id="227" data-bidang="UMUM/PERLENGKAPAN/PETUGAS KEBERSIHAN">PETUGAS KEBERSIHAN</a></li>
              <li><a class="bidang_t" href="#" data-id="228" data-bidang="UMUM/PERLENGKAPAN/KOORDINATOR PENGAMANAN DALAM">KOORDINATOR PENGAMANAN DALAM</a></li>
              <li><a class="bidang_t" href="#" data-id="229" data-bidang="UMUM/PERLENGKAPAN/PETUGAS SATPAM">PETUGAS SATPAM</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="dropdown-submenu">
        <a class="test" tabindex="-1" href="#">BERITA<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="dropdown-submenu">
            <a class="test" href="#">BERITA<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="bidang_t" href="#" data-id="311" data-bidang="BERITA/BERITA/KEPALA SEKSI PRODUKSI BERITA">KEPALA SEKSI PRODUKSI BERITA</a></li>
              <li><a class="bidang_t" href="#" data-id="312" data-bidang="BERITA/BERITA/PRODUSER LIVE CROSS">PRODUSER LIVE CROSS</a></li>
              <li><a class="bidang_t" href="#" data-id="313" data-bidang="BERITA/BERITA/PENGARAH ACARA">PENGARAH ACARA</a></li>
              <li><a class="bidang_t" href="#" data-id="314" data-bidang="BERITA/BERITA/EDITOR NLE">EDITOR NLE</a></li>
              <li><a class="bidang_t" href="#" data-id="315" data-bidang="BERITA/BERITA/REPORTER">REPORTER</a></li>
              <li><a class="bidang_t" href="#" data-id="316" data-bidang="BERITA/BERITA/REDAKTUR">REDAKTUR</a></li>
              <li><a class="bidang_t" href="#" data-id="317" data-bidang="BERITA/BERITA/KAMERAWAN">KAMERAWAN</a></li>
              <li><a class="bidang_t" href="#" data-id="318" data-bidang="BERITA/BERITA/PETUGAS KEPUSTAKAAN">PETUGAS KEPUSTAKAAN</a></li>
              <li><a class="bidang_t" href="#" data-id="319" data-bidang="BERITA/BERITA/PENGADMINISTRASI">PENGADMINISTRASI</a></li>
              <li><a class="bidang_t" href="#" data-id="3101" data-bidang="BERITA/BERITA/KEPALA SEKSI CURRENT AFFAIR DAN SIARAN OLAH RAGA">KEPALA SEKSI CURRENT AFFAIR DAN SIARAN OLAH RAGA</a></li>
              <li><a class="bidang_t" href="#" data-id="3102" data-bidang="BERITA/BERITA/PRODUSER">PRODUSER</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="dropdown-submenu">
        <a class="test" tabindex="-1" href="#">TEKNIK<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="dropdown-submenu">
            <a class="test" href="#">SEKSI TEKNIK PRODUKSI DAN PENYIARAN<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="bidang_t" href="#" data-id="411" data-bidang="TEKNIK/SEKSI TEKNIK PRODUKSI DAN PENYIARAN/KEPALA SEKSI TEKNIK PRODUKSI DAN PENYIARAN">KEPALA SEKSI TEKNIK PRODUKSI DAN PENYIARAN</a></li>
              <li><a class="bidang_t" href="#" data-id="412" data-bidang="TEKNIK/SEKSI TEKNIK PRODUKSI DAN PENYIARAN/PENATA SUARA">PENATA SUARA</a></li>
              <li><a class="bidang_t" href="#" data-id="413" data-bidang="TEKNIK/SEKSI TEKNIK PRODUKSI DAN PENYIARAN/EDITOR">EDITOR</a></li>
              <li><a class="bidang_t" href="#" data-id="414" data-bidang="TEKNIK/SEKSI TEKNIK PRODUKSI DAN PENYIARAN/PEMANDU GAMBAR">PEMANDU GAMBAR</a></li>
              <li><a class="bidang_t" href="#" data-id="415" data-bidang="TEKNIK/SEKSI TEKNIK PRODUKSI DAN PENYIARAN/PENATA CAHAYA">PENATA CAHAYA</a></li>
              <li><a class="bidang_t" href="#" data-id="416" data-bidang="TEKNIK/SEKSI TEKNIK PRODUKSI DAN PENYIARAN/KAMERAWAN">KAMERAWAN</a></li>
              <li><a class="bidang_t" href="#" data-id="417" data-bidang="TEKNIK/SEKSI TEKNIK PRODUKSI DAN PENYIARAN/MAINTENANCE AUDIO, VIDEO, DAN IT SISTEM">MAINTENANCE VIDEO, AUDIO, DAN IT SISTEM</a></li>
            </ul>
          </li>
          <li class="dropdown-submenu">
            <a class="test" href="#">SEKSI TRANSMISI<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="bidang_t" href="#" data-id="421" data-bidang="TEKNIK/SEKSI TRANSMISI/KEPALA SEKSI TRANSMISI">KEPALA SEKSI TRANSMISI</a></li>
              <li><a class="bidang_t" href="#" data-id="422" data-bidang="TEKNIK/SEKSI TRANSMISI/TEKNISI PEMANCAR">TEKNISI PEMANCAR</a></li>
              <li><a class="bidang_t" href="#" data-id="423" data-bidang="TEKNIK/SEKSI TRANSMISI/TEKNISI MICROWAVE">TEKNISI MICROWAVE</a></li>
            </ul>
          </li>
          <li class="dropdown-submenu">
            <a class="test" href="#">SEKSI FASILITASI TRANSMISI<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="bidang_t" href="#" data-id="431" data-bidang="TEKNIK/SEKSI FASILITASI TRANSMISI/KEPALA SEKSI TRANSMISI">KEPALA SEKSI FASILITASI TRANSMISI</a></li>
              <li><a class="bidang_t" href="#" data-id="432" data-bidang="TEKNIK/SEKSI FASILITASI TRANSMISI/OPERATOR LISTRIK GENSET DAN UPS">OPERATOR LISTRIK GENSET DAN UPS</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="dropdown-submenu">
        <a class="test" tabindex="-1" href="#">KEUANGAN<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="dropdown-submenu">
            <a class="test" href="#">PERBENDAHARAAN<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="bidang_t" href="#" data-id="511" data-bidang="KEUANGAN/PEREBENDAHARAAN/KEPALA SUB BAGIAN PERBEDAHARAAN">KEPALA SUB BAGIAN PERBENDAHARAAN</a></li>
              <li><a class="bidang_t" href="#" data-id="512" data-bidang="KEUANGAN/PEREBENDAHARAAN/BENDAHARA PENGELUARAN">BENDAHARA PENGELUARAN</a></li>
              <li><a class="bidang_t" href="#" data-id="513" data-bidang="KEUANGAN/PEREBENDAHARAAN/BENDAHARA PENERIMAAN">BENDAHARA PENERIMAAN</a></li>
              <li><a class="bidang_t" href="#" data-id="514" data-bidang="KEUANGAN/PEREBENDAHARAAN/PELAKSANA ADMINISTRASI KEUANGAN">PELAKSANA ADMINISTRASI KEUANGAN</a></li>
              <li><a class="bidang_t" href="#" data-id="515" data-bidang="KEUANGAN/PEREBENDAHARAAN/PENYUSUN LAPORAN KEUANGAN">PENYUSUN LAPORAN KEUANGAN</a></li>
              <li><a class="bidang_t" href="#" data-id="516" data-bidang="KEUANGAN/PEREBENDAHARAAN/PENGELOLA ADMINISTRASI BELANJA PEGAWAI">PENGELOLA ADMINISTRASI BELANJA PEGAWAI</a></li>
            </ul>
          </li>
          <li class="dropdown-submenu">
            <a class="test" href="#">AKUNTANSI<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="bidang_t" href="#" data-id="521" data-bidang="KEUANGAN/AKUNTANSI/KEPALA SUB BAGIAN AKUNTANSI">KEPALA SUB BAGIAN AKUNTANSI</a></li>
              <li><a class="bidang_t" href="#" data-id="522" data-bidang="KEUANGAN/AKUNTANSI/PETUGAS VERIFIKASI">PETUGAS VERIFIKASI</a></li>
              <li><a class="bidang_t" href="#" data-id="523" data-bidang="KEUANGAN/AKUNTANSI/UNIT MANAGER">UNIT MANAGER</a></li>
              <li><a class="bidang_t" href="#" data-id="524" data-bidang="KEUANGAN/AKUNTANSI/PETUGAS ARSIP">PETUGAS ARSIP</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="dropdown-submenu">
        <a class="test" tabindex="-1" href="#">PROGRAM<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="dropdown-submenu">
            <a class="test" href="#">PROGRAM<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="bidang_t" href="#" data-id="611" data-bidang="PROGRAM/PROGRAM/KEPALA SEKSI PROGRAM">KEPALA SEKSI PROGRAM</a></li>
              <li><a class="bidang_t" href="#" data-id="612" data-bidang="PROGRAM/PROGRAM/PRODUSER">PRODUSER</a></li>
              <li><a class="bidang_t" href="#" data-id="613" data-bidang="PROGRAM/PROGRAM/PENGARAH ACARA">PENGARAH ACARA</a></li>
              <li><a class="bidang_t" href="#" data-id="614" data-bidang="PROGRAM/PROGRAM/PENGARAH SIARAN">PENGARAH SIARAN</a></li>
              <li><a class="bidang_t" href="#" data-id="615" data-bidang="PROGRAM/PROGRAM/PENATA ARTISTIK">PENATA ARTISTIK</a></li>
              <li><a class="bidang_t" href="#" data-id="616" data-bidang="PROGRAM/PROGRAM/PELAKSANA DEKORASI">PELAKSANA DEKORASI</a></li>
              <li><a class="bidang_t" href="#" data-id="617" data-bidang="PROGRAM/PROGRAM/PENATA RIAS">PENATA RIAS</a></li>
            </ul>
          </li>
          <li class="dropdown-submenu">
            <a class="test" href="#">PENGEMBANGAN USAHA<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a class="bidang_t" href="#" data-id="621" data-bidang="PROGRAM/PENGEMBANGAN USAHA/KEPALA SEKSI PENGEMBANGAN USAHA">KEPALA SEKSI PENGEMBANGAN USAHA</a></li>
              <li><a class="bidang_t" href="#" data-id="622" data-bidang="PROGRAM/PENGEMBANGAN USAHA/PENYUSUN RUNDOWN IKLAN">PENYUSUN RUNDOWN IKLAN</a></li>
              <li><a class="bidang_t" href="#" data-id="623" data-bidang="PROGRAM/PENGEMBANGAN USAHA/DOKUMENTASI ACARA KERJASAMA">DOKUMENTASI ACARA KERJASAMA</a></li>
              <li><a class="bidang_t" href="#" data-id="624" data-bidang="PROGRAM/PENGEMBANGAN USAHA/PENYIAP BUKTI SIAR">PENYIAP BUKTI SIAR</a></li>
              <li><a class="bidang_t" href="#" data-id="625" data-bidang="PROGRAM/PENGEMBANGAN USAHA/ACCOUNT EXECUTIVE">ACCOUNT EXECUTIVE</a></li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </div>
<p><p><p>
  <div id="show_jobdesc_t" style="display: none;">
        <form method="POST" action="<?php echo base_url()."index.php/MainController/doSasaranTambahan/"; ?>">
      
      <table>
      <tr>
      <td width="90%">
          <?php

          $j=0;
          foreach ($data_jt as $key3) {
            $tes[$j]=$key3['id_job'];
            $j++;
          }
          

          $i=0;

          foreach ($data_jt as $key4) {
            if ($key4['id_job'] == 1) { ?>
            <div class="job_t" id="<?= $key4['id_bidang']; ?>_t">
            <input type="checkbox" name="jobdesc_tambahan[]" value="<?= $key4['jobdesc']; ?>"><?= $key4['jobdesc']; ?><br>
            
            <?php }elseif((empty($tes[$i+1])) || ($tes[$i+1]=="1")) { ?>
            
            <input type="checkbox" name="jobdesc_tambahan[]" value="<?= $key4['jobdesc']; ?>"><?= $key4['jobdesc']; ?><br>
            
             </div>
           <?php }else{?> 
          
            <input type="checkbox" name="jobdesc_tambahan[]" value="<?= $key4['jobdesc']; ?>"><?= $key4['jobdesc']; ?><br>
            
          <?php } $i++; } ?>
      
        <input type="text" name="jobdesc_tambahan[]" style="width: 50%;">
       </td>
       <td></td>
       </tr>
        </table>
       <br><br><br><hr>
       <input type="submit" name="lanjut" value="LANJUT" style="float: center;width: 10%;height: 25%;">
       </form>

    
  </div>
  
  <br><br>
  </div>
</div>
  

  <!-- End page content -->
</div>
   


<script>
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });

  $("#show_tambah").click(function(){
    $("#dihidden").toggle();
  });

  $("a.bidang_t").click(function(){
    var id = $(this).data('id');
    var bidang = $(this).data('bidang'); 
    $("#show_jobdesc_t").show(); 
    $(".job_t").hide();
    $("#"+id+"_t").show(); 
    document.getElementById("id-bidang").innerHTML = bidang;
  });
});

function testing() {
  var x = document.getElementById("dihidden");
  if (x.style.display == "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  }
</script>

</body>
</html>




