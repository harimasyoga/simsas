<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<!-- <h1><b>Data Master</b></h1> -->
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<!-- <li class="breadcrumb-item active"><a href="#"><?= $judul ?></a></li> -->
					</ol>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="card">
			<div class="card-header" style="font-family:Cambria">
				<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<button type="button" style="font-family:Cambria;" class="tambah_data btn  btn-info pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Tambah Data</b></button>
				<br><br>
				<table id="datatable" class="table table-bordered table-striped" width="100%">
					<thead class="color-tabel">
						<tr>
							<th style="width:5%">NO.</th>
							<th style="width:20%">NAMA SUPPLIER</th>
							<th style="width:25%">ALAMAT</th>
							<th style="width:25%">NO. TELP</th>
							<th style="width:10%">AKSI</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form role="form" method="post" id="myForm">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">NAMA SUPPLIER</label>
						<div class="col-sm-10">
							
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="jenis" id="jenis" value="m_supp">
							<input type="hidden" name="status" id="status">
							<input type="hidden" class="form-control" id="idx" name="idx">

							<input type="text" class="form-control" id="nm_supplier" name="nm_supplier" placeholder="NAMA SUPPLIER" autocomplete="off" maxlength="50" oninput="this.value = this.value.toUpperCase()">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">ALAMAT</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="alamat" name="alamat" placeholder="ALAMAT" oninput="this.value = this.value.toUpperCase()"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">NO. TELP</label>
						<div class="col-sm-10">
							<input class="angka form-control" id="no_telp" name="no_telp" placeholder="NO. TELP">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					
					<span id="btn-simpan"></span>
					<button type="button" data-dismiss="modal" class="btn-tambah-produk btn  btn-danger"><b>
						<i class="fa fa-undo" ></i> Kembali</b>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	rowNum = 0;

	$(document).ready(function() {
		$(".select2").select2()
		load_data()
	});

	$(".tambah_data").click(function(event) {
		kosong()
		$("#modalForm").modal("show")
		$("#judul").html('<h3> Form Tambah Data</h3>')
		$("#sts_input").val("insert")
		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Simpan</b> </button>`)		
		$("#btn-simpan").show();
	});

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
				"url": '<?php echo base_url(); ?>Master/load_data/supp',
				"type": "POST",
			},
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	function kosong() 
	{
		$("#idx").val("")

		$("#nm_supplier").val("")
		$("#alamat").val("")
		$("#no_telp").val("")
		$("#btn-simpan").prop("disabled", false);
	}


	function simpan() 
	{
		var nm_supplier   = $("#nm_supplier").val()
		var alamat        = $("#alamat").val()
		var no_telp       = $("#no_telp").val()
		var sts_input     = $("#sts_input").val()

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		if ( nm_supplier=='' || alamat== '' || no_telp =='') 
		{			
			swal({
				title               : "Cek Kembali",
				html                : "Harap Lengkapi Form Dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}

		$("#btn-simpan").prop("disabled", true);
		$.ajax({
			url        : '<?= base_url(); ?>Master/Insert',
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
					// swal.close();								
					kosong();
					$("#modalForm").modal("hide");
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success",
						confirmButtonText   : "OK"
					});
					
				} else {
					// toastr.error('Gagal Simpan');
					$("#btn-simpan").prop("disabled", false);
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
				$("#btn-simpan").prop("disabled", false);
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

	function tampil_edit(id, act) 
	{
		$("#sts_input").val("update")
		$("#modalForm").modal("show");
		if (act == 'detail') {
			$("#judul").html('<h3> Detail Data</h3>');
			$("#btn-simpan").hide();
		} else {
			$("#judul").html('<h3> Form Edit Data</h3>');
			$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)
			$("#btn-simpan").show();
		}
		$("#btn-simpan").prop("disabled", false);

		$.ajax({
			url: '<?php echo base_url('Master/edit_m_supp'); ?>',
			type: 'POST',
			data: ({ id }),
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
			success: function(res){
				data = JSON.parse(res)
				// console.log(data)

				$("#idx").val(id)
				$("#nm_supplier").val(data.supp.nm_supp)
				$("#alamat").val(data.supp.alamat)
				$("#no_telp").val(data.supp.no_telp)
				swal.close()
			}
		})
	}

	function deleteData(id) 
	{
		swal({
			title: "Apakah Kamu Yakin?",
			text: "",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#C00",
			confirmButtonText: "Delete"
		}).then(function(result) {
			$.ajax({
				url: '<?php echo base_url(); ?>Master/hapus',
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
					id: id,
					jenis: 'm_supp',
					field: 'id_supp'
				}),
				type: "POST",
				success: function(data) {
					swal.close()
					toastr.success('Data Berhasil Di Hapus');
					reloadTable();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					swal.close()
					toastr.error('Terjadi Kesalahan');
				}
			});
		})
	}
</script>
