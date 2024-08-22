<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6" style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" >
					<!-- <h1><b>Data Logistik</b> </h1> -->
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<!-- <li class="breadcrumb-item active"><a href="#"><?= $judul ?></a></li> -->
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">

		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>INPUT INVOICE</b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
		
			<form role="form" method="post" id="myForm">
				<div class="card-body">
					<div class="col-md-12">
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							<div class="col-md-2">Status Invoice</div>
							<div class="col-md-3">
								<select id="cek_inv" name="cek_inv" class="form-control select2" style="width: 100%" onchange="cek_invoice()">
									<option value="baru">BARU</option>
									<option value="revisi">REVISI</option>
								</select>
								<input type="hidden" name="cek_inv2" id="cek_inv2">
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">Type</div>
							<div class="col-md-3">
								
								<input type="hidden" name="sts_input" id="sts_input">
								<input type="hidden" name="jenis" id="jenis" value="invoice">
								<input type="hidden" class="form-control" value="Add" name="status" id="status">
								<select name="type_po" id="type_po" class="form-control select2" style="width: 100%" onchange="noinv(),no_inv2()">
									<option value="">-- PILIH --</option>
									<option value="roll">Roll</option>
									<option value="sheet">Sheet</option>
									<option value="box">Box</option>
								</select>
								<input type="hidden" name="type_po2" id="type_po2">
							</div>

						</div>
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							
							<div class="col-md-2">Tanggal Invoice</div>
							<div class="col-md-3">
								<input type="date" id="tgl_inv" name="tgl_inv" class="form-control" autocomplete="off" placeholder="Tanggal Invoice" onchange="noinv(),no_inv2()">
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">Pajak</div>
							<div class="col-md-3">
								<select id="pajak" name="pajak" class="form-control select2" style="width: 100%" onchange="noinv(),no_inv2()">
									<option value="">-- PILIH --</option>
									<option value="ppn">PPN 11%</option>
									<option value="ppn_pph">PPN 11% + PPH22</option>
									<option value="nonppn">NON PPN</option>
								</select>
								<input type="hidden" name="pajak2" id="pajak2">
							</div>

						</div>

						<div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="ppn_pilihan">						
							<div class="col-md-2">Incl / Excl</div>
							<div class="col-md-9">
								<select id="inc_exc" name="inc_exc" class="form-control select2" style="width: 100%" >
									<option value="Include">Include</option>
									<option value="Exclude">Exclude</option>
									<option value="nonppn_inc">Non PPN</option>
								</select>
							</div>
						</div>

						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							<div class="col-md-2">Tanggal SJ</div>
							<div class="col-md-3">
								<input type="date" id="tgl_sj" name="tgl_sj" class="form-control" autocomplete="off" placeholder="Tanggal Surat Jalan" >
								<input type="hidden" name="id_pl_sementara" id="id_pl_sementara" value="">
							</div>
							<div class="col-md-1"></div>

							<div class="col-md-2">Tanggal Jatuh Tempo</div>
							<div class="col-md-3">
								<input type="date" id="tgl_tempo" name="tgl_tempo" class="form-control" autocomplete="off" placeholder="Jatuh Tempo" >
							</div>

						</div>

						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							
							<div class="col-md-2">Customer</div>
							<div class="col-md-8">
								<select class="form-control select2" id="id_pl" name="id_pl" style="width: 100%" autocomplete="off" onchange="load_cs()" disabled>
								</select>
							</div>
							
							<div class="col-md-1">
								<button type="button" class="btn btn-primary" id="btn-search" onclick="load_sj()"><i class="fas fa-search"></i><b></b></button>
							</div>
							
							
						</div>

						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							
							<div class="col-md-2">No Invoice</div>
							<div class="col-md-1">
								<input style="" type="hidden" id="id_inv" name="id_inv" class="input-border-none" autocomplete="off"  readonly>
								
								<input style="" type="hidden" id="no_inv_old" name="no_inv_old" class="input-border-none" autocomplete="off"  readonly>

								<input style="height: calc(2.25rem + 2px);font-size: 1rem;" type="text" id="no_inv_kd" name="no_inv_kd" class="input-border-none" autocomplete="off"  readonly>
							</div>
							<div class="col-md-1">
								<input style="height: calc(2.25rem + 2px);font-size: 1rem;"  type="text" id="no_inv" name="no_inv" class="input-border-none" autocomplete="off" oninput="this.value = this.value.toUpperCase(), this.value = this.value.trim(); " readonly>
							</div>
							<div class="col-md-3">
								<input style="height: calc(2.25rem + 2px);font-size: 1rem;"  type="text" id="no_inv_tgl" name="no_inv_tgl" class="input-border-none" autocomplete="off" readonly>
							</div>
							
							<div class="col-md-4"></div>
							
						</div>


							<hr>
							<div class="card-body row" style="padding:0 20px;font-weight:bold">
								<div class="col-md-12" style="font-family:Cambria;color:#4e73df;font-size:25px"><b>DIKIRIM KE</b></div>
							</div>
							<hr>

							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2">Kepada</div>
								<div class="col-md-10">
									<input type="hidden" id="id_perusahaan" name="id_perusahaan" >

									<input type="text" id="kpd" name="kpd" class="form-control" autocomplete="off" placeholder="Kepada" >
								</div>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2">Nama Perusahaan</div>
								<div class="col-md-10">
									<input type="text" id="nm_perusahaan" name="nm_perusahaan" class="form-control" autocomplete="off" placeholder="Nama Perusahaan" >
								</div>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2" style="padding-right:0">Alamat Perusahaan</div>
								<div class="col-md-10">
									<textarea class="form-control" name="alamat_perusahaan" id="alamat_perusahaan" cols="30" rows="5" placeholder="Alamat Perusahaan" ></textarea>
								</div>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2">Pilihan Bank</div>
								<div class="col-md-10">
									<select class="form-control select2" id="bank" name="bank" style="width: 100%" autocomplete="off">
										<!-- <option value="BCA_AKB">BCA AKB</option>
										<option value="BCA_SSB">BCA SSB</option>
										<option value="BCA_KSM">BCA KSM</option>
										<option value="BCA_GMB">BCA GMB</option>
										<option value="BCA">BCA</option>
										<option value="BNI">BNI</option> -->
									</select>
								</div>
							</div>
							<hr>
							<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
								<div class="col-md-2" style="padding-right:0">List Item</div>
								<div class="col-md-10">&nbsp;
								</div>
							</div>
							<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">		
								<div class="col-md-12"	style="overflow:auto;white-space:nowrap;" width="100%">	
									<table id="datatable_input" class="table table-hover table- table-bordered table-condensed table-scrollable">
										
									</table>
								</div>
							</div>						
						
					</div>
				</div>
				<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
					<div class="col-md-12">
						<!-- <a href="<?= base_url('Logistik/Invoice')?>" class="btn btn-danger"><i class="fa fa-undo"></i> <b>Kembali</b></a> -->

						<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
							<i class="fa fa-undo" ></i> Kembali</b>
						</button>
						
						<button type="button" class="btn btn-sm btn-primary" id="btn-simpan" ><i class="fas fa-save"></i><b> Simpan</b></button>
					</div>
				</div>
				<br>
				<br>
			</form>	
		</div>
		<!-- /.card -->
		</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="card shadow mb-3">
			
			<div class="row-list">
				<div class="card-header" style="font-family:Cambria;" >
					<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
							<i class="fas fa-minus"></i></button>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="" style="position: absolute;left: 20px;">
							<?php if (in_array($this->session->userdata('username'), ['karina','developer'])) { ?>

							<!-- <a href="<?= base_url('Logistik/Invoice_add')?>" class="btn btn-info"><i class="fa fa-plus"></i> <b>Tambah Data</b></a> -->

							<button type="button" class="btn btn-info btn-sm" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
							<?php } ?>
						</div>
						<div class="" style="position: absolute;right: 20px; font-weight:bold">
							<?php 
								$qbulan    = $this->db->query("SELECT*FROM m_bulan");
								$bln_now   = date("m");
							?>
								<select id="rentang_bulan" class="form-control select2" onchange="load_data()"> 
									<option value="all">-- SEMUA --</option>
							<?php 									
								foreach ($qbulan->result() as $bln_row)
								{
									if ($bln_row->id==$bln_now) {
										echo "<option selected value=$bln_row->id><b>$bln_row->bulan</b></option>";
										}
									else {	
									echo "<option value=$bln_row->id><b>$bln_row->bulan</b></option>";
									}
								}		
							?>  
							</select>
						</div>
					</div>
					<br>
					<br>

					<!-- <button onclick="cetak_jurnal(0)"  class="btn btn-danger">
					<i class="fa fa-print"></i> CETAK JURNAL</button>
						<br>
						<br> -->
					<div style="overflow:auto;white-space:nowrap;" >

						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th style="text-align: center;">No</th>
									<th style="text-align: center;">Invoice</th>
									<th style="text-align: center;">Tgl Inv</th>
									<th style="text-align: center;">J. Tempo</th>
									<th style="text-align: center;">Total</th>
									<th style="text-align: center;">Pembayaran</th>
									<th style="text-align: center;">Admin</th>
									<th style="text-align: center;">Owner</th>
									<th style="text-align: center;;">Aksi</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL box -->
	<div class="modal fade" id="modalForm">
		<div class="modal-dialog modal-full">
			<div class="modal-content">

				<div class="card-header" style="font-family:Cambria;" >
					<h4 class="card-title" style="color:#4e73df;" id="judul"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
						<div class="card-body">
							<div class="col-md-12">
								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									<div class="col-md-2">Status Invoice</div>
									<div class="col-md-3">
										<select id="modal_cek_inv" name="modal_cek_inv" class="form-control select2" style="width: 100%">
											<option value="baru">BARU</option>
											<option value="revisi">REVISI</option>
										</select>
										<input type="hidden" name="modal_cek_inv2" id="modal_cek_inv2">
									</div>
									<div class="col-md-1"></div>
									<div class="col-md-2">Type</div>
									<div class="col-md-3">
										<input type="hidden" name="modal_jenis" id="modal_jenis" value="invoice">

										<input type="hidden" class="form-control" value="Add" name="modal_status" id="modal_status">

										<input type="hidden" class="form-control" name="modal_id_header" id="modal_id_header">

										<select name="modal_type_po" id="modal_type_po" class="form-control select2" style="width: 100%" >
																	
											<option value="">-- PILIH --</option>
											<option value="roll">Roll</option>
											<option value="sheet">Sheet</option>
											<option value="box">Box</option>
										</select>
										<input type="hidden" name="modal_type_po2" id="modal_type_po2">

									</div>

								</div>

								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									
									<div class="col-md-2">Tanggal Invoice</div>
									<div class="col-md-3">
										<input type="date" id="modal_tgl_inv" name="modal_tgl_inv" class="form-control" autocomplete="off" placeholder="Tanggal Invoice" onchange="noinv_modal()" readonly >
									</div>
									<div class="col-md-1"></div>
									<div class="col-md-2">Pajak</div>
									<div class="col-md-3">
										<select id="modal_pajak" name="modal_pajak" class="form-control select2" style="width: 100%" onchange="noinv_modal()">
											<option value="">-- PILIH --</option>
											<option value="ppn">PPN 11%</option>
											<option value="ppn_pph">PPN 11% + PPH22</option>
											<option value="nonppn">NON PPN</option>
										</select>
										<input type="hidden" name="modal_pajak2" id="modal_pajak2">
									</div>

								</div>

								<div class="card-body row" style="padding-bottom:1px;font-weight:bold;display:none" id="modal_ppn_pilihan">						
									<div class="col-md-2">Incl / Excl</div>
									<div class="col-md-9">
										<select id="modal_inc_exc" name="modal_inc_exc" class="form-control select2" style="width: 100%" readonly>
											<option value="Include">Include</option>
											<option value="Exclude">Exclude</option>
											<option value="nonppn_inc">Non PPN</option>
										</select>
									</div>
								</div>
								
								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									<div class="col-md-2">Tanggal SJ</div>
									<div class="col-md-3">
										<input type="date" id="modal_tgl_sj" name="modal_tgl_sj" class="form-control" autocomplete="off" placeholder="Tanggal Surat Jalan" onchange="load_sj_modal()" >
										<input type="hidden" name="modal_id_pl_sementara" id="modal_id_pl_sementara" value="">
									</div>
									<div class="col-md-1"></div>

									<div class="col-md-2">Tanggal Jatuh Tempo</div>
									<div class="col-md-3">
										<input type="date" id="modal_tgl_tempo" name="modal_tgl_tempo" class="form-control" autocomplete="off" placeholder="Jatuh Tempo" readonly>
									</div>

								</div>

								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									
									<div class="col-md-2">Customer</div>
									<div class="col-md-9">
										<select class="form-control select2" id="modal_id_pl" name="modal_id_pl" style="width: 100%" autocomplete="off" >
										</select>
										<!-- onchange="load_cs()" -->
									</div>
									
									<!-- <div class="col-md-1">
										<button type="button" class="btn btn-primary" id="modal_btn_verif" onclick="load_sj()"><i class="fas fa-search"></i><b></b></button>
									</div> -->
									
								</div>

								<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
									
									<div class="col-md-2">No Invoice</div>
									<div class="col-md-3">
										
										<input type="text" class="form-control" name="modal_no_invoice" id="modal_no_invoice" readonly>
									</div>
									<div class="col-md-6"></div>
									
								</div>

									<hr>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-12" style="font-family:Cambria;color:#4e73df;font-size:25px"><b>DIKIRIM KE</b></div>
									</div>
									<hr>

									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-2">Kepada</div>
										<div class="col-md-10">
											<input type="hidden" id="modal_id_perusahaan" name="modal_id_perusahaan" >

											<input type="text" id="modal_kpd" name="modal_kpd" class="form-control" autocomplete="off" placeholder="Kepada" >
										</div>
									</div>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-2">Nama Perusahaan</div>
										<div class="col-md-10">
											<input type="text" id="modal_nm_perusahaan" name="modal_nm_perusahaan" class="form-control" autocomplete="off" placeholder="Nama Perusahaan" >
										</div>
									</div>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-2" style="padding-right:0">Alamat Perusahaan</div>
										<div class="col-md-10">
											<textarea class="form-control" name="modal_alamat_perusahaan" id="modal_alamat_perusahaan" cols="30" rows="5" placeholder="Alamat Perusahaan" ></textarea>
										</div>
									</div>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-2">Pilihan Bank</div>
										<div class="col-md-10">
											<select class="form-control select2" id="modal_bank" name="modal_bank" style="width: 100%" autocomplete="off">
												<option value="BCA_AKB">BCA AKB</option>
												<option value="BCA_SSB">BCA SSB</option>
												<option value="BCA_KSM">BCA KSM</option>
												<option value="BCA_GMB">BCA GMB</option>
												<option value="BCA">BCA</option>
												<option value="BNI">BNI</option>
											</select>
										</div>
									</div>
									<hr>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-2" style="padding-right:0">List Item</div>
										<div class="col-md-10">&nbsp;
										</div>
									</div>
									<div class="card-body row" style="padding-bottom:5px;">		
										<div class="col-md-12"	style="overflow:auto;white-space:nowrap;" width="100%">	
												<table id="modal_datatable_input" class="table table-hover table- table-bordered table-condensed table-scrollable">
												</table>
											</div>
										</div>
									<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
										<div class="col-md-12">
											<input type="hidden" name="modal_status_inv_owner" id="modal_status_inv_owner">
											<input type="hidden" name="modal_status_inv_admin" id="modal_status_inv_admin">
											
											<!-- <button type="button" class="btn btn-success" id="btn_verif" onclick="acc_inv()"><i class="fas fa-check"></i><b> VERIFIKASI</b></button> -->

											<span id="modal_btn_verif"></span>

											<button type="button" class="btn btn-danger" id="modal_btn-print" onclick="Cetak()" ><i class="fas fa-print"></i> <b>Print</b></button>
											
											<button type="button" class="btn btn-danger" data-dismiss="modalForm" onclick="close_modal();" ><i class="fa fa-undo"></i> <b> Batal</b></button>
											
											
											
										</div>
									</div>
									<br>
									<br>
									
								
							</div>
						</div>
					
				</div>
			</div>
		</div>
	</div>
	<!-- /.MODAL -->

