<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nota extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$this->load->model('m_fungsi');
		$this->load->model('m_transaksi');
	}

	function Tawon()
	{
		$data = array(
			'judul' => "Nota Tawon Stiker",
			// 'pelanggan' => $this->m_master->get_data("m_pelanggan")->result()
		);

		$this->load->view('header', $data);
		$this->load->view('Nota/v_tawon_stiker', $data);
		$this->load->view('footer');
	}
	

	function load_data()
	{
		$jenis        = $this->uri->segment(3);
		$data         = array();

		if ($jenis == "jual_invoice") {

			$bulan       = $_POST['bulan'];
			$jns_data    = $_POST['jns_data'];

			if($bulan)
			{
				$bln_thn = explode('-',$bulan);
				$tahun   = $bln_thn[0];
				$blnn    = $bln_thn[1];
			}else{
				$tahun   = date('Y');
				$blnn    = date('m');
			}
			
			if($jns_data=='box')
			{

				$query = $this->db->query("SELECT a.no_invoice,a.nm_perusahaan, c.id_hub,d.nm_hub,a.bank,a.tgl_invoice,b.nm_ker,b.no_po,b.type,b.qty,b.retur_qty,b.hasil,b.harga,a.pajak from invoice_header a 
				join invoice_detail b on a.no_invoice=b.no_invoice
				join trs_po c on b.no_po=c.kode_po
				join m_hub d on c.id_hub=d.id_hub
				where a.type in ('box','sheet') and YEAR(tgl_invoice) ='$tahun' and MONTH(tgl_invoice) ='$blnn' and c.id_hub not in ('7')
				order by c.id_hub,a.tgl_invoice,a.no_invoice")->result();

				$i               = 1;
				foreach ($query as $r) {

					$row        = array();

					$row[]   = $i;
					$row[]   = $r->no_invoice;
					$row[]   = $r->nm_perusahaan;
					$row[]   = $r->id_hub;
					$row[]   = $r->nm_hub;
					$row[]   = $r->bank;
					$row[]   = $r->tgl_invoice;
					$row[]   = $r->nm_ker;
					$row[]   = $r->no_po;
					$row[]   = $r->type;
					$row[]   = '<div class="text-center">'.number_format($r->qty, 0, ",", ".").'</div>';
					$row[]   = $r->retur_qty;
					$row[]   = '<div class="text-center">'.number_format($r->hasil, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">Rp '.number_format($r->harga, 0, ",", ".").'</div>';
					$row[]   = $r->pajak;

					$data[]     = $row;

					$i++;
				}

			}else{

				$query = $this->db->query("SELECT no_invoice,nm_pelanggan_lm,id_hub,nm_hub,tgl_invoice,nm_produk_lm,no_po_lm,''type, qty_ok as qty,retur_qty as retur_qty,qty_ok-retur_qty as qty_fix,harga_pori_lm as harga,(qty_ok-retur_qty)*harga_pori_lm as total_jual,hitung as diskon,(qty_ok-retur_qty)*harga_pori_lm-hitung as total_inv FROM(

				SELECT a.no_invoice,a.tgl_invoice,g.nm_pelanggan_lm,h.id_hub,h.nm_hub,d.*,e.*,f.no_po_lm,c.hitung, d.qty_muat*(case when jenis_qty_lm='pack' then e.pack_lm else ikat_lm end) as qty_ok, b.retur_qty,f.harga_pori_lm
				FROM invoice_laminasi_header a 
				join invoice_laminasi_detail b ON a.no_surat=b.no_surat AND a.no_invoice=b.no_invoice
				left join ( select no_invoice,sum(hitung)hitung from invoice_laminasi_disc group by no_invoice ) c ON a.no_invoice=c.no_invoice
				JOIN m_rk_laminasi d ON b.id_rk_lm=d.id
				JOIN m_produk_lm e ON b.id_produk_lm=e.id_produk_lm
				JOIN trs_po_lm_detail f ON b.id_po_dtl=f.id
				JOIN m_pelanggan_lm g ON g.id_pelanggan_lm=a.id_pelanggan_lm
				JOIN m_hub h ON h.id_hub=a.bank
				WHERE MONTH(a.tgl_surat_jalan) in ($blnn) and YEAR(a.tgl_surat_jalan) in ($tahun) and a.jenis_lm='PPI'
				-- GROUP BY a.tgl_surat_jalan,a.no_surat,a.no_invoice 
				)p
				order by id_hub,p.tgl_invoice,no_invoice")->result();

				$i               = 1;
				foreach ($query as $r) {

					$row        = array();

					$row[]      = $i;
					$row[]      = $r->no_invoice;
					$row[]      = $r->nm_pelanggan_lm;
					$row[]      = $r->id_hub;
					$row[]      = $r->nm_hub;
					$row[]      = $r->tgl_invoice;
					$row[]      = $r->nm_produk_lm;
					$row[]      = $r->no_po_lm;
					$row[]      = $r->type;
					$row[]   = '<div class="text-center">'.number_format($r->qty, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->retur_qty, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->qty_fix, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->harga, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->total_jual, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->diskon, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->total_inv, 0, ",", ".").'</div>';

					$data[]     = $row;

					$i++;
				}
				
			}
			
			
		}else if ($jenis == "guna_bb") {

			$bulan       = $_POST['bulan'];
			$jns_data    = $_POST['jns_data'];

			if($bulan)
			{
				$bln_thn = explode('-',$bulan);
				$tahun   = $bln_thn[0];
				$blnn    = $bln_thn[1];
			}else{
				$tahun   = date('Y');
				$blnn    = date('m');
			}
			
			if($jns_data=='box')
			{

				$query = $this->db->query("SELECT a.no_invoice,a.nm_perusahaan, c.id_hub,d.nm_hub,a.bank,a.tgl_invoice,b.nm_ker,b.no_po,b.type,
				b.qty,b.retur_qty,b.hasil,b.harga,a.pajak,f.berat_bersih ,b.hasil*f.berat_bersih as tonase,round(b.hasil*f.berat_bersih/0.7) as bahan, 
				(
				select hrg_bhn from (
				select * from (
				select b.kode_po,a.hrg_bhn from trs_po_bhnbk a
				join trs_po_bhnbk_detail b on a.no_po_bhn=b.no_po_bhn
				group by b.kode_po,a.hrg_bhn desc
				)bhn group by kode_po
				)bhn where bhn.kode_po = c.kode_po) as harga_bahan
				from invoice_header a 
				join invoice_detail b on a.no_invoice=b.no_invoice
				join trs_po c on b.no_po=c.kode_po
				join m_hub d on c.id_hub=d.id_hub
				join trs_po_detail e on b.no_po=e.kode_po and e.id_produk=b.id_produk_simcorr
				join m_produk f on e.id_produk=f.id_produk
				where a.type in ('box','sheet') and YEAR(tgl_invoice) ='$tahun' and MONTH(tgl_invoice) ='$blnn' and c.id_hub not in ('7')
				order by c.id_hub,a.tgl_invoice,a.no_invoice")->result();

				$i               = 1;
				foreach ($query as $r) {

					$row        = array();

					$row[]   = $i;
					$row[]   = $r->no_invoice;
					$row[]   = $r->nm_perusahaan;
					$row[]   = $r->id_hub;
					$row[]   = $r->nm_hub;
					$row[]   = $r->bank;
					$row[]   = $r->tgl_invoice;
					$row[]   = $r->nm_ker;
					$row[]   = $r->no_po;
					$row[]   = $r->type;
					$row[]   = $r->qty;
					$row[]   = $r->retur_qty;
					$row[]   = $r->hasil;
					$row[]   = $r->harga;
					$row[]   = $r->pajak;
					$row[]   = $r->berat_bersih;
					$row[]   = '<div class="text-center">'.number_format($r->tonase, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->bahan, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">Rp '.number_format($r->harga_bahan, 0, ",", ".").'</div>';

					$data[]     = $row;

					$i++;
				}

			}else{

				$query = $this->db->query("SELECT no_invoice,nm_pelanggan_lm,id_hub,nm_hub,tgl_invoice,nm_produk_lm,no_po_lm, qty_ok as qty,retur_qty as retur_qty,
				qty_ok-retur_qty as qty_fix_pack,
				(qty_ok-retur_qty)/(case when jenis_qty_lm='pack' then pack_lm else ikat_lm end)qty_bal,
				(qty_ok-retur_qty)/(case when jenis_qty_lm='pack' then pack_lm else ikat_lm end)*50 as tonase,
				round( (qty_ok-retur_qty)/(case when jenis_qty_lm='pack' then pack_lm else ikat_lm end)*50/0.75 )as bahan_Kg,
				(
				select hrg_bhn from (
				select * from (
				select b.kode_po,a.hrg_bhn from trs_po_bhnbk a
				join trs_po_bhnbk_detail b on a.no_po_bhn=b.no_po_bhn
				group by b.kode_po,a.hrg_bhn desc
				)bhn group by kode_po
				)bhn where bhn.kode_po = p.no_po_lm) as harga_bahan
				FROM(

				SELECT a.no_invoice,a.tgl_invoice,g.nm_pelanggan_lm,h.id_hub,h.nm_hub,d.*,e.*,f.no_po_lm,c.hitung, d.qty_muat*(case when jenis_qty_lm='pack' then e.pack_lm else ikat_lm end) as qty_ok, b.retur_qty,f.harga_pori_lm
				FROM invoice_laminasi_header a 
				join invoice_laminasi_detail b ON a.no_surat=b.no_surat AND a.no_invoice=b.no_invoice
				left join ( select no_invoice,sum(hitung)hitung from invoice_laminasi_disc group by no_invoice ) c ON a.no_invoice=c.no_invoice
				JOIN m_rk_laminasi d ON b.id_rk_lm=d.id
				JOIN m_produk_lm e ON b.id_produk_lm=e.id_produk_lm
				JOIN trs_po_lm_detail f ON b.id_po_dtl=f.id
				JOIN m_pelanggan_lm g ON g.id_pelanggan_lm=a.id_pelanggan_lm
				JOIN m_hub h ON h.id_hub=a.bank
				WHERE (h.id_hub!='7' AND h.id_hub!='0') AND MONTH(a.tgl_surat_jalan) in ($blnn) AND YEAR(a.tgl_surat_jalan) in ($tahun) and a.jenis_lm='PPI'
				-- GROUP BY a.tgl_surat_jalan,a.no_surat,a.no_invoice 
				)p
				order by id_hub,p.tgl_invoice,no_invoice")->result();

				$i               = 1;
				foreach ($query as $r) {

					$row        = array();

					$row[]      = $i;
					$row[]      = $r->no_invoice;
					$row[]      = $r->nm_pelanggan_lm;
					$row[]      = $r->id_hub;
					$row[]      = $r->nm_hub;
					$row[]      = $r->tgl_invoice;
					$row[]      = $r->nm_produk_lm;
					$row[]      = $r->no_po_lm;
					$row[]      = $r->qty;
					$row[]      = $r->retur_qty;
					$row[]      = $r->qty_fix_pack;
					$row[]   = '<div class="text-center">'.number_format($r->qty_bal, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->tonase, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->bahan_Kg, 0, ",", ".").'</div>';
					$row[]   = '<div class="text-center">'.number_format($r->harga_bahan, 0, ",", ".").'</div>';

					$data[]     = $row;

					$i++;
				}
				
			}
			
			
		}else if ($jenis == "beli_bhn") {

			$bulan       = $_POST['bulan'];
			$jns_data    = $_POST['jns_data'];

			if($bulan)
			{
				$bln_thn = explode('-',$bulan);
				$tahun   = $bln_thn[0];
				$blnn    = $bln_thn[1];
			}else{
				$tahun   = date('Y');
				$blnn    = date('m');
			}
			
			if($jns_data=='box')
			{
				$jns_beli ='BOX';
			}else{
				$jns_beli ='LAMINASI';
			}

			$query = $this->db->query("SELECT a.no_stok,tgl_stok,tgl_j_tempo,no_timbangan,d.no_po_bhn,nm_hub,hrg_bhn,datang_bhn_bk,hrg_bhn*datang_bhn_bk as total from trs_h_stok_bb a 
			JOIN trs_d_stok_bb b on a.no_stok=b.no_stok
			JOIN m_hub c ON b.id_hub=c.id_hub
			JOIN trs_po_bhnbk d ON b.no_po_bhn = d.no_po_bhn
			where c.jns in ('$jns_beli') and MONTH(tgl_stok) in ($blnn) and YEAR(tgl_stok) ='$tahun'
			order by CAST(b.id_hub as int),tgl_j_tempo,a.no_stok")->result();

			$i               = 1;
			foreach ($query as $r) {

				$row        = array();

				$row[]   = $i;
				$row[]   = $r->no_stok;
				$row[]   = $r->tgl_stok;
				$row[]   = $r->tgl_j_tempo;
				$row[]   = $r->no_timbangan;
				$row[]   = $r->no_po_bhn;
				$row[]   = $r->nm_hub;
				$row[]   = '<div class="text-center">Rp '.number_format($r->hrg_bhn, 0, ",", ".").'</div>';
				$row[]   = '<div class="text-center">'.number_format($r->datang_bhn_bk, 0, ",", ".").'</div>';
				$row[]   = '<div class="text-center">'.number_format($r->total, 0, ",", ".").'</div>';

				$data[]     = $row;

				$i++;
			}

			
			
			
		}else if ($jenis == "jur_umum") {
			$query = $this->db->query("SELECT no_voucher, tgl_transaksi,sum(debet)debet,sum(kredit)kredit,a.id_hub,b.nm_hub,ket from jurnal_d a
			JOIN m_hub b ON a.id_hub=b.id_hub
			where no_voucher like'%JURUM%'
			group by no_voucher, tgl_transaksi,a.id_hub,ket
			order by tgl_transaksi desc")->result();

			$i               = 1;
			foreach ($query as $r) 
			{
				$no_voucher    = "'$r->no_voucher'";

				$row = array();
				$row[] = '<div class="text-center">'.$i.'</div>';
				$row[] = '<div class="text-center">'.$r->no_voucher.'</div>';
				$row[] = '<div class="text-center">'.$this->m_fungsi->tanggal_ind($r->tgl_transaksi).'</div>';
				$row[] = '<div class="text-center">'.$r->nm_hub.'</div>';
				$row[] = '<div class="text-center">Rp '.number_format($r->debet, 0, ",", ".").'</div>';
				$row[] = '<div class="text-center">Rp '.number_format($r->kredit, 0, ",", ".").'</div>';
				$row[] = '<div class="text-center">'.$r->ket .'</div>';

				$btncetak ='<a target="_blank" class="btn btn-sm btn-danger" href="' . base_url("Logistik/Cetak_inv_beli?no_voucher="."$r->no_voucher"."") . '" title="Cetak" ><i class="fas fa-print"></i> </a>';

				$btnEdit = '<a class="btn btn-sm btn-warning" onclick="edit_data(' . $no_voucher . ')" title="EDIT DATA" >
				<b><i class="fa fa-edit"></i> </b></a>';

				$btnHapus = '<button type="button" title="DELETE"  onclick="deleteData(' . $no_voucher.')" class="btn btn-danger btn-sm">
				<i class="fa fa-trash-alt"></i></button> ';

				if (in_array($this->session->userdata('level'), ['konsul_keu','User','Admin']))
				{
					$row[] = '<div class="text-center">'.$btnEdit.' '.$btncetak.' '.$btnHapus.'</div>';

				}else{
					$row[] = '<div class="text-center"></div>';
				}

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

	function cetak_nota_tawon()
	{
		// $cekpdf   = 0;
		$position   = 'P';
		$judul      = 'NOTA TAWON STICKER';
		$html       = '';
		$cekpdf   = $_GET['ctk'];

		$html = "";

		$html .= '<br>';

		$html .="<table style=\"border:0;padding:0;font-size:12px;vertical-align:top;border-collapse:collapse;color:#000;width:100%;font-family:tahoma\">
			<tr>
				<td style=\"width:40%\"></td>
				<td style=\"width:10%\"></td>
				<td style=\"width:40%\"></td>
				<td style=\"width:10%\"></td>
			</tr>
			<tr>
				<td style=\"padding:3px 0;font-weight:bold;font-size:10px;text-align:center;vertical-align:middle\">
					<img src=\"" . base_url() . "assets/gambar/logo_nota_tawon.png\"  width=\"200\" height=\"30\" />
				</td>
				<td style=\"padding:5px 0 3px\"></td>
				<td style=\"padding:5px 0 3px;font-weight:bold\">Tanggal,........................</td>
				<td style=\"padding:5px 0 3px\"></td>
			</tr>
			<tr>
				<td style=\"font-size:7px\">&nbsp;&nbsp;&nbsp;Gg anggur no2, Mantung Rt 02/14 sanggrahan, sukoharjo  </td>
				<td style=\"\" colspan=\"2\"><u>Tuan</u>..............................................</td>
				<td style=\"\" > </td>
			</tr>
			<tr>
				<td style=\"font-size:10px\">   &nbsp;&nbsp;IG @tawoncutting, HP : 0859 6286 4470 </td>
				<td style=\"padding:0px;\" colspan=\"2\">Toko &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td> </td>
			</tr>
			<tr>
				<td style=\"font-size:10px\">   &nbsp;&nbsp;Menerima :</td>
				<td style=\"padding:0px;\" colspan=\"2\" >......................................................</td>
				<td> </td>
			</tr>
			<br>";
		$html .="</table>";
		
		$html .="<table style=\"padding:0;font-size:10px;border-collapse:collapse;color:#000;width:100%;font-family:tahoma\">
			<tr>
				<th style=\"padding:0px;\"><br>STICKER CUTING, KAOS SABLON DTF, KAOS SABLON POLYFLEX <br> STIKER DIGITAL, MMT,</th>
			</tr>
			</table>";
		
			$html .="<table style=\"margin:0 0 10px;padding:0;font-size:12px;border-collapse:collapse;color:#000;width:100%;font-family:tahoma\">
			<tr>
				<th style=\"width:25%;padding:3px;border:1px solid #000\">Banyaknya</th>
				<th style=\"width:25%;padding:3px;border:1px solid #000\">Nama Barang</th>
				<th style=\"width:25%;padding:3px;border:1px solid #000\">Harga</th>
				<th style=\"width:25%;padding:3px;border:1px solid #000\">Jumlah</th>
			</tr>";

		for($i = 0; $i < 10; $i++){
			
		$html .="<tr>
				<td style=\"padding:10px;border:1px solid #000\"></td>
				<td style=\"padding:10px;border:1px solid #000\"></td>
				<td style=\"padding:10px;border:1px solid #000\"></td>
				<td style=\"padding:10px;border:1px solid #000\"></td>
			</tr>";
		}

		$html .="<tr>
				<td style=\"padding:5px;border:0px\"></td>
				<td style=\"padding:5px;border:0px\"></td>
				<td style=\"padding:5px;border:0px;text-align:right;\"><b>TOTAL Rp</b></td>
				<td style=\"padding:5px;border:1px solid #000\"></td>
			</tr>";
		$html .="<tr>
				<td style=\"padding:0px;border:0px\"></td>
				<td style=\"padding:0px;border:0px\"></td>
				<td style=\"padding:0px;border-right:0px;border-left:0px;font-size:3px\">&nbsp;</td>
				<td style=\"padding:0px;border:1px solid #000\"></td>
			</tr>";
		$html .='</table>';
		
		$data['prev'] = $html;

		switch ($cekpdf) {
			case 0;
				echo ("<title>$judul</title>");
				echo ($html);
				break;

			case 1;

				// $this->m_fungsi->newMpdf($judul, '', $html, 10, 3, 3, 3, 'L', 'TT', $bln_judul.'.pdf');

				$this->m_fungsi->_mpdf_hari2($position, 'A4', $judul, $html, $judul.'.pdf', 5, 5, 2, 5,'','','','TT','no');
				
				// $this->m_fungsi->newMpdf('aa', '', $html, 5, 5, 5, 5, $position, 'TT', 'aa.pdf');
				break;

				
				
			case 2;
				header("Cache-Control: no-cache, no-store, must-revalidate");
				header("Content-Type: application/vnd-ms-excel");
				header("Content-Disposition: attachment; filename= $judul.xls");
				$this->load->view('Master/master_cetak', $data);
				break;
		}
	}
	
	

}
