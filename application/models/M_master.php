<?php
class M_master extends CI_Model{
 	
 	function __construct(){
        parent::__construct();
        
        date_default_timezone_set('Asia/Jakarta');
        $this->username = $this->session->userdata('username');
        
    }

    public function upload($file,$nama){
        // $file = 'foto';
        // unlink('../assets/images/member/'.$nama);
        $config['upload_path'] = './assets/gambar/produk/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        // $config['max_size'] = '20480';
        // $config['remove_space'] = TRUE;
        $config['file_name'] = $nama;
    
        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        if($this->upload->do_upload($file)){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        }else{
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    public function upload2($file,$nama){
        // $file = 'foto';
        // unlink('../assets/images/member/'.$nama);
        $config['upload_path'] = './assets/gambar/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        // $config['max_size'] = '20480';
        // $config['remove_space'] = TRUE;
        $config['file_name'] = $nama;
    
        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        if($this->upload->do_upload($file)){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        }else{
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }
   
    function get_data($table){
        $query = "SELECT * FROM $table";
        return $this->db->query($query);
    }

    function get_count($table){
        $query = "SELECT count(*) as jumlah FROM $table";
        return $this->db->query($query);
    }



    function get_data_one($table,$kolom,$id){
        
        $query = "SELECT * FROM $table WHERE $kolom='$id'";
        return $this->db->query($query);
    }


    function query($query1){
        
        $query = $query1;
        return $this->db->query($query);
    }


    function get_data_max($table,$kolom){
        $query = "SELECT IFNULL(LPAD(MAX(RIGHT($kolom,4))+1,4,0),'0001')AS nomor FROM $table";
        return $this->db->query($query)->row("nomor");
    }

    function delete($tabel,$kolom,$id){
        
        $query = "DELETE FROM $tabel WHERE $kolom = '$id' ";
        $result =  $this->db->query($query);
        return $result;
    }
	
    
    function m_pelanggan($table,$status)
	{
		$kode_lama = $_POST["kode_lama"];
		$kode_pelanggan = $_POST["kode_pelanggan"];
		$cekKode = $this->db->query("SELECT*FROM m_pelanggan WHERE kode_unik='$kode_pelanggan'")->num_rows();
		if($status == 'update' && $kode_lama != $kode_pelanggan && $cekKode > 0){
			return array(
				'data' => false,
				'isi' => 'KODE PELANGGAN SUDAH ADA!',
			);
		}else if($status == 'insert' && $cekKode > 0){
			return array(
				'data' => false,
				'isi' => 'KODE PELANGGAN SUDAH ADA!',
			);
		}else{
			$data = array(
				'id_sales' => $_POST["id_sales"],
				'kode_unik' => $_POST["kode_pelanggan"],
				'nm_pelanggan' => $_POST["nm_pelanggan"],
				'attn' => $_POST["attn"],
				'alamat' => $_POST["alamat"],
				'alamat_kirim' => $_POST["alamat_kirim"],
				'prov' => ($_POST["provinsi"] == 0 || $_POST["provinsi"] == null || $_POST["provinsi"] == "") ? null : $_POST["provinsi"],
				'kab' => ($_POST["kota_kab"] == 0 || $_POST["kota_kab"] == null || $_POST["kota_kab"] == "") ? null : $_POST["kota_kab"],
				'kec' => ($_POST["kecamatan"] == 0 || $_POST["kecamatan"] == null || $_POST["kecamatan"] == "") ? null : $_POST["kecamatan"],
				'kel' => ($_POST["kelurahan"] == 0 || $_POST["kelurahan"] == null || $_POST["kelurahan"] == "") ? null : $_POST["kelurahan"],
				'kode_pos' => $_POST["kode_pos"],
				'fax' => $_POST["fax"],
				'top' => $_POST["top1"],
				'no_telp' => $_POST["no_telp"],
			);

			if ($status == 'insert') {
				$this->db->set("add_user", $this->username);
				$this->db->set("add_time", date('Y-m-d H:i:s'));
				$inputData = $this->db->insert($table, $data);
			}else{
				$this->db->set("edit_user", $this->username);
				$this->db->set("edit_time", date('Y-m-d H:i:s'));
				$this->db->where("id_pelanggan", $_POST["id_pelanggan"]);
				$inputData = $this->db->update($table, $data);
			}
			
			return array(
				'data' => true,
				'isi' => $inputData,
			);
		}
    }

	function m_penjual($table,$status)
	{		
		$data = array(
			'kode'       => $_POST["kode"],
			'nama'       => $_POST["nama"],
			'no_urut'    => $_POST["no_urut"],
		);

		if ($status == 'insert') {
			$inputData = $this->db->insert($table, $data);
		}else{
			$this->db->where("id", $_POST["idx"]);
			$inputData = $this->db->update($table, $data);
		}
		
		return array(
			'data' => true,
			'isi' => $inputData,
		);
    }

	function m_pelanggan_lm($table, $status)
	{
		// idx
		if($_POST["id_sales"] == "" || $_POST["nm_pelanggan"] == ""){
			$inputData = false;
		}else{
			$data = array(
				'id_sales' => $_POST["id_sales"],
				'nm_pelanggan_lm' => $_POST["nm_pelanggan"],
				'attn' => ($_POST["attn"] == '') ? '-' : $_POST["attn"],
				'alamat' => ($_POST["alamat"] == '') ? '-' : $_POST["alamat"],
				'alamat_kirim' => ($_POST["alamat_kirim"] == '') ? '-' : $_POST["alamat_kirim"],
				'kode_pos' => '-',
				'fax' => '-',
				'top' => '-',
				'no_telp' => ($_POST["no_telp"] == '') ? '-' : $_POST["no_telp"],
			);

			if ($status == 'insert') {
				$this->db->set("add_user", $this->username);
				$this->db->set("add_time", date('Y-m-d H:i:s'));
				$inputData = $this->db->insert($table, $data);
			}else{
				$this->db->set("edit_user", $this->username);
				$this->db->set("edit_time", date('Y-m-d H:i:s'));
				$this->db->where("id_pelanggan_lm", $_POST["idx"]);
				$inputData = $this->db->update($table, $data);
			}
		}
		
		return array(
			'data' => $inputData,
		);
	}

	
	function m_supp($table, $status)
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'insert')
		{
			$data_header = array(
				'nm_supp'   => $this->input->post('nm_supplier'),
				'alamat'        => $this->input->post('alamat'),
				'no_telp'       => $this->input->post('no_telp'),
			);

			$result_header = $this->db->insert('m_supp', $data_header);
			
		}else{

			$data_header = array(
				'nm_supp'   => $this->input->post('nm_supplier'),
				'alamat'        => $this->input->post('alamat'),
				'no_telp'       => $this->input->post('no_telp'),
			);
		
			$this->db->where('id_supp', $this->input->post('idx'));
			$result_header = $this->db->update('m_supp', $data_header);
			
		}
		return $result_header;
		
	}

    function m_hub($table,$status)
	{
		$nm_hub       = $_POST["nm_hub"];
		$nm_old       = $_POST["nm_old"];
		$cekKode      = $this->db->query("SELECT*FROM m_hub WHERE nm_hub='$nm_hub'");

		if( $status=='insert' && $cekKode->num_rows() > 0 )
		{
			return array(
				'data' => false,
				'isi' => 'NAMA HUB SUDAH TERPAKAI!',
			);
		}else if( $status=='update' && $cekKode->num_rows() > 0 && $cekKode->row()->nm_hub != $nm_old )
		{
			return array(
				'data' => false,
				'isi' => 'NAMA HUB SUDAH TERPAKAI!',
			);
		}else{
			$data = array(
				'pimpinan'  => $_POST["pimpinan"],
				'nm_hub'    => $_POST["nm_hub"],
				'alamat'    => $_POST["alamat"],
				'no_telp'   => $_POST["no_telp"],
				'kode_pos'  => $_POST["kode_pos"],
				'fax'       => $_POST["fax"],
			);

			if ($status == 'insert') {
				$this->db->set("add_user", $this->username);
				$inputData = $this->db->insert($table, $data);
			}else{
				$this->db->set("edit_user", $this->username);
				$this->db->set("edit_time", date('Y-m-d H:i:s'));
				$this->db->where("id_hub", $_POST["kode_lama"]);
				$inputData = $this->db->update($table, $data);
			}
			
			return array(
				'data' => true,
				'isi' => $inputData,
			);
		}
    }

    function tb_user($table,$status){
        
        
        $id = $this->input->post('username');

   
        $data = array(
                'username'  => $id,
                'nm_user'  	=> $this->input->post('nm_user'),
                'password'  => base64_encode($this->input->post('password')),
                'level'  	=> $this->input->post('level'),
            );

        if ($status == 'insert') {
             $cek = $this->db->query("SELECT * FROM tb_user WHERE username = '$id'
                ")->num_rows();

            if ($cek > 0) {
                return false;
            }

            $result= $this->db->insert('tb_user',$data);
        }else{
            $result= $this->db->update($table,$data,array('username' => $id));
        }
        

        return $result;
    }
   
	function m_modul_group($table,$status)
	{
		
        $id         = $this->input->post('id_group');
        $nm_group   = $this->input->post('nm_group');
        $val_group  = $this->input->post('val_group');
   
        $data = array(
			'nm_group'  	=> $nm_group,
			'val_group'  	=> $val_group,
		);

        if ($status == 'insert') {
				$cek = $this->db->query("SELECT * FROM m_modul_group WHERE nm_group = '$nm_group' and val_group='$val_group' ")->num_rows();

				if ($cek > 0) {
					return false;
				}else{

					$result= $this->db->insert($table,$data);
				}

        }else{
            $result= $this->db->update($table,$data,array('id_group' => $id));
        }
        

        return $result;
    }

    function edit_modul($table,$status)
	{        
        $id_group   = $this->input->post('id_group');
        $query      = $this->db->query("SELECT*FROM m_modul")->result();

		$delete = $this->db->query("DELETE from m_modul_groupd where id_group='$id_group' ");

		foreach ( $query as $row ) {
			$cek = $this->input->post('status'.$row->kode);
			if($cek == 1)
			{
				$data = [
					'id_group'      => $id_group,
					'kode_modul'    => $row->kode,
					'add'           => '1',
					'edit'          => '1',
					'del'           => '1',
					'cetak'         => '1',
				];

				$result = $this->db->insert("m_modul_groupd", $data);

			}
		}
        

        return $result;
    }
    
    function m_produk($table,$status){
        $data = array(
			'kode_mc'  => $this->input->post('kode_mc'),
			'nm_produk'  => $this->input->post('nm_produk'),
			'no_customer' => $this->input->post('no_customer'),
			'ukuran' => $this->input->post('ukuran'),
			'ukuran_sheet' => $this->input->post('ukuran_sheet'),
			'ukuran_sheet_p' => $this->input->post('ukuran_sheet_p'),
			'ukuran_sheet_l' => $this->input->post('ukuran_sheet_l'),
			'sambungan' => $this->input->post('sambungan'),
			'material' => $this->input->post('material'),
			'wall' => $this->input->post('wall'),
			'l_panjang' => $this->input->post('l_panjang'),
			'l_lebar' => $this->input->post('l_lebar'),
			'l_tinggi' => $this->input->post('l_tinggi'),
			'creasing' => $this->input->post('creasing'),
			'creasing2' => $this->input->post('creasing2'),
			'creasing3' => $this->input->post('creasing3'),
			'flute' => $this->input->post('flute'),
			'berat_bersih' => $this->input->post('berat_bersih'),
			'luas_bersih' => $this->input->post('luas_bersih'),
			'kualitas' => $this->input->post('kualitas'),
			'kualitas_isi' => $this->input->post('kualitas_isi'),
			'warna' => $this->input->post('warna'),
			'no_design' => $this->input->post('no_design'),
			'design' => $this->input->post('design'),
			'tipe_box' => $this->input->post('tipe_box'),
			'jenis_produk' => $this->input->post('jenis_produk'),
			'kategori' => $this->input->post('kategori'),
			'COA' => $this->input->post('COA'),
			'jml_ikat' => $this->input->post('jml_ikat'),
			'jml_palet' => $this->input->post('jml_palet'),
			'jml_paku' => $this->input->post('jml_paku'),
			'no_pisau' => $this->input->post('no_pisau'),
			'no_karet' => $this->input->post('no_karet'),
			'toleransi_kirim' => $this->input->post('toleransi_kirim'),
			'spesial_req' => $this->input->post('spesial_req')
		);

		// CEK PRODUK JIKA ADA UKURAN FLUTE SUBSTANCE YANG SAMA
		$h_id_pelanggan = $this->input->post('h_id_pelanggan');
		$noCust = $this->input->post('no_customer');
		$nm_produk = $this->input->post('nm_produk');
		$flute = $this->input->post('flute');
		$l_panjang = $this->input->post('l_panjang');
		$l_lebar = $this->input->post('l_lebar');
		$l_tinggi = $this->input->post('l_tinggi');
		$ukSheetP = $this->input->post('ukuran_sheet_p');
		$ukSheetL = $this->input->post('ukuran_sheet_l');
		$kualitas = $this->input->post('kualitas');
		$tipe_box = $this->input->post('tipe_box');
		$sambungan = $this->input->post('sambungan');
		
		$koneksi_hub = $this->db->query("SELECT*FROM akses_db_hub")->result();
		$cekProduk = $this->db->query("SELECT*FROM m_produk WHERE no_customer='$noCust' AND nm_produk='$nm_produk' AND l_panjang='$l_panjang' AND l_lebar='$l_lebar' AND l_tinggi='$l_tinggi' AND ukuran_sheet_p='$ukSheetP' AND ukuran_sheet_l='$ukSheetL' AND tipe_box='$tipe_box' AND sambungan='$sambungan' AND flute='$flute' AND kualitas='$kualitas'");

		$data2 = '';
		if ($status == 'insert') {
			if($cekProduk->num_rows() > 0){
				$result = [
					'result_ppi' => false,
					'result' => false,
					'data' => false,
				];
			}else{
				// INSERT KE PPI
				$result_ppi = $this->db->insert($table, $data);
				if($result_ppi){
					$cek_data_ppi = $this->db->query("SELECT*FROM m_produk WHERE no_customer='$noCust' AND nm_produk='$nm_produk' AND l_panjang='$l_panjang' AND l_lebar='$l_lebar' AND l_tinggi='$l_tinggi' AND ukuran_sheet_p='$ukSheetP' AND ukuran_sheet_l='$ukSheetL' AND tipe_box='$tipe_box' AND sambungan='$sambungan' AND flute='$flute' AND kualitas='$kualitas'")->row();
					// INSERT KE HUB LAINNYA
					foreach($koneksi_hub as $koneksi){
						$db_ppi_hub = '$'.$koneksi->nm_db_hub;
						$db_ppi_hub = $this->load->database($koneksi->nm_db_hub, TRUE);
						
						$db_ppi_hub->set("id_produk", $cek_data_ppi->id_produk);
						$data2 .= '| insert '.$koneksi->nm_db_hub.' | ';
						$result = array(
							'result_ppi' => $result_ppi,
							'result' => $db_ppi_hub->insert($table, $data),
							'data' => $data2);
					}
				}else{
					$result = [
						'result_ppi' => false,
						'result' => false,
						'data' => false,
					];
				}
			}
		}else{
			if($status == 'update' && $noCust != $h_id_pelanggan && $cekProduk->num_rows() > 0){
				$result = [
					'result_ppi' => false,
					'result' => false,
					'data' => false,
				];
			}else{
				// UPDATE KE PPI
				$this->db->set("edit_user", $this->username);
				$this->db->set("edit_time", date('Y-m-d H:i:s'));
				$this->db->where("id_produk", $this->input->post('id'));
				$result_ppi = $this->db->update($table, $data);
				// UPDATE KE HUB LAINNYA
				if($result_ppi){
					foreach($koneksi_hub as $koneksi){
						$db_ppi_hub = '$'.$koneksi->nm_db_hub;
						$db_ppi_hub = $this->load->database($koneksi->nm_db_hub, TRUE);
						
						$data2 .= ' | update'.$koneksi->nm_db_hub.' | ';
						$db_ppi_hub->set("edit_user", $this->username);
						$db_ppi_hub->set("edit_time", date('Y-m-d H:i:s'));
						$db_ppi_hub->where("id_produk", $this->input->post('id'));
						$result = array(
							'result_ppi' => $result_ppi,
							'result' => $db_ppi_hub->update($table, $data),
							'data' => $data2);
					}
				}else{
					$result = [
						'result_ppi' => false,
						'result' => false,
						'data' => false,
					];
				}
			}
		}

        return $result;
    }

	function buatKodeMC(){
		$mcNoCust = $_POST["mcNoCust"];
		$mcKodeUnik = $_POST["mcKodeUnik"];
		$mcKategori = $_POST["mcKategori"];
		$mcPanjang = $_POST["mcPanjang"];
		$mcLebar = $_POST["mcLebar"];
		$mcTinggi = $_POST["mcTinggi"];
		$mcFlute = $_POST["mcFlute"];
		$mcTipeBox = $_POST["mcTipeBox"];
		$mcSambungan = $_POST["mcSambungan"];
		$mcKualitas = $_POST["mcKualitas"];

		if($mcKategori == 'K_BOX'){
			$opsiWhere = "AND p.tipe_box='$mcTipeBox' AND p.sambungan='$mcSambungan'";
		}else{
			$opsiWhere = "AND p.l_panjang='$mcPanjang' AND p.l_lebar='$mcLebar'";
		}
		$cekProduk = $this->db->query("SELECT p.* FROM m_produk p
		INNER JOIN m_pelanggan c ON p.no_customer=c.id_pelanggan
		WHERE c.kode_unik='$mcKodeUnik' AND p.flute='$mcFlute' $opsiWhere");
		$cnt = str_pad($cekProduk->num_rows()+1, 4, "0", STR_PAD_LEFT);

		return array(
			'mcNoUrut' => $cnt,
		);
	}

	function simpanDataLaminasi()
	{
		$h_id = $_POST["h_id"];
		$jenis_lm = $_POST["jenis_lm"];
		$nama_lm = $_POST["nama_lm"];
		$ukuran_lm = $_POST["ukuran_lm"];
		$isi_lm = $_POST["isi_lm"];
		$ikat_lm = $_POST["ikat_lm"];
		$pack_lm = $_POST["pack_lm"];
		$plh_qty = $_POST["plh_qty"];
		$qty_lm = $_POST["qty_lm"];
		
		if(($jenis_lm == '' || $nama_lm == '' || $ukuran_lm == '' || $isi_lm < 0 || $isi_lm == '' || $isi_lm == 0 || $qty_lm == '' || $qty_lm == 0 || $qty_lm < 0) && ($plh_qty == 'pack' || $plh_qty == 'ikat')){
			$insert = false;
			$isi = 'DATA TIDAK BOLEH KOSONG!';
		}else if(($jenis_lm == '' || $nama_lm == '' || $qty_lm == '' || $qty_lm == 0 || $qty_lm < 0) && $plh_qty == 'kg'){
			$insert = false;
			$isi = 'DATA TIDAK BOLEH KOSONG!';
		}else if($jenis_lm == 'PEKALONGAN' && ($nama_lm == '' || $ukuran_lm == '' || $isi_lm < 0 || $isi_lm == '' || $isi_lm == 0 || $ikat_lm == 0 || $ikat_lm == "" || $pack_lm == 0 || $pack_lm == "" || $qty_lm == '' || $qty_lm == 0 || $qty_lm < 0)){
			$insert = false;
			$isi = 'DATA TIDAK BOLEH KOSONG!';
		}else{		
			if($plh_qty == 'pack'){
				$where = "AND pack_lm='$qty_lm'";
			}else if($plh_qty == 'ikat'){
				if($jenis_lm == 'PEKALONGAN'){
					$where = "AND pack_lm='$pack_lm' AND ikat_lm='$ikat_lm'";
				}else{
					$where = "AND ikat_lm='$qty_lm'";
				}
			}else{
				$where = "AND kg_lm='$qty_lm'";
			}
			$cekData = $this->db->query("SELECT*FROM m_produk_lm WHERE jenis_lm='$jenis_lm' AND nm_produk_lm='$nama_lm' AND ukuran_lm='$ukuran_lm' AND isi_lm='$isi_lm' AND jenis_qty_lm='$plh_qty' $where");
			
			$data = [
				'jenis_lm' => $jenis_lm,
				'nm_produk_lm' => $nama_lm,
				'ukuran_lm' => ($ukuran_lm == '') ? '-' : $ukuran_lm,
				'isi_lm' => ($isi_lm == '') ? 0 : $isi_lm,
				'jenis_qty_lm' => $plh_qty,
				'ikat_x' => ($ikat_lm == "" || $ikat_lm == 0) ? null : $ikat_lm,
				'pack_x' => ($pack_lm == "" || $pack_lm == 0) ? null : $pack_lm,
				'ikat_lm' => ($plh_qty == 'ikat') ? $qty_lm : null,
				'pack_lm' => ($plh_qty == 'pack') ? $qty_lm : null,
				'kg_lm' => ($plh_qty == 'kg') ? $qty_lm : null,
			];

			if($_POST["aksiInput"] == 'insert'){
				if($cekData->num_rows() > 0){
					$insert = false;
					$isi = 'DATA SUDAH ADA!';
				}else{
					$this->db->set('add_time', date('Y-m-d H:i:s'));
					$this->db->set('add_user', $this->username);
					$insert = $this->db->insert('m_produk_lm', $data);
					$isi = true;
				}
			}else{
				if($cekData->num_rows() > 0 && $h_id != $cekData->row()->id_produk_lm){
					$insert = false;
					$isi = 'DATA SUDAH ADA!';
				}else{
					$this->db->set('edit_time', date('Y-m-d H:i:s'));
					$this->db->set('edit_user', $this->username);
					$this->db->where('id_produk_lm', $h_id);
					$insert = $this->db->update('m_produk_lm', $data);
					$isi = true;
				}
			}
		}

		return [
			'insert' => $insert,
			'msg' => $isi,
		];
	}

	function editDataLaminasi()
	{
		$id = $_POST["id"];
		$produk = $this->db->query("SELECT*FROM m_produk_lm WHERE id_produk_lm='$id'")->row();
		$cek = $this->db->query("SELECT*FROM trs_po_lm_detail WHERE id_m_produk_lm='$id' GROUP BY id_m_produk_lm")->num_rows();
		return [
			'produk' => $produk,
			'cek' => $cek,
		];
	}

	function save_akun()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{

			$data_header = array(
				'kd_akun'   => $this->input->post('kode_akun'),
				'nm_akun'  => $this->input->post('nm_akun'),
			);
		
			$result_header = $this->db->insert('m_kode_akun', $data_header);
			
		}else{

			$data_header = array(
				'kd_akun'   => $this->input->post('kode_akun'),
				'nm_akun'  => $this->input->post('nm_akun'),
			);
		
			$this->db->where('id_akun', $this->input->post('id_akun'));
			$result_header = $this->db->update('m_kode_akun', $data_header);
			
		}
		return $result_header;
		

			
	}
	
	function save_kelompok()
	{
		$status_input   = $this->input->post('sts_input');
		$kd_kel         = str_pad($this->input->post('kd_kelompok'), 2, "0", STR_PAD_LEFT);
		if($status_input == 'add')
		{
			$data_header = array(
				'kd_akun'  	   => $this->input->post('kd_akun'),
				'kd_kelompok'  => $kd_kel,
				'nm_kelompok'  => $this->input->post('nm_kelompok'),
			);
		
			$result_header = $this->db->insert('m_kode_kelompok', $data_header);
			
		}else{

			$data_header = array(
				'kd_akun'      => $this->input->post('kd_akun'),
				'kd_kelompok'  => $kd_kel,
				'nm_kelompok'  => $this->input->post('nm_kelompok'),
			);
		
			$this->db->where('id_kelompok', $this->input->post('id_kelompok'));
			$result_header = $this->db->update('m_kode_kelompok', $data_header);
			
		}
		return $result_header;
		

			
	}
	
	function save_jenis()
	{
		$status_input   = $this->input->post('sts_input');
		$kd_jns         = str_pad($this->input->post('kd_jenis'), 2, "0", STR_PAD_LEFT);
		if($status_input == 'add')
		{

			$data_header = array(
				'kd_akun'       => $this->input->post('kd_akun'),
				'kd_kelompok'   => $this->input->post('kd_kelompok'),
				'kd_jenis'      => $kd_jns,
				'nm_jenis'      => $this->input->post('nm_jenis'),
			);
		
			$result_header = $this->db->insert('m_kode_jenis', $data_header);
			
		}else{

			$data_header = array(
				'kd_akun'       => $this->input->post('kd_akun'),
				'kd_kelompok'   => $this->input->post('kd_kelompok'),
				'kd_jenis'      => $kd_jns,
				'nm_jenis'      => $this->input->post('nm_jenis'),
			);
		
			$this->db->where('id_jenis', $this->input->post('id_jenis_old'));
			$result_header = $this->db->update('m_kode_jenis', $data_header);
			
		}
		return $result_header;
		

			
	}
	
	function save_rinci()
	{
		$status_input   = $this->input->post('sts_input');
		$kd_rinci         = str_pad($this->input->post('kd_rinci'), 2, "0", STR_PAD_LEFT);
		if($status_input == 'add')
		{

			$data_header = array(
				'kd_akun'       => $this->input->post('kd_akun'),
				'kd_kelompok'   => $this->input->post('kd_kelompok'),
				'kd_jenis'   	=> $this->input->post('kd_jenis'),
				'kd_rinci'      => $kd_rinci,
				'nm_rinci'      => $this->input->post('nm_rinci'),
			);
		
			$result_header = $this->db->insert('m_kode_rinci', $data_header);
			
		}else{

			$data_header = array(
				'kd_akun'       => $this->input->post('kd_akun'),
				'kd_kelompok'   => $this->input->post('kd_kelompok'),
				'kd_jenis'   	=> $this->input->post('kd_jenis'),
				'kd_rinci'      => $kd_rinci,
				'nm_rinci'      => $this->input->post('nm_rinci'),
			);
		
			$this->db->where('id_rinci', $this->input->post('id_rinci_old'));
			$result_header = $this->db->update('m_kode_rinci', $data_header);
			
		}
		return $result_header;
		

			
	}

    function m_setting($table,$status){
        
       

        $data = array(
            'nm_aplikasi'  => $this->input->post('nm_aplikasi'),
            'singkatan'  => $this->input->post('singkatan'),
            'nm_toko'  => $this->input->post('nm_toko'),
            'alamat'  => $this->input->post('alamat'),
            'no_telp'  => $this->input->post('no_telp'),
            'diskon_member'  => $this->input->post('diskon_member')
        );

   
        $upload = $this->m_master->upload2('logo','logo');

        if ($upload['result'] == 'success') {
            $this->db->set("logo", $upload['file']['file_name'] );
        }
        $result= $this->db->update($table,$data);
        
        return $result;
    }

    function update_status($status,$id,$table,$field){
        if ($status == '1') {
            $ubah = '0';
        }else{
            $ubah = '1';
        }
        $this->db->set("status", $ubah);
        $this->db->where($field, $id);

        return $this->db->update($table);

    }

  
	function m_sales($jenis, $status){
		$data = array(
			'nm_sales' => $_POST["nm_sales"],
			'no_sales' => $_POST["no_hp"],
		);

		if($status == "insert"){
			$result = $this->db->insert($jenis, $data);
		}else{
			$this->db->where("id_sales", $_POST["id_sales"]);
			$result = $this->db->update($jenis, $data);
		}

		return $result;
	}
  

    function  get_romawi($bln){
		switch  ($bln){
			case  1:
			return  "I";
			break;
			case  2:
			return  "II";
			break;
			case  3:
			return  "III";
			break;
			case  4:
			return  "IV";
			break;
			case  5:
			return  "V";
			break;
			case  6:
			return  "VI";
			break;
			case  7:
			return  "VII";
			break;
			case  8:
			return  "VIII";
			break;
			case  9:
			return  "IX";
			break;
			case  10:
			return  "X";
			break;
			case  11:
			return  "XI";
			break;
			case  12:
			return  "XII";
			break;
		}
    }
  

}

?>
