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
		<div class="card shadow mb-3">
			<div class="row-list">
				<div class="card-header" style="font-family:Cambria;">		
						<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
						</div>
				</div>
				<div class="card-body" >
					<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu','ma'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>

							
							<button type="button" class="btn btn-sm btn-danger" id="modal_btn-print" onclick="Cetak(1)" ><i class="fas fa-print"></i> <b>Print</b></button>
							
						</div>
					<?php } ?>
					<div style="overflow:auto;">
						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th style="width:5%">#</th>
									<th style="width:35%">NAMA JOB</th>
									<th style="width:25%">DASAR HUKUM</th>
									<th style="width:25%">SYARAT</th>
									<th style="width:10%">AKSI</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>			
		</div>
	</section>

	<section class="content">

		<!-- Default box -->
		<div class="card shadow row-input" style="display: none;">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b>Input <?=$judul?></b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<form role="form" method="post" id="myForm">
				<div class="col-md-12">
								
					<br>
						
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
											
						<div class="col-md-2 text-right">ID Pelanggan :</div>
						<div class="col-md-3">
							
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="id_tutor" id="id_tutor">
							<input class="form-control"  name="id_pelanggan" id="id_pelanggan">
						</div>
						<div class="col-md-6"></div>
						
						<div class="col-md-2 text-right">Nama :</div>
						<div class="col-md-3">
							
							<input class="form-control"  name="nm" id="nm">
						</div>
						<div class="col-md-6"></div>

						<div class="col-md-2 text-right">Tarif / Daya:</div>
						<div class="col-md-3">
							
							<input class="form-control"  name="tarif_daya" id="tarif_daya">
						</div>
						<div class="col-md-6"></div>

						<div class="col-md-2 text-right">Nominal :</div>
						<div class="col-md-3">
							
							<input class="form-control"  name="nominal" id="nominal">
						</div>
						<div class="col-md-6"></div>

						<div class="col-md-2 text-right">Admin :</div>
						<div class="col-md-3">
							
							<input class="form-control"  name="admin" id="admin">
						</div>
						<div class="col-md-6"></div>

						<div class="col-md-2 text-right">Total Bayar :</div>
						<div class="col-md-3">
							
							<input class="form-control"  name="tot_bayar" id="tot_bayar">
						</div>
						<div class="col-md-6"></div>

						<div class="col-md-2 text-right">Token :</div>
						<div class="col-md-3">
							
							<input class="form-control"  name="token" id="token">
						</div>
						<div class="col-md-6"></div>

						<div class="col-md-2 text-right">No Ref :</div>
						<div class="col-md-3">
							
							<input class="form-control"  name="noref" id="noref">
						</div>
						<div class="col-md-6"></div>

					</div>
					<br>
					
					<div class="card-body row"style="font-weight:bold">
						<div class="col-md-4">
							<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
								<i class="fa fa-chevron-left" ></i> Kembali</b>
							</button>

							<span id="btn-simpan"></span>

						</div>
						
						<div class="col-md-6"></div>
						
					</div>

					<br>
					
				</div>
			</form>	
		</div>
		<!-- /.card -->
	</section>
</div>

<script type="text/javascript">

	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		// load_data()
		// load_job()
		$('.select2').select2();
	});
	
	var rowNum = 0;
	
	function pilihan_job(cek)
	{

		if(cek == 'YA')
		{
			$('#div_job').show("1000");
			$('#div_job_text').hide("1000");
		}else{
			$('#div_job').hide("1000");
			$('#div_job_text').show("1000");
		}
	}

	function load_job() 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Tutorial/pilihan_job",
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
					option += "<option value='"+val.id_job+"'>"+val.nm_job+"</option>";
					});

					$('#pil_job').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#pil_job').html(option);					
					swal.close();
				}
			}
		});
		
	}
	
	function Cetak(ctk) 
	{
		// no_invoice = $("#no_invoice").val();
		var url = "<?= base_url('Tutorial/Cetak_tutor'); ?>";
		window.open(url + '?ctk=' + ctk, '_blank');
		// window.open(url, '_blank');
	}

	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() 
	{
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Tutorial/load_data/tr_tutorial',
				"type": "POST",
			},
			responsive: false,
			"pageLength": 25,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}
	
	function edit_data(id)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Tutorial/load_data_1',
			type       : "POST",
			data       : { id, jenis :'edit_tutor' },
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
				if(data){ 
					// header
					$("#id_tutor").val(data.header.id_tutor);
					// $("#pilihan").val(data.header.pilihan).trigger('change');

					$("input[name='pilihan'][value='" + data.header.pilihan + "']").prop("checked", true).trigger('change');

					pilihan_job(data.header.pilihan)
					
					$("#pil_job").val(data.header.pil_job).trigger('change');
					// $("#pil_job").val(data.header.pil_job);
					$("#pil_job_text").val(data.header.pil_job_text);
					$("#dasar_hukum").val(data.header.dasar_hukum);
					$("#syarat").val(data.header.syarat);
					$("#ket").val(data.header.ket);
					$("#tutor").val(data.header.tutor);
					$("#error_log").val(data.header.error_log);
					
					
					swal.close();
					// detail


				} else {

					swal.close();
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


	function kosong()
	{
		rowNum = 0
		$("input[name='pilihan'][value='YA']").prop("checked", true).trigger('change');
		pilihan_job('YA')
		$("#pil_job").val('');			
		$("#pil_job_text").val('');			
		$("#dasar_hukum").val('');			
		$("#syarat").val('');			
		$("#ket").val('');			
		$("#tutor").val('');			
		$("#error_log").val('');		
		
		
		swal.close()
	}

	function simpan() 
	{ 
		var id_tutor        = $("#id_tutor").val();
		var pilihan         = $("#pilihan").val();
		var pil_job         = $("#pil_job").val();
		var pil_job_text    = $("#pil_job_text").val();
		var dasar_hukum     = $("#dasar_hukum").val();
		var syarat          = $("#syarat").val();
		var ket             = $("#ket").val();
		var tutor           = $("#tutor").val();
		var error_log       = $("#error_log").val();
		
		if ( pilihan =='' || dasar_hukum =='' || syarat =='' || tutor =='' || error_log =='') 
		{
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		$.ajax({
			url        : '<?= base_url(); ?>Tutorial/insert_tutor',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
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
				if(data == true){
					// toastr.success('Berhasil Disimpan');						
					kosong();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					kembaliList()
					
				} else {
					// toastr.error('Gagal Simpan');
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

	function add_data()
	{
		kosong()
		$(".row-input").attr('style', '')
		$(".row-list").attr('style', 'display:none')
		$("#sts_input").val('add');
		
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)
	}

	function kembaliList()
	{
		kosong()
		reloadTable()
		$(".row-input").attr('style', 'display:none')
		$(".row-list").attr('style', '')
	}

	function deleteData(id,nm_job) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong><b>" +nm_job+ "</b> </strong> ",
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
				url: '<?= base_url(); ?>Tutorial/hapus',
				data: ({
					id         : id,
					jenis      : 'tutor',
					field      : 'id_tutor'
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
					toastr.success('Data Berhasil Di Hapus');
					swal.close();

					// swal({
					// 	title               : "Data",
					// 	html                : "Data Berhasil Di Hapus",
					// 	type                : "success",
					// 	confirmButtonText   : "OK"
					// });
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
</script>
