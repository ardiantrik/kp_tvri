<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerRekap extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('MainModel');
        $this->load->library('session');
    }

    public function doRekapTahun()
    {
        
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];
        $nip = $_SESSION['nip'];
        $id_penilai = $_POST['id_kepala'];

        date_default_timezone_set("Asia/Jakarta");
        $tahun = date('Y', time());
        $bulan = date('M', time());

        $data_sasaran = $this->MainModel->selectSpecify('jobdesc_sasaran',array(
            'id_karyawan' => $id_karyawan,
            'tahun' => $tahun
        ));

        $i=0;
        foreach ($data_sasaran as $sasaran) {
            $id1[$i] = $sasaran['id_jdsasaran'];
            $jobdesc[$i] = $sasaran['jobdesc'];
            $target[$i] = $sasaran['sasaran'];
            $tipe[$i] = $sasaran['tipe_jobdesc'];
            $i++;
        }

        $data_penilai = $this->MainModel->selectSpecify('user_pegawai',array(
            'id_pegawai' => $id_penilai
        ));

        foreach($data_penilai as $data_penilai){
            $data_p = array(
                'nama_penilai' => $data_penilai['nama'],
                'nip_penilai' => $data_penilai['nip']
            );
            
        }

        $data_catatan = $this->MainModel->selectSpecify('catatanharian_test',array(
            'id_karyawan' => $id_karyawan,
            'tahun' => $tahun
        ));

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

        $this->doCetakTahunan($data_rekap_u,$data_rekap_t, $data_p);
    }
  
    public function doCetakTahunan($data_u, $data_t, $data_p)
    {
        date_default_timezone_set("Asia/Jakarta");
        $tahun = date('Y', time());


        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('TVRI')
                        ->setLastModifiedBy('TVRI')
                        ->setTitle("Rekap Jobdesc")
                        ->setSubject("Karyawan")
                        ->setDescription("Rekap Tahunan")
                        ->setKeywords("Rekap Jobdesc");
                        
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $style_col_raw = array(
            'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $raw_noborder = array(
            'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $row_no_border = array(
            'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            )
        );
        $excel->getActiveSheet()->getStyle('A1:O99')->getFont()->setName('Times New Roman');

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "PENILAIAN SASARAN KERJA PEGAWAI"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:O1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "Jangka Waktu Penilaian"); 
        $excel->getActiveSheet()->mergeCells('A3:G3');
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "Tgl. 1 Januari s.d. 31 Desember ".$tahun); 
        $excel->getActiveSheet()->mergeCells('A4:G4');
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "Nama"); 
        $excel->getActiveSheet()->mergeCells('H3:I3');
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "NIP"); 
        $excel->getActiveSheet()->mergeCells('H4:I4');
        $excel->setActiveSheetIndex(0)->setCellValue('J3', ": ".$_SESSION['nama']); 
        $excel->getActiveSheet()->mergeCells('J3:O3');
        $excel->setActiveSheetIndex(0)->setCellValue('J4', ": ".$_SESSION['nip']); 
        $excel->getActiveSheet()->mergeCells('J4:O4');

        //Menentukan Header Tabel
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "NO"); 
        $excel->getActiveSheet()->mergeCells('A5:A6');
        $excel->setActiveSheetIndex(0)->setCellValue('B5', "KEGIATAN TUGAS JABATAN"); 
        $excel->getActiveSheet()->mergeCells('B5:C6');
        $excel->setActiveSheetIndex(0)->setCellValue('D5', "AK"); 
        $excel->getActiveSheet()->mergeCells('D5:D6');
        $excel->setActiveSheetIndex(0)->setCellValue('E5', "TARGET"); 
        $excel->getActiveSheet()->mergeCells('E5:H5');
        $excel->setActiveSheetIndex(0)->setCellValue('E6', "KUANT/OUTPUT"); 
        $excel->setActiveSheetIndex(0)->setCellValue('F6', "KUAL/ MUTU"); 
        $excel->setActiveSheetIndex(0)->setCellValue('G6', "WAKTU"); 
        $excel->setActiveSheetIndex(0)->setCellValue('H6', "BIAYA"); 
        $excel->setActiveSheetIndex(0)->setCellValue('I5', "AK"); 
        $excel->getActiveSheet()->mergeCells('I5:I6');
        $excel->setActiveSheetIndex(0)->setCellValue('J5', "REALISASI"); 
        $excel->getActiveSheet()->mergeCells('J5:M5');
        $excel->setActiveSheetIndex(0)->setCellValue('J6', "KUANT/OUTPUT"); 
        $excel->setActiveSheetIndex(0)->setCellValue('K6', "KUAL/ MUTU"); 
        $excel->setActiveSheetIndex(0)->setCellValue('L6', "WAKTU"); 
        $excel->setActiveSheetIndex(0)->setCellValue('M6', "BIAYA"); 
        $excel->setActiveSheetIndex(0)->setCellValue('N5', "PERHITUNGAN"); 
        $excel->getActiveSheet()->mergeCells('N5:N6');
        $excel->setActiveSheetIndex(0)->setCellValue('O5', "NILAI CAPAIAN SKP"); 
        $excel->getActiveSheet()->mergeCells('O5:O6');
        
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A5:A6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B5:C6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D5:D6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E5:H5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E6')->applyFromArray($style_col_raw);
        $excel->getActiveSheet()->getStyle('F6')->applyFromArray($style_col_raw);
        $excel->getActiveSheet()->getStyle('G6')->applyFromArray($style_col_raw);
        $excel->getActiveSheet()->getStyle('H6')->applyFromArray($style_col_raw);
        $excel->getActiveSheet()->getStyle('I5:I6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J5:M5')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J6')->applyFromArray($style_col_raw);
        $excel->getActiveSheet()->getStyle('K6')->applyFromArray($style_col_raw);
        $excel->getActiveSheet()->getStyle('L6')->applyFromArray($style_col_raw);
        $excel->getActiveSheet()->getStyle('M6')->applyFromArray($style_col_raw);
        $excel->getActiveSheet()->getStyle('N5:N6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O5:O6')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 5
        foreach($data_u as $data){ // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['jobdesc_u']);
            $excel->getActiveSheet()->mergeCells('B'.$numrow.':C'.$numrow);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, '0');
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['target_u']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, '100');
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, '12 bln');
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, '0');
            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['dikerjakan_u']);
            $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, "=((J".$numrow."*100)/E".$numrow.")");
            $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, '12 bln');
            $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, '');
            $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, "=(100+K".$numrow."+76)");
            $excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, "=(N".$numrow."/3)");
            
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);

            if ( strlen($data['jobdesc_u'])>170) {
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(50);
                
            }elseif (strlen($data['jobdesc_u'])>90) {
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(30);
                
            }
            
            
            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
            
        }
        $count_u = count($data_u);
        $end_u = $numrow-1;
        //$numrow++;
        if (!empty($data_t)) {
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, '');
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_col);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, 'II. TUGAS TAMBAHAN DAN KREATIVITAS');
            $excel->getActiveSheet()->mergeCells('B'.$numrow.':C'.$numrow);
            $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->applyFromArray($style_col);
            $excel->getActiveSheet()->mergeCells('D'.$numrow.':O'.$numrow);
            $excel->getActiveSheet()->getStyle('D'.$numrow.':O'.$numrow)->applyFromArray($style_col);
            $numrow++;
            $no=1;
            $count_t = 0;
            $start_t = $numrow;
        foreach($data_t as $data){ // Lakukan looping pada variabel siswa
            if ($no<=3) {
                
                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['jobdesc_t']);
                $excel->getActiveSheet()->mergeCells('B'.$numrow.':C'.$numrow);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, '0');
                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['target_t']);
                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, '100');
                $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, '12 bln');
                $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, '0');
                $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['dikerjakan_t']);
                $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, "=((J".$numrow."*100)/E".$numrow.")");
                $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, '12 bln');
                $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, "=(100+K".$numrow."+76)");
                $excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, "=(N".$numrow."/3)");
                
                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);

                if ( strlen($data['jobdesc_t'])>170) {
                    $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(50);
                    
                }elseif (strlen($data['jobdesc_t'])>90) {
                    $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(30);
                }
                $end_t = $numrow; 
                $numrow++; // Tambah 1 setiap kali looping
                $count_t++;
            }
            
            $no++; // Tambah 1 setiap kali looping
            
            
            }
            
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, '');
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_col);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, 'II. TUGAS TAMBAHAN DAN KREATIVITAS');
            $excel->getActiveSheet()->mergeCells('B'.$numrow.':C'.$numrow);
            $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->applyFromArray($style_col);
            $excel->getActiveSheet()->mergeCells('D'.$numrow.':O'.$numrow);
            $excel->getActiveSheet()->getStyle('D'.$numrow.':O'.$numrow)->applyFromArray($style_col);
            $numrow++;
            for ($i=1; $i <= 3; $i++) { 
                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $i);
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, '');
                $excel->getActiveSheet()->mergeCells('B'.$numrow.':C'.$numrow);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, '');
                $excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, '');
                
                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);

                $numrow++;
            }
            $count_t = 0;
        }
        $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, '');
        $excel->getActiveSheet()->mergeCells('A'.$numrow.':O'.$numrow);
        $excel->getActiveSheet()->getStyle('A'.$numrow.':O'.$numrow)->applyFromArray($style_col);
        $count = $count_u + $count_t;

        if ($count_t == 0) {
            $sum = "=sum(O7:O".$end_u.")/".$count;
        } else {
            $sum = "=sum(O7:O".$end_u.",O".$start_t.":O".$end_t.")/".$count;
        }

        
        
        
        $numrow++;
        $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, "Nilai Capaian SKP");
        $numb1 = $numrow + 1;
        $excel->getActiveSheet()->mergeCells('A'.$numrow.':N'.$numb1);
        $excel->getActiveSheet()->getStyle('A'.$numrow.':N'.$numb1)->applyFromArray($style_col);
        $excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $sum);
        $excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_col);
        $result = "=IF(O".$numrow.">=90,\"Sangat Baik\",IF(AND(O".$numrow."<90,O".$numrow.">=75),\"Baik\",IF(AND(O".$numrow."<75,O".$numrow.">=60),\"Cukup\",IF(AND(O".$numrow."<60,O".$numrow.">=50),\"Kurang\",IF(O".$numrow."<50,\"Buruk\")))))";
        $excel->setActiveSheetIndex(0)->setCellValue('O'.$numb1, $result);
        $excel->getActiveSheet()->getStyle('O'.$numb1)->applyFromArray($style_col);
        $numrow=$numrow+3;
        $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, "Yogyakarta, 31 Desember ".$tahun);
        $excel->getActiveSheet()->mergeCells('L'.$numrow.':O'.$numrow);
        $excel->getActiveSheet()->getStyle('L'.$numrow.':O'.$numrow)->applyFromArray($raw_noborder);
        $numrow++;
        $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, "Pejabat Penilai,");
        $excel->getActiveSheet()->mergeCells('L'.$numrow.':O'.$numrow);
        $excel->getActiveSheet()->getStyle('L'.$numrow.':O'.$numrow)->applyFromArray($raw_noborder);
        $numrow=$numrow+3;
        $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data_p['nama_penilai']);
        $excel->getActiveSheet()->mergeCells('L'.$numrow.':O'.$numrow);
        $excel->getActiveSheet()->getStyle('L'.$numrow.':O'.$numrow)->applyFromArray($raw_noborder);
        $numrow++;
        $excel->getActiveSheet()->getCell('L'.$numrow)->setValueExplicit($data_p['nip_penilai'], PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->mergeCells('L'.$numrow.':O'.$numrow);
        $excel->getActiveSheet()->getStyle('L'.$numrow.':O'.$numrow)->applyFromArray($raw_noborder);



        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(60); 
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(10); 
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(10); 
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12); 
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(10); 
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(10); 
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(10); 
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(12); 
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(10); 
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getStyle('A5'.':O'.$numrow)->getAlignment()->setWrapText(true);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Penilaian SKP");
        $excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:O'.$numrow);
        $excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $excel->getActiveSheet()->getPageMargins()->setTop(0.75); 
        $excel->getActiveSheet()->getPageMargins()->setRight(0.25); 
        $excel->getActiveSheet()->getPageMargins()->setLeft(0.25); 
        $excel->getActiveSheet()->getPageMargins()->setBottom(0.75);
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Penilaian SKP-'.$tahun.'_'.$_SESSION['nama'].'.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function doRekapSasaran()
    {
        $id_karyawan = $_SESSION['id_karyawan'];
        $nama = $_SESSION['nama'];
        $data_penilai = array(
            'nama_penilai' => $_POST['nama_penilai'],
            'nip_penilai' => $_POST['nip_penilai'],
            'golongan_penilai' => $_POST['golongan_penilai'],
            'jabatan_penilai' => $_POST['jabatan_penilai']
        );

        //var_dump($data_penilai);

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
                'nip' => $data['nip'],
                'golongan' => $_POST['golongan_dinilai']
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
        // ))

        if (empty($data_tambahan)) {
            $this->doCetakSasaran($data_u, $data_tambahan, $data_k, $data_penilai);
        } else {
            $this->doCetakSasaran($data_u, $data_t, $data_k, $data_penilai);
        }
        
        
        
        

    }

    public function doCetakSasaran($data_u, $data_t, $data_k, $data_penilai)
    {
            //Setting Bulan Tahun
            date_default_timezone_set("Asia/Jakarta");
            $tahun = date('Y', time());
            $bulan = date('m', time());

            if($bulan=='1'){
                $bulan='Januari';
            }elseif($bulan=='2'){
                $bulan='Februari';
            }elseif($bulan=='3'){
                $bulan='Maret';
            }elseif($bulan=='4'){
                $bulan='April';
            }elseif($bulan=='5'){
                $bulan='Mei';
            }elseif($bulan=='6'){
                $bulan='Juni';
            }elseif($bulan=='7'){
                $bulan='Juli';
            }elseif($bulan=='8'){
                $bulan='Agustus';
            }elseif($bulan=='9'){
                $bulan='September';
            }elseif($bulan=='10'){
                $bulan='Oktober';
            }elseif($bulan=='11'){
                $bulan='November';
            }elseif($bulan=='12'){
                $bulan='Desember';
            }

        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('TVRI')
                        ->setLastModifiedBy('TVRI')
                        ->setTitle("Sasaran Kerja Pegawai")
                        ->setSubject("TVRI")
                        ->setDescription("Sasaran Kerja Pegawai")
                        ->setKeywords("Sasaran Jobdesc");
                        
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_col_center = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $style_row_center = array(
            'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $no_border_row = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            )
        );

        $excel->getActiveSheet()->getStyle('A1:H99')->getFont()->setName('Times New Roman');

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "SASARAN KERJA PEGAWAI"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:H1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        
        //
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); 
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "I.PEJABAT PENILAI"); 
        $excel->getActiveSheet()->mergeCells('B3:C3');
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "NO"); 
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "II.PEGAWAI NEGERI SIPIL YANG DINILAI"); 
        $excel->getActiveSheet()->mergeCells('E3:H3');

        $excel->setActiveSheetIndex(0)->setCellValue('A4', "1"); 
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "Nama");
        $excel->setActiveSheetIndex(0)->setCellValue('A5', "2"); 
        $excel->setActiveSheetIndex(0)->setCellValue('B5', "NIP");
        $excel->setActiveSheetIndex(0)->setCellValue('A6', "3"); 
        $excel->setActiveSheetIndex(0)->setCellValue('B6', "Pangkat/Gol. Ruang");
        $excel->setActiveSheetIndex(0)->setCellValue('A7', "4"); 
        $excel->setActiveSheetIndex(0)->setCellValue('B7', "Jabatan");
        $excel->setActiveSheetIndex(0)->setCellValue('A8', "5"); 
        $excel->setActiveSheetIndex(0)->setCellValue('B8', "Unit Kerja");

        $excel->setActiveSheetIndex(0)->setCellValue('D4', "1"); 
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "Nama");
        $excel->getActiveSheet()->mergeCells('F4:H4');
        $excel->setActiveSheetIndex(0)->setCellValue('D5', "2"); 
        $excel->setActiveSheetIndex(0)->setCellValue('E5', "NIP");
        $excel->getActiveSheet()->mergeCells('F5:H5');
        $excel->setActiveSheetIndex(0)->setCellValue('D6', "3"); 

        $pkt = $_SESSION['pangkat'];
        if ($pkt == 'I' || $pkt == 'II' || $pkt == 'III' || $pkt == 'IV' || $pkt == 'V' || $pkt == 'VI' || $pkt == 'VII' || $pkt == 'VIII' || $pkt == 'IX' || $pkt == 'X' || $pkt == 'XI' || $pkt == 'XII'|| $pkt == 'XIII' || $pkt == 'XIV' || $pkt == 'XV' || $pkt == 'XVI') {
            $excel->setActiveSheetIndex(0)->setCellValue('E6', "Kelas Jabatan");
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('E6', "Pangkat/Gol. Ruang");
        }
        
        
        $excel->getActiveSheet()->mergeCells('F6:H6');
        $excel->setActiveSheetIndex(0)->setCellValue('D7', "4"); 
        $excel->setActiveSheetIndex(0)->setCellValue('E7', "Jabatan");
        $excel->getActiveSheet()->mergeCells('F7:H7');
        $excel->setActiveSheetIndex(0)->setCellValue('D8', "5"); 
        $excel->setActiveSheetIndex(0)->setCellValue('E8', "Unit Kerja");
        $excel->getActiveSheet()->mergeCells('F8:H8');

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col_center);
        $excel->getActiveSheet()->getStyle('A4:A8')->applyFromArray($style_row_center);
        $excel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4:B8')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('C4:C8')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col_center);
        $excel->getActiveSheet()->getStyle('D4:D8')->applyFromArray($style_row_center);
        $excel->getActiveSheet()->getStyle('E3:H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4:E8')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('F4:H8')->applyFromArray($style_row);

        foreach ($data_k as $data) {
            $nama = $data['nama'];
            $nip = $data['nip'];

            $excel->setActiveSheetIndex(0)->setCellValue('F4', $data['nama']); 
            $excel->getActiveSheet()->getCell('F5')->setValueExplicit($data['nip'], PHPExcel_Cell_DataType::TYPE_STRING);
            $excel->setActiveSheetIndex(0)->setCellValue('F6', $data['golongan']);
            $excel->setActiveSheetIndex(0)->setCellValue('F7', $data['jabatan']);
            $excel->setActiveSheetIndex(0)->setCellValue('F8', "TVRI Stasiun D.I.Yogyakarta");
        }
        
            // $nama_penilai = "dasdas";
            // $nip_penilai = "asdasdas";

            $nama_penilai = $data_penilai['nama_penilai'];
            $nip_penilai = $data_penilai['nip_penilai'];

            $excel->setActiveSheetIndex(0)->setCellValue('C4', $data_penilai['nama_penilai']); 
            $excel->getActiveSheet()->getCell('C5')->setValueExplicit($data_penilai['nip_penilai'], PHPExcel_Cell_DataType::TYPE_STRING);
            $excel->setActiveSheetIndex(0)->setCellValue('C6', $data_penilai['golongan_penilai']);
            $excel->setActiveSheetIndex(0)->setCellValue('C7', $data_penilai['jabatan_penilai']);
            $excel->setActiveSheetIndex(0)->setCellValue('C8', "TVRI Stasiun D.I.Yogyakarta");
        

        //$excel->setActiveSheetIndex(0)->setCellValue('C8', "TVRI Stasiun D.I.Yogyakarta");

        


        //Menentukan Header Tabel
        $excel->setActiveSheetIndex(0)->setCellValue('A9', "NO"); 
        $excel->getActiveSheet()->mergeCells('A9:A10');
        $excel->setActiveSheetIndex(0)->setCellValue('B9', "III.KEGIATAN TUGAS JABATAN"); 
        $excel->getActiveSheet()->mergeCells('B9:C10');
        $excel->setActiveSheetIndex(0)->setCellValue('D9', "AK"); 
        $excel->getActiveSheet()->mergeCells('D9:D10');
        $excel->setActiveSheetIndex(0)->setCellValue('E9', "TARGET"); 
        $excel->getActiveSheet()->mergeCells('E9:H9');
        $excel->setActiveSheetIndex(0)->setCellValue('E10', "KUANT/OUTPUT"); 
        $excel->setActiveSheetIndex(0)->setCellValue('F10', "KUAL/MUTU"); 
        $excel->setActiveSheetIndex(0)->setCellValue('G10', "WAKTU"); 
        $excel->setActiveSheetIndex(0)->setCellValue('H10', "BIAYA"); 
        
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A9:A10')->applyFromArray($style_col_center);
        $excel->getActiveSheet()->getStyle('B9:C10')->applyFromArray($style_col_center);
        $excel->getActiveSheet()->getStyle('D9:D10')->applyFromArray($style_col_center);
        $excel->getActiveSheet()->getStyle('E9:H9')->applyFromArray($style_col_center);
        $excel->getActiveSheet()->getStyle('E10')->applyFromArray($style_col_center);
        $excel->getActiveSheet()->getStyle('F10')->applyFromArray($style_col_center);
        $excel->getActiveSheet()->getStyle('G10')->applyFromArray($style_col_center);
        $excel->getActiveSheet()->getStyle('H10')->applyFromArray($style_col_center);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 11; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data_u as $data){ // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['jobdesc']);
            $excel->getActiveSheet()->mergeCells('B'.$numrow.':C'.$numrow);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, '0');
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['target']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, '100');
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, '12 Bulan');
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, '');
        
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row_center);
            $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row_center);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row_center);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row_center);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row_center);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row_center); 
            
            if ( strlen($data['jobdesc'])>170) {
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(50);
                $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->getAlignment()->setWrapText(true);
            }elseif (strlen($data['jobdesc'])>90) {
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(30);
                $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->getAlignment()->setWrapText(true);
            }
            
            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
            
        }

        if(!empty($data_t)){

            //Menentukan Header Tabel
        $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, ""); 
        $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, "IV.TUGAS TAMBAHAN DAN KREATIVITAS"); 
        $excel->getActiveSheet()->mergeCells('B'.$numrow.':C'.$numrow);
        $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, ""); 
        $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, ""); 
        $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, ""); 
        $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, ""); 
        $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, ""); 
        
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->applyFromArray($style_col_center);
        $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_col);

        $numrow++;
        $no=1;

        }

        

        
        foreach($data_t as $data){

                // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['jobdesc']);
            $excel->getActiveSheet()->mergeCells('B'.$numrow.':C'.$numrow);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, '0');
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['target']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, '100');
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, '12 Bulan');
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, '');
            
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row_center);
            $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row_center);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row_center);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row_center);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row_center);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row_center);

            if ( strlen($data['jobdesc'])>170) {
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(50);
                $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->getAlignment()->setWrapText(true);
            }elseif (strlen($data['jobdesc'])>90) {
                $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(30);
                $excel->getActiveSheet()->getStyle('B'.$numrow.':C'.$numrow)->getAlignment()->setWrapText(true);
            }
        
            
            

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
        }


        


            
            $num1=$numrow+1;
            $num3=$numrow+6;
            $num4=$numrow+7;
            
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$num1, "Pejabat Penilai,"); 
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$num3, $nama_penilai); 
            $excel->getActiveSheet()->getCell('C'.$num4)->setValueExplicit($nip_penilai, PHPExcel_Cell_DataType::TYPE_STRING);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, "Yogyakarta,     ".$bulan." ".$tahun);
            $excel->getActiveSheet()->mergeCells('F'.$numrow.':H'.$numrow);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$num1, "Pegawai Negeri Sipil Yang Dinilai"); 
            $excel->getActiveSheet()->mergeCells('F'.$num1.':H'.$num1);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$num3, $nama); 
            $excel->getActiveSheet()->mergeCells('F'.$num3.':H'.$num3);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$num4, $nip); 
            $excel->getActiveSheet()->mergeCells('F'.$num4.':H'.$num4);
            $excel->getActiveSheet()->getStyle('F'.$num4)->applyFromArray($no_border_row);
            


        
            // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(60); 
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 
        
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("SKP Tahunan");
        $num9=$numrow+9;
        $excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H'.$num9);
        $excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $excel->getActiveSheet()->getPageMargins()->setTop(0.75); 
        $excel->getActiveSheet()->getPageMargins()->setRight(0.25); 
        $excel->getActiveSheet()->getPageMargins()->setLeft(0.25); 
        $excel->getActiveSheet()->getPageMargins()->setBottom(0.75);
        $excel->setActiveSheetIndex(0);

        
        //   Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="SKP-'.$tahun.'_'.$_SESSION['nama'].'.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

  


    

    
}