<script type="text/javascript">
	rowNum = 0;
	$(document).ready(function() {
		load_data();
		load_bank();
		// getMax();
		$('.select2').select2({
			containerCssClass: "wrap",
			placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
	});

	status = "insert";

	function cetak_jurnal(ctk)
	{		
		var url    = "<?php echo base_url('Logistik/cetak_jurnal'); ?>";
		window.open(url, '_blank');   
	}

	function Cetak() 
	{
		no_invoice = $("#no_invoice").val();
		var url = "<?= base_url('Logistik/Cetak_Invoice'); ?>";
		window.open(url + '?no_invoice=' + no_invoice, '_blank');
	}

	function load_data() 
	{
		
		var blnn    = $('#rentang_bulan').val();
		var table   = $('#datatable').DataTable();

		table.destroy();

		tabel = $('#datatable').DataTable({

			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?= base_url(); ?>Logistik/load_data/Invoice',
				"type": "POST",
				data  : ({blnn:blnn}), 
				// data  : ({tanggal:tanggal,tanggal_akhir:tanggal_akhir,id_kategori:id_kategori1,id_sub_kategori:id_sub_kategori1}), 
			},
			"aLengthMenu": [
				[10, 15, 20, 25, -1],
				[10, 15, 20, 25, "Semua"] // change per page values here
			],		

			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});

	}

	function load_bank() 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_bank",
			// data       : { idp: pelanggan, kd: '' },
			dataType   : 'json',
			beforeSend: function() {
				swal({
				title: 'loading ...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success:function(data){			
				if(data.message == "Success"){					
					option = `<option value="">-- Pilih --</option>`;	

					$.each(data.data, function(index, val) {
					option += "<option value='"+val.nm_bank+"'>"+val.nm_bank+"</option>";
					});

					$('#bank').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#bank').html(option);					
					swal.close();
				}
			}
		});
		
	}

	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}
	
	var no_po = ''

	function deleteData(id,no) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "INVOICE",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +no+ " </strong> ",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>Hapus</b>',
			cancelButtonText   : '<b>Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			cancelButtonColor  : '#d33'
		}).then(() => {

		// if (cek) {
			$.ajax({
				url   : '<?= base_url(); ?>Logistik/hapus',
				type  : "POST",
				data: ({
					id       : id,
					no_inv   : no,
					field    : 'id',
					jenis    : 'invoice'
				}),
				beforeSend: function() {
					swal({
					title: 'loading ...',
					allowEscapeKey    : false,
					allowOutsideClick : false,
					onOpen: () => {
						swal.showLoading();
					}
					})
				},
				success: function(data) {
					// toastr.success('Data Berhasil Di Hapus');
					swal({
						title               : "Data",
						html                : "Data Berhasil Di Hapus",
						type                : "success",
						confirmButtonText   : "OK"
					});
					reloadTable();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// toastr.error('Terjadi Kesalahan');
					swal({
						title               : "Cek Kembali",
						html                : "Terjadi Kesalahan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			});
		// }

		});


	}

	function close_modal()
	{
		$('#modalForm').modal('hide');
		reloadTable()
	}

	function add_data()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn btn-sm btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}

	// MODAL //
	function open_modal(id,no_invoice) 
	{		
		$("#modalForm").modal("show");

		$("#judul").html('<h3> VERIFIKASI OWNER </h3>');
		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id: id, no: no_invoice, jenis:'invoice' },
			dataType   : "JSON",
			beforeSend: function() {
				swal({
				title: 'loading data...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success: function(data) {
				// console.log(data)
				if(data){
					// header
					$("#modal_type_po").val(data.header.type).trigger('change');
					$("#modal_cek_inv").val(data.header.cek_inv).trigger('change');
					$("#modal_tgl_inv").val(data.header.tgl_invoice);
					$("#modal_tgl_sj").val(data.header.tgl_sj);
					$("#modal_id_inv").val(data.header.id);
					$("#modal_no_inv_old").val(data.header.no_invoice);
					$("#modal_no_invoice").val(data.header.no_invoice);
					$("#modal_id_pl_sementara").val(data.header.id_perusahaan);
					load_sj_modal()

					$("#modal_pajak").val(data.header.pajak).trigger('change');
					$("#modal_bank").val(data.header.bank).trigger('change');
					$("#modal_tgl_tempo").val(data.header.tgl_jatuh_tempo);
					$("#modal_id_perusahaan").val(data.header.id_perusahaan);
					$("#modal_kpd").val(data.header.kepada);
					$("#modal_nm_perusahaan").val(data.header.nm_perusahaan);
					$("#modal_alamat_perusahaan").val(data.header.alamat_perusahaan);
					$("#modal_status_inv_owner").val(data.header.acc_owner);
					$("#modal_status_inv_admin").val(data.header.acc_admin);

					if(data.header.acc_owner == 'Y')
					{
						$("#modal_btn_verif").html(`<button type="button" class="btn btn-success" id="modal_btn_verif" onclick="acc_inv()"><i class="fas fa-lock"></i><b> BATAL VERIFIKASI </b></button>`)
					}else{
						$("#modal_btn_verif").html(`<button type="button" class="btn btn-success" id="modal_btn_verif" onclick="acc_inv()"><i class="fas fa-check"></i><b> VERIFIKASI </b></button>`)

					}

					if(data.header.pajak == 'ppn' || data.header.pajak == 'ppn_pph' )
					{
						$('#modal_ppn_pilihan').show("1000");
						$("#modal_inc_exc").val(data.header.inc_exc).trigger('change');
					}else{
						$('#modal_ppn_pilihan').hide("1000");
					}
					
					$("#modal_type_po").prop("disabled", true);
					$("#modal_pajak").prop("disabled", true);
					$("#modal_inc_exc").prop("disabled", true);
					$("#modal_id_pl").prop("disabled", true);
					$("#modal_cek_inv").prop("disabled", true);
					$("#modal_tgl_sj").prop("readonly", true);

					
					$("#modal_type_po2").val(data.header.type);
					$("#modal_cek_inv2").val(data.header.cek_inv);
					$("#modal_pajak2").val(data.header.pajak);

					// detail
					if(data.header.type=='roll')
					{
						var list = `
						<table id="datatable_input" class="table ">
						<thead class="color-tabel">
							<th style="text-align: center" >No</th>
							<th style="text-align: center" >KET</th>
							<th style="text-align: center; padding: 12px 50px" >HARGA</th>
							<th style="text-align: center" >QTY</th>
							<th style="text-align: center; padding: 12px 30px">R. QTY</th>
							<th style="text-align: center" >BERAT</th>
							<th style="text-align: center; padding: 12px 30px" >SESET</th>
							<th style="text-align: center; padding: 12px 30px" >HASIL</th>
						</thead>`;

						var no = 1;
						$.each(data.detail, function(index, val) {
							list += `
							<tbody>
								<td id="modal_no_urut${no}" name="modal_no_urut[${no}]" style="text-align: center" >${no}
									<input type="hidden" name="modal_nm_ker[${no}]" id="modal_nm_ker${no}" value="${val.nm_ker}">
									<input type="hidden" name="modal_id_inv_detail[${no}]" id="modal_id_inv_detail${no}" value="${val.id}">
									</td>

								<td style="text-align: left" >
									NO SJ : <b> ${val.no_surat} </b> <br>
									NO PO : <b> ${val.no_po} </b> <br>
									GSM : <b> ${val.g_label} </b> <br> 
									ITEM : <b> ${val.width} </b>
									
									<input type="hidden" name="modal_no_surat[${no}]" id="modal_no_surat${no}" value="${val.no_surat}">
									<input type="hidden" id="modal_no_po${no}" name="modal_no_po[${no}]" value="${val.no_po}">
									<input type="hidden" id="modal_g_label${no}" name="modal_g_label[${no}]" value="${val.g_label}">
									<input type="hidden" id="modal_width${no}" name="modal_width[${no}]" value="${val.width}">
								</td>

								<td style="text-align: center" >
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>Rp</b>
											</span>
										</div>		
										<input type="text" name="modal_hrg[${no}]" id="modal_hrg${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka(val.harga)}" readonly >
									</div>
								</td>

								<td style="text-align: center" >${val.qty}
									<input type="hidden" id="modal_qty${no}" name="modal_qty[${no}]" value="${val.qty}">
								</td>

								<td style="text-align: center" >${format_angka(val.retur_qty)}
									<input type="hidden" name="modal_retur_qty[${no}]" id="modal_retur_qty${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id)" value="${format_angka(val.retur_qty)}">
								</td>

								<td style="text-align: center" >${format_angka(val.weight)}
									<input type="hidden" id="modal_weight${no}" name="modal_weight[${no}]"  value="${val.weight}">
								</td>

								<td style="text-align: center" >${format_angka(val.seset)}
									<input type="hidden" name="modal_seset[${no}]" id="modal_seset${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})" value="${format_angka(val.seset)}" >
								</td>

								<td style="text-align: center" >${format_angka(val.hasil)}
									<input type="hidden" id="modal_hasil${no}" name="modal_hasil[${no}]"  class="form-control" value="${format_angka(val.hasil)}" readonly>
								</td>
							</tbody>`;
							no ++;
						})
						list += `</table>`;
					}else{
						var list = `
						<table id="modal_datatable_input" class="table">
							<thead class="color-tabel">
								<th style="text-align: center" >No</th>
								<th style="text-align: center" >Ukuran</th>
								<th style="text-align: center" >Kualitas</th>
								<th style="text-align: center; padding: 12px 50px" >HARGA</th>
								<th style="text-align: center" >QTY</th>
								<th style="text-align: center; padding: 12px 30px">R. QTY</th>
								<th style="text-align: center; padding: 12px 30px" >HASIL</th>
							</thead>`;
						var no             = 1;
						var berat_total    = 0;
						$.each(data.detail, function(index, val) {
							if(val.no_po_sj == null || val.no_po_sj == '')
							{
								no_po = val.no_po
							}else{
								no_po = val.no_po_sj
							}
							list += `
							<tbody>
								<td id="modal_no_urut${no}" name="modal_no_urut[${no}]" style="text-align: center" >${no}
								
									<input type="hidden" name="modal_id_pl_roll[${no}]" id="modal_id_pl_roll${no}" value="${val.id_pl}">
									
									<input type="hidden" name="modal_id_inv_detail[${no}]" id="modal_id_inv_detail${no}" value="${val.id}">
								</td>

								<td style="text-align: left" >
									NO SJ : <b> ${val.no_surat} </b> <br>
									NO PO : <b> ${val.no_po} </b><br>
									ITEM : <b> ${val.id_produk_simcorr} - ${val.nm_ker} </b><br>
									UKURAN : <b> ${val.g_label} </b>

									<input type="hidden" name="modal_no_surat[${no}]" id="modal_no_surat${no}" value="${val.no_surat}">
									<input type="hidden" id="modal_no_po${no}" name="modal_no_po[${no}]" value="${no_po}">
									<input type="hidden" name="modal_item[${no}]" id="modal_item${no}" value="${val.nm_ker}">
									<input type="hidden" id="modal_id_produk_simcorr${no}" name="modal_id_produk_simcorr[${no}]" value="${val.id_produk_simcorr}">
									<input type="hidden" id="modal_ukuran${no}" name="modal_ukuran[${no}]" value="${val.g_label}">
								</td>

								<td style="text-align: center" >${val.kualitas}
									<input type="hidden" id="modal_kualitas${no}" name="modal_kualitas[${no}]" value="${val.kualitas}">
								</td>

								<td style="text-align: center" >
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text"><b>Rp</b>
											</span>
										</div>		
										<input type="text" name="modal_hrg[${no}]" id="modal_hrg${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka(val.harga)}" readonly>
									</div>
									
								</td>

								<td style="text-align: center" >${format_angka(val.qty)} pcs
									<input type="hidden" id="modal_qty${no}" name="modal_qty[${no}]" onkeyup="ubah_angka(this.value,this.id)" value="${val.qty}">
								</td>
								
								<td style="text-align: center" >${format_angka(val.retur_qty)} pcs
									<input type="hidden" id="modal_retur_qty${no}" name="modal_retur_qty[${no}]" class="form-control" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})" value="${format_angka(val.retur_qty)}">
								</td>

								<td style="text-align: center" >${format_angka(val.hasil)} pcs
									<input type="hidden" id="modal_hasil${no}" name="modal_hasil[${no}]"  class="form-control" onkeyup="ubah_angka(this.value,this.id)" value="${format_angka(val.hasil)}" readonly>
								</td>

							</tbody>`;
							berat_total += parseInt(val.qty);
							no ++;
						})
						list += `<td style="text-align: center" colspan="6">TOTAL
								</td>
								<td style="text-align: center" >${format_angka(berat_total)}
								</td>`;
						list += `</table>`;
						$("#modal_datatable_input").html(list);
						// swal.close();
					}
					
					$("#modal_datatable_input").html(list);
					// swal.close();

				} else {

					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});

	}

	function noinv_modal()
	{
		var type    = $('#modal_type_po').val()
		var tgl_inv = $('#modal_tgl_inv').val()
		var pajak   = $('#modal_pajak').val()

		const myArray   = tgl_inv.split("-");
		let year        = myArray[0];
		let month       = myArray[1];
		let day         = myArray[2];

		if(type=='roll')
		{
			if(pajak=='nonppn')
			{
				$('#modal_no_inv_kd').val('B/');
			}else{
				$('#modal_no_inv_kd').val('A/');
			}
		}else{

			if(pajak=='nonppn')
			{
				$('#modal_no_inv_kd').val('BB/');
			}else{
				$('#modal_no_inv_kd').val('AA/');
			}

		}
		
		if(tgl_inv)
		{
			$('#modal_no_inv_tgl').val('/'+month+'/'+year);
		}
		
	}
	
	function load_sj_modal() 
	{
		var tgl_sj            = $("#modal_tgl_sj").val()
		var type_po           = $("#modal_type_po").val()
		var id_pl_sementara   = $("#modal_id_pl_sementara").val()
		var stat              = 'edit'
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_sj",
			dataType   : 'json',
			data       : {tgl_sj,type_po,stat},
			beforeSend: function() {
				swal({
				title: 'loading ...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success:function(data){			
				if(data.message == "Success"){						
					option = "<option>--- Pilih ---</option>";
					$.each(data.data, function(index, val) {
					option += `<option value="${val.id_perusahaan}" data-nm="${val.pimpinan}" data-nm_perusahaan="${val.nm_perusahaan}" data-id_perusahaan="${val.id_perusahaan}" data-alamat_perusahaan="${val.alamat_perusahaan}">[ "${val.tgll}" ] - [ "${val.pimpinan}" ] - [ "${val.nm_perusahaan}" ]</option>`;
					});

					$('#modal_id_pl').html(option);
					if(id_pl_sementara !='')
					{
						$("#modal_id_pl").val(id_pl_sementara).trigger('change');
					}
					swal.close();
				}else{	
					option += "<option value=''>Data Kosong</option>";
					$('#modal_id_pl').html(option);		
					swal.close();
				}
			}
		});
	}

	
	function acc_inv(no_invoice,status_owner) 
	{	
		var user        = "<?= $this->session->userdata('username')?>"
		var acc_owner   = status_owner
		// var acc_admin   = $('#modal_status_inv_admin').val()
		var no_inv      = no_invoice
		
		if(user=='bumagda' || user=='developer')
		{
			acc = acc_owner
		}else{
			acc = acc_owner
		}

		// console.log(user)
		// console.log(acc)
		if (acc=='N')
		{
			var html = 'VERIFIKASI'
			var icon = '<i class="fas fa-check"></i>'
		}else{
			var html = 'BATAL VERIFIKASI'
			var icon = '<i class="fas fa-lock"></i>'
		}
		
		swal({
			title              : html,
			html               : "<p> Apakah Anda yakin ?</p><br>",
			type               : "question",
			showCancelButton   : true,
			confirmButtonText  : '<b>'+icon+' '+html+'</b>',
			cancelButtonText   : '<b><i class="fas fa-undo"></i> Batal</b>',
			confirmButtonClass : 'btn btn-success',
			cancelButtonClass  : 'btn btn-danger',
			confirmButtonColor : '#28a745',
			cancelButtonColor  : '#d33'
		}).then(() => {

				$.ajax({
					url: '<?= base_url(); ?>Logistik/prosesData',
					data: ({
						no_inv    : no_inv,
						acc       : acc,
						jenis     : 'verif_inv'
					}),
					type: "POST",
					beforeSend: function() {
						swal({
							title: 'loading ...',
							allowEscapeKey    : false,
							allowOutsideClick : false,
							onOpen: () => {
								swal.showLoading();
							}
						})
					},
					success: function(data) {
						toastr.success('Data Berhasil Diproses');
						// swal({
						// 	title               : "Data",
						// 	html                : "Data Berhasil Diproses",
						// 	type                : "success",
						// 	confirmButtonText   : "OK"
						// });
						
						// setTimeout(function(){ location.reload(); }, 1000);
						// location.href = "<?= base_url()?>Logistik/Invoice";
						// location.href = "<?= base_url()?>Logistik/Invoice_edit?id="+id+"&statuss=Y&no_inv="+no_inv+"&acc=1";
						reloadTable()
						close_modal()
						swal.close();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						// toastr.error('Terjadi Kesalahan');
						swal({
							title               : "Cek Kembali",
							html                : "Terjadi Kesalahan",
							type                : "error",
							confirmButtonText   : "OK"
						});
						return;
					}
				});
		
		});


	}

	// INVOICE ADD //

	
	function simpan() 
	{
		var cek_inv   = $('#cek_inv').val();
		var no_inv_kd   = $('#no_inv_kd').val();
		var no_inv      = $('#no_inv').val();
		var no_inv_tgl  = $('#no_inv_tgl').val();
		var no_inv_ok   = no_inv_kd+''+no_inv+''+no_inv_tgl;

		swal({
			title: 'loading ...',
			allowEscapeKey    : false,
			allowOutsideClick : false,
			onOpen: () => {
				swal.showLoading();
			} 
		})		
		
		var tgl_inv   = $("#tgl_inv").val();
		var tgl_sj    = $("#tgl_sj").val();
		var id_pl     = $("#id_pl").val();
		var pajak     = $("#pajak").val();
		var tgl_tempo = $("#tgl_tempo").val();

		if (tgl_inv == '' || tgl_sj == '' || id_pl=='' || pajak=='' || tgl_tempo=='' ) 
		{
			swal.close();
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		var bucket = $('#bucket').val();

		for (var i = 1; i <= bucket-1; i++) {
			id_produk_simcorr   = $("#id_produk_simcorr" + i).val();

			if (id_produk_simcorr == '' ) {
				swal({
					title               : "Cek Kembali",
					html                : "Kode ITEM Kosong !, Hubungi IT",
					type                : "info",
					confirmButtonText   : "OK"
				});
				return;
				// swal.close();
			}
		}
		
		$.ajax({
			url        : '<?= base_url(); ?>Logistik/Insert_inv',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
			success: function(data) {
				if(data.status=='1'){
					// toastr.success('Berhasil Disimpan');
					swal.close();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success"
						// confirmButtonText   : "OK"
					});
					// location.href = "<?= base_url()?>Logistik/Invoice_edit?id="+data.id+"&no_inv="+no_inv_ok+"";
					// location.href = "<?= base_url()?>Logistik/Invoice";
					kembaliList();
					kosong();
					
				} else if(data.status=='3'){
					swal.close();
					swal({
						title               : "CEK KEMBALI",
						html                : "<p><strong>Nomor Invoice</strong></p>"
											+"Sudah di Gunakan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				} else {
					// toastr.error('Gagal Simpan');
					swal.close();
					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
				reloadTable();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal.close();
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});

	}

	function kosong(c = '') 
	{
		// $("#cek_inv").val("");
		$("#jenis").val("");
		$("#status").val("");
		$("#type_po").val("");
		$("#type_po").html(`<select name="type_po" id="type_po" class="form-control select2" style="width: 100%" onchange="noinv(),no_inv2()">
									<option value="">-- PILIH --</option>
									<option value="roll">Roll</option>
									<option value="sheet">Sheet</option>
									<option value="box">Box</option>
								</select>`);
		$("#tgl_inv").val("");
		$("#tgl_sj").val("");
		$("#tgl_tempo").val("");
		$("#pajak").val("");
		$("#pajak").html(`<select id="pajak" name="pajak" class="form-control select2" style="width: 100%" onchange="noinv(),no_inv2()">
									<option value="">-- PILIH --</option>
									<option value="ppn">PPN 11%</option>
									<option value="ppn_pph">PPN 11% + PPH22</option>
									<option value="nonppn">NON PPN</option>
								</select>`);
		$("#inc_exc").val("");
		$('#ppn_pilihan').hide("1000");
		$("#id_pl_sementara").val("");
		$("#id_pl").val("");
		$("#id_pl").html(`<select class="form-control select2" id="id_pl" name="id_pl" style="width: 100%" autocomplete="off" onchange="load_cs()" disabled></select>`);
		$("#no_inv_kd").val("");
		$("#no_inv").val("");
		$("#no_inv_tgl").val("");
		$("#id_perusahaan").val("");
		$("#kpd").val("");
		$("#nm_perusahaan").val("");
		$("#alamat_perusahaan").val("");
		// $("#bank").val("");

		$("#id_pelanggan").select2("val", "");
		$('#id_pelanggan').val("").trigger('change');		
		$("#id_pelanggan").prop("", false);

		clearRow();		
		$("#type_po").prop("disabled", false);
		$("#pajak").prop("disabled", false);
		$("#id_pl").prop("disabled", false);
		$("#btn-search").prop("disabled", false);
		$("#cek_inv").prop("disabled", false);
		$("#tgl_sj").prop("readonly", false);
		$("#btn-simpan").show();

		$(".btn-tambah-produk").show();
	}

	var no_po = ''

	function load_sj() 
	{
		var tgl_sj            = $("#tgl_sj").val()
		var type_po           = $("#type_po").val()
		var id_pl_sementara   = $("#id_pl_sementara").val()
		var stat              = $("#sts_input").val();
		$("#id_pl").prop('disabled', false);

		if(type_po == '' || type_po == null)
		{
			swal.close();
			swal({
				title               : "Cek Kembali",
				html                : "Harap Pilih <b> Type  </b> Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_sj",
			dataType   : 'json',
			data       : {tgl_sj,type_po,stat},
			beforeSend: function() {
				swal({
				title: 'loading ...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success:function(data){			
				if(data.message == "Success"){						
					option = "<option>--- Pilih ---</option>";
					$.each(data.data, function(index, val) {
					option += `<option value="${val.id_perusahaan}" data-nm="${val.pimpinan}" data-nm_perusahaan="${val.nm_perusahaan}" data-id_perusahaan="${val.id_perusahaan}" data-alamat_perusahaan="${val.alamat_perusahaan}">[ "${val.tgll}" ] - [ "${val.pimpinan}" ] - [ "${val.nm_perusahaan}" ]</option>`;
					});

					$('#id_pl').html(option);
					if(id_pl_sementara !='')
					{
						$("#id_pl").val(id_pl_sementara).trigger('change');
					}
					swal.close();
				}else{	
					option += "<option value=''>Data Kosong</option>";
					$('#id_pl').html(option);		
					swal.close();
				}
			}
		});
	}

	function load_cs()
	{
		var status    = $("#sts_input").val();
		if(status=='add')
		{
			var kpd                 = $('#id_pl option:selected').attr('data-nm');
			var id_perusahaan       = $('#id_pl option:selected').attr('data-id_perusahaan');
			var nm_perusahaan       = $('#id_pl option:selected').attr('data-nm_perusahaan');
			var alamat_perusahaan   = $('#id_pl option:selected').attr('data-alamat_perusahaan');
			$("#id_perusahaan").val(id_perusahaan)
			$("#kpd").val(kpd)
			$("#nm_perusahaan").val(nm_perusahaan)
			$("#alamat_perusahaan").val(alamat_perusahaan)
		}else{

		}
			show_list_pl()

	}

	function show_list_pl()
	{
		var id_perusahaan   = $('#id_pl option:selected').attr('data-id_perusahaan');
		var tgl_sj          = $("#tgl_sj").val()
		var type_po         = $("#type_po").val()

		$.ajax({
			url: '<?= base_url('Logistik/list_item'); ?>',
			type: 'POST',
			data: {id_perusahaan, tgl_sj, type_po},
			dataType: "JSON",
			beforeSend: function() {
						swal({
							title: 'Ambil Data Surat Jalan...',
							allowEscapeKey    : false,
							allowOutsideClick : false,
							onOpen: () => {
								swal.showLoading();
							}
						})
					},
			success: function(data)
			{  
				if(data.message == "Success"){
					if(type_po=='roll')
					{
						var list = `
							<table id="datatable_input" class="table">
								<thead class="color-tabel">
									<th style="text-align: center" >No</th>
									<th style="text-align: center" >NO SJ</th>
									<th style="text-align: center" >NO PO</th>
									<th style="text-align: center" >GSM</th>
									<th style="text-align: center" >ITEM</th>
									<th style="text-align: center; padding-right: 35px" >EXCLUDE</th>
									<th style="text-align: center; padding-right: 35px" >INCLUDE</th>
									<th style="text-align: center" >QTY</th>
									<th style="text-align: center; padding-right: 10px">R. QTY</th>
									<th style="text-align: center" >BERAT</th>
									<th style="text-align: center; padding-right: 25px" >SESET</th>
									<th style="text-align: center; padding-right: 30px" >HASIL</th>
									<th style="text-align: center" >AKSI</th>
								</thead>`;
							var no             = 1;
							var berat_total    = 0;
							var no_po          = '';
							$.each(data.data, function(index, val) {
								if(val.no_po_sj == null || val.no_po_sj == '')
								{
									no_po = val.no_po
								}else{
									no_po = val.no_po_sj
								}
								list += `
								<tbody>
									<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
										<input type="hidden" name="nm_ker[${no}]" id="nm_ker${no}" value="${val.nm_ker}">
										
										<input type="hidden" name="id_pl_roll[${no}]" id="id_pl_roll${no}" value="${val.id_pl}">
									</td>

									<td style="text-align: center" >${val.no_surat}
										<input type="hidden" name="no_surat[${no}]" id="no_surat${no}" value="${val.no_surat}">
									</td>

									<td style="text-align: center" >${no_po}
										<input type="hidden" id="no_po${no}" name="no_po[${no}]" value="${no_po}">
									</td>

									<td style="text-align: center" >${val.g_label}
										<input type="hidden" id="g_label${no}" name="g_label[${no}]" value="${val.g_label}">
									</td>

									<td style="text-align: center" >${val.width}
										<input type="hidden" id="width${no}" name="width[${no}]" value="${val.width}">
									</td>

									<td style="text-align: center" >
										<input type="text" name="hrg[${no}]" id="hrg${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" >
									</td>
									<td style="text-align: center" >
										<input type="text" name="inc[${no}]" id="inc${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" >
									</td>

									<td style="text-align: center" >${val.qty}
										<input type="hidden" id="qty${no}" name="qty[${no}]" value="${val.qty}">
									</td>

									<td style="text-align: center" >
										<input type="text" name="retur_qty[${no}]" id="retur_qty${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id)">
									</td>

									<td style="text-align: center" >${format_angka(val.weight)}
										<input type="hidden" id="weight${no}" name="weight[${no}]"  value="${val.weight}">
									</td>

									<td style="text-align: center" >
										<input type="text" name="seset[${no}]" id="seset${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})">
									</td>

									<td style="text-align: center" >
										<input type="text" id="hasil${no}" name="hasil[${no}]"  class="form-control" value="${format_angka(val.weight)}" readonly>
									</td>

									<td style="text-align: center" >
										<input type="checkbox" name="aksi[${no}]" id="aksi${no}" class="form-control" value="0" onchange="cek(this.value,this.id)">
									</td>
								</tbody>`;
								berat_total += parseInt(val.weight);
								no ++;
							})
							list += `<td style="text-align: center" colspan="9">TOTAL
									</td>
									<td style="text-align: center" >${format_angka(berat_total)}
									</td>
									<td style="text-align: center" colspan="3">&nbsp;
									</td>`;
							list += `</table>`;

					}else{
						var list = `
							<table id="datatable_input" class="table">
								<thead class="color-tabel">
									<th style="text-align: center" >No</th>
									<th style="text-align: center" >NO SJ</th>
									<th style="text-align: center" >NO PO</th>
									<th style="text-align: center" >ITEM</th>
									<th style="text-align: center" >Ukuran</th>
									<th style="text-align: center" >Kualitas</th>
									<th style="text-align: center; padding-right: 35px" >EXCLUDE</th>
									<th style="text-align: center; padding-right: 35px" >INCLUDE</th>
									<th style="text-align: center" >QTY</th>
									<th style="text-align: center; padding-right: 35px">R. QTY</th>
									<th style="text-align: center; padding-right: 35px" >HASIL</th>
									<th style="text-align: center" >AKSI</th>
								</thead>`;
							var no             = 1;
							var berat_total    = 0;
							var no_po          = '';
							$.each(data.data, function(index, val) {
								if(val.no_po_sj == null || val.no_po_sj == '')
								{
									no_po = val.no_po
								}else{
									no_po = val.no_po_sj
								}
								list += `
								<tbody>
									<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
										
										<input type="hidden" name="id_pl_roll[${no}]" id="id_pl_roll${no}" value="${val.id_pl}">
									</td>

									<td style="text-align: center" >${val.no_surat}
										<input type="hidden" name="no_surat[${no}]" id="no_surat${no}" value="${val.no_surat}">
									</td>

									<td style="text-align: center" >${no_po}
										<input type="hidden" id="no_po${no}" name="no_po[${no}]" value="${no_po}">
									</td>

									<td style="text-align: center" >${val.id_produk_simcorr} - ${val.item}
										<input type="hidden" id="item${no}" name="item[${no}]" value="${val.item}">
										<input type="hidden" id="id_produk_simcorr${no}" name="id_produk_simcorr[${no}]" value="${val.id_produk_simcorr}">
									</td>

									<td style="text-align: center" >${val.ukuran2}
										<input type="hidden" id="ukuran${no}" name="ukuran[${no}]" value="${val.ukuran2}">
									</td>

									<td style="text-align: center" >${val.kualitas}
										<input type="hidden" id="kualitas${no}" name="kualitas[${no}]" value="${val.kualitas}">
									</td>
									
									<td style="text-align: center" >
										<input type="text" name="hrg[${no}]" id="hrg${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" >
									</td>

									<td style="text-align: center" >
										<input type="text" name="inc[${no}]" id="inc${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" >
									</td>

									<td style="text-align: center" >${format_angka(val.qty)}
										<input type="hidden" id="qty${no}" name="qty[${no}]" value="${val.qty}">
									</td>

									<td style="text-align: center" >
										<input type="text" name="retur_qty[${no}]" id="retur_qty${no}" class="form-control" autocomplete="off" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})">
									</td>

									<td style="text-align: center" >
										<input type="text" id="hasil${no}" name="hasil[${no}]"  class="form-control" value="${format_angka(val.qty)}" readonly>
									</td>

									<td style="text-align: center" >
										<input type="checkbox" name="aksi[${no}]" id="aksi${no}" class="form-control" value="0" onchange="cek(this.value,this.id)">
									</td>
								</tbody>`;
								berat_total += parseInt(val.qty);
								no ++;
							})
							list += `<td style="text-align: center" colspan="8">TOTAL
									</td>
									<td style="text-align: center" >${format_angka(berat_total)}
									</td>
									<td style="text-align: center" colspan="3">&nbsp;
										<input type="hidden" id="bucket" value="${no}"></input>
									</td>`;
							list += `</table>`;
					}				
					
					$("#datatable_input").html(list);
					swal.close();
				}else{	
						
					swal.close();
				}
				
			}
		})

	}

	function noinv()
	{
		var type    = $('#type_po').val()
		var tgl_inv = $('#tgl_inv').val()
		var pajak   = $('#pajak').val()
		$("#id_pl").prop('disabled', true);
		
		if(pajak == 'ppn' || pajak == 'ppn_pph' )
		{
			$('#ppn_pilihan').show("1000");
			$("#inc_exc").val('Exclude').trigger('change');
		}else{
			$('#ppn_pilihan').hide("1000");
			$("#inc_exc").val('nonppn_inc').trigger('change');
		}

		const myArray   = tgl_inv.split("-");
		let year        = myArray[0];
		let month       = myArray[1];
		let day         = myArray[2];

		if(year=='2023'){

			if(type=='roll')
			{
				if(pajak=='nonppn')
				{
					$('#no_inv_kd').val('B/');
				}else{
					$('#no_inv_kd').val('A/');
				}
			}else{

				if(pajak=='nonppn')
				{
					$('#no_inv_kd').val('BB/');
				}else{
					$('#no_inv_kd').val('AA/');
				}

			}
			
		}else{
			if(type=='roll')
			{
				if(pajak=='nonppn')
				{
					$('#no_inv_kd').val('FD/');
				}else{
					$('#no_inv_kd').val('FC/');
				}
			}else{

				if(pajak=='nonppn')
				{
					$('#no_inv_kd').val('FB/');
				}else{
					$('#no_inv_kd').val('FA/');
				}

			}

		}
		
		
		if(tgl_inv)
		{
			$('#no_inv_tgl').val('/'+month+'/'+year);
		}
		
	}
	
	function no_inv2()
	{
		var status    = $("#sts_input").val();
		if(status=='add')
		{

			var type      = $('#type_po').val()
			var pajak     = $('#pajak').val()
			var cek_inv   = $('#cek_inv').val()
			var tgl_inv   = $('#tgl_inv').val()

			if(tgl_inv=='' || tgl_inv == null)
			{
				th_invoice = <?= date('Y') ?>
			}else{

				const myArray    = tgl_inv.split("-")
				var year         = myArray[0]
				th_invoice      = year

			}
			$.ajax({
				type        : 'POST',
				url         : "<?= base_url(); ?>Logistik/load_no_inv",
				data        : { type,pajak,th_invoice },
				dataType    : 'json',
				success:function(val){			
						
						$("#no_inv").val(val)
						if(cek_inv=='baru')
						{
							$("#no_inv").prop('readonly', true);
						}else{
							$("#no_inv").prop('readonly', false);

						}
					
				}
			});
		
		}else{

		}
	}

	function cek_invoice()
	{
		var cek_inv = $('#cek_inv').val()

		if(cek_inv=='baru')
		{
			$("#no_inv").prop('readonly', true);
		}else{
			$("#no_inv").prop('readonly', false);
		}
	}

	function cek(vall,id)
	{
		if (vall == 0) {
			$('#'+id).val(1);
		} else {
			$('#'+id).val(0);
		}
	}


	function clearRow() 
	{
		// jQuery('#datatable_input').remove();
		$("#datatable_input").html('');
	}

	function Hitung_price(val,id) 
	{
		var cek = id.substr(0,3);
		var id2 = id.substr(3,1);
		var isi = val.split('.').join('');
		
		if(cek=='hrg')
		{
			inc = (isi *1.11).toFixed(2);
			$('#inc'+id2).val(format_angka_koma(inc));

		}else {
			exc = Math.ceil(isi /1.11);
			$('#hrg'+id2).val(format_angka(exc));

		}
	}

	function hitung_hasil(val,id)
	{
		var type    = $('#type_po').val()
		if(type=='roll')
		{
			var berat    = $('#weight'+id).val()
			var seset    = val.split('.').join('')
			var hasil    = berat - seset
		}else{
			var qty    = $('#qty'+id).val()
			var retur  = val.split('.').join('')
			var hasil  = qty - retur
		}

		$('#hasil'+id).val(format_angka(hasil));

	}

	// INVOICE ADD END //


	// INVOICE EDIT //

	// function edit_data(id,no_po)
	// {
	// 	$(".row-input").attr('style', '');
	// 	$(".row-list").attr('style', 'display:none');
	// 	$("#sts_input").val('edit');

	// 	$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

	// 	$.ajax({
	// 		url        : '<?= base_url(); ?>Logistik/load_data_1',
	// 		type       : "POST",
	// 		data       : { id, tbl:'trs_h_stok_bb', jenis :'edit_stok_bb',field :'id_stok' },
	// 		dataType   : "JSON",
	// 		beforeSend: function() {
	// 			swal({
	// 			title: 'loading data...',
	// 			allowEscapeKey    : false,
	// 			allowOutsideClick : false,
	// 			onOpen: () => {
	// 				swal.showLoading();
	// 			}
	// 			})
	// 		},
	// 		success: function(data) {
	// 			if(data){
	// 				// header

	// 				var history = data.header.history - data.header.total_item - data.header.tonase_ppi

	// 				$("#id_stok_h").val(data.header.id_stok);
	// 				$("#no_stok").val(data.header.no_stok);
	// 				$("#muat_ppi").val(data.header.muatan_ppi).trigger('change');
	// 				$("#tgl_stok").val(data.header.tgl_stok);
	// 				$("#id_timb").val(data.header.id_timbangan);
	// 				$("#no_timb").val(data.header.no_timbangan);
	// 				$("#history_timb").val(format_angka(history));
	// 				$("#jum_timb").val(format_angka(data.header.total_timb));
	// 				$("#tonase_ppi").val(format_angka(data.header.tonase_ppi));
	// 				$("#total_bb_item").val(format_angka(data.header.total_item));
	// 				$("#sisa_timb").val(format_angka(data.header.sisa_stok)); 
	// 				swal.close();

	// 				// detail

	// 				var list = `
	// 					<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
	// 					<thead class="color-tabel">
	// 						<tr>
	// 							<th id="header_del">Delete</th>
	// 							<th style="padding : 12px 20px" >LIST </th>
	// 							<th style="padding : 12px 150px">PO</th>
	// 							<th style="padding : 12px 50px">Tonase PO</th>
	// 							<th style="padding : 12px 70px" >History PO</th>
	// 							<th style="padding : 12px 50px" >Kedatangan</th>
	// 						</tr>
	// 					</thead>`;
						
	// 				var no   = 0;
	// 				$.each(data.detail, function(index, val) {
	// 					var history_detail = val.history - val.datang_bhn_bk
	// 					list += `
	// 						<tr id="itemRow${ no }">
	// 							<td id="detail-hapus-${ no }">
	// 								<div class="text-center">
	// 									<a class="btn btn-danger" id="btn-hapus-${ no }" onclick="removeRow(${ no })">
	// 										<i class="far fa-trash-alt" style="color:#fff"></i> 
	// 									</a>
	// 								</div>
	// 							</td>
	// 							<td>
	// 								<div class="text-center">
	// 									<button type="button" title="PILIH"  onclick="load_item(this.id)" class="btn btn-success btn-sm" data-toggle="modal"  name="list[${ no }]" id="list${ no }">
	// 										<i class="fas fa-search"></i>
	// 									</button> 

	// 									<button type="button" title="PILIH"  onclick="cetak_inv_bb(this.id)" class="btn btn-danger btn-sm" name="print_inv[${ no }]" id="print_inv${ no }">
	// 										<i class="fas fa-print"></i>
	// 									</button> 
										
	// 								</div>
	// 							</td>
	// 							<td style="padding : 12px 20px" >
	// 								<input type="hidden" name="id_po_bhn[${ no }]" id="id_po_bhn${ no }" value="${val.id_po_bhn}">
									
	// 								<div class="input-group mb-1">
	// 									<div class="input-group-append">
	// 										<span class="input-group-text"><b>&nbsp;CUST&nbsp;</b>
	// 										</span>
	// 									</div>								
	// 									<input type="hidden" name="id_hub[${ no }]" id="id_hub${ no }" class="angka form-control" value="${val.id_hub}" readonly>
										
	// 									<input type="text" name="nm_hub[${ no }]" id="nm_hub${ no }" class="angka form-control" value="${val.nm_hub}" readonly>
	// 								</div>
	// 								<div class="input-group mb-1">
	// 									<div class="input-group-append">
	// 										<span class="input-group-text"><b>NO PO</b>
	// 										</span>
	// 									</div>
										
	// 									<input type="text" name="no_po[${ no }]" id="no_po${ no }" class="angka form-control" value="${val.no_po_bhn}"  readonly>
	// 								</div>
	// 							</td>	

	// 							<td style="padding : 12px 20px">
	// 								<div class="input-group mb-1">
	// 									<input type="text" size="5" name="ton[${ no }]" id="ton${ no }" class="angka form-control" value="${format_angka(val.tonase_po)}"  readonly>
	// 									<div class="input-group-append">
	// 										<span class="input-group-text"><b>Kg</b>
	// 										</span>
	// 									</div>		
	// 								</div>
	// 							</td>		

	// 							<td style="padding : 12px 20px">
	// 								<div class="input-group mb-1">
	// 									<input type="text" size="5" name="history[${ no }]" id="history${ no }" class="angka form-control" value="${format_angka(history_detail)}"  readonly>
	// 									<div class="input-group-append">
	// 										<span class="input-group-text"><b>Kg</b>
	// 										</span>
	// 									</div>		
	// 								</div>
	// 							</td>		
	// 							<td style="padding : 12px 20px">
	// 								<div class="input-group mb-1">
	// 									<input type="text" size="5" name="datang[${ no }]" id="datang${ no }" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value="${format_angka(val.datang_bhn_bk)}" >
	// 									<div class="input-group-append">
	// 										<span class="input-group-text"><b>Kg</b>
	// 										</span>
	// 									</div>		
	// 								</div>
	// 							</td>		
	// 						</tr>
	// 					`;

	// 					no ++;
	// 				})
	// 				rowNum = no-1 
	// 				$('#bucket').val(rowNum);					
	// 				$("#table_list_item").html(list);					
	// 				hitung_total()
	// 				swal.close();

	// 			} else {

	// 				swal.close();
	// 				swal({
	// 					title               : "Cek Kembali",
	// 					html                : "Gagal Simpan",
	// 					type                : "error",
	// 					confirmButtonText   : "OK"
	// 				});
	// 				return;
	// 			}
	// 		},
	// 		error: function(jqXHR, textStatus, errorThrown) {
	// 			// toastr.error('Terjadi Kesalahan');
				
	// 			swal.close();
	// 			swal({
	// 				title               : "Cek Kembali",
	// 				html                : "Terjadi Kesalahan",
	// 				type                : "error",
	// 				confirmButtonText   : "OK"
	// 			});
				
	// 			return;
	// 		}
	// 	});
	// }

	function edit_data(id,no_invoice) 
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn btn-sm btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		// var type_po       = $('#type_po').val()

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id: id, no: no_invoice, jenis:'invoice' },
			dataType   : "JSON",
			beforeSend: function() {
				swal({
				title: 'loading data...',
				allowEscapeKey    : false,
				allowOutsideClick : false,
				onOpen: () => {
					swal.showLoading();
				}
				})
			},
			success: function(data) {
				// console.log(data)
				if(data){
					// header
					$("#type_po").val(data.header.type).trigger('change');
					$("#cek_inv").val(data.header.cek_inv).trigger('change');
					$("#tgl_inv").val(data.header.tgl_invoice);
					$("#tgl_sj").val(data.header.tgl_sj);
					$("#id_inv").val(data.header.id);
					$("#no_inv_old").val(data.header.no_invoice);
					$("#id_pl_sementara").val(data.header.id_perusahaan);
					load_sj() 
					
					$("#pajak").val(data.header.pajak).trigger('change');
					$("#bank").val(data.header.bank).trigger('change');
					$("#tgl_tempo").val(data.header.tgl_jatuh_tempo);
					$("#id_perusahaan").val(data.header.id_perusahaan);
					$("#kpd").val(data.header.kepada);
					$("#nm_perusahaan").val(data.header.nm_perusahaan);
					$("#alamat_perusahaan").val(data.header.alamat_perusahaan);

					if(data.header.pajak == 'ppn' || data.header.pajak == 'ppn_pph' )
					{
						$('#ppn_pilihan').show("1000");
						$("#inc_exc").val(data.header.inc_exc).trigger('change');
					}else{
						$('#ppn_pilihan').hide("1000");
					}
					
					const myArray    = data.header.no_invoice.split("/");
					var no_inv_kd    = myArray[0]+'/';
					var no_inv       = myArray[1];
					var no_inv_tgl   = '/'+myArray[2]+'/'+myArray[3];

					$("#no_inv_kd").val(no_inv_kd);
					$("#no_inv").val(no_inv);
					$("#no_inv_tgl").val(no_inv_tgl);
					
					$("#type_po").prop("disabled", true);
					$("#pajak").prop("disabled", true);
					// $("#inc_exc").prop("disabled", true);
					$("#id_pl").prop("disabled", true);
					$("#btn-search").prop("disabled", true);
					$("#cek_inv").prop("disabled", true);
					$("#tgl_sj").prop("readonly", true);

					
					$("#type_po2").val(data.header.type);
					$("#cek_inv2").val(data.header.cek_inv);
					$("#pajak2").val(data.header.pajak);

					// detail
					if(data.header.type=='roll')
					{
						var list = `
						<table id="datatable_input" class="table ">
						<thead class="color-tabel">
							<th style="text-align: center" >No</th>
							<th style="text-align: center" >NO SJ</th>
							<th style="text-align: center" >NO PO</th>
							<th style="text-align: center" >GSM</th>
							<th style="text-align: center" >ITEM</th>
							<th style="text-align: center; padding-right: 30px" >Exclude</th>
							<th style="text-align: center; padding-right: 30px" >Include</th>
							<th style="text-align: center" >QTY</th>
							<th style="text-align: center; padding-right: 10px">R. QTY</th>
							<th style="text-align: center" >BERAT</th>
							<th style="text-align: center; padding-right: 25px" >SESET</th>
							<th style="text-align: center; padding-right: 30px" >HASIL</th>
							<th style="text-align: center" >AKSI</th>
						</thead>`;

						var no = 1;
						$.each(data.detail, function(index, val) {
							list += `
							<tbody>
								<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
									<input type="hidden" name="nm_ker[${no}]" id="nm_ker${no}" value="${val.nm_ker}">
									<input type="hidden" name="id_inv_detail[${no}]" id="id_inv_detail${no}" value="${val.id}">
									</td>

								<td style="text-align: center" >${val.no_surat}
									<input type="hidden" name="no_surat[${no}]" id="no_surat${no}" value="${val.no_surat}">
								</td>

								<td style="text-align: center" >${val.no_po}
									<input type="hidden" id="no_po${no}" name="no_po[${no}]" value="${val.no_po}">
								</td>

								<td style="text-align: center" >${val.g_label}
									<input type="hidden" id="g_label${no}" name="g_label[${no}]" value="${val.g_label}">
								</td>

								<td style="text-align: center" >${val.width}
									<input type="hidden" id="width${no}" name="width[${no}]" value="${val.width}">
								</td>

								<td style="text-align: center" >
									<input type="text" name="hrg[${no}]" id="hrg${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka(val.harga)}">
								</td>
								
								<td style="text-align: center" >
									<input type="text" name="inc[${no}]" id="inc${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka_koma(val.include)}">
								</td>

								<td style="text-align: center" >${val.qty}
									<input type="hidden" id="qty${no}" name="qty[${no}]" value="${val.qty}">
								</td>

								<td style="text-align: center" >
									<input type="text" name="retur_qty[${no}]" id="retur_qty${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id)" value="${format_angka(val.retur_qty)}">
								</td>

								<td style="text-align: center" >${format_angka(val.weight)}
									<input type="hidden" id="weight${no}" name="weight[${no}]"  value="${val.weight}">
								</td>

								<td style="text-align: center" >
									<input type="text" name="seset[${no}]" id="seset${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})" value="${format_angka(val.seset)}" >
								</td>

								<td style="text-align: center" >
									<input type="text" id="hasil${no}" name="hasil[${no}]"  class="form-control" value="${format_angka(val.hasil)}" readonly>
								</td>

								<td style="text-align: center" >
									<input type="checkbox" checked name="aksi[${no}]" id="aksi${no}" class="form-control" value="1" onchange="cek(this.value,this.id)" disabled>
								</td>
							</tbody>`;
							no ++;
						})
						list += `</table>`;
					}else{
						var list = `
						<table id="datatable_input" class="table">
							<thead class="color-tabel">
								<th style="text-align: center" >No</th>
								<th style="text-align: center" >NO SJ</th>
								<th style="text-align: center" >NO PO</th>
								<th style="text-align: center" >ITEM</th>
								<th style="text-align: center" >Ukuran</th>
								<th style="text-align: center" >Kualitas</th>
								<th style="text-align: center; padding-right: 35px" >Exclude</th>
								<th style="text-align: center; padding-right: 40px" >Include</th>
								<th style="text-align: center" >QTY</th>
								<th style="text-align: center; padding-right: 35px">R. QTY</th>
								<th style="text-align: center; padding-right: 40px" >HASIL</th>
								<th style="text-align: center" >AKSI</th>
							</thead>`;
						var no             = 1;
						var berat_total    = 0;
						$.each(data.detail, function(index, val) {
							if(val.no_po_sj == null || val.no_po_sj == '')
							{
								no_po = val.no_po
							}else{
								no_po = val.no_po_sj
							}
							list += `
							<tbody>
								<td id="no_urut${no}" name="no_urut[${no}]" style="text-align: center" >${no}
								
									<input type="hidden" name="id_pl_roll[${no}]" id="id_pl_roll${no}" value="${val.id_pl}">
									
									<input type="hidden" name="id_inv_detail[${no}]" id="id_inv_detail${no}" value="${val.id}">
								</td>

								<td style="text-align: center" >${val.no_surat}
									<input type="hidden" name="no_surat[${no}]" id="no_surat${no}" value="${val.no_surat}">
								</td>

								<td style="text-align: center" >${no_po}
									<input type="hidden" id="no_po${no}" name="no_po[${no}]" value="${no_po}">
								</td>

								<td style="text-align: center" >${val.id_produk_simcorr} - ${val.nm_ker}
									<input type="hidden" name="item[${no}]" id="item${no}" value="${val.nm_ker}">
									<input type="hidden" id="id_produk_simcorr${no}" name="id_produk_simcorr[${no}]" value="${val.id_produk_simcorr}">
								</td>

								<td style="text-align: center" >${val.g_label}
									<input type="hidden" id="ukuran${no}" name="ukuran[${no}]" value="${val.g_label}">
								</td>

								<td style="text-align: center" >${val.kualitas}
									<input type="hidden" id="kualitas${no}" name="kualitas[${no}]" value="${val.kualitas}">
								</td>

								<td style="text-align: center" >
									<input type="text" name="hrg[${no}]" id="hrg${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka(val.harga)}">
								</td>

								<td style="text-align: center" >
									<input type="text" name="inc[${no}]" id="inc${no}" class="form-control" onkeyup="ubah_angka(this.value,this.id),Hitung_price(this.value,this.id)" value="${format_angka_koma(val.include)}">
								</td>

								<td style="text-align: center" >${format_angka(val.qty)}
									<input type="hidden" id="qty${no}" name="qty[${no}]" onkeyup="ubah_angka(this.value,this.id)" value="${val.qty}">
								</td>
								
								<td style="text-align: center" >
									<input type="text" id="retur_qty${no}" name="retur_qty[${no}]" class="form-control" onkeyup="ubah_angka(this.value,this.id),hitung_hasil(this.value,${no})" value="${format_angka(val.retur_qty)}">
								</td>

								<td style="text-align: center" >
									<input type="text" id="hasil${no}" name="hasil[${no}]"  class="form-control" onkeyup="ubah_angka(this.value,this.id)" value="${format_angka(val.hasil)}" readonly>
								</td>

								<td style="text-align: center" >
									<input type="checkbox" checked name="aksi[${no}]" id="aksi${no}" class="form-control" value="1" onchange="cek(this.value,this.id)" disabled>
								</td>
							</tbody>`;
							berat_total += parseInt(val.qty);
							no ++;
						})
						list += `<td style="text-align: center" colspan="8">TOTAL
								</td>
								<td style="text-align: center" >${format_angka(berat_total)}
								</td>
								<td style="text-align: center" colspan="3">&nbsp;
								</td>`;
						list += `</table>`;
						// $("#datatable_input").html(list);
					}
					
					$("#datatable_input").html(list);
					// swal.close();

				} else {

					swal({
						title               : "Cek Kembali",
						html                : "Gagal Simpan",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// toastr.error('Terjadi Kesalahan');
				
				swal({
					title               : "Cek Kembali",
					html                : "Terjadi Kesalahan",
					type                : "error",
					confirmButtonText   : "OK"
				});
				
				return;
			}
		});

	}

	// INVOICE EDIT END //

</script>
