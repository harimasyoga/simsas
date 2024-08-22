<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
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
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
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
							<th style="text-align: center; width:5%">NO.</th>
							<th style="text-align: center; width:20%">PIMPINAN</th>
							<th style="text-align: center; width:20%">NAMA INSTANSI</th>
							<th style="text-align: center; width:35%">ALAMAT</th>
							<th style="text-align: center; width:10%">NO HP</th>
							<th style="text-align: center; width:10%">AKSI</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modalForm">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="judul"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form role="form" method="post" id="myForm">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">PIMPINAN</label>
						<div class="col-sm-10">
							<input type="hidden" class="form-control" id="kode_lama">
							<input type="text" class="form-control" id="pimpinan" placeholder="ATAS NAMA" autocomplete="off" maxlength="50" oninput="this.value = this.value.toUpperCase()">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">NAMA HUB</label>
						<div class="col-sm-10">
							<input type="hidden" class="form-control" id="nm_old">
							<input type="text" class="form-control" id="nm_hub" placeholder="NAMA PELANGGAN" autocomplete="off" maxlength="50" oninput="this.value = this.value.toUpperCase()">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">ALAMAT</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="alamat" placeholder="ALAMAT KANTOR" oninput="this.value = this.value.toUpperCase()"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">KODE POS</label>
						<div class="col-sm-10">
							<input type="text" class="angka form-control" id="kode_pos" placeholder="-" autocomplete="off" maxlength="10">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">NO TELP</label>
						<div class="col-sm-10">
							<input type="text" class="angka form-control" id="no_telp" placeholder="-" autocomplete="off" maxlength="16">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">FAX</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="fax" placeholder="-" autocomplete="off" maxlength="25">
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i> Simpan</button>
				
				<button type="button" class="btn btn-danger" data-dismiss="modalForm" onclick="close_modal();" ><i class="fa fa-times-circle"></i> <b> Batal</b></button>
				
			</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
	rowNum = 0;
	$(document).ready(function() {
		$(".select2").select2()
		load_data()
	});

	status = "insert";
	$(".tambah_data").click(function(event) {
		kosong()
		$("#modalForm").modal("show")
		$("#judul").html('<h3> Form Tambah Data</h3>')
		status = "insert"
	});

	function close_modal(){
		$('#modalForm').modal('hide');
	}

	function load_data() {
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Master/load_data/hub',
				"type": "POST",
			},
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function simpan() {
		$("#btn-simpan").prop("disabled", true);
		
		kode_lama   = $("#kode_lama").val();
		nm_old      = $("#nm_old").val();
		pimpinan    = $("#pimpinan").val();
		nm_hub      = $("#nm_hub").val();
		alamat      = $("#alamat").val();
		no_telp     = $("#no_telp").val();
		kode_pos    = $("#kode_pos").val();
		fax         = $("#fax").val();

		if ( pimpinan == "" || nm_hub == "" || alamat == "" ) {
			swal("HARAP LENGKAPI FORM!", "", "info")
			$("#btn-simpan").prop("disabled", false);
			return;
		}

		$.ajax({
			url: '<?php echo base_url(); ?>/Master/Insert/'+status,
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
				kode_lama, nm_old, pimpinan ,nm_hub ,alamat ,no_telp ,kode_pos ,fax , jenis: 'm_hub', status: status
			}),
			success: function(res) {
				data = JSON.parse(res)
				// console.log(data)
				if(data.data){
					swal("BERHASIL DISIMPAN!", "", "success")
					kosong();
					$("#modalForm").modal("hide");
					reloadTable();
				}else{
					swal(data.isi, "", "error")
					$("#btn-simpan").prop("disabled", false);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				toastr.error('Terjadi Kesalahan');
				swal.close()
			}
		});
	}

	function kosong() {
		$("#kode_lama").val("");
		$("#nm_old").val("");
		$("#pimpinan").val("");
		$("#nm_hub").val("");
		$("#alamat").val("");
		$("#kode_pos").val("");
		$("#no_telp").val("");
		$("#fax").val("");
		status = 'insert';
		$("#btn-simpan").show().prop("disabled", false);
	}

	function tampil_edit(id, act) {
		status = 'update';
		$("#modalForm").modal("show");
		if (act == 'detail') {
			$("#judul").html('<h3> Detail Data</h3>');
			$("#btn-simpan").hide();
		} else {
			$("#judul").html('<h3> Form Edit Data</h3>');
			$("#btn-simpan").show();
		}

		$("#jenis").val('Update');
		// $("#id_sales").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$.ajax({
			url    : '<?php echo base_url('Master/edit_hub'); ?>',
			type   : 'POST',
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
				id,
			}),
		})
		.done(function(json) {
			data = JSON.parse(json)

			$("#kode_lama").val(data.hub.id_hub);
			$("#pimpinan").val(data.hub.pimpinan);
			$("#nm_hub").val(data.hub.nm_hub);
			$("#nm_old").val(data.hub.nm_hub);
			$("#alamat").val(data.hub.alamat);
			$("#kode_pos").val(data.hub.kode_pos);
			$("#no_telp").val(data.hub.no_telp);
			$("#fax").val(data.hub.fax);

			swal.close()
		})
	}


	function deleteData(id) {
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
					jenis: 'm_hub',
					field: 'id_hub'
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
