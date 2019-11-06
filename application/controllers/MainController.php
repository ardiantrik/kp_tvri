<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainController extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('MainModel');
        $this->load->library('session');
    }

    public function doLogin()
	{
		$nip = $_POST['nip'];
		$pass = $_POST['password'];

		$where = array(
			'nip' => $nip,
			'password' => $pass
		);

		if ($login = $this->MainModel->selectSpecify('user_pegawai',$where)) {
            foreach ($login as $login) {
                $_SESSION['id_karyawan'] = $login['id_pegawai'];
                $_SESSION['nama'] = $login['nama'];
                $_SESSION['nip'] = $login['nip'];
                $_SESSION['jabatan'] = $login['jabatan'];
                $_SESSION['pangkat'] = $login['pangkat'];
                $_SESSION['status'] = "login";
                $this->viewListJobdesc();
            }
		}else{
			echo "<script> alert('Login Gagal! Periksa NIP atau Password anda');history.go(-1); </script>";
		}
    }
    
    function doLogout() {
        $this->session->sess_destroy();
        redirect(base_url()."index.php/MainController/");
    }

    public function sessionCheck()
    {
        if(!isset($_SESSION['id_karyawan'])){
            echo "<script> alert('Mohon Login Terlebih Dahulu');
            window.location.href='".base_url()."index.php/MainController/"."' </script>";
        }

    }

    public function index()
    {
		$this->load->view('view_login_karyawan');
    }

    public function viewHint()
    {
		$this->load->view('view_hint');
    }

    public function viewLihatJobdesc()
    {
        $this->sessionCheck();
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];

        date_default_timezone_set("Asia/Jakarta");
        $tahun = date('Y', time());

        $data = $this->MainModel->selectAllData('all_jobdesc');

        $data_u = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
            'nama' => $nama,
            'id_karyawan' => $id_karyawan,
            'tahun' => $tahun,
            'tipe_jobdesc' => 'utama'
        ));

        $data_t = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
            'nama' => $nama,
            'id_karyawan' => $id_karyawan,
            'tahun' => $tahun,
            'tipe_jobdesc' => 'tambahan'
        ));

        $this->load->view("view_lihat_jobdesc",array(
            'data_u' => $data_u,
            'data_t' => $data_t,
            'data_jt' => $data
        ));
    }

    public function viewSasaranKerja()
    {
        $this->sessionCheck();
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];
        date_default_timezone_set("Asia/Jakarta");
        $tahun = date('Y', time());
       
        $data_kepala = $this->MainModel->queryGetHelper(
            "SELECT * FROM user_pegawai WHERE jabatan LIKE '%Kepala%'"
        );

        $data_u = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
            'nama' => $nama,
            'id_karyawan' => $id_karyawan,
            'tahun' => $tahun,
            'tipe_jobdesc' => 'utama'
        ));

        

        $data_t = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
            'nama' => $nama,
            'id_karyawan' => $id_karyawan,
            'tahun' => $tahun,
            'tipe_jobdesc' => 'tambahan'
        ));
        if (empty($data_u)) {
            
            $status=0;
        } else {
            
            $status=1;
        }

        $this->load->view("view_listsasaran",array(
            'data_u' => $data_u,
            'data_t' => $data_t,
            'tahun' => $tahun,
            'status' => $status,
            'data_kepala' => $data_kepala
        ));
    }

    public function viewPilihJobdesc()
    {
        $this->sessionCheck();
        $data = $this->MainModel->selectAllData('all_jobdesc');
        $this->load->view("view_pilih_jobdesc",array(
            'data' => $data
        ));
    }

    public function viewListJobdesc()
    {
        $this->sessionCheck();
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];
        date_default_timezone_set("Asia/Jakarta");
        $tahun = date('Y', time());
        // $data = $this->MainModel->selectspecify('catatanharian_hari',array(
        //     'id_karyawan' => $id_karyawan
        // ));
        $sql = "SELECT * FROM catatanharian_hari WHERE id_karyawan = '$id_karyawan' AND (tahun = '$tahun' OR tahun = '$tahun-1')";
        $data = $this->MainModel->queryGetHelper($sql);
        $this->load->view("view_list_jobdesc",array(
            'data' => $data
        ));
    }

    public function viewListHarian($tanggal)
    {
        $this->sessionCheck();
        $nama = $_SESSION['nama'];
        $id_karyawan = $_SESSION['id_karyawan'];
        $tgl = explode("-",$tanggal);
        $data = $this->MainModel->selectSpecify('catatanharian_test',array(
            'nama' => $nama,
            'id_karyawan' => $id_karyawan,
            'tanggal' => $tgl[0],
            'bulan' => $tgl[1],
            'tahun' => $tgl[2]
        ));

        $this->load->view("view_list_perhari",array(
            'data' => $data
        ));
    }

    public function viewHasilCatatan()
    {
        $this->sessionCheck();
        $tanggal=$_POST['tanggal'];
        $nosurat = $_POST['nosurat'];
        $namaka = $_POST['namaka'];
        $catatan = $_POST['catatan'];
        $jobdesc = $_POST['jobdesc'];
        $lamp = $_FILES['lampiran']['tmp_name'];


        $count_jobdesc = count($jobdesc);
        
             if(empty($tanggal) or empty($nosurat) or empty($namaka) or empty($catatan)){
                echo"<script>window.alert('Maaf, kembali cek form kembali');</script>";
             }else{

                $error = 0;

                //VALIDASI INPUTAN
                for ($i=0; $i < $count_jobdesc && $error!=1 ; $i++) { 
                    if (empty($tanggal[$i]) or empty($nosurat[$i]) or empty($namaka[$i]) or empty($catatan[$i])) {
                            $error = 1 ;
                        }else{
                            $error = 0;
                        }
                }

                if ($error==0) {
                    $this->load->view("view_hasilcatatanharian",array(
                        'tanggal' => $tanggal,
                        'nosurat' => $nosurat,
                        'namaka' => $namaka,
                        'catatan' => $catatan,
                        'lampiran' => $lamp,
                        'jobdesc' => $jobdesc,
                        'count_jobdesc' => $count_jobdesc
                    ));
                }else{
                    echo"<script>window.alert('Maaf, terjadi kesalahan! Harap kembali cek form kembali');history.go(-1)</script>";
                }    
             }
        
    }

    public function viewRekapBulan()
    {
        $this->sessionCheck();
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];

        date_default_timezone_set("Asia/Jakarta");
        $tahun = date('Y', time());
        $bulan = date('M', time());

        $data_sasaran = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
            'id_karyawan' => $id_karyawan,
            'tahun' => $tahun
        ));

        if (!empty($data_sasaran)) {
            $i=0;
            foreach ($data_sasaran as $sasaran) {
                $id1[$i] = $sasaran['id_jdsasaran'];
                $jobdesc[$i] = $sasaran['jobdesc'];
                $target[$i] = $sasaran['sasaran'];
                $tipe[$i] = $sasaran['tipe_jobdesc'];
                $i++;
            }

            $data_catatan = $this->MainModel->selectSpecify('catatanharian_test',array(
                'id_karyawan' => $id_karyawan,
                'tahun' => $tahun,
                'bulan' => $bulan
            ));
            if (!empty($data_catatan)) {
                $i=0;
            foreach ($data_catatan as $catatan) {
               $id2[$i] = $catatan['id_jdsasaran'];
               $i++;
            }
            // echo "TUGAS UTAMA<br>";
            for ($i=0; $i < count($id1) ; $i++) { 
                if ($tipe[$i]=='utama') {
                    $done[$i]=0;
                    for ($j=0; $j < count($id2); $j++) { 
                        if ($id2[$j]==$id1[$i]) {
                            $done[$i] = $done[$i] + 1;
                        }else{
    
                        }
                    }
                    $data_rekap_u[] = array(
                        'jobdesc_u' => $jobdesc[$i],
                        'target_u' => $target[$i],
                        'dikerjakan_u' => $done[$i]
                    );
                    // echo $jobdesc[$i]."--->".$target[$i]."--->".$done[$i];
                    // echo "<br>";
                }
            
            }
    
            //var_dump($data_rekap_u);
            
    
            // echo "<br><br>TUGAS TAMBAHAN<br>";
            for ($i=0; $i < count($id1) ; $i++) { 
                if ($tipe[$i]=='tambahan') {
                    $done[$i]=0;
                    for ($j=0; $j < count($id2); $j++) { 
                        if ($id2[$j]==$id1[$i]) {
                            $done[$i] = $done[$i] + 1;
                        }else{
    
                        }
                    }
                    $data_rekap_t[] = array(
                        'jobdesc_t' => $jobdesc[$i],
                        'target_t' => $target[$i],
                        'dikerjakan_t' => $done[$i]
                    );
                    // echo $jobdesc[$i]."--->".$target[$i]."--->".$done[$i];
                    // echo "<br>";
                }
            
            }
            
    
            array_multisort(array_column($data_rekap_t, 'dikerjakan_t'), SORT_DESC, $data_rekap_t);
            //var_dump($data_rekap_t);
            
            $this->load->view("view_rekapbulan",array(
                'data_u' => $data_rekap_u,
                'data_t' => $data_rekap_t,
                'tahun' => $tahun,
                'bulan' => $bulan
                
            )); 
            }else{
                for ($i=0; $i < count($id1) ; $i++) { 
                    if ($tipe[$i]=='utama') {
                        $data_rekap_u[] = array(
                            'jobdesc_u' => $jobdesc[$i],
                            'target_u' => $target[$i],
                            'dikerjakan_u' => 0
                        );
                    }else{
                        $data_rekap_t[] = array(
                            'jobdesc_t' => $jobdesc[$i],
                            'target_t' => $target[$i],
                            'dikerjakan_t' => 0
                        );
                    }
                }
                
                $this->load->view("view_rekapbulan",array(
                    'data_u' => $data_rekap_u,
                    'data_t' => $data_rekap_t,
                    'tahun' => $tahun,
                    'bulan' => $bulan
                    
                ));
                
            }
            
        }else{

            $data_u = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
                'nama' => $nama,
                'id_karyawan' => $id_karyawan,
                'tahun' => $tahun,
                'tipe_jobdesc' => 'utama'
            ));
    
            $data_t = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
                'nama' => $nama,
                'id_karyawan' => $id_karyawan,
                'tahun' => $tahun,
                'tipe_jobdesc' => 'tambahan'
            ));
            
            $this->load->view("view_rekapbulan",array(
                'data_u' => $data_u,
                'data_t' => $data_t,
                'tahun' => $tahun,
                'bulan' => $bulan  
            )); 
        }
        

    }

    public function viewRekapTahun()
    {
        $this->sessionCheck();
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];

        date_default_timezone_set("Asia/Jakarta");
        $tahun = date('Y', time());
        $bulan = date('M', time());

        $data_sasaran = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
            'id_karyawan' => $id_karyawan,
            'tahun' => $tahun
        ));

        if (!empty($data_sasaran)) {
            $i=0;
            foreach ($data_sasaran as $sasaran) {
                $id1[$i] = $sasaran['id_jdsasaran'];
                $jobdesc[$i] = $sasaran['jobdesc'];
                $target[$i] = $sasaran['sasaran'];
                $tipe[$i] = $sasaran['tipe_jobdesc'];
                $i++;
            }

            $data_catatan = $this->MainModel->selectSpecify('catatanharian_test',array(
                'id_karyawan' => $id_karyawan,
                'tahun' => $tahun
            ));
            if(!empty($data_catatan)){
                $i=0;
                foreach ($data_catatan as $catatan) {
                $id2[$i] = $catatan['id_jdsasaran'];
                $i++;
                }
                // echo "TUGAS UTAMA<br>";
                for ($i=0; $i < count($id1) ; $i++) { 
                    if ($tipe[$i]=='utama') {
                        $done[$i]=0;
                        for ($j=0; $j < count($id2); $j++) { 
                            if ($id2[$j]==$id1[$i]) {
                                $done[$i] = $done[$i] + 1;
                            }else{

                            }
                        }
                        $data_rekap_u[] = array(
                            'jobdesc_u' => $jobdesc[$i],
                            'target_u' => $target[$i],
                            'dikerjakan_u' => $done[$i]
                        );
                        // echo $jobdesc[$i]."--->".$target[$i]."--->".$done[$i];
                        // echo "<br>";
                    }
                
                }

                //var_dump($data_rekap_u);
                

                // echo "<br><br>TUGAS TAMBAHAN<br>";
                for ($i=0; $i < count($id1) ; $i++) { 
                    if ($tipe[$i]=='tambahan') {
                        $done[$i]=0;
                        for ($j=0; $j < count($id2); $j++) { 
                            if ($id2[$j]==$id1[$i]) {
                                $done[$i] = $done[$i] + 1;
                            }else{

                            }
                        }
                        $data_rekap_t[] = array(
                            'jobdesc_t' => $jobdesc[$i],
                            'target_t' => $target[$i],
                            'dikerjakan_t' => $done[$i]
                        );
                        // echo $jobdesc[$i]."--->".$target[$i]."--->".$done[$i];
                        // echo "<br>";
                    }else{
                        $data_rekap_t = array();
                    }
                
                }
                
                if (empty($data_rekap_t)) {
                    # code...
                } else {
                    array_multisort(array_column($data_rekap_t, 'dikerjakan_t'), SORT_DESC, $data_rekap_t);
                }
                //var_dump($data_rekap_t);

                $data_kepala = $this->MainModel->queryGetHelper(
                    "SELECT * FROM user_pegawai WHERE jabatan LIKE '%Kepala%'"
                );
                
                $this->load->view("view_rekaptahun",array(
                    'data_u' => $data_rekap_u,
                    'data_t' => $data_rekap_t,
                    'data_kepala' => $data_kepala,
                    'tahun' => $tahun,
                    'status' => 1
                ));

            }else{
                for ($i=0; $i < count($id1) ; $i++) { 
                    if ($tipe[$i]=='utama') {
                        $data_rekap_u[] = array(
                            'jobdesc_u' => $jobdesc[$i],
                            'target_u' => $target[$i],
                            'dikerjakan_u' => 0
                        );
                    }else{
                        $data_rekap_t[] = array(
                            'jobdesc_t' => $jobdesc[$i],
                            'target_t' => $target[$i],
                            'dikerjakan_t' => 0
                        );
                    }
                }

                $data_kepala = $this->MainModel->queryGetHelper(
                    "SELECT * FROM user_pegawai WHERE jabatan LIKE '%Kepala%'"
                );
                
                $this->load->view("view_rekaptahun",array(
                    'data_u' => $data_rekap_u,
                    'data_t' => $data_rekap_t,
                    'data_kepala' => $data_kepala,
                    'tahun' => $tahun,
                    'status' => 0
                ));

            }
        }else{
            $data_u = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
                'nama' => $nama,
                'id_karyawan' => $id_karyawan,
                'tahun' => $tahun,
                'tipe_jobdesc' => 'utama'
            ));
    
            $data_t = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
                'nama' => $nama,
                'id_karyawan' => $id_karyawan,
                'tahun' => $tahun,
                'tipe_jobdesc' => 'tambahan'
            ));

            $data_kepala = $this->MainModel->queryGetHelper(
                "SELECT * FROM user_pegawai WHERE jabatan LIKE '%Kepala%'"
            );
            
            $this->load->view("view_rekaptahun",array(
                'data_u' => $data_u,
                'data_t' => $data_t,
                'data_kepala' => $data_kepala,
                'tahun' => $tahun,
                'status' => 0
            ));

        }
        

    }

    public function doRekapSasaran()
    {
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];

        date_default_timezone_set("Asia/Jakarta");
        $tahun = date('Y', time());

        $data_karyawan = $this->MainModel->selectSpecify('user_pegawai',array(
            'nama' => $nama,
            'id_pegawai' => $id_karyawan
        ));

        foreach ($data_karyawan as $data) {
            $data_k[]=array(
                'nama' => $data['nama'],
                'jabatan' => $data['jabatan'],
                'nip' => $data['nip']
            );
        }

        $data_utama = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
            'nama' => $nama,
            'id_karyawan' => $id_karyawan,
            'tahun' => $tahun,
            'tipe_jobdesc' => 'utama'
        ));

        foreach ($data_utama as $data) {
            $data_u[]=array(
                'jobdesc' => $data['jobdesc'],
                'target' => $data['sasaran']
            );
        }

        $data_tambahan = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
            'nama' => $nama,
            'id_karyawan' => $id_karyawan,
            'tahun' => $tahun,
            'tipe_jobdesc' => 'tambahan'
        ));

        foreach ($data_tambahan as $data) {
            $data_t[]=array(
                'jobdesc' => $data['jobdesc'],
                'target' => $data['sasaran']
            );
        }

        // $this->load->view("view_listsasaran",array(
        //     'data_u' => $data_u,
        //     'data_t' => $data_t,
        //     'data_k' => $data_karyawan
        // ));

        $this->ControllerRekap->doCetakSasaran($data_u, $data_t, $data_k);

    }

    public function doCatatanHarian()
    {
        if (empty($_POST['jobdesc'])) {
            echo"<script>window.alert('Maaf, terjadi kesalahan! Harap cek form kembali');history.go(-1);</script>";
        }else {
            $jobdesc = $_POST['jobdesc'];
            $count_jobdesc = count($jobdesc);

            $this->load->view("view_catatanharian",array(
                'jobdesc' => $jobdesc,
                'count_jobdesc' => $count_jobdesc
            ));
        }
        
    }

    public function doEditCatatan($value)
    {

        $data = $this->MainModel->selectSpecify('catatanharian_test',array(
            'id_catatanharian' => $value
        ));
        foreach ($data as $data) {
            $tanggal = $data['tanggal']."-".$data['bulan']."-".$data['tahun'];
        }
        
        $this->load->view("view_editcatatan",array(
            'data' => $data,
            'id_catatanharian' => $value,
            'tanggal' => $tanggal
        ));
    }

    public function doSasaran()
    {
        $jobdesc_u = $_POST['jobdesc_utama'];
        $jobdesc_t = $_POST['jobdesc_tambahan'];
        $count_jobdesc_u = count($jobdesc_u);
        if ($jobdesc_u[$count_jobdesc_u-1]=='') {
            $count_jobdesc_u--;
        }

        if (empty($jobdesc_t)) {
            $this->load->view("view_sasaran_jobdesc",array(
                'jobdesc_u' => $jobdesc_u,
                'count_jobdesc_u' => $count_jobdesc_u,
                'count_jobdesc_t' => 0

            ));
        }else{
            $count_jobdesc_t = count($jobdesc_t);
            if ($jobdesc_t[$count_jobdesc_t-1]=='') {
                $count_jobdesc_t--;
            }

            $this->load->view("view_sasaran_jobdesc",array(
                'jobdesc_u' => $jobdesc_u,
                'jobdesc_t' => $jobdesc_t,
                'count_jobdesc_u' => $count_jobdesc_u,
                'count_jobdesc_t' => $count_jobdesc_t
            ));

        }
        
        
    }

    public function doSasaranTambahan()
    {
        $jobdesc_t = $_POST['jobdesc_tambahan'];
        $count_jobdesc_t = count($jobdesc_t);
        if ($jobdesc_t[$count_jobdesc_t-1]=='') {
            $count_jobdesc_t--;
        }

        $this->load->view("view_sasaran_tambahan",array(
            'jobdesc_t' => $jobdesc_t,
            'count_jobdesc_t' => $count_jobdesc_t
        ));
        
    }

    public function doCetakCatatan($value)
    {
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];

        // Load plugin fpdf nya
        include APPPATH.'third_party/fpdf/fpdf.php';

        $pdf = new FPDF('p','mm','A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string 
        $pdf->Image('http://tvrijogja.com/utama/images/logo.png',87,10,40);
        $pdf->Ln(20);
        $pdf->Cell(190,7,'TVRI Stasiun D.I.Yogyakarta',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'Catatan Harian Pegawai',0,1,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'Nama: '.$_SESSION['nama'],0,1);
        $pdf->Cell(190,7,'NIP    : '.$_SESSION['nip'],0,1);
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',11);
        $data_catatan = $this->MainModel->selectSpecify('catatanharian_test',array(
            'id_catatanharian' => $value
        ));
        foreach ($data_catatan as $data) {
            $tanggal = $data['tanggal']."-".$data['bulan']."-".$data['tahun'];
            $nosurat = $data['nosurat'];
            $namaka = $data['namakegiatan'];
            $catatan = $data['catatan'];
            $jobdesc = $data['jobdesc'];
            $lampiran = $data['lampiran'];
        }
        $pdf->MultiCell(190,7,$jobdesc,0,'C');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(30,7,'Tanggal',0,0);
        $pdf->Cell(50,7,": ".$tanggal,0,1);
        $pdf->Cell(30,7,'No. Surat',0,0);
        $pdf->Cell(50,7,": ".$nosurat,0,1);
        $pdf->Cell(30,7,'Nama Kegiatan',0,0);
        $pdf->Cell(50,7,": ".$namaka,0,1);
        $pdf->Cell(30,7,'Catatan',0,0);
        $pdf->Cell(100,7,": ",0,1);
        $pdf->MultiCell(190,10,$catatan,0,'L');
        if (empty($lampiran)) {
            $pdf->Cell(30,7,'Lampiran',0,0);
            $pdf->Cell(100,7,": -",0,1);
        } else {
            $pdf->Cell(30,7,'Lampiran',0,0);
            $pdf->Cell(100,7,": Terlampir",0,1);
        }
        $pdf->Ln(40);
        $pdf->SetFont('Arial','B',11);
        $pdf->Cell(190,7,'Pegawai yang bersangkutan,',0,1,'R');
        $pdf->Ln(20);
        $pdf->Cell(190,7,$_SESSION['nama'],0,1,'R');
        $pdf->Cell(190,7,$_SESSION['nip'],0,1,'R');

        if (!empty($lampiran)) {
            $pdf->AddPage();
            $pdf->Cell(190,7,'Lampiran',0,1,'C');
            $pdf->Image("data:image/jpeg;base64,".base64_encode($lampiran),10,20,150,0,'JPEG');
        }

        
        $pdf->Output('','sdasds');
        
        
    }

    public function inputJobdesc()
    {
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];
        $tanggal=$_POST['tanggal'];
        $nosurat = $_POST['nosurat'];
        $namaka = $_POST['namaka'];
        $catatan = $_POST['catatan'];
        $jobdesc = $_POST['jobdesc'];
        $lamp = $_POST['lampiran'];
        
        $count_jobdesc = count($jobdesc);
        
             if(empty($tanggal) or empty($nosurat) or empty($namaka) or empty($catatan)){
                echo"<script>window.alert('Maaf, kembali cek form kembali');history.go(-1);</script>";
             }else{
                $error = 0;

                //VALIDASI INPUTAN
                for ($i=0; $i < $count_jobdesc && $error!=1 ; $i++) { 
                    if (empty($tanggal[$i]) or empty($nosurat[$i]) or empty($namaka[$i]) or empty($catatan[$i])) {
                            $error = 1 ;
                        }else{
                            $error = 0;
                        }
                }

                for ($i=0; $i < $count_jobdesc && $error!=1; $i++) { 

                    $cek_isi = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
                        'jobdesc' => $jobdesc[$i],
                        'id_karyawan' => $id_karyawan
                    ));
                    
                    foreach ($cek_isi as $isi) {
                        $id_jdsasaran = $isi['id_jdsasaran'];
                    }

                    
                    if (empty($lamp[$i])) {
                       
                        $tgl = explode("-", $tanggal[$i]);

                        $data = array(
                            'id_catatanharian' => '',
                            'id_jdsasaran' => $id_jdsasaran,
                            'id_karyawan' => $id_karyawan,
                            'tanggal' => $tgl[0],
                            'bulan' => $tgl[1],
                            'tahun' => $tgl[2],
                            'nosurat' => $nosurat[$i],
                            'namakegiatan' => $namaka[$i],
                            'catatan' => $catatan[$i],
                            'lampiran' => '',
                            'nama' => $nama,
                            'jobdesc' => $jobdesc[$i]   
                        );

                        $res = $this->MainModel->insertData('catatanharian_test',$data);

                        if ($res>=1) {
                            $error = 0 ;
                        }else{
                            $error = 1 ;
                        }

                    }else{
                        
                        $img=base64_decode($lamp[$i]);
                        $tgl = explode("-", $tanggal[$i]);
                        $data = array(
                            'id_catatanharian' => '',
                            'id_jdsasaran' => $id_jdsasaran ,
                            'id_karyawan' => $id_karyawan,
                            'tanggal' => $tgl[0],
                            'bulan' => $tgl[1],
                            'tahun' => $tgl[2],
                            'nosurat' => $nosurat[$i],
                            'namakegiatan' => $namaka[$i],
                            'catatan' => $catatan[$i],
                            'lampiran' => $img,
                            'nama' => $nama,
                            'jobdesc' => $jobdesc[$i],
                            
                        );

                        $res = $this->MainModel->insertData('catatanharian_test',$data);

                        if ($res>=1) {
                            $error = 0 ;
                        }else{
                            $error = 1 ;
                        }
                    }
                    
                }

                for ($i=0; $i <$count_jobdesc && $error!=1  ; $i++) { 

                    $cek_isi = $this->MainModel->selectSpecify('catatanharian_hari',array(
                        'tanggal' => $tanggal[$i],
                        'id_karyawan' => $id_karyawan
                    ));

                        if (count($cek_isi) > 0) {
                            foreach ($cek_isi as $isi) {
                            $kuant = $isi['kuant_harian'];
                            $res = $this->MainModel->updateData('catatanharian_hari',array(
                                'kuant_harian' => $kuant+1
                            ),array(
                                'tanggal' => $tanggal[$i],
                                'id_karyawan' => $id_karyawan
                            ));
                        }
                        } else {
                            
                            $tgl2 = explode("-",$tanggal[$i]);
                            $kuant = 0;
                            $res = $this->MainModel->insertData('catatanharian_hari',array(
                                'tanggal' => $tanggal[$i],
                                'kuant_harian' => $kuant+1,
                                'id_karyawan' => $id_karyawan,
                                'tahun' => $tgl2[2]
                            ));
                        }
                        if ($res>=1) {
                            $error = 0 ;
                        }else{
                            $error = 1 ;
                        }
                    }
                    
                    

                    if ($error==0) {
                        redirect(base_url()."index.php/MainController/viewListJobdesc/");
                    }else{
                        echo"<script>window.alert('Maaf, terjadi kesalahan! Harap kembali cek form kembali');</script>";
                    } 
             }
    }

    public function inputSasaran()
    {
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];
        $jobdesc_u = $_POST['jobdesc_u'];
        $sasaran_u = $_POST['sasaran_u'];
        $count_jd_u = count($jobdesc_u);
        
        if ( isset($_POST['jobdesc_t']) ) {
            echo "test isset";
            $jobdesc_t = $_POST['jobdesc_t'];
            $sasaran_t = $_POST['sasaran_t'];
            $count_jd_t = count($jobdesc_t);
            $count_jobdesc= $count_jd_u + $count_jd_t;
            $status_tambahan = 1;
        }else {
            $count_jobdesc= $count_jd_u;
            $status_tambahan=0;
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $tahun = date('Y', time());

        //VALIDASI INPUTAN
        $error = 0;
        for ($i=0; $i < $count_jobdesc && $error!=1 ; $i++) { 
            if ((empty($jobdesc_u[$i]) or empty($sasaran_u[$i])) and $status_tambahan==0 ) {
                    $error = 1 ;
                }else{
                    $error = 0;
                }
        }

        if ($status_tambahan==0) {
            for ($i=0; $i < $count_jd_u && $error!=1; $i++) { 
            
                $data = array(
                    'id_jdsasaran' => '',
                    'id_karyawan' => $id_karyawan,
                    'tahun' => $tahun,
                    'nama' => $nama,
                    'jobdesc' => $jobdesc_u[$i],
                    'sasaran' => $sasaran_u[$i],
                    'tipe_jobdesc' => 'utama'
                );
    
                $res = $this->MainModel->insertData('jobdesc_sasaran',$data);
    
                if ($res>=1) {
                    $error = 0 ;
                }else{
                    $error = 1 ;
                }
            }
        }else {
            for ($i=0; $i < $count_jd_u && $error!=1; $i++) { 
            
                $data = array(
                    'id_jdsasaran' => '',
                    'id_karyawan' => $id_karyawan,
                    'tahun' => $tahun,
                    'nama' => $nama,
                    'jobdesc' => $jobdesc_u[$i],
                    'sasaran' => $sasaran_u[$i],
                    'tipe_jobdesc' => 'utama'
                );
    
                $res = $this->MainModel->insertData('jobdesc_sasaran',$data);
    
                if ($res>=1) {
                    $error = 0 ;
                }else{
                    $error = 1 ;
                }
            }
            
            for ($i=0; $i < $count_jd_t && $error!=1; $i++) { 
    
                $data = array(
                    'id_jdsasaran' => '',
                    'id_karyawan' => $id_karyawan,
                    'tahun' => $tahun,
                    'nama' => $nama,
                    'jobdesc' => $jobdesc_t[$i],
                    'sasaran' => $sasaran_t[$i],
                    'tipe_jobdesc' => 'tambahan'
                );
    
                $res = $this->MainModel->insertData('jobdesc_sasaran',$data);
    
                if ($res>=1) {
                    $error = 0 ;
                }else{
                    $error = 1 ;
                }
            }
        }
        

        if ($error==0) {
            redirect(base_url()."index.php/MainController/viewListJobdesc/");
        }else{
            echo"<script>window.alert('Maaf, terjadi kesalahan! Harap kembali cek form kembali');histroy.go(-1);</script>";
        }

        
    }

    public function inputSasaranTambahan()
    {
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];
        $jobdesc_t = $_POST['jobdesc_t'];
        $sasaran_t = $_POST['sasaran_t'];
        $count_jd_t = count($jobdesc_t);
        $count_jobdesc= $count_jd_t;
        
        date_default_timezone_set("Asia/Jakarta");
        $tahun = date('Y', time());

        //VALIDASI INPUTAN
        $error = 0;
        for ($i=0; $i < $count_jobdesc && $error!=1 ; $i++) { 
            if (empty($jobdesc_t[$i]) or empty($sasaran_t[$i]) ) {
                    $error = 1 ;
                }else{
                    $error = 0;
                }
        }

        for ($i=0; $i < $count_jd_t && $error!=1; $i++) { 
            
            $data = array(
                'id_jdsasaran' => '',
                'id_karyawan' => $id_karyawan,
                'tahun' => $tahun,
                'nama' => $nama,
                'jobdesc' => $jobdesc_t[$i],
                'sasaran' => $sasaran_t[$i],
                'tipe_jobdesc' => 'tambahan'
            );

            $res = $this->MainModel->insertData('jobdesc_sasaran',$data);

            if ($res>=1) {
                $error = 0 ;
            }else{
                $error = 1 ;
            }
        }
        

        if ($error==0) {
            redirect(base_url()."index.php/MainController/viewLihatJobdesc/");
        }else{
            echo"<script>window.alert('Maaf, terjadi kesalahan! Harap kembali cek form kembali');</script>";
        }

        
    }

    public function editJobdesc($id_ctt)
    {
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];
        $tanggal=$_POST['tanggal'];
        $nosurat = $_POST['nosurat'];
        $namaka = $_POST['namaka'];
        $catatan = $_POST['catatan'];
        $jobdesc = $_POST['jobdesc'];
        $lamp = $_FILES['lampiran']['tmp_name'];

        if(empty($tanggal) or empty($nosurat) or empty($namaka) or empty($catatan)){
            echo"<script>window.alert('Maaf, kembali cek form kembali');</script>";
         }else{
             if (empty($lamp)) {
                $tgl = explode("-", $tanggal);

                $data = array(
                    'tanggal' => $tgl[0],
                    'bulan' => $tgl[1],
                    'tahun' => $tgl[2],
                    'nosurat' => $nosurat,
                    'namakegiatan' => $namaka,
                    'catatan' => $catatan,
                    'nama' => $nama,
                    
                );


    
                $res = $this->MainModel->updateData('catatanharian_test',$data,array(
                    'nama' => $nama,
                    'id_karyawan' => $id_karyawan,
                    'id_catatanharian' => $id_ctt
                ));

                
                if ($res>=1) {
                    $error = 0 ;
                }else{
                    $error = 1 ;
                }
            
             }else{
                 $img = file_get_contents($lamp);
                $tgl = explode("-", $tanggal);

                $data = array(
                    'tanggal' => $tgl[0],
                    'bulan' => $tgl[1],
                    'tahun' => $tgl[2],
                    'nosurat' => $nosurat,
                    'namakegiatan' => $namaka,
                    'lampiran' => $img,
                    'catatan' => $catatan,
                    'nama' => $nama,
                    
                );


                $res = $this->MainModel->updateData('catatanharian_test',$data,array(
                    'nama' => $nama,
                    'id_karyawan' => $id_karyawan,
                    'id_catatanharian' => $id_ctt
                ));
                
                if ($res>=1) {
                    $error = 0 ;
                }else{
                    $error = 1 ;
                }

             }
         }

        if ($error==0) {
           redirect(base_url()."index.php/MainController/viewListJobdesc/");
        }else{
            echo"<script>window.alert('Maaf, terjadi kesalahan! Harap cek form kembali');history.go(-1);</script>";
        }


    }

    public function deleteCatatan($id)
    {
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];
        $cek_isi1 = $this->MainModel->selectSpecify('catatanharian_test',array(
            'id_catatanharian' => $id,
            'nama' => $nama,
            'id_karyawan' => $id_karyawan
        ));

        foreach ($cek_isi1 as $data1) {
            $tgl = $data1['tanggal']."-".$data1['bulan']."-".$data1['tahun'];
        }
        
        $cek_isi2 = $this->MainModel->selectSpecify('catatanharian_hari',array(
            'tanggal' => $tgl,
            'id_karyawan' => $id_karyawan
        ));

        foreach ($cek_isi2 as $data2 ) {
            $kuant = $data2['kuant_harian'];
        }

        $res1 = $this->MainModel->updateData('catatanharian_hari',array(
            'kuant_harian' => $kuant-1
        ),array(
            'tanggal' => $tgl,
            'id_karyawan' => $id_karyawan
        ));

        if ($kuant-1 == 0) {
            $res = $this->MainModel->deleteData('catatanharian_hari',array(
                'tanggal' => $tgl,
                'id_karyawan' => $id_karyawan
            ));
        }  

        $res2 = $this->MainModel->deleteData('catatanharian_test',array(
            'id_catatanharian' => $id,
            'nama' => $nama,
            'id_karyawan' => $id_karyawan
        )); 

        


 
        if ($res1>=1 and $res2>=1) {
            redirect(base_url()."index.php/MainController/viewListHarian/".$tgl);
        }else{
            echo"<script>window.alert('Maaf, terjadi kesalahan! Harap cek form kembali');history.go(-1);</script>";
        }
    }

    

    
}