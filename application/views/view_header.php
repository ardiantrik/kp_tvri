<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
<button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
    <span class="w3-bar-item w3-right"><img src="http://tvrijogja.com/utama/images/logo.png" width="100"></span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s8 w3-bar">
      <span>Selamat Datang, <strong><?= $_SESSION['nama']; ?></strong></span><br>
      <a href="<?php echo base_url()."index.php/MainController/doLogout/"; ?>">Log Out</a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>MENU</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#pageSubmenuCatatan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle w3-bar-item w3-button w3-padding" style="font-weight:500;"><i class="fa fa-list-alt"></i>  Catatan Harian</a>
    <ul class="collapse list-unstyled" id="pageSubmenuCatatan">
        <li>
            <a href="<?php echo base_url()."index.php/MainController/viewListJobdesc/"; ?>" class="w3-bar-item w3-button w3-padding"><i class="fa fa-angle-double-right"></i> Lihat Catatan Harian</a>
        </li>
        <li>
            <a href="<?php echo base_url()."index.php/MainController/viewLihatJobdesc/"; ?>" class="w3-bar-item w3-button w3-padding"><i class="fa fa-angle-double-right"></i> Input Catatan Harian</a>
        </li>
    </ul>
    <a href="#pageSubmenuSasaran" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle w3-bar-item w3-button w3-padding" style="font-weight:500;"><i class="fa fa-clipboard"></i>  Sasaran Jobdesc</a>
    <ul class="collapse list-unstyled" id="pageSubmenuSasaran">
        <li>
            <a href="<?php echo base_url()."index.php/MainController/viewSasaranKerja/"; ?>" class="w3-bar-item w3-button w3-padding"><i class="fa fa-angle-double-right"></i> Lihat Sasaran Jobdesc</a>
        </li>
        <li>
            <a href="<?php echo base_url()."index.php/MainController/viewPilihJobdesc/"; ?>" class="w3-bar-item w3-button w3-padding"><i class="fa fa-angle-double-right"></i> Input Sasaran Jobdesc</a>
        </li>
    </ul>
    <a href="#pageSubmenuRekap" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle w3-bar-item w3-button w3-padding" style="font-weight:500;"><i class="fa fa-file-archive-o"></i>  Rekap</a>
    <ul class="collapse list-unstyled" id="pageSubmenuRekap">
        <li>
            <a href="<?php echo base_url()."index.php/MainController/viewRekapBulan/"; ?>" class="w3-bar-item w3-button w3-padding"><i class="fa fa-angle-double-right"></i>  Rekap Bulanan #UNDER CONSTRUCTION</a>
        </li>
        <li>
            <a href="<?php echo base_url()."index.php/MainController/viewRekapTahun/"; ?>" class="w3-bar-item w3-button w3-padding" ><i class="fa fa-angle-double-right"></i> Rekap Tahunan</a>
        </li>
    </ul>
    <a href="<?php echo base_url()."index.php/MainController/viewHint/"; ?>" class="w3-bar-item w3-button w3-padding" style="font-weight:500;"><i class="fas fa-question-circle"></i> Bantuan</a>
  </div>
</nav>

<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>