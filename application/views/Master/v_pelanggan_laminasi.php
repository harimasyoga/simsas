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
				<?php if (in_array($this->session->userdata('level'), ['Admin','konsul_keu','Laminasi'])) {
					if($this->session->userdata('username') != 'usman'){
				?>
					<button type="button" style="font-family:Cambria;" class="tambah_data btn  btn-info pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Tambah Data</b></button>
					<br><br>
				<?php }} ?>
				<div style="overflow:auto;white-space:nowrap">
					<table id="datatable" class="table table-bordered table-striped">
						<thead class="color-tabel">
							<tr>
								<th style="width:5%">NO.</th>
								<th style="width:20%">NAMA PELANGGAN</th>
								<th style="width:25%">ALAMAT</th>
								<th style="width:25%">NO. TELP</th>
								<th style="width:15%">SALES</th>
								<th style="width:10%">AKSI</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
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
			<div class="modal-body">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">SALES</label>
					<div class="col-sm-10">
						<select id="id_sales" class="form-control select2"></select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">NAMA PELANGGAN</label>
					<div class="col-sm-10">
						<input type="hidden" class="form-control" id="idx">
						<input type="text" class="form-control" id="nm_pelanggan" placeholder="NAMA PELANGGAN" autocomplete="off" maxlength="50" oninput="this.value = this.value.toUpperCase()">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">ATTN</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="attn" placeholder="ATAS NAMA" autocomplete="off" maxlength="50" oninput="this.value = this.value.toUpperCase()">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">KOTA</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="alamat" placeholder="KOTA" oninput="this.value = this.value.toUpperCase()"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">ALAMAT KIRIM</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="alamat_kirim" placeholder="ALAMAT KIRIM" oninput="this.value = this.value.toUpperCase()"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">NO. TELP</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="no_telp" placeholder="NO. TELP" oninput="this.value = this.value.toUpperCase()"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i> Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	rowNum = 0;
	status = "insert";

	$(document).ready(function() {
		$(".select2").select2()
		load_data()
		getPlhSales()
	});

	$(".tambah_data").click(function(event) {
		kosong()
		$("#modalForm").modal("show")
		$("#judul").html('<h3> Form Tambah Data</h3>')
		status = "insert"
	});

	function reloadTable() {
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() {
		var table = $('#datatable').DataTable();
		table.destroy();
		tabel = $('#datatable').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Master/load_data/pelanggan_laminasi',
				"type": "POST",
			},
			responsive: false,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	function kosong() {
		$("#idx").val("")
		$("#id_sales").val("").trigger('change')
		$("#nm_pelanggan").val("")
		$("#attn").val("")
		$("#alamat").val("")
		$("#alamat_kirim").val("")
		$("#no_telp").val("")
		$("#btn-simpan").prop("disabled", false);
	}

	function getPlhSales(){
		$("#id_sales").html(`<option value="">PILIH</option>`).prop('disabled', true)
		$.ajax({
			url: '<?php echo base_url('Master/getPlhSales')?>',
			type: "POST",
			success: function(res){
				data = JSON.parse(res)
				let htmlCust = ''
				htmlCust += `<option value="">PILIH</option>`
				data.forEach(loadCust)
				function loadCust(r, index) {
					htmlCust += `<option value="${r.id_sales}" data-nama="${r.nm_sales}">${r.nm_sales}</option>`;
				}
				$("#id_sales").html(htmlCust).prop('disabled', false)
			}
		})
	}

	$('#id_sales').on('change', function() {
		let id_sales = $('#id_sales option:selected').val()
		let nm_sales = $('#id_sales option:selected').attr('data-nama')
	})

	function simpan() {
		let idx = $("#idx").val()
		let id_sales = $('#id_sales option:selected').val();
		let nm_pelanggan = $("#nm_pelanggan").val()
		let attn = $("#attn").val()
		let alamat = $("#alamat").val()
		let alamat_kirim = $("#alamat_kirim").val()
		let no_telp = $("#no_telp").val()

		$("#btn-simpan").prop("disabled", true);
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
				idx, id_sales, nm_pelanggan, attn, alamat, alamat_kirim, no_telp, jenis: 'm_pelanggan_lm', status: status
			}),
			success: function(res) {
				data = JSON.parse(res)
				if(data.data){
					swal("BERHASIL DISIMPAN!", "", "success")
					$("#modalForm").modal("hide");
					kosong();
					reloadTable();
				}else{
					swal("HARAP LENGKAPI FORM!", "", "error")
					$("#btn-simpan").prop("disabled", false);
				}
			}
		});
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
		$("#btn-simpan").prop("disabled", false);
		$.ajax({
			url: '<?php echo base_url('Master/getEditPelangganLM'); ?>',
			type: 'POST',
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
				$("#idx").val(id)
				$("#id_sales").val(data.pelanggan.id_sales).trigger('change')
				$("#nm_pelanggan").val(data.pelanggan.nm_pelanggan_lm)
				$("#attn").val(data.pelanggan.attn)
				$("#alamat").val(data.pelanggan.alamat)
				$("#alamat_kirim").val(data.pelanggan.alamat_kirim)
				$("#no_telp").val(data.pelanggan.no_telp)
				swal.close()
			}
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
					jenis: 'm_pelanggan_lm',
					field: 'id_pelanggan_lm'
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
