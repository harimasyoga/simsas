<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Laporan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$this->load->model('m_laporan');
		$this->load->model('m_fungsi');
	}

	function Rekap_omset()
	{

		$data = array(
			'judul' => "REKAP OMSET"
		);

		$this->load->view('header', $data);
		$this->load->view('Laporan/v_rekap_omset', $data);
		$this->load->view('footer');
	}

	function Laporan_Pengiriman()
	{
		$data = array(
			'judul' => "Laporan_Pengiriman"
		);
		$this->load->view('header', $data);
		$this->load->view('Laporan/v_lap_pengiriman', $data);
		$this->load->view('footer');
	}

	function cariListLaporan()
	{
		$html ='';
		$id_pelanggan = $_POST["id_pelanggan"];
		($id_pelanggan != "") ? $wCust = "AND p.id_perusahaan='$id_pelanggan'" : $wCust = '';
		$tgl1 = $_POST["tgl1"];
		$tgl2 = $_POST["tgl2"];

		// TANGGAL
		$getRit = $this->db->query("SELECT tgl FROM pl_box p
		WHERE tgl BETWEEN '$tgl1' AND '$tgl2' $wCust
		GROUP BY tgl");
		$html .= '<table style="width:100%">';
			if($getRit->num_rows() == 0){
				$html .= '<tr><td>TIDAK ADA PENGIRIMAN</td></tr>';
			}else{
				$totTimbangan = 0;
				foreach($getRit->result() as $t){
					$html .= '<tr><td style="border:0"><br></td></tr>
					<tr>
						<td style="border:0;font-weight:bold">'.strtoupper($this->m_fungsi->getHariIni($t->tgl)).', '.strtoupper($this->m_fungsi->tanggal_format_indonesia($t->tgl)).'</td>
					</tr>';
					// NOPOL
					$nopol = $this->db->query("SELECT p.tgl,p.no_pl_urut,p.no_kendaraan,p.kategori FROM pl_box p
					INNER JOIN m_rencana_kirim r ON p.no_pl_urut=r.rk_urut AND p.tgl=r.rk_tgl AND p.id_perusahaan=r.id_pelanggan AND p.id=r.id_pl_box
					WHERE p.tgl='$t->tgl' $wCust
					GROUP BY p.tgl,p.no_pl_urut,p.no_kendaraan");
					$nn = 0;
					$hariTimbang = 0;
					foreach($nopol->result() as $n){
						$nn++;
						// CUSTOMER
						$cPelanggan = $this->db->query("SELECT*FROM pl_box p
						INNER JOIN m_pelanggan c ON p.id_perusahaan=c.id_pelanggan
						INNER JOIN m_rencana_kirim r ON p.no_pl_urut=r.rk_urut AND p.tgl=r.rk_tgl AND p.id_perusahaan=r.id_pelanggan AND p.id=r.id_pl_box
						WHERE p.tgl='$n->tgl' AND p.no_kendaraan='$n->no_kendaraan' AND p.no_pl_urut='$n->no_pl_urut' $wCust
						GROUP BY p.id_perusahaan,p.no_pl_urut");
						($cPelanggan->num_rows() == 1) ? $cC = ' '.$cPelanggan->row()->nm_pelanggan : $cC = '';
						$html .= '<tr><td style="border:0"><br></td></tr>
						<tr>
							<td style="border:0">RIT '.$nn.', PENGIRIMAN BOX KE'.$cC.'</td>
						</tr>';

						$pp = 0;
						$sumQty = 0;
						$sumTimbang = 0;
						foreach($cPelanggan->result() as $p){
							$pp++;
							if($cPelanggan->num_rows() != 1){
								$html .= '<tr>
									<td style="border:0">'.$pp.'. '.$p->nm_pelanggan.'</td>
								</tr>';
							}
							// KIRIMAN
							$kiriman = $this->db->query("SELECT i.nm_produk,i.ukuran_sheet,SUM(r.qty_muat) AS sum_qty_muat,r.* FROM pl_box p
							INNER JOIN m_rencana_kirim r ON p.no_pl_urut=r.rk_urut AND p.tgl=r.rk_tgl AND p.id_perusahaan=r.id_pelanggan AND p.id=r.id_pl_box
							INNER JOIN m_produk i ON r.id_produk=i.id_produk
							WHERE p.tgl='$p->tgl' AND p.no_kendaraan='$p->no_kendaraan' AND p.no_pl_urut='$p->no_pl_urut' AND p.id_perusahaan='$p->id_perusahaan'
							GROUP BY i.kategori,i.id_produk ORDER BY i.kategori,i.nm_produk");
							$gK = $this->db->query("SELECT i.kategori FROM pl_box p
							INNER JOIN m_rencana_kirim r ON p.no_pl_urut=r.rk_urut AND p.tgl=r.rk_tgl AND p.id_perusahaan=r.id_pelanggan AND p.id=r.id_pl_box
							INNER JOIN m_produk i ON r.id_produk=i.id_produk
							WHERE p.tgl='$p->tgl' AND p.no_kendaraan='$p->no_kendaraan' AND p.no_pl_urut='$p->no_pl_urut' AND p.id_perusahaan='$p->id_perusahaan'
							GROUP BY i.kategori");
							foreach($kiriman->result() as $k){
								if($k->kategori == 'SHEET'){
									($k->c_uk == 1) ? $c_uk = $k->nm_produk.'. '.$k->ukuran_sheet : $c_uk = $k->nm_produk;
									$nm_produk = $c_uk;
									$ket = 'LEMBAR';
								}else{
									$nm_produk = $k->nm_produk;
									$ket = 'PCS';
								}
								if($gK->num_rows() == 1){
									$t_ket = '';
								}else{
									($k->kategori == 'SHEET') ? $t_ket = ' (SHEET)' : $t_ket = ' (BOX)';
								}
								($cPelanggan->num_rows() == 1 && $kiriman->num_rows() == 1) ? $kTot = '' : $kTot = '. TOTAL '.number_format($k->sum_qty_muat).' '.$ket;
								$html .= '<tr>
									<td style="border:0">- '.$nm_produk.$kTot.$t_ket.'</td>
								</tr>';
								$sumQty += $k->sum_qty_muat;
							}
						}
						// TOTAL DAN TIMBANGAN
						$timbangan = $this->db->query("SELECT*FROM m_jembatan_timbang WHERE tgl_t='$p->tgl' AND urut_t='$p->no_pl_urut' AND no_polisi='$p->no_kendaraan'");
						($timbangan->num_rows() == 0) ? $timbang = 0 : $timbang = $timbangan->row()->berat_bersih;
						($n->kategori == 'BOX') ? $nket = 'PCS' : $nket = 'LEMBAR';
						$html .= '<tr>
							<td style="border:0">TOTAL '.number_format($sumQty).' '.$nket.' / '.number_format($timbang).' KG</td>
						</tr>';
						$sumTimbang += $timbang;
						$hariTimbang += $sumTimbang;
					}
					// TOTAL HARI
					if($nopol->num_rows() != 1){
						$html .= '<tr><td style="border:0"><br></td></tr>
						<tr>
							<td style="border:0;font-weight:bold">TOTAL '.number_format($hariTimbang).' KG</td>
						</tr>';
					}
					$totTimbangan += $hariTimbang;
				}
				// TOTAL SEMUA
				if($tgl1 != $tgl2){
					$html .= '<tr><td style="border:0"><br></td></tr>
					<tr>
						<td style="border:0;font-weight:bold">TOTAL '.number_format($totTimbangan).' KG</td>
					</tr>';
				}
			}
		$html .= '</table>';
		echo json_encode([
			'html' => $html,
		]);
	}

	function plhOS()
	{
		$tahun = $_POST["tahun"];
		$pelanggan = $_POST["pelanggan"];
		$no_po = $_POST["no_po"];
		$opsi = $_POST["opsi"];
		$html = '';
		$htmlPO = '';

		($no_po == "") ? $w_nopo = '' : $w_nopo = "AND p.kode_po='$no_po'";
		if($opsi == "" || $opsi == "OPEN"){
			$w_opsi = "AND p.status_kiriman='Open'";
		}else{
			$w_opsi = "";
		}
		$data = $this->db->query("SELECT*FROM trs_po p
		WHERE p.tgl_po LIKE '%$tahun%' AND p.status='Approve' AND p.id_pelanggan='$pelanggan' $w_nopo $w_opsi
		GROUP BY kode_po ORDER BY tgl_po");

		$htmlPO .='<option value="">PILIH</option>';
		foreach($data->result() as $r){	
			$htmlPO .='<option value="'.$r->kode_po.'">'.$r->kode_po.'</option>';
		}

		if($data->num_rows() > 0){
			$html .='<table>
				<tr>
					<th style="padding:5px;text-align:center;border:1px solid #aaa">NO</th>
					<th style="padding:5px;text-align:center;border:1px solid #aaa">ITEM</th>
					<th style="padding:5px;text-align:center;border:1px solid #aaa">UKURAN</th>
					<th style="padding:5px;text-align:center;border:1px solid #aaa">KUALITAS</th>
					<th style="padding:5px;text-align:center;border:1px solid #aaa">FLUTE</th>
					<th style="padding:5px;text-align:center;border:1px solid #aaa">QTY</th>
					<th style="padding:5px 10px;text-align:center;border:1px solid #aaa">O S</th>
				</tr>';
				foreach($data->result() as $r){
					if($this->session->userdata('level') == 'Admin'){
						if($r->status_kiriman == 'Open'){
							$aksi = 'onclick="closePengiriman('."'".$r->id."'".','."'Close'".')';
							$bgBtn = 'btn-danger';
							$txtBtn = 'close';
						}else{
							$aksi = 'onclick="closePengiriman('."'".$r->id."'".','."'Open'".')';
							$bgBtn = 'btn-info';
							$txtBtn = 'open';
						}
						$btnBtl = '<button type="button" class="btn btn-xs '.$bgBtn.'" style="font-weight:bold" '.$aksi.'">'.$txtBtn.'</button>';
					}else{
						$btnBtl = '-';
					}
					$html .='<tr>
						<td style="background:#adb5bd;padding:5px;border:1px solid #aaa;font-weight:bold" colspan="6">'.$r->kode_po.'</td>
						<td style="background:#adb5bd;padding:5px;border:1px solid #aaa;font-weight:bold;text-align:center">'.$btnBtl.'</td>
					</tr>';
					$detail = $this->db->query("SELECT*FROM trs_po_detail d
					INNER JOIN m_produk i ON d.id_produk=i.id_produk
					WHERE d.kode_po='$r->kode_po'");
					$i = 0;
					foreach($detail->result() as $d){
						$i++;
						($d->kategori == 'K_BOX') ? $ukuran = $d->ukuran : $ukuran = $d->ukuran_sheet;
						($this->session->userdata('level') == 'Admin') ? $spanS = '<span style="vertical-align:top;font-style:italic;font-size:12px">'.$d->id_produk.'</span>' : $spanS = '';
						$html .='<tr>
							<td style="padding:5px;border:1px solid #aaa;text-align:center">'.$i.'</td>
							<td style="padding:5px;border:1px solid #aaa">'.$d->nm_produk.'</td>
							<td style="padding:5px;border:1px solid #aaa">'.$ukuran.'</td>
							<td style="padding:5px;border:1px solid #aaa">'.$this->m_fungsi->kualitas($d->kualitas, $d->flute).'</td>
							<td style="padding:5px;border:1px solid #aaa;text-align:center">'.$d->flute.'</td>
							<td style="padding:5px;border:1px solid #aaa;font-weight:bold;text-align:right">'.number_format($d->qty,0,',','.').'</td>
							<td style="padding:5px;border:1px solid #aaa;text-align:center">'.$spanS.'</td>
						</tr>';
						$kirim = $this->db->query("SELECT SUM(r.qty_muat) AS tot_muat,r.*,p.* FROM m_rencana_kirim r
						INNER JOIN pl_box p ON r.rk_kode_po=p.no_po AND r.rk_urut=p.no_pl_urut AND r.id_pl_box=p.id
						WHERE p.no_po='$d->kode_po' AND r.id_produk='$d->id_produk'
						GROUP BY r.rk_tgl,r.id_pelanggan,r.id_produk,r.rk_kode_po,r.rk_urut");
						$sumKirim = 0;
						$sumRetur = 0;
						if($kirim->num_rows() > 0){
							foreach($kirim->result() as $k){
								$ii = (((rand(1, 999) * 888) - 777) + 666) * 123;
								$retur = $this->db->query("SELECT*FROM m_rencana_kirim_retur
								WHERE rtr_tgl='$k->tgl' AND rtr_id_pelanggan='$k->id_pelanggan' AND rtr_id_produk='$k->id_produk' AND rtr_kode_po='$k->rk_kode_po' AND rtr_urut='$k->rk_urut'");
								if($r->status_kiriman == 'Open' && $retur->num_rows() == 0 && in_array($this->session->userdata('level'), ['Admin', 'User'])){
									$btnRetur = '<button type="button" class="btn btn-xs btn-warning" style="font-weight:bold;padding:2px 6px" onclick="returKiriman('."'".$ii."'".')">+</button>
										<input type="hidden" id="h_tot_muat_'.$ii.'" value="'.$k->tot_muat.'">
										<input type="hidden" id="h_tgl_'.$ii.'" value="'.$k->tgl.'">
										<input type="hidden" id="h_id_pelanggan_'.$ii.'" value="'.$k->id_pelanggan.'">
										<input type="hidden" id="h_id_produk_'.$ii.'" value="'.$k->id_produk.'">
										<input type="hidden" id="h_kode_po_'.$ii.'" value="'.$k->rk_kode_po.'">
										<input type="hidden" id="h_urut_'.$ii.'" value="'.$k->rk_urut.'">
										<input type="hidden" id="h_no_surat_'.$ii.'" value="'.$k->no_surat.'">
										<input type="hidden" id="h_plat_'.$ii.'" value="'.$k->no_kendaraan.'">';
								}else{
									$btnRetur = '';
								}
								$html .='<tr>
									<td style="padding:5px;border-left:1px solid #aaa"></td>
									<td style="padding:5px" colspan="4">- '.strtoupper($this->m_fungsi->getHariIni($k->tgl)).', '.strtoupper($this->m_fungsi->tglIndSkt($k->tgl)).' - '.$k->no_surat.' - '.$k->no_kendaraan.'</td>
									<td style="padding:5px;text-align:right">'.number_format($k->tot_muat,0,',','.').'</td>
									<td style="padding:5px;border-right:1px solid #aaa;text-align:center">'.$btnRetur.'</td>
								</tr>';
								// RETUR
								if($retur->num_rows() != 0){
									($this->session->userdata('level') == 'Admin') ? $delR = '<button type="button" class="btn btn-xs btn-danger" style="font-weight:bold" onclick="deleteReturkiriman('."'".$retur->row()->id."'".')">x</button>' : $delR = '';
									$html .='<tr>
										<td style="padding:5px;border-left:1px solid #aaa"></td>
										<td style="padding:5px;text-align:right;font-style:italic" colspan="4">'.$retur->row()->rtr_ket.'</td>
										<td style="padding:5px;text-align:right;font-style:italic">'.number_format($retur->row()->rtr_jumlah,0,',','.').'</td>
										<td style="padding:5px;text-align:center;border-right:1px solid #aaa">
											<span class="btn btn-xs btn-secondary" style="font-weight:bold;cursor:default">retur</span>
											'.$delR.'
										</td>
									</tr>';
								}
								if($r->status_kiriman == 'Open' && $retur->num_rows() == 0 && in_array($this->session->userdata('level'), ['Admin', 'User'])){
									$html .='<tr class="tr tampilkantr-'.$ii.'" style="display:none">
										<td style="padding:5px;border-left:1px solid #aaa"></td>
										<td style="padding:5px;vertical-align:top">
											<input type="date" class="form-control" id="rtr_tgl_'.$ii.'">
										</td>
										<td style="padding:5px" colspan="3">
											<textarea class="form-control" id="rtr_ket_'.$ii.'" placeholder="ALASAN RETUR '.$k->no_surat.'" style="resize:none" oninput="this.value=this.value.toUpperCase()"></textarea>
										</td>
										<td style="padding:5px;vertical-align:top">
											<input type="number" class="form-control" id="rtr_jumlah_'.$ii.'" placeholder="0" style="padding:7px 6px;height:100%;width:70px;text-align:right">
										</td>
										<td style="padding:5px;vertical-align:top;text-align:center;border-right:1px solid #aaa">
											<button type="button" class="btn btn-xs btn-secondary" style="font-weight:bold" onclick="addReturKiriman('."'".$ii."'".')">retur</button>
										</td>
									</tr>';
								}
								$sumKirim += $k->tot_muat;
								$sumRetur += ($retur->num_rows() == 0) ? 0 : $retur->row()->rtr_jumlah;
							}
						}
						if($kirim->num_rows() > 0){
							if($sumRetur != 0){
								$html .='<tr>
									<td style="padding:5px;font-weight:bold;text-align:right;border-left:1px solid #aaa" colspan="5">TOTAL RETUR</td>
									<td style="padding:5px;font-weight:bold;text-align:right">'.number_format($sumRetur,0,',','.').'</td>
									<td style="padding:5px;border-right:1px solid #aaa"></td>
								</tr>';
							}
							$sisa = ($sumKirim - $sumRetur) - $d->qty;
							($sisa <= 0) ? $bgtd = ';background:#74c69d' : $bgtd = ';background:#ff758f';
							$html .='<tr style="border-bottom:1px solid #aaa">
								<td style="padding:5px;font-weight:bold;text-align:right;border-left:1px solid #aaa" colspan="5">TOTAL KIRIMAN</td>
								<td style="padding:5px;font-weight:bold;text-align:right">'.number_format($sumKirim,0,',','.').'</td>
								<td style="padding:5px;font-weight:bold;text-align:right;border-right:1px solid #aaa'.$bgtd.'">'.number_format($sisa,0,',','.').'</td>
							</tr>';
						}
					}
				}
			$html .='<input type="hidden" id="h_tr" value=""></table>';
		}else{
			$html .='DATA KOSONG!';
		}

		echo json_encode([
			'html' => $html,
			'no_po' => $no_po,
			'htmlPO' => $htmlPO,
		]);
	}

	function closePengiriman()
	{
		$id_po = $_POST["id_po"];
		$opsi = $_POST["opsi"];

		$this->db->set('status_kiriman', $opsi);
		$this->db->where('id', $id_po);
		$close_po = $this->db->update('trs_po');
		echo json_encode([
			'close_po' => $close_po,
		]);
	}

	function addReturKiriman()
	{
		$result = $this->m_laporan->addReturKiriman();
		echo json_encode($result);
	}

	function deleteReturkiriman()
	{
		$result = $this->m_laporan->deleteReturkiriman();
		echo json_encode($result);
	}

	function load_rekap_omset()
	{
		$html   = '';

		$th_hub = $this->input->post('th_hub');
		if($th_hub){
			$tahun  = $th_hub;
		}else{
			$tahun  = date('Y');
		}
		
		$query  = $this->db->query("SELECT b.id_hub,e.nm_hub,b.id_pelanggan,d.nm_pelanggan,sum(c.qty*price_inc)total_hub, YEAR(b.tgl_po)th
		from trs_po b 
		JOIN trs_po_detail c ON b.no_po=c.no_po 
		JOIN m_pelanggan d ON d.id_pelanggan=b.id_pelanggan
		JOIN m_hub e ON e.id_hub=b.id_hub
		where YEAR(b.tgl_po) in ('$tahun') 
		group by b.id_pelanggan,d.nm_pelanggan,b.id_hub,e.nm_hub,YEAR(b.tgl_po)
		ORDER BY id_hub,id_pelanggan
		")->result();

		$html .='<div style="padding-bottom:20px;font-weight:bold">';
		$html .='<table class="table table-bordered table-striped">
		<thead class="color-tabel">
			<tr>
				<th style="text-align:center">NO</th>
				<th style="text-align:center">Nama HUB</th>
				<th style="text-align:center">Nama Customer</th>
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
					<td style="text-align:left">'.$r->nm_pelanggan.'</td>
					<td style="text-align:right">'.number_format($r->total_hub, 0, ",", ".").'</td>
					<td style="text-align:right">'.number_format(4800000000-$r->total_hub, 0, ",", ".").'</td>
					<td style="text-align:right">'.$tahun.'</td>
				</tr>';
				$total    += $r->total_hub;
				$sisa_hub += 4800000000-$r->total_hub;
			}
			
			$html .='<tr>
					<th style="text-align:center" colspan="3" >Total</th>
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

	function load_data()
	{
		$jenis = $this->uri->segment(3);
		$data = array();

		if ($jenis == "rekap_omset") {
			
			$th_hub = $this->input->post('th_hub');
			if($th_hub){
				$tahun  = $th_hub;
			}else{
				$tahun  = date('Y');
			}
			
			$query = $this->m_master->query("SELECT b.id_hub,e.nm_hub,b.id_pelanggan,d.nm_pelanggan,sum(c.qty*price_inc)total_hub, YEAR(b.tgl_po)th
			from trs_po b 
			JOIN trs_po_detail c ON b.no_po=c.no_po 
			JOIN m_pelanggan d ON d.id_pelanggan=b.id_pelanggan
			JOIN m_hub e ON e.id_hub=b.id_hub
			where YEAR(b.tgl_po) in ('$tahun') 
			group by b.id_pelanggan,d.nm_pelanggan,b.id_hub,e.nm_hub,YEAR(b.tgl_po)
			ORDER BY id_hub,id_pelanggan")->result();
			$i = 1;
			foreach ($query as $r) {
				$row          = array();
				$row[]        = '<div class="text-center">'.$i.'</div>';
				$row[]        = $r->nm_hub;
				$row[]        = $r->nm_pelanggan; 
				$row[]        = '<div class="text-right"><b>'. number_format($r->total_hub, 0, ",", "."). '</b></div>';
				$row[]        = '<div class="text-right"><b>'. number_format(4800000000-$r->total_hub, 0, ",", "."). '</b></div>';
				$row[]        = '<div class="text-center">'.$tahun.'</div>';

				$id_hub       = $r->id_hub;
				$cekpo    = $this->db->query("SELECT * FROM trs_po WHERE id_hub='$id_hub'")->num_rows();

				$data[] = $row;
				$i++;
			}
		}

		$output = array(
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function Laporan_Stok()
	{

		$query = $this->m_master->query("SELECT * FROM m_produk ORDER BY id_produk ");

		$html = '';


		if ($query->num_rows() > 0) {

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:14px;font-family: ;">
                        <tr style="font-weight: bold;">
                            <td colspan="4" align="center">
                              <h1> Laporan Stok</h1>
                              
                            </td>
                        </tr>
                 </table><br>';

			$html .= '<table width="100%" border="1" cellspacing="0" style="font-size:14px;font-family: ;">
                        <tr>
                            <th align="center">ID Produk</th>
                            <th align="center">Nama Produk</th>
                            <th align="center">Satuan</th>
                            <th align="center">Stok</th>
                        </tr>';
			$tot_stok = 0;
			foreach ($query->result() as $r) {
				$html .= '
                            <tr>
                                <td align="center">' . $r->id_produk . '</td>
                                <td align="center">' . $r->nm_produk . '</td>
                                <td align="center">' . $r->satuan . '</td>
                                <td align="center">' . number_format($r->stok, 0, ",", ".") . '</td>
                            </tr>';

				$tot_stok += $r->stok;
			}
			$html .= '
                            <tr style="background-color: #959a9a">
                                <td align="right" colspan="3">Total</td>
                                <td align="center">' . number_format($tot_stok, 0, ",", ".") . '</td>
                            </tr>';
			$html .= '
                 </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		$judul = "Laporan Stok";

		if (/*$ctk*/'1' == '0') {
			echo $html;
		} else {
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=$judul.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$data['prev'] = $html;
			$this->load->view('view_excel', $data);
		}
	}

	function lap_cost($periode, $id_kategori, $ctk)
	{
		$data_tgl = $this->db->query("SELECT DATE_FORMAT(tanggal,'%d') day,tanggal FROM `tr_pemakaian` WHERE id_kategori='$id_kategori' AND DATE_FORMAT(tanggal,'%Y-%m') = '$periode' GROUP BY tanggal");

		$nm_kategori = $this->db->query("SELECT nm_kategori from m_kategori where id = '$id_kategori' ")->row("nm_kategori");
		$html = '';


		if ($data_tgl->num_rows() > 0) {
			$colspan = $data_tgl->num_rows() + 2;
			$tot_cost = 0;

			$html .= '<table width="100%" border="0" cellspacing="0" style="font-size:14px;font-family: ;">
                        <tr style="font-weight: bold;">
                            <td colspan="' . $colspan . '" align="center"><h1> COST ' . $nm_kategori . '</h1></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td style="color:blue" colspan="2"><h2>' . $this->m_fungsi->periode_indonesia($periode . "-01") . '</h2>
                            <td colspan="' . $data_tgl->num_rows() . '" align="center"></td>
                        </tr>
                 </table>';

			$html .= '<table width="100%" border="1" cellspacing="0" style="font-size:14px;font-family: ;">
                        <tr style="font-weight: bold;">
                            <td>Tanggal</td>
                            <td>Harga Satuan</td>';
			foreach ($data_tgl->result() as $r) {
				$html .= '<td>' . $r->day . '</td>';
			}
			$html .= '
                             <td>Total Cost</td>
                        </tr>
                        <tr style="background-color:yellow;font-weight: bold;">
                            <td>Hasil Rewinder</td>
                            <td></td>';
			$tot_rewinder = 0;
			foreach ($data_tgl->result() as $r) {
				$rewinder =  $this->db->query("SELECT nominal FROM `m_rewinder` WHERE  tanggal = '" . $r->tanggal . "' ")->row();
				$html .= '<td align="right">' . number_format($rewinder->nominal, 2, ",", ".") . '</td>';
				$tot_rewinder += $rewinder->nominal;
			}
			$html .= '
                            <td align="right">' . number_format($tot_rewinder, 2, ",", ".") . '</td>
                        </tr>';

			$sub_kategori = $this->db->query("SELECT * FROM `m_sub_kategori` WHERE id_kategori='$id_kategori' and status='1' ORDER BY nm_sub_kategori ")->result();

			$tot_pemakaian = 0;
			foreach ($sub_kategori as $sub) {
				$html .= '
                             <tr style="font-weight: bold;">
                                <td>' . $sub->nm_sub_kategori . '</td>
                                <td></td>';
				foreach ($data_tgl->result() as $r) {

					$html .= '<td></td>';
				}
				$html .= '
                                <td></td>
                             </tr>';


				$produk = $this->db->query("SELECT * FROM `m_produk` WHERE id_kategori='$id_kategori' AND id_sub_kategori='" . $sub->id . "' and status='1' ORDER BY nm_produk ")->result();

				foreach ($produk as $pro) {
					$harga = $this->db->query("SELECT ifnull(harga,0) harga FROM `m_harga` WHERE id_produk='" . $pro->id . "' AND DATE_FORMAT(tanggal,'%Y-%m') = '$periode' ORDER BY id DESC limit 1");

					$html .= '
                                     <tr>
                                        <td style="padding-left:10px"> * ' . $pro->nm_produk . '</td>
                                        <td>' . ($harga->num_rows() > 0 ? number_format($harga->row()->harga, 2, ",", ".") : 0) . '</td>';

					$tot_cost_samping = 0;
					foreach ($data_tgl->result() as $r) {
						$pemakaian = $this->db->query("SELECT ifnull(nominal,0) nominal,ifnull(harga,0) harga FROM `tr_pemakaian` WHERE id_produk='" . $pro->id . "' AND tanggal = '" . $r->tanggal . "' limit 1");



						if ($pro->id == '55') {
							$jum_pemakaian = 0;
						} else if ($pro->id == '56') {
							$pemakaian = $this->db->query("SELECT sum(ifnull(nominal,0)) nominal,ifnull(harga,0) harga FROM `tr_pemakaian` WHERE id_produk in (53) AND tanggal = '" . $r->tanggal . "' limit 1");


							$pemakaian1 = $this->db->query("SELECT sum(ifnull(nominal,0)) nominal,ifnull(harga,0) harga FROM `tr_pemakaian` WHERE id_produk in (54) AND tanggal = '" . $r->tanggal . "' limit 1");


							$jum_pemakaian = ($pemakaian->num_rows() > 0 ? $pemakaian->row()->harga : 0) * ($pemakaian->num_rows() > 0 ? $pemakaian->row()->nominal : 0);

							$jum_pemakaian1 = ($pemakaian1->num_rows() > 0 ? $pemakaian1->row()->harga : 0) * ($pemakaian1->num_rows() > 0 ? $pemakaian1->row()->nominal : 0);

							$jum_pemakaian = ($jum_pemakaian + $jum_pemakaian1) * 0.03;
						} else {

							$jum_pemakaian = ($pemakaian->num_rows() > 0 ? $pemakaian->row()->harga : 0) * ($pemakaian->num_rows() > 0 ? $pemakaian->row()->nominal : 0);
						}

						$html .= '<td align="right">' . number_format(round($jum_pemakaian), 2, ",", ".") . '</td>';

						$tot_cost_samping += $jum_pemakaian;
					}


					$html .= '
                                        <td align="right">' . number_format($tot_cost_samping, 2, ",", ".") . '</td>
                                     </tr>';
				}

				if ($id_kategori == '3') {

					$html .= '
                                 <tr style="font-weight: bold;">
                                    <td>Total </td>
                                    <td></td>';
					foreach ($data_tgl->result() as $r) {
						$pemakaian = $this->db->query("SELECT SUM(nominal) nominal FROM ( SELECT  ((nominal) * (harga)) nominal FROM tr_pemakaian a WHERE id_sub_kategori = '" . $sub->id . "' AND tanggal ='" . $r->tanggal . "' and id_produk <> 55)z")->row("nominal");

						$pemakaian1 = $this->db->query("SELECT SUM(nominal) nominal FROM ( SELECT  ((nominal) * (harga))nominal FROM tr_pemakaian a WHERE id_sub_kategori = '" . $sub->id . "' AND tanggal ='" . $r->tanggal . "' and id_produk in (53,54) )z")->row("nominal");

						if ($sub->id == '17') {
							$pemakaian = $pemakaian + ($pemakaian1 * 0.03);
						}
						$html .= '<td align="right">' . number_format(round($pemakaian), 2, ",", ".") . '</td>';
					}
					$html .= '
                                    <td></td>
                                 </tr>
                                 <tr style="background-color:#3cd7ea;font-weight: bold;">
                                    <td>BIAYA ' . $sub->nm_sub_kategori . ' / KG PAPER</td>
                                    <td></td>';
					foreach ($data_tgl->result() as $r) {
						$pemakaian = $this->db->query("SELECT SUM(nominal) nominal FROM ( SELECT  ((nominal) * (harga)) nominal FROM tr_pemakaian a WHERE id_sub_kategori = '" . $sub->id . "' AND tanggal ='" . $r->tanggal . "' and id_produk <> '55' )z")->row("nominal");

						$rewinder = $this->db->query("SELECT * FROM m_rewinder WHERE  tanggal ='" . $r->tanggal . "'")->row("nominal");

						if ($sub->id == '17') {
							# code...
							$biaya =  ($pemakaian / $rewinder) + (($pemakaian * 0.03) / $rewinder);
						} else {
							$biaya =  ($pemakaian / $rewinder);
						}

						$html .= '<td align="right">' . number_format($biaya, 2, ",", ".") . '</td>';
					}
					$html .= '
                                    <td></td>
                                 </tr>';
				}
			}
			if ($id_kategori != '3') {
				$html .= '
                         <tr style="font-weight: bold;">
                            <td>Total ' . $nm_kategori . '</td>
                            <td></td>';
				$tot_cost = 0;
				foreach ($data_tgl->result() as $r) {

					$tot_pemakaian = $this->db->query("SELECT  SUM(pemakaian) pemakaian FROM (
                                      SELECT (nominal * harga) pemakaian FROM tr_pemakaian a WHERE tanggal ='" . $r->tanggal . "' AND id_kategori = '$id_kategori' )z
                                        ")->row("pemakaian");



					$html .= '<td align="right">' . number_format($tot_pemakaian, 2, ",", ".") . '</td>';
					$tot_cost += $tot_pemakaian;
				}

				//total cost samping
				$tot_cost_samping_bawah = $this->db->query("SELECT sum(total) total FROM ( SELECT ((nominal) * (harga)) total  FROM `tr_pemakaian` 
                                 WHERE DATE_FORMAT(tanggal,'%Y-%m') = '$periode' AND id_kategori = '$id_kategori' AND id_produk NOT IN (28,29,30,31,32,33) )z")->row("total");
				$html .= '
                            <td align="right">' . number_format($tot_cost_samping_bawah, 2, ",", ".") . '</td>
                        </tr>
                         <tr style="font-weight: bold;background-color:#3cd7ea">
                            <td>BIAYA ' . $nm_kategori . ' /KG PAPER </td>
                            <td></td>';
				foreach ($data_tgl->result() as $r) {
					$rewinder =  $this->db->query("SELECT nominal FROM `m_rewinder` WHERE  tanggal = '" . $r->tanggal . "' ")->row();
					$tot_bahan_baku =  $this->db->query("SELECT  SUM(pemakaian) nominal FROM (
                                      SELECT (nominal * harga) pemakaian FROM tr_pemakaian a WHERE tanggal ='" . $r->tanggal . "' AND id_kategori = '$id_kategori' )z
                                        ")->row("nominal");


					$biaya = $tot_bahan_baku / $rewinder->nominal;
					$html .= '<td align="right">' . number_format($biaya, 2, ",", ".") . '</td>';
				}
				$html .= '
                            <td></td>
                        </tr>';
			}

			$html .= '
                    </table>';
		} else {
			$html .= '<h1> Data Kosong </h1>';
		}

		$kategori = $this->db->query("SELECT nm_kategori from m_kategori WHERE id='$id_kategori' ")->row("nm_kategori");

		$kategori = str_replace(",", "", $kategori);
		$judul = "Laporan Cost " . $kategori . " periode " . $periode;

		if ($ctk == '0') {
			echo $html;
		} else {
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=$judul.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$data['prev'] = $html;
			$this->load->view('view_excel', $data);
		}
	}

	public function cetak_anu()
	{
		$data = array(
			'judul' => "Invoice",
		);
		$this->load->view('header', $data);
		$this->load->view('anu');
		$this->load->view('footer');
	}
}
