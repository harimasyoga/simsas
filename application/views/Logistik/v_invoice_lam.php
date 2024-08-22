<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
			<div class="col-sm-6"></div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right"></ol>
			</div>
			</div>
		</div>
	</section>

	<style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>

	<section class="content">
		<div class="container-fluid">

			<div class="row row-input-invoice-laminasi" style="display:none">
				<div class="col-md-7">
					<div class="card card-success card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT INVOICE LAMINASI</h3>
						</div>
						<div style="margin:12px 6px;display:flex">
							<button type="button" class="btn btn-sm btn-info" onclick="kembali()"><i class="fa fa-arrow-left"></i> <b>KEMBALI</b></button><div id="btn-header" style="margin-left:6px"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TGL. INVOICE</div>
							<div class="col-md-8">
								<input type="date" id="tgl_invoice" class="form-control" value="<?= date('Y-m-d')?>">
							</div>
							<div class="col-md-1"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TGL. SJ</div>
							<div class="col-md-8">
								<input type="date" id="tgl_sj" class="form-control" onchange="cariSJLaminasi()">
							</div>
							<div class="col-md-1"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">SURAT JALAN</div>
							<div class="col-md-9">
								<select id="no_surat_jalan" class="form-control select2" onchange="pilihSJInvLam()" disabled>
									<option value="">PILIH</option>
								</select>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">NO. INVOICE</div>
							<div class="col-md-8">
								<input type="text" class="form-control" style="font-weight:bold" id="txt_no_invoice" value="AUTO" disabled>
								<input type="hidden" id="no_invoice" value="">
							</div>
							<div class="col-md-1"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 16px">
							<div class="col-md-3">TGL. JATUH TEMPO</div>
							<div class="col-md-8">
								<input type="date" id="tgl_jatuh_tempo" class="form-control">
							</div>
							<div class="col-md-1"></div>
						</div>
					</div>
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">DIKIRIM KE</h3>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:16px 12px 6px">
							<div class="col-md-3">KEPADA</div>
							<div class="col-md-9">
								<input type="hidden" id="h_id_pelanggan_lm" value="">
								<input type="text" id="kepada" class="form-control" placeholder="Kepada" autocomplete="off" oninput="this.value=this.value.toUpperCase()">
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">ALAMAT</div>
							<div class="col-md-9">
								<textarea id="alamat" class="form-control" style="resize:none" rows="3" placeholder="Alamat" autocomplete="off" oninput="this.value=this.value.toUpperCase()"></textarea>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 16px">
							<div class="col-md-3">PILIHAN BANK</div>
							<div class="col-md-9">
								<select id="pilihan_bank" class="form-control select2" disabled>
									<option value="">PILIH</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<div class="col-verif-invoice-laminasi" style="display:none">
						<div class="card card-info card-outline" style="padding-bottom:18px">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">VERIFIKASI DATA</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:18px 12px 6px">
								<div class="col-md-3">ADMIN</div>
								<div class="col-md-9">
									<div id="verif-admin"></div>
								</div>
							</div>
							<div id="input-marketing"></div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3">OWNER</div>
								<div class="col-md-9">
									<div id="verif-owner"></div>
								</div>
							</div>
							<div id="input-owner"></div>
						</div>
					</div>
				</div>
				<input type="hidden" id="h_id_header" value="">
			</div>

			<div class="row row-item-invoice-laminasi" style="display:none">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST ITEM</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-item">LIST ITEM KOSONG</div>
								<div class="disc-potongan" style="display:none">
									<div class="card-body row" style="font-weight:bold;padding:12px 6px 6px">
										<div class="col-md-1">*OPSI</div>
										<div class="col-md-3">
											<select id="dc_opsi" class="form-control select2" onchange="discOpsi()">
												<option value="">PILIH</option>
												<option value="DISCOUNT">DISCOUNT</option>
												<option value="BIAYA BONGKAR">BIAYA BONGKAR</option>
												<option value="POTONG KARUNG">POTONG KARUNG</option>
											</select>
										</div>
										<div class="col-md-8"></div>
									</div>
									<div class="dcp-persen" style="display:none">
										<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
											<div class="col-md-1"></div>
											<div class="col-md-3">
												<div class="input-group">
													<input type="number" id="dcp_input_persen" class="form-control" autocomplete="off" placeholder="%" onkeyup="keyUpDisc('persen')">
													<div class="input-group-append">
														<span class="input-group-text" style="font-weight:bold">%</span>
													</div>
												</div>
											</div>
											<div class="col-md-8"></div>
										</div>
									</div>
									<div class="dcp-hari" style="display:none">
										<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
											<div class="col-md-1"></div>
											<div class="col-md-3">
												<div class="input-group">
													<input type="number" id="dcp_input_hari" class="form-control" autocomplete="off" placeholder="HARI" onkeyup="keyUpDisc('hari')">
													<div class="input-group-append">
														<span class="input-group-text" style="font-weight:bold">HARI</span>
													</div>
												</div>
											</div>
											<div class="col-md-8"></div>
										</div>
									</div>
									<div class="dcp-rupiah" style="display:none">
										<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
											<div class="col-md-1"></div>
											<div class="col-md-3">
												<div class="input-group">
													<input type="number" id="dcp_input_rupiah" class="form-control" autocomplete="off" placeholder="Rp." onkeyup="keyUpDisc('rupiah')">
													<div class="input-group-append">
														<span class="input-group-text" style="font-weight:bold">Rp</span>
													</div>
												</div>
											</div>
											<div class="col-md-8"></div>
										</div>
									</div>
									<div class="dcp-ball" style="display:none">
										<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
											<div class="col-md-1"></div>
											<div class="col-md-3">
												<div class="input-group">
													<input type="number" id="dcp_input_ball" class="form-control" autocomplete="off" placeholder="BALL" onkeyup="keyUpDisc('ball')">
													<div class="input-group-append">
														<span class="input-group-text" style="font-weight:bold">BALL</span>
													</div>
												</div>
											</div>
											<div class="col-md-8"></div>
										</div>
									</div>
									<div class="dcp-hitung" style="display:none">
										<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
											<div class="col-md-1"></div>
											<div class="col-md-3">
												<input type="text" id="dcp_input_hitung" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" disabled onkeyup="keyUpDisc('hitung')">
											</div>
											<div class="col-md-8"></div>
										</div>
									</div>
									<div class="dcp-total" style="display:none">
										<div class="card-body row" style="font-weight:bold;padding:0 6px 6px">
											<div class="col-md-1">HASIL</div>
											<div class="col-md-3">
												<input type="text" id="dcp_input_total" class="form-control" style="font-weight:bold;color:#000;text-align:right" autocomplete="off" placeholder="0" disabled onkeyup="keyUpDisc('total')">
											</div>
											<div class="col-md-8"></div>
										</div>
									</div>
									<div class="card-body row" style="font-weight:bold;padding:0 6px 16px">
										<div class="col-md-1"></div>
										<div class="col-md-11">
											<div class="btn-add-disc"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-pembayaran" style="display:none">
				<div class="col-md-12">
					<div class="card card-primary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">PEMBAYARAN</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-pembayaran"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-list-invoice-laminasi">
				<div class="col-md-12 col-list-laminasi">
					<div class="card shadow mb-3">
						<div class="card-header" style="font-family:Cambria;">
							<h3 class="card-title" style="color:#4e73df;"><b>INVOICE LAMINASI</b></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<?php if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi', 'Keuangan1'])){ ?>
								<div style="margin-bottom:12px">
									<?php if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi'])){ ?>
										<button type="button" class="btn btn-sm btn-info" onclick="tambahData()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
									<?php } ?>
									<button type="button" class="btn btn-sm btn-danger" onclick="laporanInvoice('laporan')"><i class="fas fa-file-alt"></i> <b>LAPORAN</b></button>
									<button type="button" class="btn btn-sm btn-danger" onclick="laporanInvoice('pembayaran')"><i class="fas fa-money-check"></i> <b>PEMBAYARAN</b></button>
								</div>
							<?php } ?>
							<div class="card-body row" style="padding:0 0 8px;font-weight:bold">
								<div class="col-md-2" style="padding-bottom:3px">
									<select id="tahun" class="form-control select2" onchange="load_data()">
										<?php 
											$thang = date("Y");
											$thang_maks = $thang + 2;
											$thang_min = $thang - 2;
											for ($th = $thang_min; $th <= $thang_maks; $th++)
											{ ?>
												<?php if ($th==$thang) { ?>
													<option selected value="<?= $th ?>"> <?= $thang ?> </option>
												<?php }else{ ?>
													<option value="<?= $th ?>"> <?= $th ?> </option>
												<?php }
											}
										?>
									</select>
								</div>
								<?php if($this->session->userdata('username') != 'usman'){ ?>
									<div class="col-md-2" style="padding-bottom:3px">
										<select id="jenis" class="form-control select2" onchange="load_data()">
											<option value="">SEMUA</option>
											<option value="PPI">PPI</option>
											<option value="PEKALONGAN">PEKALONGAN</option>
										</select>
									</div>
									<div class="col-md-4" style="padding-bottom:3px">
										<select id="hub" class="form-control select2" onchange="load_data()">
											<?php
												$query = $this->db->query("SELECT*FROM m_no_rek_lam WHERE id_hub!='0' AND id_hub!='7' ORDER BY an_bank");
												$html ='';
												$html .='<option value="">SEMUA</option>';
												foreach($query->result() as $r){
													$html .='<option value="'.$r->id_hub.'">'.$r->an_bank.'</option>';
												}
												echo $html
											?>
										</select>
									</div>
									<div class="col-md-4"></div>
								<?php }else{ ?>
									<div class="col-md-10">
										<input type="hidden" id="jenis" value="">
										<input type="hidden" id="hub" value="">
									</div>
								<?php } ?>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable" class="table table-bordered table-striped">
									<thead class="color-tabel">
										<tr>
											<th style="padding:12px;text-align:center">NO.</th>
											<th style="padding:12px;text-align:center">DESKRIPSI</th>
											<th style="padding:12px;text-align:center">JATUH TEMPO</th>
											<th style="padding:12px;text-align:center">BATAS WAKTU</th>
											<th style="padding:12px;text-align:center">PEMBAYARAN</th>
											<th style="padding:12px;text-align:center">TOTAL</th>
											<th style="padding:12px;text-align:center">ADMIN</th>
											<th style="padding:12px;text-align:center">OWNER</th>
											<th style="padding:12px;text-align:center">CETAK</th>
											<th style="padding:12px;text-align:center">AKSI</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-list-lam-laporan" style="display:none">
					<div class="card shadow mb-3">
						<div class="card-header" style="font-family:Cambria;">
							<h3 class="card-title" style="color:#4e73df;"><b>LAPORAN LAMINASI</b></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<?php if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi', 'Keuangan1'])){ ?>
								<div style="margin-bottom:12px">
									<button type="button" class="btn btn-sm btn-info" onclick="laporanInvoice('list')"><i class="fas fa-list"></i> <b>LIST INVOICE</b></button>
								</div>
							<?php } ?>
							<div style="overflow:auto;white-space:nowrap">
								<table style="font-weight:bold">
									<tr>
										<td style="padding:3px 0">PILIH</td>
										<td style="padding:3px 10px">:</td>
										<td style="padding:3px 0" colspan="3">
											<select id="plh-lap-lap" class="form-control select2">
												<?php
													$html ='';
													if($this->session->userdata('username') == 'usman'){
														$html .='<option value="PEKALONGAN">PEKALONGAN</option>';
													}else{
														$html .='<option value="">SEMUA</option>
														<option value="PPI">PPI</option>
														<option value="PEKALONGAN">PEKALONGAN</option>';
													}
													echo $html;
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td style="padding:3px 0">CUSTOMER</td>
										<td style="padding:3px 10px">:</td>
										<td style="padding:3px 0" colspan="3">
											<select id="plh-lap-cust" class="form-control select2">
												<?php
													($this->session->userdata('username') == 'usman') ? $where = "WHERE h.jenis_lm='PEKALONGAN'" : $where = '';
													$query = $this->db->query("SELECT h.id_pelanggan_lm,h.attn_lam_inv FROM invoice_laminasi_header h
													$where GROUP BY h.id_pelanggan_lm,h.attn_lam_inv ORDER BY h.attn_lam_inv");
													$html2 ='';
													$html2 .='<option value="" attn="">SEMUA</option>';
													foreach($query->result() as $r){
														$html2 .='<option value="'.$r->id_pelanggan_lm.'" attn="'.$r->attn_lam_inv.'">'.$r->id_pelanggan_lm.' | '.$r->attn_lam_inv.'</option>';
													}
													echo $html2;
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td style="padding:3px 0">TANGGAL SURAT JALAN</td>
										<td style="padding:3px 10px">:</td>
										<td>
											<input type="date" id="tgl1_lap" class="form-control" value="<?= date("Y-m-d")?>">
										</td>
										<td style="padding:3px 10px">S/D</td>
										<td>
											<input type="date" id="tgl2_lap" class="form-control" value="<?= date("Y-m-d")?>">
										</td>
										<td style="padding:3px 10px">
											<button type="button" class="btn btn-primary" onclick="cariLaporanLaminasi('laporan')"><i class="fas fa-search"></i></button>
										</td>
										<td style="padding:3px 10px">
											<div class="btn-print-lap-lam-pdf"></div>
										</td>
									</tr>
								</table>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<div class="cari-lap-laminasi"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-list-lam-pembayaran" style="display:none">
					<div class="card shadow mb-3">
						<div class="card-header" style="font-family:Cambria;">
							<h3 class="card-title" style="color:#4e73df;"><b>LAPORAN PEMBAYARAN LAMINASI</b></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<?php if(in_array($this->session->userdata('level'), ['Admin', 'Laminasi', 'Keuangan1'])){ ?>
								<div style="margin-bottom:12px">
									<button type="button" class="btn btn-sm btn-info" onclick="laporanInvoice('list')"><i class="fas fa-list"></i> <b>LIST INVOICE</b></button>
								</div>
							<?php } ?>
							<div style="overflow:auto;white-space:nowrap">
								<table style="font-weight:bold">
									<tr>
										<td style="padding:3px 0">PILIH</td>
										<td style="padding:3px 10px">:</td>
										<td style="padding:3px 0" colspan="3">
											<select id="plh_pilih" class="form-control select2">
												<?php
													$html3 = '';
													if($this->session->userdata('username') == 'usman'){
														$html3 .='<option value="PEKALONGAN">PEKALONGAN</option>';
													}else{
														$html3 .='<option value="">SEMUA</option>
														<option value="PPI">PPI</option>
														<option value="PEKALONGAN">PEKALONGAN</option>';
													}
													echo $html3;
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td style="padding:3px 0">PEMBAYARAN</td>
										<td style="padding:3px 10px">:</td>
										<td style="padding:3px 0" colspan="3">
											<select id="plh_bayar" class="form-control select2">
												<option value="">SEMUA</option>
												<option value="BELUM BAYAR">BELUM BAYAR</option>
												<option value="NYICIL">NYICIL</option>
												<option value="LUNAS">LUNAS</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="padding:3px 0">CUSTOMER</td>
										<td style="padding:3px 10px">:</td>
										<td style="padding:3px 0" colspan="3">
											<select id="plh_cust" class="form-control select2">
												<?php
													($this->session->userdata('username') == 'usman') ? $where2 = "WHERE h.jenis_lm='PEKALONGAN'" : $where2 = '';
													$query = $this->db->query("SELECT h.id_pelanggan_lm,h.attn_lam_inv FROM invoice_laminasi_header h
													$where2 GROUP BY h.id_pelanggan_lm,h.attn_lam_inv ORDER BY h.attn_lam_inv");
													$html4 ='';
													$html4 .='<option value="" attn="">SEMUA</option>';
													foreach($query->result() as $r){
														$html4 .='<option value="'.$r->id_pelanggan_lm.'" attn="'.$r->attn_lam_inv.'">'.$r->id_pelanggan_lm.' | '.$r->attn_lam_inv.'</option>';
													}
													echo $html4;
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td style="padding:3px 0">TGL. JATUH TEMPO</td>
										<td style="padding:3px 10px">:</td>
										<td>
											<input type="date" id="tgl1_jt" class="form-control" value="<?= date("Y-m-d")?>">
										</td>
										<td style="padding:3px 10px">S/D</td>
										<td>
											<input type="date" id="tgl2_jt" class="form-control" value="<?= date("Y-m-d")?>">
										</td>
										<td style="padding:3px 10px">
											<button type="button" class="btn btn-primary" onclick="cariPembayaranLaminasi('laporan')"><i class="fas fa-search"></i></button>
										</td>
										<td style="padding:3px 10px">
											<div class="btn-print-bayar-lam-pdf"></div>
										</td>
									</tr>
								</table>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<div class="cari-lap-pembayaran"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="font-weight:bold">LIST SURAT JALAN</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="overflow:auto;white-space:nowrap">
					<div class="list-cari-sj"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';
	const urlUser = '<?= $this->session->userdata('username')?>';

	$(document).ready(function ()
	{
		load_data()
		$('.select2').select2();
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() {
		let tahun = $("#tahun").val()
		let jenis = $("#jenis").val()
		let hub = $("#hub").val()
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Logistik/load_data/loadDataInvoiceLaminasi')?>',
				"type": "POST",
				"data": ({
					tahun, jenis, hub
				}),
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}

	function kosong()
	{
		$("#h_id_header").val("")

		let tanggal = '<?= date("Y-m-d")?>'
		$("#tgl_invoice").val(tanggal).prop('disabled', false)
		$("#tgl_sj").val("").prop('disabled', false)
		$("#no_surat_jalan").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$("#txt_no_invoice").val("AUTO").prop('disabled', true)
		$("#no_invoice").val("")
		$("#tgl_jatuh_tempo").val("").prop('disabled', false)

		$("#h_id_pelanggan_lm").val("")
		$("#kepada").val("").prop('disabled', false)
		$("#alamat").val("").prop('disabled', false)
		$("#pilihan_bank").html('<option value="">PILIH</option>').prop('disabled', true)

		$("#verif-admin").html('. . .')
		$("#verif-owner").html('. . .')
		$("#input-owner").html('')
		$(".list-item").html('LIST ITEM KOSONG')

		$(".disc-potongan").hide()
		$("#dc_opsi").val("").prop('disabled', false).trigger('change')
		$(".dcp-persen").hide()
		$(".dcp-hari").hide()
		$(".dcp-rupiah").hide()
		$(".dcp-ball").hide()

		$(".row-pembayaran").hide()
		$(".list-pembayaran").html("")
		
		$("#dcp_input_persen").val("")
		$("#dcp_input_hari").val("")
		$("#dcp_input_rupiah").val("")
		$("#dcp_input_ball").val("")
		$("#dcp_input_hitung").val("")
		$("#dcp_input_total").val("")

		statusInput = 'insert'
		swal.close()
	}

	function tambahData() {
		kosong()
		$(".row-list-invoice-laminasi").hide()
		$(".col-verif-invoice-laminasi").hide()
		$(".row-input-invoice-laminasi").show()
		$(".row-item-invoice-laminasi").show()
	}

	function kembali() {
		kosong()
		reloadTable()
		$(".row-input-invoice-laminasi").hide()
		$(".col-verif-invoice-laminasi").hide()
		$(".row-item-invoice-laminasi").hide()
		$(".row-list-invoice-laminasi").show()
	}

	function cariSJLaminasi(){
		$("#no_surat_jalan").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$(".list-item").html('LIST ITEM KOSONG')
		let tgl_sj= $("#tgl_sj").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/cariSJLaminasi')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({ tgl_sj }),
			success: function(res){
				data = JSON.parse(res)
				$("#no_surat_jalan").html(data.htmlSJ).prop('disabled', (data.numRows == 0) ? true : false)
				swal.close()
			}
		})
	}

	function pilihSJInvLam() {
		$(".list-item").html('LOAD DATA LIST ITEM')
		let no_surat = $("#no_surat_jalan").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/pilihSJInvLam')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({ no_surat }),
			success: function(res){
				data = JSON.parse(res)
				if(no_surat != ''){
					$("#txt_no_invoice").val("AUTO")
					$("#no_invoice").val(data.no_invoice)
					$("#h_id_pelanggan_lm").val(data.id_pelanggan_lm)
					$("#kepada").val(data.kepada)
					$("#alamat").val(data.alamat)
					$("#pilihan_bank").html(data.htmlBank).prop('disabled', true)
					$(".list-item").html(data.htmlItem)
				}
				swal.close()
			}
		})
	}

	function simpanInvLam() {
		let h_id_header = $("#h_id_header").val()
		let tgl_invoice = $("#tgl_invoice").val()
		let tgl_sj = $("#tgl_sj").val()
		let no_surat_jalan = $("#no_surat_jalan").val()
		let no_invoice = $("#no_invoice").val()
		let tgl_jatuh_tempo = $("#tgl_jatuh_tempo").val()
		let h_id_pelanggan_lm = $("#h_id_pelanggan_lm").val()
		let kepada = $("#kepada").val()
		let alamat = $("#alamat").val()
		let pilihan_bank = $("#pilihan_bank").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanInvLam')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				h_id_header, tgl_invoice, tgl_sj, no_surat_jalan, no_invoice, tgl_jatuh_tempo, h_id_pelanggan_lm, kepada, alamat, pilihan_bank, statusInput
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					toastr.success(`<b>BERHASIL!</b>`)
					kembali()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function editInvoiceLaminasi(id_header, opsi) {
		$(".row-list-invoice-laminasi").hide()
		$(".row-input-invoice-laminasi").show()
		$(".col-verif-invoice-laminasi").attr('style', 'position:sticky;top:12px;margin-bottom:16px')
		$(".row-item-invoice-laminasi").show()
		$.ajax({
			url: '<?php echo base_url('Logistik/editInvoiceLaminasi')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				id_header, opsi
			}),
			success: function(res){
				data = JSON.parse(res)
				$("#h_id_header").val(id_header)
				let prop = true;
				(opsi == 'edit') ? prop = false : prop = true;
				$("#tgl_invoice").val(data.header.tgl_invoice).prop('disabled', prop)
				$("#tgl_sj").val(data.header.tgl_surat_jalan).prop('disabled', true)
				$("#no_surat_jalan").html(`<option value="${data.header.no_surat}">${data.header.no_surat}</option>`).prop('disabled', true)
				$("#txt_no_invoice").val(data.header.no_invoice)
				$("#no_invoice").val(data.header.no_invoice).prop('disabled', true)
				$("#tgl_jatuh_tempo").val(data.header.tgl_jatuh_tempo).prop('disabled', prop)
				$("#h_id_pelanggan_lm").val(data.header.id_pelanggan_lm).prop('disabled', prop)
				$("#kepada").val(data.header.attn_lam_inv).prop('disabled', prop)
				$("#alamat").val(data.header.alamat_lam_inv).prop('disabled', prop)
				$("#pilihan_bank").html(data.htmlBank).prop('disabled', true)
				// VERIFIKASI DATA
				$("#verif-admin").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.oke_admin}`)
				// VERIFIFIKASI OWNER
				if((urlAuth == 'Admin' || (urlAuth == 'Keuangan1' && urlUser == 'bumagda')) && data.header.acc_admin == 'Y' && (data.header.acc_owner == 'N' || data.header.acc_owner == 'H' || data.header.acc_owner == 'R')){
					// BUTTON OWNER
					let lock = ''
					if(urlAuth == 'Admin' && data.header.acc_owner != 'N'){
						lock = `<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifInvLaminasi('lock','owner')"><i class="fas fa-lock"></i> Lock</button>`
					}else{
						lock = ''
					}
					$("#verif-owner").html(`
						${lock}
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifInvLaminasi('verifikasi','owner')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifInvLaminasi('hold','owner')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifInvLaminasi('reject','owner')"><i class="fas fa-times"></i> Reject</button>
					`)
					// KETERANGAN OWNER
					if(data.header.acc_owner != 'N'){
						if(data.header.acc_owner == 'H'){
							callout = 'callout-warning'
							colorbtn = 'btn-warning'
							txtsave = 'HOLD!'
						}else{
							callout = 'callout-danger'
							colorbtn = 'btn-danger'
							txtsave = 'REJECT!'
						}
						$("#input-owner").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:0;margin:0">
										<textarea class="form-control" id="ket_laminasi" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.ket_owner}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifInvLaminasi('${data.header.acc_owner}', 'owner')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
								</div>
							</div>
						`)
					}
				}else{
					// BUTTON OWNER
					if(data.header.acc_owner == 'N'){
						$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-lock"></i></button>`)
					}else if(data.header.acc_owner == 'H'){
						$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;cursor:default" class="btn btn-sm btn-warning"><i class="fas fa-hand-paper"></i></button> ${data.time_owner}`)
					}else if(data.header.acc_owner == 'R'){
						$("#verif-owner").html(`<button style="text-align:center;font-weight:bold;padding:4px 10px;cursor:default" class="btn btn-sm btn-danger"><i class="fas fa-times" style="color:#000"></i></button> ${data.time_owner}`)
					}else{
						$("#verif-owner").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.time_owner}`)
					}
					// KETERANGAN OWNER
					if(data.header.acc_owner != 'N'){
						if(data.header.acc_owner == 'H'){
							callout = 'callout-warning'
						}else if(data.header.acc_owner == 'R'){
							callout = 'callout-danger'
						}else{
							callout = 'callout-success'
						}
						$("#input-owner").html(`
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="callout ${callout}" style="padding:6px;margin:0">${data.header.ket_owner}</div>
								</div>
							</div>
						`)
					}
				}
				// PEMBAYARAN
				if(data.header.acc_owner != 'Y'){
					$(".row-item-invoice-laminasi").show()
					$(".row-pembayaran").hide()
					$(".list-item").html(data.htmlItem)
					$(".list-pembayaran").html("")
				}
				if(data.header.acc_owner == 'Y'){
					$(".row-item-invoice-laminasi").hide()
					$(".row-pembayaran").show()
					$(".list-item").html("")
					$(".list-pembayaran").html(data.htmlBayar)
				}
				// DISCOUNT / POTONGAN
				if(opsi == 'edit' && (data.header.acc_owner == 'N' || data.header.acc_owner == 'H' || data.header.acc_owner == 'R') && (urlAuth == 'Admin' || urlAuth == 'Laminasi')){
					$(".disc-potongan").show()
				}else{
					$(".disc-potongan").hide()
				}
				statusInput = 'update'
				swal.close()
			}
		})
	}

	function returInvLaminasi(id_dtl, id_header)
	{
		let retur_qty = $("#retur-"+id_dtl).val()
		let qty_order = $("#h_qty_order-"+id_dtl).val().split('.').join('')
		$.ajax({
			url: '<?php echo base_url('Logistik/returInvLaminasi')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				id_dtl, retur_qty, qty_order
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					if(data.data2){
						toastr.error(`<b>${data.msg}</b>`)
					}else{
						toastr.success(`<b>${data.msg}</b>`)
					}
					editInvoiceLaminasi(id_header, 'edit')
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					editInvoiceLaminasi(id_header, 'edit')
					swal.close()
				}
			}
		})
	}

	function upHargainv(i)
	{
		let rupiah = new Intl.NumberFormat('id-ID', {styles: 'currency', currency: 'IDR'})
		let harga = $("#harga-"+i).val().split('.').join('');
		(harga == 0 || harga < 0 || harga == '') ? $("#harga-"+i).val(0) : $("#harga-"+i).val(rupiah.format(harga));
	}

	function hargaInvLaminasi(id_dtl, id_header)
	{
		let harga = $("#harga-"+id_dtl).val().split('.').join('')
		$.ajax({
			url: '<?php echo base_url('Logistik/hargaInvLaminasi')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				id_dtl, harga
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data == false){
					toastr.error(`<b>${data.msg}</b>`)
				}
				editInvoiceLaminasi(id_header, 'edit')
			}
		})
	}

	function verifInvLaminasi(aksi, status_verif)
	{
		if(aksi == 'verifikasi'){
			vrf = 'Y'
			callout = 'callout-success'
			colorbtn = 'btn-success'
			txtsave = 'VERIFIKASI!'
		}else if(aksi == 'lock'){
			vrf = 'N'
			callout = 'callout-warning'
			colorbtn = 'btn-warning'
			txtsave = 'LOCK!'
		}else if(aksi == 'hold'){
			vrf = 'H'
			callout = 'callout-warning'
			colorbtn = 'btn-warning'
			txtsave = 'HOLD!'
		}else if(aksi == 'reject'){
			vrf = 'R'
			callout = 'callout-danger'
			colorbtn = 'btn-danger'
			txtsave = 'REJECT!'
		}
		$("#input-owner").html(`
			<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<div class="callout ${callout}" style="padding:0;margin:0">
						<textarea class="form-control" id="ket_laminasi" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()"></textarea>
					</div>
				</div>
			</div>
			<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifInvLaminasi('${vrf}', '${status_verif}')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
				</div>
			</div>
		`)
	}

	function btnVerifInvLaminasi(aksi, status_verif)
	{
		let h_id_header = $("#h_id_header").val()
		let ket_laminasi = $("#ket_laminasi").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/btnVerifInvLaminasi')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				h_id_header, ket_laminasi, aksi, status_verif
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data){
					kembali()
				}else{
					toastr.error(`<b>KETERANGAN TIDAK BOLEH KOSONG!</b>`)
					swal.close()
				}
			}
		})
	}

	function keyUpDisc(opsi) {
		let dc_opsi = $("#dc_opsi").val()
		let h_total_inv = $("#h_total_inv").val()
		// KEYUP
		if(opsi == 'persen'){
			let persen = $("#dcp_input_persen").val();
			(persen < 0) ? persen = 0 : persen = persen;
			$("#dcp_input_persen").val(persen)
		}
		if(opsi == 'hari'){
			let hari = $("#dcp_input_hari").val();
			(hari < 0) ? hari = 0 : hari = hari;
			$("#dcp_input_hari").val(hari)
		}
		if(opsi == 'rupiah'){
			let rupiah = $("#dcp_input_rupiah").val();
			(rupiah < 0) ? rupiah = 0 : rupiah = rupiah;
			$("#dcp_input_rupiah").val(rupiah)
		}
		if(opsi == 'ball'){
			let ball = $("#dcp_input_ball").val();
			(ball < 0) ? ball = 0 : ball = ball;
			$("#dcp_input_ball").val(ball)
		}
		// PERHITUNGAN
		// DISCOUNT
		if(dc_opsi == 'DISCOUNT'){
			let persen = $("#dcp_input_persen").val();
			let hari = $("#dcp_input_hari").val();
			let discount = 0;
			let total = 0;
			if((persen != 0 || persen != '') && (hari != 0 || hari != '')){
				discount = (parseInt(h_total_inv) * parseFloat(persen)) / 100
				total = (parseInt(h_total_inv) - parseInt(discount))
			}else{
				discount = 0
				total = 0
			}
			$("#dcp_input_hitung").val(format_angka(discount))
			$("#dcp_input_total").val(format_angka(total))
		}
		// BIAYA BONGKAR	
		if(dc_opsi == 'BIAYA BONGKAR'){
			let rupiah = $("#dcp_input_rupiah").val();
			let discount = 0;
			let total = 0;
			if(rupiah != 0 || rupiah != ''){
				discount = rupiah
				total = (parseInt(h_total_inv) - parseInt(discount))
			}else{
				discount = 0
				total = 0
			}
			$("#dcp_input_hitung").val(format_angka(discount))
			$("#dcp_input_total").val(format_angka(total))
		}
		// POTONG KARUNG
		if(dc_opsi == 'POTONG KARUNG'){
			let rupiah = $("#dcp_input_rupiah").val();
			let ball = $("#dcp_input_ball").val();
			let discount = 0;
			let total = 0;
			if((rupiah != 0 || rupiah != '') && (ball != 0 || ball != '')){
				discount = parseInt(rupiah) * parseInt(ball)
				total = (parseInt(h_total_inv) - parseInt(discount))
			}else{
				discount = 0
				total = 0
			}
			$("#dcp_input_hitung").val(format_angka(discount))
			$("#dcp_input_total").val(format_angka(total))
		}
	}

	function discOpsi(){
		let dc_opsi = $("#dc_opsi").val()
		$("#dcp_input_persen").val("")
		$("#dcp_input_hari").val("")
		$("#dcp_input_rupiah").val("")
		$("#dcp_input_ball").val("")
		$("#dcp_input_hitung").val("")
		$("#dcp_input_total").val("")
		$(".btn-add-disc").html("")

		if(dc_opsi == ''){
			$(".dcp-persen").hide()
			$(".dcp-hari").hide()
			$(".dcp-rupiah").hide()
			$(".dcp-ball").hide()
			$(".dcp-hitung").hide()
			$(".dcp-total").hide()
		}
		if(dc_opsi == 'DISCOUNT'){
			$(".dcp-persen").show()
			$(".dcp-hari").show()
			$(".dcp-rupiah").hide()
			$(".dcp-ball").hide()
		}
		if(dc_opsi == 'BIAYA BONGKAR'){
			$(".dcp-persen").hide()
			$(".dcp-hari").hide()
			$(".dcp-rupiah").show()
			$(".dcp-ball").hide()
		}
		if(dc_opsi == 'POTONG KARUNG'){
			$(".dcp-persen").hide()
			$(".dcp-hari").hide()
			$(".dcp-rupiah").show()
			$(".dcp-ball").show()
		}
		if(dc_opsi != ''){
			$(".dcp-hitung").show()
			$(".dcp-total").show()
			$(".btn-add-disc").html('<button type="button" class="btn btn-sm btn-success" style="font-weight:bold" onclick="addDisc()"><i class="fas fa-plus"></i> ADD</button>')
		}
	}

	function addDisc() {
		let id_header = $("#h_id_header").val()
		let no_invoice = $("#no_invoice").val()
		let dc_opsi = $("#dc_opsi").val()
		let persen = $("#dcp_input_persen").val()
		let hari = $("#dcp_input_hari").val()
		let rupiah = $("#dcp_input_rupiah").val()
		let ball = $("#dcp_input_ball").val()
		let hitung = $("#dcp_input_hitung").val().split('.').join('')
		let total = $("#dcp_input_total").val().split('.').join('')
		$.ajax({
			url: '<?php echo base_url('Logistik/addDisc')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				no_invoice, dc_opsi, persen, hari, rupiah, ball, hitung, total
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.result){
					editInvoiceLaminasi(id_header, 'edit')
					$("#dc_opsi").val("").trigger('change')
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function hapusDisc(id) {
		let id_header = $("#h_id_header").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/hapusDisc')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({ id }),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					editInvoiceLaminasi(id_header, 'edit')
					$("#dc_opsi").val("").trigger('change')
				}else{
					toastr.error(`<b>Terjadi Kesalahan</b>`)
					swal.close()
				}
			}
		})
	}

	function hapusInvoiceLaminasi(id){
		swal({
			title: "Apakah Kamu Yakin?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#C00",
			confirmButtonText: "Delete"
		}).then(function(result) {
			$.ajax({
				url: '<?php echo base_url('Logistik/hapusInvoiceLaminasi')?>',
				type: "POST",
				beforeSend: function() {
					swal({
						title: 'Loading',
						allowEscapeKey: false,
						allowOutsideClick: false,
						onOpen: () => {
							swal.showLoading();
						}
					});
				},
				data: ({ id }),
				success: function(res){
					data = JSON.parse(res)
					if(data.no_pl_inv){
						kosong()
						reloadTable()
					}else{
						toastr.error(`<b>PO SUDAH DI ACC!</b>`)
						reloadTable()
						swal.close()
					}
				}
			})
		});
	}

	function rejectInvLam(opsi){
		let id_header = $("#h_id_header").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/rejectInvLam')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				opsi, id_header
			}),
			success: function(res){
				data = JSON.parse(res)
				editInvoiceLaminasi(id_header, 'edit')
			}
		})
	}

	function bayarInvoiceLaminasi(opsi)
	{
		let id_header = $("#h_id_header").val()
		let h_bayar_inv = $("#h_bayar_inv").val()
		let tgl_bayar = $("#tgl_bayar").val()
		let input_bayar = $("#input_bayar").val().split('.').join('')
		if(opsi == 'input'){
			(input_bayar < 0 || input_bayar == '') ? input_bayar = 0 : input_bayar = input_bayar;
			let hitung = input_bayar - h_bayar_inv;
			let t_hitung = 0;
			(hitung == 0 || parseInt(input_bayar) > parseInt(h_bayar_inv)) ? t_hitung = 0 : t_hitung = hitung;
			(parseInt(input_bayar) > parseInt(h_bayar_inv)) ? input_bayar = h_bayar_inv : input_bayar = input_bayar;
			$("#hasil_bayar").val(format_angka(t_hitung))
			$("#input_bayar").val(format_angka(input_bayar))
		}
		if(opsi == 'button'){
			$.ajax({
				url: '<?php echo base_url('Logistik/bayarInvoiceLaminasi')?>',
				type: "POST",
				beforeSend: function() {
					swal({
						title: 'Loading',
						allowEscapeKey: false,
						allowOutsideClick: false,
						onOpen: () => {
							swal.showLoading();
						}
					});
				},
				data: ({
					tgl_bayar, input_bayar, id_header
				}),
				success: function(res){
					data = JSON.parse(res)
					if(data.bayar){
						editInvoiceLaminasi(id_header, 'edit')
					}else{
						toastr.error(`<b>${data.msg}</b>`)
						swal.close()
					}
				}
			})
		}
	}

	function hapusBayarInvLam(id) {
		let id_header = $("#h_id_header").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/hapusBayarInvLam')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				id, id_header
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					editInvoiceLaminasi(id_header, 'edit')
				}else{
					toastr.error(`<b>Terjadi Kesalahan</b>`)
					swal.close()
				}
			}
		})
	}

	function laporanInvoice(opsi){
		$(".btn-print-lap-lam-pdf").html("")
		$(".cari-lap-laminasi").html("")
		$(".cari-lap-pembayaran").html("")
		if(opsi == 'laporan'){
			if(urlUser != 'usman'){
				$("#plh-lap-lap").val("").trigger('change')
			}
			$("#plh-lap-cust").val("").trigger('change')
			$(".col-list-laminasi").hide()
			$(".col-list-lam-laporan").show()
			$(".col-list-lam-pembayaran").hide()
		}else if(opsi == 'pembayaran'){
			if(urlUser != 'usman'){
				$("#plh_pilih").val("").trigger('change')
			}
			$("#plh_bayar").val("").trigger('change')
			$("#plh_cust").val("").trigger('change')
			$(".col-list-laminasi").hide()
			$(".col-list-lam-laporan").hide()
			$(".col-list-lam-pembayaran").show()
		}else{
			$(".col-list-laminasi").show()
			$(".col-list-lam-laporan").hide()
			$(".col-list-lam-pembayaran").hide()
		}
	}

	function cariLaporanLaminasi(opsi) {
		$(".btn-print-lap-lam-pdf").html("")
		$(".cari-lap-laminasi").html("")
		let pilih = $("#plh-lap-lap").val()
		let attn = $('#plh-lap-cust option:selected').attr('attn')
		let plh_cust = $("#plh-lap-cust").val()
		let tgl1_lap = $("#tgl1_lap").val()
		let tgl2_lap = $("#tgl2_lap").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/cariLaporanLaminasi')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				opsi, pilih, plh_cust, tgl1_lap, tgl2_lap, attn
			}),
			success: function(res){
				data = JSON.parse(res)
				if(opsi == 'laporan'){
					$(".btn-print-lap-lam-pdf").html(data.pdf)
					$(".cari-lap-laminasi").html(data.html)
				}
				swal.close()
			}
		})
	}

	function cariPembayaranLaminasi(opsi) {
		$(".btn-print-bayar-lam-pdf").html("")
		$(".cari-lap-pembayaran").html("")
		let plh_pilih = $("#plh_pilih").val()
		let plh_bayar = $("#plh_bayar").val()
		let plh_cust = $("#plh_cust").val()
		let attn = $('#plh_cust option:selected').attr('attn')
		let tgl1_jt = $("#tgl1_jt").val()
		let tgl2_jt = $("#tgl2_jt").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/cariPembayaranLaminasi')?>',
			type: "POST",
			beforeSend: function() {
				swal({
					title: 'Loading',
					allowEscapeKey: false,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading();
					}
				});
			},
			data: ({
				opsi, plh_pilih, plh_bayar, plh_cust, attn, tgl1_jt, tgl2_jt
			}),
			success: function(res){
				data = JSON.parse(res)
				if(opsi == 'laporan'){
					$(".btn-print-bayar-lam-pdf").html(data.pdf)
					$(".cari-lap-pembayaran").html(data.html)
				}
				swal.close()
			}
		})
	}

	function batalInvoiceLaminasi(id)
	{
		swal({
			title: "BATAL ACC YAKIN?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#C00",
			confirmButtonText: "Yakin"
		}).then(function(result) {
			$.ajax({
				url: '<?php echo base_url('Logistik/batalInvoiceLaminasi')?>',
				type: "POST",
				beforeSend: function() {
					swal({
						title: 'Loading',
						allowEscapeKey: false,
						allowOutsideClick: false,
						onOpen: () => {
							swal.showLoading();
						}
					});
				},
				data: ({ id }),
				success: function(res){
					data = JSON.parse(res)
					if(data.data){
						toastr.success(`<b>${data.msg}</b>`)
						kosong()
						reloadTable()
					}else{
						toastr.error(`<b>${data.msg}</b>`)
						reloadTable()
						swal.close()
					}
				}
			})
		});
	}

	function addJurnalInvLaminasi(id)
	{
		swal({
			title: "TAMBAHKAN JURNAL?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#0C0",
			confirmButtonText: "Tambah"
		}).then(function(result) {
			$.ajax({
				url: '<?php echo base_url('Logistik/addJurnalInvLaminasi')?>',
				type: "POST",
				beforeSend: function() {
					swal({
						title: 'Loading',
						allowEscapeKey: false,
						allowOutsideClick: false,
						onOpen: () => {
							swal.showLoading();
						}
					});
				},
				data: ({ id }),
				success: function(res){
					data = JSON.parse(res)
					console.log(data)
					if(data.data){
						toastr.success(`<b>${data.msg}</b>`)
						kosong()
						reloadTable()
					}else{
						toastr.error(`<b>${data.msg}</b>`)
						reloadTable()
						swal.close()
					}
				}
			})
		});
	}

	function batalJurnalInvLaminasi(id)
	{
		swal({
			title: "BATAL JURNAL DAN BB?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#C00",
			confirmButtonText: "Batal"
		}).then(function(result) {
			$.ajax({
				url: '<?php echo base_url('Logistik/batalJurnalInvLaminasi')?>',
				type: "POST",
				beforeSend: function() {
					swal({
						title: 'Loading',
						allowEscapeKey: false,
						allowOutsideClick: false,
						onOpen: () => {
							swal.showLoading();
						}
					});
				},
				data: ({ id }),
				success: function(res){
					data = JSON.parse(res)
					console.log(data)
					if(data.data){
						toastr.success(`<b>${data.msg}</b>`)
						kosong()
						reloadTable()
					}else{
						toastr.error(`<b>${data.msg}</b>`)
						reloadTable()
						swal.close()
					}
				}
			})
		});
	}

	function bayarJurnalInvLaminasi(id)
	{
		swal({
			title: "PEMBAYARAN JURNAL?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#00C",
			confirmButtonText: "Bayar"
		}).then(function(result) {
			$.ajax({
				url: '<?php echo base_url('Logistik/bayarJurnalInvLaminasi')?>',
				type: "POST",
				beforeSend: function() {
					swal({
						title: 'Loading',
						allowEscapeKey: false,
						allowOutsideClick: false,
						onOpen: () => {
							swal.showLoading();
						}
					});
				},
				data: ({ id }),
				success: function(res){
					data = JSON.parse(res)
					console.log(data)
					if(data.data){
						toastr.success(`<b>${data.msg}</b>`)
						kosong()
						reloadTable()
					}else{
						toastr.error(`<b>${data.msg}</b>`)
						reloadTable()
						swal.close()
					}
				}
			})
		});
	}
</script>
