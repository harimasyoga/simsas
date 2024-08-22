<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$data['setting'] = $this->m_master->get_data("m_setting")->row();
	}

	public function index()
	{
		$data = array(
			'judul' => "Dashboard",
			'level' => $this->session->userdata('level'),
		);
		$this->load->view('header',$data );

		if (in_array($this->session->userdata('level'), ['Admin' ,'Owner' ,'Keuangan1' ,'User','Hub']))
		{			
			// $this->load->view('dashboard');
			$this->load->view('home');
		}else{
			$this->load->view('home');
		}

		$this->load->view('footer');
	}

	function Produk()
	{

		$data = array(
			'judul' => "Master Produk",
			'pelanggan' => $this->m_master->get_data("m_pelanggan")->result()
		);

		$this->load->view('header', $data);
		$this->load->view('Master/v_produk', $data);
		$this->load->view('footer');
	}

	function Rek_akun()
	{
		$data = [
			'judul' => "KODE REKENING AKUN",
		];
		$this->load->view('header',$data);
		if(in_array($this->session->userdata('level'), ['Admin','konsul_keu', 'User'])){
			$this->load->view('Master/v_rek_akun');
		}else{
			$this->load->view('home');
		}
		$this->load->view('footer');
	}
	
	function Rek_kelompok()
	{
		$data = [
			'judul' => "KODE REKENING KELOMPOK",
		];
		$this->load->view('header',$data);
		if(in_array($this->session->userdata('level'), ['Admin','konsul_keu', 'User'])){
			$this->load->view('Master/v_rek_kelompok');
		}else{
			$this->load->view('home');
		}
		$this->load->view('footer');
	}
	
	function Rek_jenis()
	{
		$data = [
			'judul' => "KODE REKENING JENIS",
		];
		$this->load->view('header',$data);
		if(in_array($this->session->userdata('level'), ['Admin','konsul_keu', 'User'])){
			$this->load->view('Master/v_rek_jenis');
		}else{
			$this->load->view('home');
		}
		$this->load->view('footer');
	}
	
	function Rek_rinci()
	{
		$data = [
			'judul' => "KODE REKENING RINCI",
		];
		$this->load->view('header',$data);
		if(in_array($this->session->userdata('level'), ['Admin','konsul_keu', 'User'])){
			$this->load->view('Master/v_rek_rinci');
		}else{
			$this->load->view('home');
		}
		$this->load->view('footer');
	}

	function Produk_Laminasi()
	{

		$data = array(
			'judul' => "Master Produk Laminasi",
		);

		$this->load->view('header', $data);
		$this->load->view('Master/v_produk_laminasi', $data);
		$this->load->view('footer');
	}

	function simpanDataLaminasi()
	{
		$result = $this->m_master->simpanDataLaminasi();
		echo json_encode($result);
	}

	function editDataLaminasi()
	{
		$result = $this->m_master->editDataLaminasi();
		echo json_encode($result);
	}

	function Pelanggan()
	{
		$data = array(
			'judul' => "Master Pelanggan"
		);

		$this->load->view('header', $data);
		$this->load->view('Master/v_pelanggan', $data);
		$this->load->view('footer');
	}

	function Penjual()
	{
		$data = array(
			'judul' => "Master Penjual"
		);

		$this->load->view('header', $data);
		$this->load->view('Master/v_penjual', $data);
		$this->load->view('footer');
	}

	function Pelanggan_Laminasi()
	{
		$data = array(
			'judul' => "Master Pelanggan Laminasi"
		);

		$this->load->view('header', $data);
		$this->load->view('Master/v_pelanggan_laminasi', $data);
		$this->load->view('footer');
	}

	function supp()
	{
		$data = array(
			'judul' => "Master Supplier Pembelian"
		);

		$this->load->view('header', $data);
		$this->load->view('Master/v_supp', $data);
		$this->load->view('footer');
	}
	
	function Hub()
	{
		$data = array(
			'judul' => "Master Hub"
		);

		$this->load->view('header', $data);
		$this->load->view('Master/v_hub', $data);
		$this->load->view('footer');
	}

	function Sales()
	{
		$data = array(
			'judul' => "Master Sales"
		);
		$this->load->view('header', $data);
		$this->load->view('Master/v_sales', $data);
		$this->load->view('footer');
	}

	function plhWilayah(){
		$v_prov = $_POST["prov"];
		$v_kab = $_POST["kab"];
		$v_kec = $_POST["kec"];

		if($v_prov == 0 && $v_kab == 0 && $v_kec == 0){
			$prov = $this->db->query("SELECT*FROM m_provinsi")->result();
			$kab = 0;
			$kec = 0;
			$kel = 0;
		}else if($v_prov != 0 && $v_kab == 0 && $v_kec == 0){
			$prov = $this->db->query("SELECT*FROM m_provinsi")->result();
			$kab = $this->db->query("SELECT*FROM m_kab WHERE prov_id='$v_prov'")->result();
			$kec = 0;
			$kel = 0;
		}else if($v_prov != 0 && $v_kab != 0 && $v_kec == 0){
			$prov = $this->db->query("SELECT*FROM m_provinsi")->result();
			$kab = $this->db->query("SELECT*FROM m_kab WHERE prov_id='$v_prov'")->result();
			$kec = $this->db->query("SELECT*FROM m_kec WHERE kab_id='$v_kab'")->result();
			$kel = 0;
		}else if($v_prov != 0 && $v_kab != 0 && $v_kec != 0){
			$prov = $this->db->query("SELECT*FROM m_provinsi")->result();
			$kab = $this->db->query("SELECT*FROM m_kab WHERE prov_id='$v_prov'")->result();
			$kec = $this->db->query("SELECT*FROM m_kec WHERE kab_id='$v_kab'")->result();
			$kel = $this->db->query("SELECT*FROM m_kel WHERE kec_id='$v_kec'")->result();
		}else{
			$prov = 0;
			$kab = 0;
			$kec = 0;
			$kel = 0;
		}

		echo json_encode(array(
			'prov' => $prov,
			'kab' => $kab,
			'kec' => $kec,
			'kel' => $kel,
		));
	}

	function User()
	{
		$data = array(
			'judul' => "Master User"
		);

		$this->load->view('header', $data);
		$this->load->view('Master/v_user', $data);
		$this->load->view('footer');
	}

	function User_level()
	{
		$data = array(
			'judul' => "Master User Level"
		);

		$this->load->view('header', $data);
		$this->load->view('Master/v_user_level', $data);
		$this->load->view('footer');
	}
	
	function User_level_add()
	{
		
		$val_group    = $_GET['val_group'];
		$nama         = $this->db->query("SELECT*FROM m_modul_group a WHERE id_group='$val_group' LIMIT 1 ")->row();
		
		$query = $this->db->query("SELECT *
		FROM m_modul a order by kode")->result();

		$data = array(
			'judul'  => "Edit Modul",
			'judul2' => "$nama->nm_group",
			'id'     => $val_group,
			'query'  => $query
		);
		

		$this->load->view('header', $data);
		$this->load->view('Master/v_user_level_add', $data);
		$this->load->view('footer');
	}

	function load_group()
	{
		if($this->session->userdata('level') == 'PPIC')
		{
			$cek="WHERE id_group in ('7','8','9') ";
		}else{
			$cek="";
		}
		$data = $this->db->query("SELECT * FROM m_modul_group $cek
		ORDER BY nm_group ")->result();
		echo json_encode($data);
	}

	function Sistem()
	{
		$data = array(
			'data' => $this->m_master->get_data("m_setting")->row(),			
			'judul' => "Master Sistem",
		);

		$this->load->view('header',$data);
		$this->load->view('Master/v_setting', $data);
		$this->load->view('footer');
	}

	function Insert()
	{
		$jenis = $this->input->post('jenis');
		$status = $this->input->post('status');
		
		$result = $this->m_master->$jenis($jenis, $status);
		echo json_encode($result);
	}

	function load_data()
	{
		$jenis = $this->uri->segment(3);

		$data = array();

		if ($jenis == "hub") {
			$query = $this->m_master->query("SELECT * FROM m_hub 
			ORDER BY id_hub")->result();
			$i = 1;
			foreach ($query as $r) {
				$row          = array();
				$row[]        = '<div class="text-center"><a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id_hub."'".','."'detail'".')">'.$i."<a></div>";
				$row[]        = $r->pimpinan;
				$row[]        = $r->nm_hub;
				$row[]        = $r->alamat;
				$row[]        = ($r->no_telp == 0) ? '-' : $r->no_telp;

				$id_hub       = $r->id_hub;
				$cekpo    = $this->db->query("SELECT * FROM trs_po WHERE id_hub='$id_hub'")->num_rows();

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','User']))
				{
					$btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="tampil_edit('."'".$r->id_hub."'".','."'edit'".')"><i class="fas fa-pen"></i></button>';

					$btnHapus = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteData('."'".$r->id_hub."'".')"><i class="fas fa-times"></i></button>';

				}else{

					$btnEdit = '';
					$btnHapus = '';
				}
				

				$row[] = ($cekpo == 0) ? $btnEdit.' '.$btnHapus : $btnEdit ;
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "pelanggan") {
			$query = $this->m_master->query("SELECT prov.prov_name,kab.kab_name,kec.kec_name,kel.kel_name,les.nm_sales,pel.* FROM m_pelanggan pel
			LEFT JOIN m_provinsi prov ON pel.prov=prov.prov_id
			LEFT JOIN m_kab kab ON pel.kab=kab.kab_id
			LEFT JOIN m_kec kec ON pel.kec=kec.kec_id
			LEFT JOIN m_kel kel ON pel.kel=kel.kel_id
			LEFT JOIN m_sales les ON pel.id_sales=les.id_sales
			ORDER BY pel.nm_pelanggan")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();
				$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id_pelanggan."'".','."'detail'".')">'.$i."<a></div>";
				$row[] = $r->nm_pelanggan;
				$row[] = $r->attn;
				$row[] = $r->prov_name;
				$row[] = $r->alamat_kirim;
				$row[] = ($r->nm_sales == 0) ? '-' : $r->nm_sales;
				$row[] = ($r->top == "") ? '-' : $r->top;

				$idPelanggan = $r->id_pelanggan;
				$cekProduk = $this->db->query("SELECT * FROM m_produk WHERE no_customer='$idPelanggan'")->num_rows();

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','User']))
				{
					$btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="tampil_edit('."'".$r->id_pelanggan."'".','."'edit'".')"><i class="fas fa-pen"></i></button>';
					$btnHapus = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteData('."'".$r->id_pelanggan."'".')"><i class="fas fa-times"></i></button>';

				}else{

					$btnEdit = '';
					$btnHapus = '';
				}
				

				$row[] = ($cekProduk == 0) ? $btnEdit.' '.$btnHapus : $btnEdit ;
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "penjual") {
			$query = $this->m_master->query("SELECT*FROM m_penjual order by nama")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();
				$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id."'".','."'detail'".')">'.$i."<a></div>";
				$row[] = $r->kode;
				$row[] = $r->nama;
				$row[] = '<div class="text-center">'.$r->no_urut.'</div>';

				$idPelanggan = $r->id;
				$cekProduk = $this->db->query("SELECT * FROM invoice_header_umum WHERE nm_penjual='$idPelanggan'")->num_rows();

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','user']))
				{
					$btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="tampil_edit('."'".$r->id."'".','."'edit'".')"><i class="fas fa-pen"></i></button>';
					$btnHapus = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteData('."'".$r->id."'".')"><i class="fas fa-times"></i></button>';

				}else{

					$btnEdit = '';
					$btnHapus = '';
				}
				

				$row[] = ($cekProduk == 0) ? $btnEdit.' '.$btnHapus : '' ;
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "pelanggan_laminasi") {
			($this->session->userdata('username') == 'usman') ? $where = "WHERE s.id_sales='9' OR s.nm_sales='Usman'" : $where = '';
			$query = $this->m_master->query("SELECT s.nm_sales,lm.* FROM m_pelanggan_lm lm
			LEFT JOIN m_sales s ON lm.id_sales=s.id_sales
			$where
			ORDER BY lm.nm_pelanggan_lm")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();
				$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id_pelanggan_lm."'".','."'detail'".')">'.$i."<a></div>";
				$row[] = $r->nm_pelanggan_lm;
				$row[] = $r->alamat_kirim;
				$row[] = $r->no_telp;
				$row[] = $r->nm_sales;

				$cekPO = $this->db->query("SELECT*FROM trs_po_lm WHERE id_pelanggan='$r->id_pelanggan_lm' GROUP BY id_pelanggan")->num_rows();
				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','User','Laminasi']))
				{
					if($r->id_sales != 9){
						// if($this->session->userdata('username') != 'usman'){
							$btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="tampil_edit('."'".$r->id_pelanggan_lm."'".','."'edit'".')"><i class="fas fa-pen"></i></button>';
							($cekPO == 1) ? $btnHapus = '' : $btnHapus = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteData('."'".$r->id_pelanggan_lm."'".')"><i class="fas fa-times"></i></button>';
						// }else{
						// 	$btnEdit = '-';
						// 	$btnHapus = '';
						// }
					}else{
						$btnEdit = '-';
						$btnHapus = '';
					}
				}else{
					$btnEdit = '-';
					$btnHapus = '';
				}

				$row[] = '<div class="text-center">'.$btnEdit.' '.$btnHapus.'</div>';
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "supp") {
			$query = $this->m_master->query("SELECT*FROM m_supp ORDER BY nm_supp")->result();
			$i = 0;
			foreach ($query as $r) {
 
				$id             = "'$r->id_supp'";
				$i++;
				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<a href="javascript:void(0)" onclick="tampil_edit(' . $id . ','."'detail'".')">'.$r->nm_supp.'<a>';
				$row[] = '<div class="text-center">'.$r->alamat.'</div>';
				$row[] = '<div class="text-center">'.$r->no_telp.'</div>';

				$btnEdit = '<button type="button" class="btn btn-sm btn-warning" onclick="tampil_edit(' . $id . ')"><i class="fas fa-pen"></i></button>';

				// $cekProduk = $this->db->query("SELECT*FROM trs_po_lm_detail WHERE id_m_produk_lm='$r->id_produk_lm' GROUP BY id_m_produk_lm");

				// if($cekProduk->num_rows() == 0){
					$btnHapus = '<button type="button" class="btn btn-sm btn-danger" style="padding:4px 10px" onclick="deleteData(' . $id . ')"><i class="fas fa-times"></i></button>';
				// }else{
				// 	$btnHapus = '';
				// }

				if(in_array($this->session->userdata('level'), ['Admin','konsul_keu', 'Laminasi']))
				{
					$btnAksi = $btnEdit.' '.$btnHapus;
				}else{
					$btnAksi = '';
				}
				$row[] = '<div class="text-center">'.$btnAksi.'</div>';
				$data[] = $row;
				
			}
		} else if ($jenis == "produk_laminasi") {
			($this->session->userdata('username') == 'usman') ? $where = "WHERE jenis_lm='PEKALONGAN'" : $where = '';
			$query = $this->m_master->query("SELECT*FROM m_produk_lm $where ORDER BY nm_produk_lm")->result();
			$i = 0;
			foreach ($query as $r) {
				$i++;
				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				($this->session->userdata('username') != 'usman' && $r->jenis_lm == "PEKALONGAN") ? $ket = ' <span style="font-size:12px;vertical-align:top;font-style:italic">( pkl )</span>' : $ket = '';
				$row[] = '<a href="javascript:void(0)" onclick="editDataLaminasi('."'".$r->id_produk_lm."'".','."'detail'".')">'.$r->nm_produk_lm.$ket.'<a>';
				$row[] = '<div class="text-center">'.$r->ukuran_lm.'</div>';
				$row[] = '<div class="text-right">'.number_format($r->isi_lm,0,',','.').'</div>';
				if($r->jenis_qty_lm == 'pack'){
					$qty = number_format($r->pack_lm,0,',','.').' <span style="font-size:12px;vertical-align:top;font-style:italic">( pack )</span>';
				}else if($r->jenis_qty_lm == 'ikat'){
					if($r->jenis_lm == "PEKALONGAN"){
						$qty = number_format($r->ikat_x,0,',','.').' <span style="font-size:12px;vertical-align:top;font-style:italic">( ikat )</span>';
					}else{
						$qty = number_format($r->ikat_lm,0,',','.').' <span style="font-size:12px;vertical-align:top;font-style:italic">( ikat )</span>';
					}
				}else{
					$qty = round($r->kg_lm,2).' <span style="font-size:12px;vertical-align:top;font-style:italic">( kg )</span>';
				}
				$row[] = '<div class="text-right">'.$qty.'</div>';

				$btnEdit = '<button type="button" class="btn btn-sm btn-warning" onclick="editDataLaminasi('."'".$r->id_produk_lm."'".','."'edit'".')"><i class="fas fa-pen"></i></button>';
				$cekProduk = $this->db->query("SELECT*FROM trs_po_lm_detail WHERE id_m_produk_lm='$r->id_produk_lm' GROUP BY id_m_produk_lm");
				if($cekProduk->num_rows() == 0){
					$btnHapus = '<button type="button" class="btn btn-sm btn-danger" style="padding:4px 10px" onclick="hapusDataLaminasi('."'".$r->id_produk_lm."'".')"><i class="fas fa-times"></i></button>';
				}else{
					$btnHapus = '';
				}

				if(in_array($this->session->userdata('level'), ['Admin','konsul_keu', 'Laminasi'])){
					if($this->session->userdata('username') != 'usman'){
						$btnAksi = $btnEdit.' '.$btnHapus;
					}else{
						$btnAksi = '-';
					}
				}else{
					$btnAksi = '-';
				}

				$row[] = '<div class="text-center">'.$btnAksi.'</div>';
				$data[] = $row;
			}
		} else if ($jenis == "produk") {
			$query = $this->m_master->query("SELECT c.nm_pelanggan,c.attn,p.* FROM m_produk p INNER JOIN m_pelanggan c ON p.no_customer=c.id_pelanggan ORDER BY kategori,nm_produk")->result();
			$i = 1;
			foreach ($query as $r) {
				( $r->kategori =='K_SHEET' ) ? $kategori='SHEET' : $kategori='BOX';
				($r->attn == '-') ? $attn = '' : $attn = ' | '.$r->attn;
				($r->kategori == 'K_BOX') ? $ukuran = $r->ukuran : $ukuran = $r->ukuran_sheet;

				$row = array();
				$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id_produk."'".','."'detail'".')">'.$i."<a></div>";
				$row[] = $r->nm_pelanggan.$attn;
				$row[] = '<div class="text-center">'.$kategori.'</div>';
				$row[] = $r->nm_produk;
				$row[] = $ukuran;
				$row[] = '<div class="text-center">'.$r->flute.'</div>';
				$row[] = $this->m_fungsi->kualitas($r->kualitas, $r->flute);
				$row[] = $r->kode_mc;

				$idProduk = $r->id_produk; 
				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','User']))
				{
					$cekPO = $this->db->query("SELECT * FROM trs_po_detail WHERE id_produk='$idProduk'")->num_rows();

					$btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="tampil_edit('."'".$r->id_produk."'".','."'edit'".')"><i class="fas fa-pen"></i></button>';

					$btnHapus = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteData('."'".$r->id_produk."'".')"><i class="fas fa-times"></i></button>';
				}else{
					$cekPO       = '';
					$btnEdit     = '';
					$btnHapus    = '';
				}

				($cekPO == 0) ? $btnAksi = $btnEdit.' '.$btnHapus : $btnAksi = $btnEdit;
				$row[] = '<div class="text-center">'.$btnAksi.'</div>';
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "sales") {
			$query = $this->m_master->query("SELECT * FROM m_sales ORDER BY nm_sales")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();
				$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id_sales."'".','."'detail'".')">'.$i.'<a></div>';
				$row[] = $r->nm_sales;
				$row[] = $r->no_sales;

				$idSales = $r->id_sales;
				$cekPO = $this->db->query("SELECT COUNT(c.id_sales) AS jmlSales FROM trs_po p INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
				WHERE c.id_sales='$idSales' GROUP BY c.id_sales")->num_rows();
				$cekPOLam = $this->db->query("SELECT COUNT(c.id_sales) AS jmlSales FROM trs_po_lm p INNER JOIN m_pelanggan_lm c ON p.id_pelanggan=c.id_pelanggan_lm
				WHERE c.id_sales='$idSales' GROUP BY c.id_sales")->num_rows();
				$btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="tampil_edit('."'".$r->id_sales."'".','."'edit'".')"><i class="fas fa-pen"></i></button>';
				$btnHapus = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteData('."'".$r->id_sales."'".')"><i class="fas fa-times"></i></button>';
				if($cekPO != 0 && $cekPOLam == 0){
					$btnAksi = $btnEdit;
				}else if($cekPO == 0 && $cekPOLam != 0){
					$btnAksi = $btnEdit;
				}else{
					$btnAksi = $btnEdit.' '.$btnHapus;
				}
				$row[] = '<div class="text-center">'.$btnAksi.'</div>';
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "user") {
			if($this->session->userdata('level') == 'PPIC'){
				$where = "WHERE u.level='Corrugator' OR u.level='Flexo' OR u.level='Finishing'";
			}else{
				$where = "";
			}
			$query = $this->m_master->query("SELECT * FROM tb_user u $where ORDER BY u.id")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();

				$row[] = '<a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->username . "'" . ',' . "'detail'" . ')">' . $r->username . "<a>";
				$row[] = $r->nm_user;
				$row[] = base64_decode($r->password);
				$row[] = $r->level;

				if($this->session->userdata('level') == 'Admin' || $this->session->userdata('level') == 'PPIC'){
					if ($r->level == 'Admin') {
						$aksi = '<a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->username . "'" . ',' . "'edit'" . ')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>
						';
					}else{
						$aksi = '<a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->username . "'" . ',' . "'edit'" . ')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>

						<a href="javascript:void(0)" onclick="deleteData(' . "'" . $r->username . "'" . ')" class="btn btn-danger btn-sm" class="btn btn-danger btn-sm"><i class="fas fa-times"></i>';
					}
				}else{
					$aksi = '-';
				}

				$row[] = $aksi;
				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "user_level") {
			
			$query = $this->m_master->query("SELECT * FROM m_modul_group ORDER BY id_group")->result();
			$i = 1;
			foreach ($query as $r) {
				$row = array();

				$row[] = '<div class="text-center">'.$r->id_group.'</div>';
				$row[] = $r->nm_group;

				$row[] = '<div class="text-center">
				<a href="javascript:void(0)" onclick="tampil_edit(' . "'" . $r->val_group . "'" . ',' . "'edit'" . ')" class="btn btn-warning btn-sm">
				<i class="fas fa-edit"></i>
				</a>

				<a class="btn btn-sm btn-primary" href="'. base_url("Master/User_level_add?val_group=" . $r->id_group . "") .'" title="EDIT MENU" ><b>
				<i class="fas fa-search"></i> MENU</b></a>

				</div>
				';

				$data[] = $row;
				$i++;
			}
		} else if ($jenis == "load_kd_akun") {
			$query = $this->db->query("SELECT * FROM m_kode_akun ORDER BY id_akun ")->result();

			$i               = 1;
			foreach ($query as $r) {

				$cek_data = $this->db->query("SELECT*FROM m_kode_kelompok where kd_akun='$r->kd_akun' ")->num_rows();

				$id         = "'$r->id_akun'";
				$kd_akun    = "'$r->kd_akun'";
				$nm_akun    = "'$r->nm_akun'";
				
				$row = array();
				$row[] = '<div class="text-center">'.$r->kd_akun.'</div>';
				$row[] = $r->nm_akun;
				$row[] = '<div class="text-center">'.$r->jenis.'</div>';
				$row[] = '<div class="text-center">'.$r->dk.'</div>';

				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','User']))
				{
					if($cek_data>0)
					{
						$aksi = '
						<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $nm_akun . ')" title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 

						';
					}else{
						$aksi = '
						<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $nm_akun . ')" title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 

						<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $nm_akun . ')" class="btn btn-danger btn-sm">
							<i class="fa fa-trash-alt"></i>
						</button> 
						';
					}
					
			
				} else {
					$aksi = '';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "load_kd_kelompok") {
			$query = $this->db->query("SELECT a.*,b.* FROM m_kode_kelompok a 
			join m_kode_akun b ON a.kd_akun=b.kd_akun 
			ORDER BY a.kd_akun ,a.id_kelompok ")->result();

			$i               = 1;
			foreach ($query as $r) {

				
				$cek_data = $this->db->query("SELECT*FROM m_kode_jenis where kd_akun='$r->kd_akun' and kd_kelompok='$r->kd_kelompok' ")->num_rows();

				$id             = "'$r->id_kelompok'";
				$kd_kelompok    = "'$r->kd_kelompok'";
				$nm_kelompok    = "'$r->nm_kelompok'";
				
				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="">'.$r->nm_akun.'</div>';
				$row[] = '<div class="text-center">'.$r->id_akun.'.'.$r->kd_kelompok.'</div>';
				$row[] = $r->nm_kelompok;
				$row[] = '<div class="text-center">'.$r->jenis.'</div>';
				$row[] = '<div class="text-center">'.$r->dk.'</div>';

				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','User']))
				{
					if($cek_data>0)
					{
						$aksi = '
						<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $nm_kelompok . ')" title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 
						';
					}else{
						$aksi = '
						<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $nm_kelompok . ')" title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 

						<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $nm_kelompok . ')" class="btn btn-danger btn-sm">
							<i class="fa fa-trash-alt"></i>
						</button> 
						';
					}
			
				} else {
					$aksi = '';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "load_kd_kelompok_list") {
			$query = $this->db->query("SELECT a.*,b.* FROM m_kode_kelompok a 
			join m_kode_akun b ON a.kd_akun=b.kd_akun 
			ORDER BY a.kd_akun ,a.id_kelompok ")->result();

			$i               = 1;
			foreach ($query as $r) {

				$id_akun             = "'$r->id_akun'";
				$nm_akun        = "'$r->nm_akun'";
				$kd_kelompok    = "'$r->kd_kelompok'";
				$nm_kelompok    = "'$r->nm_kelompok'";
				
				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="">'.$r->nm_akun.'</div>';
				$row[] = '<div class="text-center">'.$r->id_akun.'.'.$r->kd_kelompok.'</div>';
				$row[] = $r->nm_kelompok;

				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','User']))
				{
					
					$aksi = '
					<button type="button" title="PILIH"  onclick="add_timb(' . $id_akun . ',' . $nm_akun . ',' . $kd_kelompok . ',' . $nm_kelompok . ')" class="btn btn-success btn-sm">
						<i class="fas fa-check-circle"></i>
					</button> ';
			
				} else {
					$aksi = '';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "load_kd_jenis") {
			$query = $this->db->query("SELECT * FROM m_kode_jenis a
			join m_kode_akun b on a.kd_akun=b.kd_akun
			join m_kode_kelompok c on a.kd_akun=c.kd_akun and a.kd_kelompok=c.kd_kelompok
			ORDER BY id_jenis ")->result();

			$i               = 1;
			foreach ($query as $r) {

				
				$cek_data = $this->db->query("SELECT*FROM m_kode_rinci where kd_akun='$r->kd_akun' and kd_kelompok='$r->kd_kelompok' and kd_jenis='$r->kd_jenis' ")->num_rows();


				$id         = "'$r->id_jenis'";
				$kd_jenis   = "'$r->kd_jenis'";
				$nm_jenis   = "'$r->nm_jenis'";
				
				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="">'.$r->nm_akun.'</div>';
				$row[] = '<div class="">'.$r->nm_kelompok.'</div>';
				$row[] = '<div class="text-center">'.$r->kd_akun.'.'.$r->kd_kelompok.'.'.$r->kd_jenis.'</div>';
				$row[] = '<div class="text-center">'.$r->nm_jenis.'</div>';
				$row[] = '<div class="text-center">'.$r->jenis.'</div>';
				$row[] = '<div class="text-center">'.$r->dk.'</div>';

				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','User']))
				{
					if($cek_data>0)
					{
						$aksi = '
						<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $kd_jenis . ')" title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 
						';
					}else{

						$aksi = '
						<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $kd_jenis . ')" title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 

						<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $kd_jenis . ')" class="btn btn-danger btn-sm">
							<i class="fa fa-trash-alt"></i>
						</button> 
						';
					}
					
			
				} else {
					$aksi = '';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "load_kd_rinci") {
			$query = $this->db->query("SELECT * FROM m_kode_rinci a
			join m_kode_akun b on a.kd_akun=b.kd_akun
			join m_kode_kelompok c on a.kd_akun=c.kd_akun and a.kd_kelompok=c.kd_kelompok
			join m_kode_jenis d on a.kd_akun=d.kd_akun and a.kd_kelompok=d.kd_kelompok and a.kd_jenis=d.kd_jenis
			ORDER BY id_rinci")->result();

			$i               = 1;
			foreach ($query as $r) {

				$id         = "'$r->id_rinci'";
				$kd_rinci   = "'$r->kd_rinci'";
				$nm_rinci   = "'$r->nm_rinci'";
				
				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="">'.$r->nm_akun.'</div>';
				$row[] = '<div class="">'.$r->nm_kelompok.'</div>';
				$row[] = '<div class="text-center">'.$r->nm_jenis.'</div>';
				$row[] = '<div class="text-center">'.$r->kd_akun.'.'.$r->kd_kelompok.'.'.$r->kd_jenis.'.'.$r->kd_rinci.'</div>';
				$row[] = '<div class="text-center">'.$r->nm_rinci.'</div>';
				$row[] = '<div class="text-center">'.$r->jenis.'</div>';
				$row[] = '<div class="text-center">'.$r->dk.'</div>';

				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','User']))
				{
					$aksi = '
						<a class="btn btn-sm btn-warning" onclick="edit_data(' . $id . ',' . $kd_rinci . ')" title="EDIT DATA" >
							<b><i class="fa fa-edit"></i> </b>
						</a> 

						<button type="button" title="DELETE"  onclick="deleteData(' . $id . ',' . $nm_rinci . ')" class="btn btn-danger btn-sm">
							<i class="fa fa-trash-alt"></i>
						</button> 
						';
			
				} else {
					$aksi = '';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;

				$i++;
			}
		} else if ($jenis == "load_kd_jenis_list") {
			$query = $this->db->query("SELECT * FROM m_kode_jenis a
			join m_kode_akun b on a.kd_akun=b.kd_akun
			join m_kode_kelompok c on a.kd_akun=c.kd_akun and a.kd_kelompok=c.kd_kelompok
			ORDER BY id_jenis ")->result();

			$i               = 1;
			foreach ($query as $r) {

				$kd_akun        = "'$r->kd_akun'";
				$nm_akun        = "'$r->nm_akun'";
				$kd_kelompok    = "'$r->kd_kelompok'";
				$nm_kelompok    = "'$r->nm_kelompok'";
				$kd_jenis       = "'$r->kd_jenis'";
				$nm_jenis       = "'$r->nm_jenis'";
				
				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="">'.$r->nm_akun.'</div>';
				$row[] = '<div class="">'.$r->nm_kelompok.'</div>';
				$row[] = '<div class="text-center">'.$r->kd_akun.'.'.$r->kd_kelompok.'.'.$r->kd_jenis.'</div>';
				$row[] = '<div class="">'.$r->nm_jenis.'</div>';

				$aksi = "";

				if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','User']))
				{
					
					$aksi = '
					<button type="button" title="PILIH"  onclick="add_timb(' . $kd_akun . ',' . $nm_akun . ',' . $kd_kelompok . ',' . $nm_kelompok . ',' . $kd_jenis . ',' . $nm_jenis . ')" class="btn btn-success btn-sm">
						<i class="fas fa-check-circle"></i>
					</button> ';
			
				} else {
					$aksi = '';
				}
				$row[] = '<div class="text-center">'.$aksi.'</div>';
				$data[] = $row;

				$i++;
			}
		}else{
		}



		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function load_akun($searchTerm="")
	{
		// ASLI

		$query = $this->db->query("SELECT * FROM m_kode_akun ORDER BY id_akun")->result();

		if (!$query) {
			$response = [
				'message'	=> 'not found',
				'data'		=> [],
				'status'	=> false,
			];
		}else{
			$response = [
				'message'	=> 'Success',
				'data'		=> $query,
				'status'	=> true,
			];
		}
		$json = json_encode($response);
		print_r($json);
    }

	function Insert_kode_akun()
	{
		if($this->session->userdata('username'))
		{
			$asc         = $this->m_master->save_akun();	
			if($asc){	
				echo json_encode(array("status" =>"1","id" => $asc));	
			}else{
				echo json_encode(array("status" => "2","id" => $asc));	
			}
		}		
	}
	
	function Insert_kode_kelompok()
	{
		if($this->session->userdata('username'))
		{
			$status_input    = $this->input->post('sts_input');
			$id_kelompok     = $this->input->post('id_kelompok');
			$kd_kelompok_old = $this->input->post('kd_kelompok_old');
			$kd_akun         = $this->input->post('kd_akun');
			$kd_kel          = str_pad($this->input->post('kd_kelompok'), 2, "0", STR_PAD_LEFT);

			$cek = $this->db->query("SELECT*FROM m_kode_kelompok where kd_akun ='$kd_akun' and kd_kelompok='$kd_kel' ");

			if($cek->num_rows()>0 && $status_input=='add')
			{
				echo json_encode(array("status" =>"3","id" => $cek));	
			}else{

				if($status_input=='edit' && $cek->num_rows()>0 && $kd_kelompok_old != $kd_kel)
				{
					echo json_encode(array("status" =>"3","id" => $cek));	
				}else{
					$asc         = $this->m_master->save_kelompok();	
					if($asc){	
						echo json_encode(array("status" =>"1","id" => $asc));	
					}else{
						echo json_encode(array("status" => "2","id" => $asc));	
					}

				}
				

			}
			
		}		
	}

	function Insert_kode_jenis()
	{
		if($this->session->userdata('username'))
		{
			$asc         = $this->m_master->save_jenis();	
			if($asc){	
				echo json_encode(array("status" =>"1","id" => $asc));	
			}else{
				echo json_encode(array("status" => "2","id" => $asc));	
			}
		}		
	}
	
	function Insert_kode_rinci()
	{
		if($this->session->userdata('username'))
		{
			$asc         = $this->m_master->save_rinci();	
			if($asc){	
				echo json_encode(array("status" =>"1","id" => $asc));	
			}else{
				echo json_encode(array("status" => "2","id" => $asc));	
			}
		}		
	}

	function load_data_1()
	{
		$id       = $this->input->post('id');
		$tbl      = $this->input->post('tbl');
		$jenis    = $this->input->post('jenis');
		$field    = $this->input->post('field');

		if($jenis=='kode_akun')
		{
			$queryd   = "SELECT*FROM $tbl where $field='$id' ";
			$queryh   = "SELECT*FROM $tbl where $field='$id' ";

		}else if($jenis=='kode_jenis')
		{
			$queryd   = "SELECT*FROM $tbl where $field='$id' ";
			$queryh   = "SELECT * FROM m_kode_jenis a
			join m_kode_akun b on a.kd_akun=b.kd_akun
			join m_kode_kelompok c on a.kd_akun=c.kd_akun and a.kd_kelompok=c.kd_kelompok where $field='$id' 
			ORDER BY id_jenis ";

		}else if($jenis=='kode_rinci')
		{
			$queryd   = "SELECT*FROM $tbl where $field='$id' ";
			$queryh   = "SELECT * FROM m_kode_rinci a
			join m_kode_akun b on a.kd_akun=b.kd_akun
			join m_kode_kelompok c on a.kd_akun=c.kd_akun and a.kd_kelompok=c.kd_kelompok
			join m_kode_jenis d on a.kd_akun=d.kd_akun and a.kd_kelompok=d.kd_kelompok and a.kd_jenis=d.kd_jenis
			where $field='$id'
			ORDER BY id_rinci";

		}else{

			$queryd   = "SELECT*FROM $tbl where $field='$id' ";
			$queryh   = "SELECT*FROM $tbl where $field='$id' ";
		}
		

		$header   = $this->db->query($queryh)->row();
		$detail    = $this->db->query($queryd)->result();

		$data = ["header" => $header, "detail" => $detail];

        echo json_encode($data);
	}

	function hapus()
	{
		$jenis    = $_POST['jenis'];
		$field    = $_POST['field'];
		$id       = $_POST['id'];

		$result = $this->m_master->query("DELETE FROM $jenis WHERE  $field = '$id'");

		echo json_encode($result);
	}


	function get_edit()
	{
		$id    = $this->input->post('id');
		$jenis    = $this->input->post('jenis');
		$field    = $this->input->post('field');

		$data =  $this->m_master->get_data_one($jenis, $field, $id)->row();
		echo json_encode($data);
	}

	function getPlhCustomer()
	{
		$data = $this->db->query("SELECT s.nm_sales,p.* FROM m_pelanggan p
		LEFT JOIN m_sales s ON p.id_sales=s.id_sales
		ORDER BY p.nm_pelanggan")->result();
		echo json_encode($data);
	}

	function getPlhSales()
	{
		($this->session->userdata('username') == 'usman') ? $where = "WHERE id_sales='9' OR nm_sales='Usman'" : $where = '';
		$data = $this->db->query("SELECT*FROM m_sales $where ORDER BY nm_sales")->result();
		echo json_encode($data);
	}

	function getEditProduk()
	{
		$id = $_POST["id"];
		$data = $this->db->query("SELECT s.nm_sales,c.nm_pelanggan AS customer,c.kode_unik,p.* FROM m_produk p
		INNER JOIN m_pelanggan c ON p.no_customer=c.id_pelanggan
		LEFT JOIN m_sales s ON c.id_sales=s.id_sales
		WHERE p.id_produk='$id'")->row();
		$pelanggan = $this->db->query("SELECT*FROM m_pelanggan pel
		LEFT JOIN m_provinsi prov ON pel.prov=prov.prov_id
		LEFT JOIN m_kab kab ON pel.kab=kab.kab_id
		LEFT JOIN m_kec kec ON pel.kec=kec.kec_id
		LEFT JOIN m_kel kel ON pel.kel=kel.kel_id
		LEFT JOIN m_sales sal ON pel.id_sales=sal.id_sales
		ORDER BY id_pelanggan")->result();
		$id_pelanggan = $data->no_customer;
		// $wilayah = $this->db->query("SELECT prov.prov_name,kab.kab_name,kec.kec_name,kel.kel_name,pel.* FROM m_pelanggan pel
		// LEFT JOIN m_provinsi prov ON pel.prov=prov.prov_id
		// LEFT JOIN m_kab kab ON pel.kab=kab.kab_id
		// LEFT JOIN m_kec kec ON pel.kec=kec.kec_id
		// LEFT JOIN m_kel kel ON pel.kel=kel.kel_id
		// WHERE pel.id_pelanggan='$id_pelanggan'")->row();
		$id_produk = $data->id_produk;
		$poDetail = $this->db->query("SELECT*FROM trs_po_detail WHERE id_produk='$id_produk'")->result();
		echo json_encode(array(
			'produk' => $data,
			'pelanggan' => $pelanggan,
			// 'wilayah' => $wilayah,
			'poDetail' => $poDetail,
		));
	}

	function buatKodeMC(){
		$result = $this->m_master->buatKodeMC();
		echo json_encode($result);
	}

	function edit_hub()
	{
		$id = $_POST["id"];
		$data =  $this->db->query("SELECT * FROM m_hub WHERE id_hub='$id'")->row();

		$cekPO = $this->db->query("SELECT * FROM trs_po WHERE id_hub='$id'")->num_rows();
		echo json_encode(array(
			'hub' => $data,
			'cek_po' => $cekPO,
		));
	}

	function rekap_omset_hub()
	{
		$html   = '';

		$th_hub = $this->input->post('th_hub');
		if($th_hub){
			$tahun  = $th_hub;
		}else{
			$tahun  = date('Y');
		}

		$level   = $this->session->userdata('level');
		$nm_user = $this->session->userdata('nm_user');

		if($level =='Hub')
		{
			$cek     = $this->db->query("SELECT*FROM m_hub where nm_hub='$nm_user' ")->row();
			$cek_data = "WHERE a.id_hub in ('$cek->id_hub')";
		}else{

			$cek_data = '';
		}
		
		$query  = $this->db->query("SELECT a.*,IFNULL(
		(
		select jum from(
		select id_hub,nm_hub,sum(jum) jum from (select b.id_hub,d.nm_hub,c.qty*price_inc as jum 
		from trs_po b 
		JOIN trs_po_detail c ON b.no_po=c.no_po 
		JOIN m_hub d on b.id_hub=d.id_hub
		where YEAR(b.tgl_po) in ('$tahun') 
		union all
		SELECT po.id_hub,hub.nm_hub,dtl.order_pori_lm*dtl.harga_pori_lm as jum
		FROM trs_po_lm po
		INNER JOIN trs_po_lm_detail dtl ON po.no_po_lm=dtl.no_po_lm
		LEFT JOIN m_hub hub ON hub.id_hub=po.id_hub
		WHERE (po.id_hub!='0') and po.jenis_lm='PPI' and YEAR(po.tgl_lm) in ('$tahun') 
		)p group by p.id_hub,p.nm_hub
		)q where q.id_hub=a.id_hub
		),0) total_hub 
		FROM m_hub a $cek_data
		order by id_hub 
		
		")->result();

		$html .='<div style="font-weight:bold">';
		$html .='<table class="table table-bordered table-striped">
		<thead class="color-tabel">
			<tr>
				<th style="text-align:center">NO</th>
				<th style="text-align:center">Nama HUB</th>
				<th style="text-align:center">JENIS</th>
				<th style="text-align:center">OMSET</th>
				<th style="text-align:center">SISA PLAFON</th>
				<th style="text-align:center">TAHUN</th>
			</tr>
		</thead>';
		$i            = 0;
		$total        = 0;
		$total_rata   = 0;
		$sisa_hub     = 0;
		if($query)
		{
			foreach($query as $r){
				$i++;
				$html .= '</tr>
					<td style="text-align:center">'.$i.'</td>
					<td style="text-align:left">'.$r->nm_hub.'</td>
					<td style="text-align:left">'.$r->jns.'</td>
					<td style="text-align:right">'.number_format($r->total_hub, 0, ",", ".").'</td>
					<td style="text-align:right">'.number_format(4800000000-$r->total_hub, 0, ",", ".").'</td>
					<td style="text-align:right">'.$tahun.'</td>
				</tr>';
				$total    += $r->total_hub;
				$sisa_hub += 4800000000-$r->total_hub;
			}
			
			$html .='<tr>
					<th style="text-align:center" colspan="2" >Total</th>
					<th style="text-align:right">'.number_format($total, 0, ",", ".").'</th>
					<th style="text-align:right">'.number_format($sisa_hub, 0, ",", ".").'</th>
					<th style="text-align:right"></th>
				</tr>
				';
			
			$html .='</table>
			</div>';
		}else{
			$html .='<tr>
				<th style="text-align:center" colspan="4" >Data Kosong</th>
			</tr>
			';
		
		$html .='</table>
		</div>';
		}

		echo $html;
		
	}

	function rekap_jt_bhn()
	{
		$priode       = $_POST['priode'];
		$attn         = $_POST['id_hub'];
		$tgl_awal     = $_POST['tgl_awal'];
		$tgl_akhir    = $_POST['tgl_akhir'];

		if($attn=='' || $attn== null || $attn== 'null')
		{
			if($priode=='all')
			{
				$value="";
			}else{
				$value="where a.tgl_j_tempo BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
			}

		}else{
			if($priode=='all')
			{
				$value="where b.id_hub='$attn' ";
			}else{
				$value="where b.id_hub='$attn' and a.tgl_j_tempo BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
			}

		}

		$data = array();

		$query = $this->m_master->query("SELECT*from trs_h_stok_bb a
		JOIN trs_d_stok_bb b on a.no_stok=b.no_stok
		JOIN m_hub c ON b.id_hub=c.id_hub
		JOIN trs_po_bhnbk d ON b.no_po_bhn = d.no_po_bhn
		$value
		order by tgl_j_tempo,a.no_stok ")->result();
	
		
		$i = 1;

		foreach ($query as $r) {
			$row = array();
			$row[] = "<div class='text-center'>".$i."</div>";
			$row[] = $r->no_stok;
			$row[] = "<div class='text-center'>".$r->tgl_stok."</div>";
			$row[] = "<div class='text-center'>".$r->tgl_j_tempo."</div>";
			$row[] = $r->nm_hub;
			$row[] = "Rp ".number_format($r->hrg_bhn,0,',','.');
			$row[] = number_format($r->datang_bhn_bk,0,',','.')." Kg";
			$row[] = "<div style='font-weight:bold;' class='text-right'> Rp ".number_format($r->hrg_bhn*$r->datang_bhn_bk,0,',','.')."</div>";

			// $idSales = $r->id;
			// $cekPO = $this->db->query("SELECT COUNT(c.id_sales) AS jmlSales FROM trs_po p INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
			// WHERE c.id_sales='$idSales' GROUP BY c.id_sales")->num_rows();
			$btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="tampil_edit('."'".$r->no_stok."'".','."'edit'".')"><i class="fas fa-pen"></i></button>';
			// $row[] = ($cekPO == 0) ? $btnEdit.' '.$btnHapus : $btnEdit;
			// $row[] = $btnEdit;
			$data[] = $row;
			$i++;
		}
		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	function rekap_all_jt_bahan()
	{
		$priode       = $_POST['priode'];
		$attn         = $_POST['id_hub'];
		$tgl_awal     = $_POST['tgl_awal'];
		$tgl_akhir    = $_POST['tgl_akhir'];

		if($attn=='' || $attn== null || $attn== 'null')
		{
			if($priode=='all')
			{
				$value="";
			}else{
				$value="where a.tgl_j_tempo BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
			}

		}else{
			if($priode=='all')
			{
				$value="where b.id_hub='$attn' ";
			}else{
				$value="where b.id_hub='$attn' and a.tgl_j_tempo BETWEEN  '$tgl_awal' and  '$tgl_akhir'";
			}

		}
		$rekap_jumlah = $this->m_master->query("SELECT IFNULL(sum(hrg_bhn*datang_bhn_bk),0)jumlah from trs_h_stok_bb a
				JOIN trs_d_stok_bb b on a.no_stok=b.no_stok
				JOIN m_hub c ON b.id_hub=c.id_hub
				JOIN trs_po_bhnbk d ON b.no_po_bhn = d.no_po_bhn
				$value
				order by tgl_j_tempo,a.no_stok ")->row();

		$data     = ["rekap_jumlah" => $rekap_jumlah];

        echo json_encode($data);
	}
	
	function rekap_jt()
	{
		$jenis = $this->uri->segment(3);

		$data = array();
		$query = $this->m_master->query("SELECT*FROM invoice_header a 
		join invoice_detail b ON a.no_invoice=b.no_invoice
		ORDER BY tgl_jatuh_tempo desc,a.no_invoice")->result();
		$i = 1;

		foreach ($query as $r) {
			$row = array();
			$row[] = '<div class="text-center"><a href="javascript:void(0)" onclick="tampil_edit('."'".$r->id."'".','."'detail'".')">'.$i."<a></div>";
			$row[] = $r->nm_perusahaan;
			$row[] = $r->no_invoice;
			$row[] = $r->no_surat;
			$row[] = $r->no_po;
			$row[] = $this->m_fungsi->tanggal_ind($r->tgl_jatuh_tempo);

			// $idSales = $r->id;
			// $cekPO = $this->db->query("SELECT COUNT(c.id_sales) AS jmlSales FROM trs_po p INNER JOIN m_pelanggan c ON p.id_pelanggan=c.id_pelanggan
			// WHERE c.id_sales='$idSales' GROUP BY c.id_sales")->num_rows();
			$btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="tampil_edit('."'".$r->id."'".','."'edit'".')"><i class="fas fa-pen"></i></button>';
			// $row[] = ($cekPO == 0) ? $btnEdit.' '.$btnHapus : $btnEdit;
			$row[] = $btnEdit;
			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function rekap_bhn()
	{
		$vall = $this->uri->segment(3);
		if($vall=='po')
		{
			$value='KELUAR DENGAN PO';
		}else{
			$value='KELUAR DENGAN INV';

		}

		$data = array();
		$query = $this->m_master->query("SELECT*FROM (
		SELECT 
		(select sum(masuk)masuk from trs_stok_bahanbaku b where b.jenis='PPI' group by jenis)masuk,
		(select sum(keluar)keluar from trs_stok_bahanbaku b where b.jenis='PPI' group by jenis)keluar,
		(select sum(masuk-keluar)stok_akhir from trs_stok_bahanbaku b where b.jenis='PPI' group by jenis)stok_akhir,
		'0' as id_hub, 'PPI' as pimpinan, 'PPI' as nm_hub, 'PPI' as aka, ''nm_bank,''no_rek,'-' as alamat, '-' as kode_pos, '-' as no_telp, '-' as fax, '-' as add_time, '-' as add_user, '-' as edit_time, '-' as edit_user,'' as jns FROM m_hub e limit 1) as ppi

		UNION ALL

		SELECT 
		(select sum(masuk)masuk from trs_stok_bahanbaku b where a.id_hub=b.id_hub group by id_hub)masuk,
		(select sum(keluar)keluar from trs_stok_bahanbaku c where a.id_hub=c.id_hub and ket='$value' group by id_hub)keluar,
		(select sum(masuk-(case when d.ket='$value' then keluar else 0 end) )stok_akhir from trs_stok_bahanbaku d where a.id_hub=d.id_hub group by id_hub)stok_akhir,
		a.* FROM m_hub a
		
		")->result();

		$i = 1;
		foreach ($query as $r) {
			$row = array();
			$row[] = '<div class="text-center" style="font-weight:bold">'.$i.'</div>';
			$row[] = '<div style="font-weight:bold">'.$r->nm_hub.'</div>';

			$row[] = '<div class="text-right" style="font-weight:bold">
			<a href="javascript:void(0)" onclick="tampil_data('."'".$r->id_hub."'".','."'masuk'".')">'.number_format($r->masuk,0,',','.').' ( Kg )</a>
			</div>';

			$row[] = '<div class="text-right" style="font-weight:bold">
			<a href="javascript:void(0)" onclick="tampil_data('."'".$r->id_hub."'".','."'keluar'".')">'.number_format($r->keluar,0,',','.').' ( Kg )</a>
			</div>';

			$row[] = '<div class="text-right" style="font-weight:bold">
			<a href="javascript:void(0)" onclick="tampil_data('."'".$r->id_hub."'".','."'stok_akhir'".')">'.number_format($r->stok_akhir,0,',','.').' ( Kg )</a>
			</div>';

			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	function rekap_bhn_rinci()
	{		
		$id_hub   = $this->input->post('id_hub');
		$ket      = $this->input->post('ket');
		$status   = $this->input->post('status');

		if($status=='keluar')
		{
			if($ket=='po')
			{
				$value="and ket='KELUAR DENGAN PO'";
			}else{
				$value="and ket='KELUAR DENGAN INV'";
			}			
		}else{
			if($ket=='po')
			{
				$value="and ket='MASUK DENGAN PO'";
			}else{
				$value="and ket='MASUK DENGAN INV'";
			}		
		}
		
		if($id_hub=='0')
		{
			$where ="where status = '$status' $value and id_hub is null ";
		}else{
			$where ="where status = '$status' $value and id_hub='$id_hub' ";

		}
		$query    = $this->m_master->query("SELECT*from trs_stok_bahanbaku $where")->result();

		$data     = array();
		$i        = 1;
		foreach ($query as $r) {

			if($ket=='masuk')
			{
				$value = $r->masuk;

			}else if($ket=='keluar'){

				$value = $r->keluar;
			}else{
				$value = $r->masuk - $r->keluar;
			}
			$row = array();
			$row[] = '<div class="text-center" style="font-weight:bold">'.$i.'</div>';
			$row[] = '<div class="text-center" style="font-weight:bold">'.$r->no_transaksi.'</div>';
			$row[] = '<div class="text-center" style="font-weight:bold">'.$this->m_fungsi->tanggal_ind($r->tgl_input).'</div>';
			$row[] = '<div class="text-center" style="font-weight:bold">'.$r->jam_input.'</div>';
			$row[] = '<div class="text-center" style="font-weight:bold">'.number_format($value,0,',','.').'</div>';
			$row[] = '<div style="font-weight:bold">'.$r->ket.'</div>';
			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function cek_produk()
	{
		$jenis = $this->uri->segment(3);

		$data = array();
		$query = $this->m_master->query("SELECT a.id_pelanggan,c.nm_pelanggan,a.kode_po,b.id_produk,d.nm_produk FROM trs_po a 
		join trs_po_detail b on a.kode_po=b.kode_po
		join m_pelanggan c on a.id_pelanggan=c.id_pelanggan
		join m_produk d on b.id_produk=d.id_produk
		where a.kode_po in (select no from tbl_bantuan) and c.nm_pelanggan not like '%PT. DELTA%' and c.nm_pelanggan not like '%PT. DUNIA%'
		group by a.id_pelanggan,c.nm_pelanggan,a.kode_po,b.id_produk,d.nm_produk
		order by c.nm_pelanggan,a.kode_po,b.id_produk,d.nm_produk
		")->result();

		$i = 1;
		foreach ($query as $r) {
			$row = array();
			$row[] = '<div class="text-center" style="font-weight:bold">'.$i.'</div>';
			$row[] = $r->id_pelanggan;
			$row[] = $r->nm_pelanggan;
			$row[] = $r->kode_po;
			$row[] = $r->id_produk;
			$row[] = $r->nm_produk;

			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	function getEditPelanggan()
	{
		$id = $_POST["id"];
		$data =  $this->db->query("SELECT s.nm_sales,p.* FROM m_pelanggan p
		INNER JOIN m_sales s ON p.id_sales=s.id_sales
		WHERE p.id_pelanggan='$id'")->row();
		$prov = $this->db->query("SELECT*FROM m_provinsi")->result();
		$sales = $this->db->query("SELECT*FROM m_sales ORDER BY nm_sales")->result();
		$wilayah = $this->db->query("SELECT prov.prov_name,kab.kab_name,kec.kec_name,kel.kel_name,pel.* FROM m_pelanggan pel
		LEFT JOIN m_provinsi prov ON pel.prov=prov.prov_id
		LEFT JOIN m_kab kab ON pel.kab=kab.kab_id
		LEFT JOIN m_kec kec ON pel.kec=kec.kec_id
		LEFT JOIN m_kel kel ON pel.kel=kel.kel_id
		WHERE pel.id_pelanggan='$id'")->row();
		$cekPO = $this->db->query("SELECT p.id_pelanggan FROM m_pelanggan p
		INNER JOIN trs_po o ON p.id_pelanggan=o.id_pelanggan
		WHERE p.id_pelanggan='$id'
		GROUP BY p.id_pelanggan")->num_rows();
		echo json_encode(array(
			'pelanggan' => $data,
			'prov' => $prov,
			'sales' => $sales,
			'wilayah' => $wilayah,
			'cek_po' => $cekPO,
		));
	}
	
	function getEditpenjual()
	{
		$id = $_POST["id"];

		$data =  $this->db->query("SELECT*FROM m_penjual
		WHERE id='$id'")->row();

		echo json_encode(array(
			'penjual' => $data,
		));
	}

	function getEditPelangganLM()
	{
		$id = $_POST["id"];
		$data =  $this->db->query("SELECT*FROM m_pelanggan_lm WHERE id_pelanggan_lm='$id'")->row();
		$cekPO = $this->db->query("SELECT*FROM trs_po_lm WHERE id_pelanggan='$id' GROUP BY id_pelanggan")->num_rows();
		echo json_encode(array(
			'pelanggan' => $data,
			'cekPO' => $cekPO,
		));
	}
	
	function edit_m_supp()
	{
		$id = $_POST["id"];
		$data =  $this->db->query("SELECT*FROM m_supp where id_supp='$id' ORDER BY nm_supp")->row();
		// $cekPO = $this->db->query("SELECT*FROM trs_po_lm WHERE id_pelanggan='$id' GROUP BY id_pelanggan")->num_rows();
		echo json_encode(array(
			'supp' => $data,
			// 'cekPO' => $cekPO,
		));
	}
}
