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
			
			<div class="row row-input-invoice-jasa" style="display:none">
				<div class="col-md-7">
					<div class="card card-success card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">INPUT INVOICE JASA</h3>
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
							<div class="col-md-3">TRANSAKSI</div>
							<div class="col-md-8">
								<select id="pilih_transaksi" class="form-control select2" onchange="pilihTransaksi()">
									<option value="">PILIH</option>
									<option value="CORRUGATED">CORRUGATED</option>
									<option value="LAMINASI">LAMINASI</option>
								</select>
							</div>
							<div class="col-md-1"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">TGL. SJ</div>
							<div class="col-md-8">
								<input type="date" id="tgl_sj" class="form-control" onchange="cariSJJasa()">
							</div>
							<div class="col-md-1"></div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">SURAT JALAN</div>
							<div class="col-md-9">
								<select id="no_surat_jalan" class="form-control select2" onchange="pilihSJInvJasa()" disabled>
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
								<input type="hidden" id="h_id_hub" value="">
								<input type="text" id="kepada" class="form-control" placeholder="Kepada" autocomplete="off" oninput="this.value=this.value.toUpperCase()" disabled>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
							<div class="col-md-3">ALAMAT</div>
							<div class="col-md-9">
								<textarea id="alamat" class="form-control" style="resize:none" rows="3" placeholder="Alamat" autocomplete="off" oninput="this.value=this.value.toUpperCase()" disabled></textarea>
							</div>
						</div>
						<div class="card-body row" style="font-weight:bold;padding:0 12px 16px">
							<div class="col-md-3">PILIHAN BANK</div>
							<div class="col-md-9">
								<select id="pilihan_bank" class="form-control select2">
									<option value="">PILIH</option>
									<option value="7">BCA PT. PRIMA PAPER INDONESIA</option>
								</select>
							</div>
						</div>
						<input type="hidden" id="h_id_header" value="">
					</div>
				</div>

				<div class="col-md-5">
					<div class="col-list-surat-jalan" style="display:none">
						<div class="card card-secondary card-outline">
							<div class="card-header" style="padding:12px">
								<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST SURAT JALAN</h3>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:5px 5px 0">
								<div class="col-md-6" style="padding-bottom:5px">
									<select id="plh_jenis" class="form-control select2" onchange="plhListSJasa()">
										<option value="">PILIH</option>
										<option value="CORRUGATED">CORRUGATED</option>
										<option value="LAMINASI">LAMINASI</option>
									</select>
								</div>
								<div class="col-md-6" style="padding-bottom:5px">
									<select id="plh_hub" class="form-control select2" onchange="plhListSJasa()">
										<?php
											$query = $this->db->query("SELECT*FROM m_hub WHERE id_hub!='7' ORDER BY nm_hub");
											$html ='';
											$html .='<option value="">PILIH</option>';
											foreach($query->result() as $r){
												$html .='<option value="'.$r->id_hub.'">CV. '.$r->nm_hub.'</option>';
											}
											echo $html
										?>
									</select>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 5px 0">
								<div class="col-md-6" style="padding-bottom:5px">
									<input type="date" id="tgl1" class="form-control" onchange="plhListSJasa()">
								</div>
								<div class="col-md-6" style="padding-bottom:5px">
									<input type="date" id="tgl2" class="form-control" onchange="plhListSJasa()">
								</div>
							</div>
							<div id="hasil_cari"></div>
						</div>
					</div>

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
			</div>

			<div class="row row-item-invoice-jasa" style="display:none">
				<div class="col-md-12">
					<div class="card card-secondary card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">LIST ITEM</h3>
						</div>
						<div class="card-body" style="padding:6px">
							<div style="overflow:auto;white-space:nowrap">
								<div class="list-item">LIST ITEM KOSONG</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row row-list-invoice-jasa">
				<div class="col-md-12">
					<div class="card shadow mb-3">
						<div class="card-header" style="font-family:Cambria;">
							<h3 class="card-title" style="color:#4e73df;"><b>INVOICE JASA</b></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<?php if(in_array($this->session->userdata('level'), ['Admin', 'Admin2'])){ ?>
								<div style="margin-bottom:12px">
									<button type="button" class="btn btn-sm btn-info" onclick="tambahData()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
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
								<div class="col-md-2" style="padding-bottom:3px">
									<select id="jenis" class="form-control select2" onchange="load_data()">
										<option value="">SEMUA</option>
										<option value="CORRUGATED">CORRUGATED</option>
										<option value="LAMINASI">LAMINASI</option>
									</select>
								</div>
								<div class="col-md-4" style="padding-bottom:3px">
									<select id="hub" class="form-control select2" onchange="load_data()">
										<?php
											$query = $this->db->query("SELECT*FROM m_hub WHERE id_hub!='7' ORDER BY nm_hub");
											$html ='';
											$html .='<option value="">SEMUA</option>';
											foreach($query->result() as $r){
												$html .='<option value="'.$r->id_hub.'">CV. '.$r->nm_hub.'</option>';
											}
											echo $html
										?>
									</select>
								</div>
								<div class="col-md-4"></div>
							</div>
							<div style="overflow:auto;white-space:nowrap">
								<table id="datatable" class="table table-bordered table-striped">
									<thead class="color-tabel">
										<tr>
											<th style="padding:12px;text-align:center">NO.</th>
											<th style="padding:12px 150px;text-align:center">DESKRIPSI</th>
											<th style="padding:12px;text-align:center">TGL INV</th>
											<th style="padding:12px;text-align:center">JATUH TEMPO</th>
											<th style="padding:12px;text-align:center">ADMIN</th>
											<th style="padding:12px;text-align:center">OWNER</th>
											<th style="padding:12px;text-align:center">TOTAL</th>
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
			</div>

		</div>
	</section>
</div>

<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';
	const urlUser = '<?= $this->session->userdata('username')?>';

	$(document).ready(function ()
	{
		kosong()
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
				"url": '<?php echo base_url('Logistik/load_data/loadDataInvoiceJasa')?>',
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
		let tanggal = '<?= date("Y-m-d")?>'
		$("#tgl_invoice").val(tanggal).prop('disabled', false)
		$("#pilih_transaksi").val("").prop('disabled', false).trigger("change")
		$("#tgl_sj").val("").prop('disabled', true)
		$("#no_surat_jalan").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$("#txt_no_invoice").val("AUTO").prop('disabled', true)
		$("#no_invoice").val("").prop('disabled', true)
		$("#tgl_jatuh_tempo").val("").prop('disabled', false)

		$("#h_id_hub").val("")
		$("#kepada").val("").prop('disabled', true)
		$("#alamat").val("").prop('disabled', true)
		$("#pilihan_bank").val("").prop('disabled', false).trigger("change")

		// $("#plh_jenis").val("").trigger("change")
		// $("#plh_hub").val("").trigger("change")
		// $("#tgl1").val("").trigger("change")
		// $("#tgl2").val("").trigger("change")

		$("#verif-admin").html('. . .')
		$("#verif-owner").html('. . .')
		$("#input-owner").html('')
		$(".list-item").html("LIST ITEM KOSONG")

		statusInput = 'insert'
		swal.close()
	}

	function tambahData() {
		kosong()
		$(".row-input-invoice-jasa").show()
		$(".col-list-surat-jalan").show()
		$(".col-verif-invoice-laminasi").hide()
		$(".row-item-invoice-jasa").show()
		$(".row-list-invoice-jasa").hide()
		$("#plh_jenis").trigger("change")
	}

	function kembali() {
		kosong()
		reloadTable()
		$(".row-input-invoice-jasa").hide()
		$(".col-list-surat-jalan").hide()
		$(".col-verif-invoice-laminasi").hide()
		$(".row-item-invoice-jasa").hide()
		$(".row-list-invoice-jasa").show()
	}

	function plhListSJasa()
	{
		let plh_jenis = $("#plh_jenis").val()
		let plh_hub = $("#plh_hub").val()
		let tgl1 = $("#tgl1").val()
		let tgl2 = $("#tgl2").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/plhListSJasa')?>',
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
				plh_jenis, plh_hub, tgl1, tgl2
			}),
			success: function(res){
				data = JSON.parse(res)
				$("#hasil_cari").html(data.html)
				swal.close()
			}
		})
	}

	function pilihTransaksi()
	{
		let pilih_transaksi = $("#pilih_transaksi").val();
		$("#tgl_sj").val("").prop('disabled', (pilih_transaksi == "") ? true : false);
		if(pilih_transaksi == ""){
			$("#no_surat_jalan").val("")
			cariSJJasa()
			pilihSJInvJasa()
		}
	}

	function cariSJJasa()
	{
		let pilih_transaksi = $("#pilih_transaksi").val()
		let tgl_sj = $("#tgl_sj").val()
		$("#no_surat_jalan").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$(".list-item").html('LIST ITEM KOSONG')
		$.ajax({
			url: '<?php echo base_url('Logistik/cariSJJasa')?>',
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
				pilih_transaksi, tgl_sj
			}),
			success: function(res){
				data = JSON.parse(res)
				$("#no_surat_jalan").html(data.htmlSJ).prop('disabled', (data.numRows == 0) ? true : false)
				swal.close()
			}
		})
	}

	function pilihSJInvJasa() {
		$(".list-item").html('LOAD DATA LIST ITEM')
		let pilih_transaksi = $("#pilih_transaksi").val()
		let no_surat = $("#no_surat_jalan").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/pilihSJInvJasa')?>',
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
				pilih_transaksi, no_surat
			}),
			success: function(res){
				data = JSON.parse(res)
				$("#txt_no_invoice").val("AUTO")
				$("#no_invoice").val(data.no_invoice)
				$("#h_id_hub").val(data.id_hub)
				$("#kepada").val(data.kepada)
				$("#alamat").val(data.alamat)
				$(".list-item").html(data.htmlItem)
				swal.close()
			}
		})
	}

	function simpanInvJasa(opsi) {
		let h_id_header = $("#h_id_header").val()
		let tgl_invoice = $("#tgl_invoice").val()
		let pilih_transaksi = $("#pilih_transaksi").val()
		let tgl_sj = $("#tgl_sj").val()
		let no_surat_jalan = $("#no_surat_jalan").val()
		let no_invoice = $("#no_invoice").val()
		let tgl_jatuh_tempo = $("#tgl_jatuh_tempo").val()
		let h_id_hub = $("#h_id_hub").val()
		let kepada = $("#kepada").val()
		let alamat = $("#alamat").val()
		let pilihan_bank = $("#pilihan_bank").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/simpanInvJasa')?>',
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
				h_id_header, tgl_invoice, pilih_transaksi, tgl_sj, no_surat_jalan, no_invoice, tgl_jatuh_tempo, h_id_hub, kepada, alamat, pilihan_bank, opsi, statusInput
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.insert){
					toastr.success(`<b>BERHASIL!</b>`)
					kembali()
				}else{
					toastr.error(`<b>${data.msg}</b>`)
					swal.close()
				}
			}
		})
	}

	function editInvoiceJasa(id_header, opsi) {
		$(".row-input-invoice-jasa").show()
		$(".col-verif-invoice-laminasi").attr('style', 'position:sticky;top:12px;margin-bottom:16px')
		$(".row-item-invoice-jasa").show()
		$(".row-list-invoice-jasa").hide()
		$.ajax({
			url: '<?php echo base_url('Logistik/editInvoiceJasa')?>',
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
				$("#pilih_transaksi").val(data.header.transaksi).prop('disabled', true)
				$("#tgl_sj").val(data.header.tgl_surat_jalan).prop('disabled', true)
				$("#no_surat_jalan").html(`<option value="">${data.header.no_surat}</option>`).prop('disabled', true)
				$("#txt_no_invoice").val(data.header.no_invoice)
				$("#no_invoice").val(data.header.no_invoice).prop('disabled', true)
				$("#tgl_jatuh_tempo").val(data.header.tgl_jatuh_tempo).prop('disabled', prop)

				$("#h_id_hub").val(data.header.id_hub)
				$("#kepada").val(data.header.kepada_jasa_inv).prop('disabled', true)
				$("#alamat").val(data.header.alamat_jasa_inv).prop('disabled', true)
				$("#pilihan_bank").val(data.header.bank).prop('disabled', prop).trigger('change')

				// LIST SURAT JALAN
				$("#plh_jenis").val("").trigger("change")
				$("#plh_hub").val("").trigger("change")
				$("#tgl1").val("").trigger("change")
				$("#tgl2").val("").trigger("change")
				$(".col-list-surat-jalan").hide()
				// VERIFIKASI DATA
				$("#verif-admin").html(`<button title="OKE" style="text-align:center;cursor:default" class="btn btn-sm btn-success "><i class="fas fa-check-circle"></i></button> ${data.oke_admin}`)
				// VERIFIFIKASI OWNER
				if((urlAuth == 'Admin' || urlAuth == 'Owner') && data.cHarga == 0 && data.detail != 0 && data.header.acc_admin == 'Y' && (data.header.acc_owner == 'N' || data.header.acc_owner == 'H' || data.header.acc_owner == 'R')){
					// BUTTON OWNER
					let lock = ''
					if(urlAuth == 'Admin' && data.header.acc_owner != 'N'){
						lock = `<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifInvJasa('lock','owner')"><i class="fas fa-lock"></i> Lock</button>`
					}else{
						lock = ''
					}
					$("#verif-owner").html(`
						${lock}
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-success" onclick="verifInvJasa('verifikasi','owner')"><i class="fas fa-check"></i> Verifikasi</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-warning" onclick="verifInvJasa('hold','owner')"><i class="far fa-hand-paper"></i> Hold</button>
						<button type="button" style="text-align:center;font-weight:bold" class="btn btn-sm btn-danger" onclick="verifInvJasa('reject','owner')"><i class="fas fa-times"></i> Reject</button>
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
										<textarea class="form-control" id="ket_jasa" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()">${data.header.ket_owner}</textarea>
									</div>
								</div>
							</div>
							<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifInvJasa('${data.header.acc_owner}', 'owner')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
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
				$(".list-item").html(data.htmlItem)
				statusInput = 'update'
				swal.close()
			}
		})
	}

	function keyupHargaJasa(id_dtl) {
		let tonase = $("#tonase-"+id_dtl).val()
		let harga = $("#harga-"+id_dtl).val().split('.').join('')
		$("#harga-"+id_dtl).val(format_angka(harga))
		
		let hitung = tonase * harga;
		(isNaN(hitung) || hitung == "" || hitung == 0) ? hitung = 0 : hitung = hitung
		$("#total-"+id_dtl).val(format_angka(hitung))
	}

	function editHargaJasa(id_dtl) {
		let id_header = $("#h_id_header").val()
		let harga = $("#harga-"+id_dtl).val().split('.').join('')
		let total = $("#total-"+id_dtl).val().split('.').join('')
		$.ajax({
			url: '<?php echo base_url('Logistik/editHargaJasa')?>',
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
				id_dtl, harga, total
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.data){
					editInvoiceJasa(id_header, 'edit')
				}else{
					toastr.error(`<b>INPUT TIDAK BOLEH KOSONG!</b>`)
					swal.close()
				}
			}
		})
	}

	function verifInvJasa(aksi, status_verif)
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
						<textarea class="form-control" id="ket_jasa" style="padding:6px;border:0;resize:none" placeholder="ALASAN" oninput="this.value=this.value.toUpperCase()"></textarea>
					</div>
				</div>
			</div>
			<div class="card-body row" style="font-weight:bold;padding:0 12px 6px">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button type="button" style="text-align:center;font-weight:bold" class="btn btn-xs ${colorbtn}" onclick="btnVerifInvJasa('${vrf}', '${status_verif}')"><i class="fas fa-save" style="color:#000"></i> <span style="color:#000">${txtsave}</span></button>
				</div>
			</div>
		`)
	}

	function btnVerifInvJasa(aksi, status_verif)
	{
		let h_id_header = $("#h_id_header").val()
		let ket_jasa = $("#ket_jasa").val()
		$.ajax({
			url: '<?php echo base_url('Logistik/btnVerifInvJasa')?>',
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
				h_id_header, ket_jasa, aksi, status_verif
			}),
			success: function(res){
				data = JSON.parse(res)
				if(data.result){
					kembali()
				}else{
					toastr.error(`<b>KETERANGAN TIDAK BOLEH KOSONG!</b>`)
					swal.close()
				}
			}
		})
	}

	function hapusInvoiceJasa(id){
		swal({
			title: "Apakah Kamu Yakin?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#C00",
			confirmButtonText: "Delete"
		}).then(function(result) {
			$.ajax({
				url: '<?php echo base_url('Logistik/hapusInvoiceJasa')?>',
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
					if(data.no_pl_jasa){
						kosong()
						reloadTable()
					}
				}
			})
		});
	}

	function batalInvoiceJasa(id)
	{
		swal({
			title: "BATAL ACC YAKIN?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#C00",
			confirmButtonText: "Yakin Bgt!"
		}).then(function(result) {
			$.ajax({
				url: '<?php echo base_url('Logistik/batalInvoiceJasa')?>',
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
</script>
