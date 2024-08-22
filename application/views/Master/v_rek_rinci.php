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

	<div class="container-fluid row-input" style="display: none;">
		<form role="form" method="post" id="myForm">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-info card-outline">
						<div class="card-header" style="padding:12px">
							<h3 class="card-title" style="font-weight:bold;font-size:18px">Input Rekening Rinci</h3>
						</div>
											
						<div class="card-body row" style="padding-bottom:none;font-weight:bold">						
							<div class="col-md-8"></div>
							<div class="col-md-7"></div>
							
						</div>

							<div class="card-body row" style="padding : 5px;font-weight:bold">
								<div class="col-md-1"></div>

								<div class="col-md-2">PILIH JENIS</div>
								<div class="col-md-1">
									
									<input type="hidden" class="angka form-control" name="sts_input" id="sts_input" >

									<button class="btn btn-success btn-sm" style="width:100%;margin:auto" data-toggle="modal" data-target=".list_kelompok" type="button" onclick="load_jenis()">
									<i class="fa fa-search"></i>
								</button>
								</div>

								<div class="col-md-8"></div>
							</div>
							<div class="card-body row" style="padding : 5px;font-weight:bold">
								<div class="col-md-1"></div>

								<div class="col-md-2">KODE AKUN</div>
								
								<div class="col-md-3">
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text" id="id_akun">&nbsp;&nbsp; .</span>
										</div>
										<input type="hidden" class="form-control" name="kd_akun" id="kd_akun" maxlength="4" readonly>
										<input type="text" class="form-control" name="nm_akun" id="nm_akun" maxlength="4" readonly>

									</div>
								</div>

								<div class="col-md-6"></div>
							</div>
							<div class="card-body row" style="padding : 5px;font-weight:bold">
								<div class="col-md-1"></div>
								<div class="col-md-2">KODE KELOMPOK</div>
								<div class="col-md-3">
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text" id="id_kelompok">&nbsp;&nbsp; .</span>
										</div>
										<input type="hidden" class="form-control" name="kd_kelompok" id="kd_kelompok" maxlength="4" readonly>
										<input type="text" class="form-control" name="nm_kelompok" id="nm_kelompok" maxlength="4" readonly>

									</div>
								</div>
									

								<div class="col-md-6"></div>

							</div>
							<div class="card-body row" style="padding : 5px;font-weight:bold">
								<div class="col-md-1"></div>
								<div class="col-md-2">KODE JENIS</div>
								<div class="col-md-3">
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text" id="id_jenis">&nbsp;&nbsp; .</span>
										</div>
										<input type="hidden" class="form-control" name="kd_jenis" id="kd_jenis" maxlength="4" readonly>
										<input type="text" class="form-control" name="nm_jenis" id="nm_jenis" maxlength="4" readonly>

									</div>
								</div>
									

								<div class="col-md-6"></div>

							</div>
							
							<div class="card-body row" style="padding : 5px;font-weight:bold">
								<div class="col-md-1"></div>
								<div class="col-md-2">KODE RINCI</div>
								<div class="col-md-3">
									<div class="input-group mb-1">
										<div class="input-group-append">
											<span class="input-group-text" id="id_rinci">&nbsp;&nbsp; .</span>
										</div>
										<input type="hidden" class="angka form-control" name="id_rinci_old" id="id_rinci_old" maxlength="2" >
										<input type="text" class="angka form-control" name="kd_rinci" id="kd_rinci" maxlength="2" >

									</div>
								</div>
									

								<div class="col-md-6"></div>

							</div>
							<div class="card-body row" style="padding : 5px;font-weight:bold">
								<div class="col-md-1"></div>
								<div class="col-md-2">NAMA RINCI</div>
								<div class="col-md-3">
									<div class="input-group mb-1">
										<input type="text" class="form-control" name="nm_rinci" id="nm_rinci" oninput="this.value = this.value.toUpperCase()">

									</div>
								</div>									

								<div class="col-md-6"></div>

							</div>
						<br>
						
						<div class="card-body row"style="font-weight:bold">
							<div class="col-md-2">
								<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
									<i class="fa fa-undo" ></i> Kembali</b>
								</button>
							</div>
							<div class="col-md-2">
								<div id="btn-simpan"></div>
								
							</div>	
							
							<div class="col-md-6"></div>
							
						</div>

						<br>
					</div>
				</div>
			</div>
		</form>	
	</div>

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
					<?php if(in_array($this->session->userdata('level'), ['Admin','konsul_keu','Laminasi'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
						</div>
					<?php } ?>
					<!-- <div style="overflow:auto;white-space:nowrap"> -->
						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th class="text-center title-white">NO</th>
									<th class="text-center title-white">NAMA AKUN</th>
									<th class="text-center title-white">NAMA KELOMPOK</th>
									<th class="text-center title-white">NAMA JENIS</th>
									<th class="text-center title-white">KODE RINCI</th>
									<th class="text-center title-white">NAMA RINCI</th>
									<th class="text-center title-white">JENIS</th>
									<th class="text-center title-white">D/K</th>
									<th class="text-center title-white">AKSI</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					<!-- </div> -->
				</div>
			</div>			
		</div>
	</section>

</div>

<!-- Modal kelompok -->
<div class="modal fade list_kelompok" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full" style="width:100%;margin:auto">

        <div class="modal-content">
            <div class="modal-header">
                <h5><b>Pilih Kelompok</b></h5>
            </div>
            <div class="modal-body">
				<div style="overflow:auto;white-space:nowrap">

                <table class="table table-bordered table-striped" id="tbl_jenis" style="margin:auto !important">
                    <thead>
                        <tr class="color-tabel">
                            <th class="text-center title-white">NO </th>
                            <th class="text-center title-white">NAMA AKUN</th>
                            <th class="text-center title-white">NAMA KELOMPOK</th>
                            <th class="text-center title-white">KODE JENIS</th>
                            <th class="text-center title-white">NAMA JENIS</th>
                            <th class="text-center title-white">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>

    </div>
</div>
<!-- Modal kelompok -->


<script type="text/javascript">
	let statusInput = 'insert';
	const urlAuth = '<?= $this->session->userdata('level')?>';

	$(document).ready(function ()
	{
		kosong()
		load_data()
		$('.select2').select2();
	});

	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() 
	{
		let table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Master/load_data/load_kd_rinci')?>',
				"type": "POST",
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}
	
	function load_jenis()
	{
		let table = $('#tbl_jenis').DataTable();
		table.destroy();
		tabel = $('#tbl_jenis').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url('Master/load_data/load_kd_jenis_list')?>',
				"type": "POST",
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

	function add_timb(id_akun,nm_akun,kd_kelompok,nm_kelompok,kd_jenis,nm_jenis)
	{		
		$('.list_kelompok').modal('hide');
		$("#id_akun").html(id_akun)
		$("#kd_akun").val(id_akun)
		$('#nm_akun').val(nm_akun);
		$("#id_kelompok").html(id_akun+'.'+kd_kelompok)
		$("#kd_kelompok").val(kd_kelompok)
		$('#nm_kelompok').val(nm_kelompok);
		$("#id_jenis").html(id_akun+'.'+kd_kelompok+'.'+kd_jenis)
		$("#kd_jenis").val(kd_jenis)
		$('#nm_jenis').val(nm_jenis);
		$("#id_rinci").html(id_akun+'.'+kd_kelompok+'.'+kd_jenis+'.')

		swal.close();
	}
	
	function edit_data(id,kd_rinci)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Master/load_data_1',
			type       : "POST",
			data       : { id, tbl:'m_kode_rinci', jenis :'kode_rinci',field :'id_rinci' },
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

					$("#id_akun").html(data.header.kd_akun)
					$("#kd_akun").val(data.header.kd_akun)
					$('#nm_akun').val(data.header.nm_akun);

					$("#id_kelompok").html(data.header.kd_akun+'.'+data.header.kd_kelompok)
					$("#kd_kelompok").val(data.header.kd_kelompok)
					$('#nm_kelompok').val(data.header.nm_kelompok);

					$("#id_jenis").html(data.header.kd_akun+'.'+data.header.kd_kelompok+'.'+data.header.kd_jenis)
					$("#kd_jenis").val(data.header.kd_jenis)
					$('#nm_jenis').val(data.header.nm_jenis);

					$("#id_rinci").html(data.header.kd_akun+'.'+data.header.kd_kelompok+'.'+data.header.kd_jenis+'.')
					$("#id_rinci_old").val(data.header.id_rinci)
					$("#kd_rinci").val(data.header.kd_rinci)
					$('#nm_rinci').val(data.header.nm_rinci);


					swal.close();

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
		statusInput = 'insert'
		$("#sts_input").val("")
		$("#id_akun").html(".")
		$("#kd_akun").val("")
		$("#nm_akun").val("")
		$("#id_kelompok").html(".")
		$("#kd_kelompok").val("")
		$("#nm_kelompok").val("")
		$("#id_jenis").html(".")
		$("#kd_jenis").val("")
		$("#nm_jenis").val("")
		$("#id_rinci").html("")
		$("#id_rinci_old").val("")
		$("#kd_rinci").val("")
		$("#nm_rinci").val("")
		
		swal.close()
	}

	function simpan() 
	{
		var kd_rinci    = $("#kd_rinci").val();
		var nm_rinci    = $("#nm_rinci").val();

		if (kd_rinci='' || nm_rinci== '' ) 
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

		$.ajax({
			url        : '<?= base_url(); ?>Master/Insert_kode_rinci',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
			success: function(data) {
				if(data.status=='1'){
					// toastr.success('Berhasil Disimpan');
					// swal.close();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					// location.href = "<?= base_url()?>Master/Invoice_edit?id="+data.id+"&no_inv="+no_inv_ok+"";					
					kosong();
					location.href = "<?= base_url()?>Master/Rek_rinci";
					
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

	function deleteData(id,nm_akun) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus file ini ?</p><br>"
			+"<strong>" +nm_akun+ " </strong> ",
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
				url: '<?= base_url(); ?>Master/hapus',
				data: ({
					id: id,
					jenis: 'm_kode_rinci',
					field: 'id_rinci'
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
