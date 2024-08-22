<?php
class M_laporan extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->username = $this->session->userdata('username');
	}

	function get_periode()
	{
		$query = $this->db->query("SELECT DATE_FORMAT(tgl,'%Y-%m') periode FROM tr_absensi GROUP BY DATE_FORMAT(tgl,'%Y-%m') ORDER BY periode DESC");
		return $query;
	}

	function get_produk($searchTerm = "", $jenis)
	{
		if ($jenis == "Produk") {
			$table = "m_produk";
			$id = "id_produk";
			$text = "nm_produk";
		} else {
			$table = "m_perawatan";
			$id = "id_perawatan";
			$text = "nm_perawatan";
		}
		$users = $this->db->query("SELECT * FROM $table where $text like '%$searchTerm%' ")->result_array();
		$data = array();
		array_push(
			$data,
			['id' => "-", 'text' => "Semua"]
		);
		foreach ($users as $user) {
			$data[] = array(
				"id" => $user[$id],
				"text" => $user[$text]
			);
		}
		return $data;
	}

	function addReturKiriman()
	{
		$h_tot_muat = $_POST["h_tot_muat"];
		$h_tgl = $_POST["h_tgl"];
		$h_id_pelanggan = $_POST["h_id_pelanggan"];
		$h_id_produk = $_POST["h_id_produk"];
		$h_kode_po = $_POST["h_kode_po"];
		$h_urut = $_POST["h_urut"];
		$h_no_surat = $_POST["h_no_surat"];
		$h_plat = $_POST["h_plat"];
		$rtr_tgl = $_POST["rtr_tgl"];
		$rtr_ket = $_POST["rtr_ket"];
		$rtr_jumlah = $_POST["rtr_jumlah"];

		if($rtr_tgl == ""){
			$data = false;
			$msg = "TANGGAL TIDAK BOLEH KOSONG!";
		}else if($rtr_ket == ""){
			$data = false;
			$msg = "KETERANGAN TIDAK BOLEH KOSONG!";
		}else if($rtr_jumlah == "" || $rtr_jumlah < 0 || $rtr_jumlah == 0){
			$data = false;
			$msg = "JUMLAH TIDAK BOLEH KOSONG!";
		}else if($rtr_jumlah > $h_tot_muat){
			$data = false;
			$msg = "RETUR MELEBIHI JUMLAH MUAT!";
		}else{
			$retur = array(
				'rtr_tgl' => $h_tgl,
				'rtr_id_pelanggan' => $h_id_pelanggan,
				'rtr_id_produk' => $h_id_produk,
				'rtr_kode_po' => $h_kode_po,
				'rtr_urut' => $h_urut,
				'rtr_no_surat' => $h_no_surat,
				'rtr_plat' => $h_plat,
				'rtr_jumlah' => $rtr_jumlah,
				'rtr_ket' => $rtr_ket,
				'time' => date('Y-m-d H:i:s'),
			);
			$data = $this->db->insert('m_rencana_kirim_retur', $retur);
			$msg = "DATA RETUR DITAMBAHKAN!";
		}

		return [
			'data' => $data,
			'msg' => $msg,
		];
	}

	function deleteReturkiriman()
	{
		$this->db->where('id', $_POST["id"]);
		$data = $this->db->delete('m_rencana_kirim_retur');
		return [
			'data' => $data,
		];
	}
}
