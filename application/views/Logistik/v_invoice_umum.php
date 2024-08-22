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
						<h3 class="card-title" style="color:#42b549;"><b><?= $judul ?></b></h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fas fa-minus"></i></button>
						</div>
				</div>
				<div class="card-body" >
					<?php if(in_array($this->session->userdata('level'), ['Admin','user'])){ ?>
						<div style="margin-bottom:12px">
							<button type="button" class="btn btn-sm btn-info" onclick="add_data()"><i class="fa fa-plus"></i> <b>TAMBAH DATA</b></button>
						</div>
					<?php } ?>
					<div style="overflow:auto;">
						<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
							<thead class="color-tabel">
								<tr>
									<th class="text-center">NO</th>
									<th class="text-center">NO INVOICE</th>
									<th class="text-center">TANGGAL</th>
									<th class="text-center">TOTAL</th>
									<th class="text-center">NM PRODUK</th>
									<th class="text-center">REIMBURS</th>
									<th class="text-center">AKSI</th>
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
				<h3 class="card-title" style="color:#42b549;"><b>Input - <?=$judul?></b></h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
				</div>
			</div>
			<form role="form" method="post" id="myForm">
				<div class="col-md-12">
								
					<br>
						
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
						<div class="col-md-2">No Invoice</div>
						<div class="col-md-3">
							<input type="hidden" name="sts_input" id="sts_input">
							<input type="hidden" name="id_header_beli" id="id_header_beli">

							<input type="text" class="angka form-control" name="no_inv_beli" id="no_inv_beli" value="AUTO" readonly>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2">PENJUAL</div>
						<div class="col-md-3">
							<select class="form-control select2" name="nm_penjual" id="nm_penjual" style="width: 100%;" >
							</select> 
						</div>

					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
					<div class="col-md-2">Tanggal Invoice</div>
						<div class="col-md-3">
							<input type="date" class="form-control" name="tgl_inv" id="tgl_inv" value ="<?= date('Y-m-d') ?>" >
						</div>
						<div class="col-md-1"></div>

						<div class="col-md-2">PEMBELI</div>
						<div class="col-md-3">
							<input type="text" class=" form-control" name="nm_pembeli" id="nm_pembeli" value="">
						</div>
					</div>
					
					<div class="card-body row" style="padding-bottom:1px;font-weight:bold">			
						
						<div class="col-md-6"></div>

						<div class="col-md-2">ALAMAT KIRIM 1</div>
						<div class="col-md-3">
							<textarea class="form-control" name="alamat_kirim1" id="alamat_kirim1"></textarea>
						</div>
						
					</div>
					

					<br>
					
					<!-- detail PO-->
					<hr>
					<div class="card-body row" style="padding:0 20px 20px;font-weight:bold">
						<div class="col-md-4" style="padding-right:0">List Item Pembelian</div>
						<div class="col-md-8">&nbsp;
						</div>
					</div>


					<div style="overflow:auto;white-space:nowrap;" >
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 50px">Nama Barang</th>
									<th style="padding : 12px 70px" >Qty</th>
									<th style="padding : 12px 70px" >Satuan</th>
									<th style="padding : 12px 50px" >Harga satuan</th>
									<th style="padding : 12px 50px" >Total Harga</th>
								</tr>
							</thead>
							<tbody>
								<tr id="itemRow0">
									<td id="detail-hapus-0">
										<div class="text-center">
											<a class="btn btn-danger" id="btn-hapus-0" onclick="removeRow(0)">
												<i class="far fa-trash-alt" style="color:#fff"></i> 
											</a>
										</div>
									</td>
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<textarea class="form-control" name="nm_produk[0]" id="nm_produk0"></textarea>
										</div>
									</td>	

									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											
											<input type="text" size="5" name="jumlah[0]" id="jumlah0" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
											<div class="input-group-append">
												<span class="input-group-text"><b>pcs</b>
												</span>
											</div>	
												
										</div>
									</td>	
									
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											
											<input type="text" size="5" name="satuan[0]" id="satuan0" class="form-control" placeholder='-'>
												
										</div>
										
									</td>
									
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>	
											<input type="text" size="5" name="harga[0]" id="harga0" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
												
										</div>
										
									</td>		
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>	
											<input type="text" size="5" name="total_harga[0]" id="total_harga0" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0' readonly>
												
										</div>
										
									</td>		
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5" class="text-right">
										<label for="total">SUB TOTAL</label>
									</td>	
									<td>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="sub_total" id="sub_total" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
								</tr>
								<tr>
									<td colspan="5" class="text-right">
										<label for="total">PAJAK (11%) </label>
									</td>	
									<td>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="pajak" id="pajak" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
										</div>
										
									</td>	
								</tr>
								
								<tr>
									<td colspan="5" class="text-right">
										<label for="total">TOTAL TAGIHAN</label>
									</td>	
									<td>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="total_all" id="total_all" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
								</tr>
							</tfoot>
						</table>
						<div id="add_button" >
							<button type="button" onclick="addRow()" class="btn-tambah-produk btn  btn-success"><b><i class="fa fa-plus" ></i></b></button>
							<input type="hidden" name="bucket" id="bucket" value="0">
						</div>
						<br>
					</div>

					<!-- end detail PO-->

				
					<div class="card-body row"style="font-weight:bold">
						<div class="col-md-4">
							<button type="button" onclick="kembaliList()" class="btn-tambah-produk btn  btn-danger"><b>
								<i class="fa fa-undo" ></i> Kembali</b>
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
		load_data()
		load_penjual()
		$('.select2').select2();
	});
	
	var rowNum = 0;
	
	function addRow() 
	{
		var b = $('#bucket').val();

		if (b == -1) {
			b = 0;
			rowNum = 0;
		}
		var ket         = $('#ket' + b).val();
		var jns_beban   = $('#jns_beban' + b).val();
		var nominal     = $('#nominal' + b).val();
			
		if (nominal != '0' && nominal != '' && jns_beban != '' && ket != '') 
		{			
			rowNum++;
			var x = rowNum + 1;
			
				$('#table_list_item').append(
					`<tr id="itemRow${rowNum}">
						<td id="detail-hapus-${rowNum}">
							<div class="text-center">
								<a class="btn btn-danger" id="btn-hapus-${rowNum}" onclick="removeRow(${rowNum})">
									<i class="far fa-trash-alt" style="color:#fff"></i> 
								</a>
							</div>
						</td>
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<textarea class="form-control" name="nm_produk[${rowNum}]" id="nm_produk${rowNum}"></textarea>
							</div>
						</td>	

						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								
								<input type="text" size="5" name="jumlah[${rowNum}]" id="jumlah${rowNum}" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
								<div class="input-group-append">
									<span class="input-group-text"><b>pcs</b>
									</span>
								</div>	
									
							</div>
						</td>		

						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								
								<input type="text" size="5" name="satuan[${rowNum}]" id="satuan${rowNum}" class="form-control" placeholder='-'>
									
							</div>
							
						</td>

						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<div class="input-group-append">
									<span class="input-group-text"><b>Rp</b>
									</span>
								</div>	
								<input type="text" size="5" name="harga[${rowNum}]" id="harga${rowNum}" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0'>
									
							</div>
							
						</td>		
						<td style="padding : 12px 20px">
							<div class="input-group mb-1">
								<div class="input-group-append">
									<span class="input-group-text"><b>Rp</b>
									</span>
								</div>	
								<input type="text" size="5" name="total_harga[${rowNum}]" id="total_harga${rowNum}" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='0' readonly>
									
							</div>
							
						</td>		
					</tr>
					`);
				$('#bucket').val(rowNum);
				$('#list' + rowNum).focus();
		}else{
			swal({
				title               : "Cek Kembali",
				html                : "Isi form diatas terlebih dahulu",
				type                : "info",
				confirmButtonText   : "OK"
			});
			return;
		}
	}

	function removeRow(e) 
	{
		if (rowNum > 0) {
			jQuery('#itemRow' + e).remove();
			// rowNum--;
		} else {
			// toastr.error('Baris pertama tidak bisa dihapus');
			// return;

			swal({
					title               : "Cek Kembali",
					html                : "Baris pertama tidak bisa dihapus",
					type                : "error",
					confirmButtonText   : "OK"
				});
			return;
		}
		// $('#bucket').val(rowNum);
	}

	function clearRow() 
	{
		var bucket = $('#bucket').val();
		for (var e = bucket; e > 0; e--) {
			jQuery('#itemRow' + e).remove();
			rowNum--;
		}		
		$('#bucket').val(rowNum);
	}

	function hitung_total()
	{	
		var pajak          = $("#pajak").val()
		pajak_ok           = (pajak=='' || isNaN(pajak) || pajak == null) ? '0' : pajak;
		var pajak_total    = parseInt(pajak_ok.split('.').join(''))
		
		var sub_total = 0
		for(loop = 0; loop <= rowNum; loop++)
		{
			var jumlah       = $("#jumlah"+loop).val()
			jumlah_ok        = (jumlah=='' || isNaN(jumlah) || jumlah == null) ? '0' : jumlah;
			var jum_total    = parseInt(jumlah_ok.split('.').join(''))

			var harga        = $("#harga"+loop).val()
			harga_ok         = (harga=='' || isNaN(harga) || harga == null) ? '0' : harga;
			var harga_total  = parseInt(harga_ok.split('.').join(''))
			
			total_harga      = jum_total*harga_total			
			$("#total_harga"+loop).val(format_angka(total_harga))	

			sub_total += total_harga
		}		
		sub_total_ok = (sub_total=='' || isNaN(sub_total) || sub_total == null) ? 0 : sub_total
				
		var total_all     = parseInt(sub_total_ok) - parseInt(pajak_total)

		$("#sub_total").val(format_angka(sub_total_ok))	
		$("#total_all").val(format_angka(total_all))
		
	}
	
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
				"url": '<?php echo base_url('Logistik/load_data/inv_umum')?>',
				"type": "POST",
			},
			"aLengthMenu": [
				[5, 10, 50, 100, -1],
				[5, 10, 50, 100, "Semua"]
			],	
			"responsive": false,
			"pageLength": 10,
			"language": {
				"emptyTable": "TIDAK ADA DATA.."
			}
		})
	}

	function load_penjual() 
	{
		option = "";
		$.ajax({
			type       : 'POST',
			url        : "<?= base_url(); ?>Logistik/load_penjual",
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
					option += "<option value='"+val.id+"'>"+val.nama+"</option>";
					});

					$('#nm_penjual').html(option);
					swal.close();
				}else{	
					option += "<option value=''></option>";
					$('#nm_penjual').html(option);					
					swal.close();
				}
			}
		});
		
	}
	
	function edit_data(id,no_po)
	{
		$(".row-input").attr('style', '');
		$(".row-list").attr('style', 'display:none');
		$("#sts_input").val('edit');

		$("#btn-simpan").html(`<button type="button" onclick="simpan()" class="btn-tambah-produk btn  btn-primary"><b><i class="fa fa-save" ></i> Update</b> </button>`)

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/load_data_1',
			type       : "POST",
			data       : { id, jenis :'edit_inv_umum' },
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
					$("#id_header_beli").val(data.header.id_header_beli);
					$("#no_inv_beli").val(data.header.no_inv_beli);
					$("#tgl_inv").val(data.header.tgl_inv);				
					$("#nm_penjual").val(data.header.nm_penjual).trigger('change');
					$("#nm_pembeli").val(data.header.nm_pembeli);
					$("#alamat_kirim1").val(data.header.alamat_kirim1);

					pajak_ok = (data.header.pajak=='' || isNaN(data.header.pajak) || data.header.pajak == null) ? '0' : data.header.pajak;

					swal.close();
					// detail

					var list = `
						<table class="table table-hover table-striped table-bordered table-scrollable table-condensed" id="table_list_item" width="100%">
							<thead class="color-tabel">
								<tr>
									<th id="header_del">Delete</th>
									<th style="padding : 12px 50px">Nama Barang</th>
									<th style="padding : 12px 70px" >Qty</th>
									<th style="padding : 12px 70px" >Satuan</th>
									<th style="padding : 12px 50px" >Harga satuan</th>
									<th style="padding : 12px 50px" >Total Harga</th>
								</tr>
							</thead>`;
						
					var no   = 0;
					$.each(data.detail, function(index, val) {
						
						list += `
							<tr id="itemRow${no}">
									<td id="detail-hapus-${no}">
										<div class="text-center">
											<a class="btn btn-danger" id="btn-hapus-${no}" onclick="removeRow(${no})">
												<i class="far fa-trash-alt" style="color:#fff"></i> 
											</a>
										</div>
									</td>
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<textarea class="form-control" name="nm_produk[${no}]" id="nm_produk${no}">${val.nm_produk}</textarea>
										</div>
									</td>	
									
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											
											<input type="text" size="5" name="jumlah[${no}]" id="jumlah${no}" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='${format_angka(val.jumlah)}'>
											<div class="input-group-append">
												<span class="input-group-text"><b>pcs</b>
												</span>
											</div>	
												
										</div>
									</td>	
									
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											
											<input type="text" size="5" name="satuan[${no}]" id="satuan${no}" class="form-control" value="${(val.satuan)}">
												
										</div>
										
									</td>

									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>	
											<input type="text" size="5" name="harga[${no}]" id="harga${no}" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='${format_angka(val.harga)}'>
												
										</div>
										
									</td>		
									<td style="padding : 12px 20px">
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>	
											<input type="text" size="5" name="total_harga[${no}]" id="total_harga${no}" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='${format_angka(val.total_harga)}' readonly>
												
										</div>
										
									</td>		
								</tr>
						`;
						no ++;
					})
					
					list +=`<tfoot>
								<tr>
									<td colspan="5" class="text-right">
										<label for="total">SUB TOTAL</label>
									</td>	
									<td>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="sub_total" id="sub_total" class="angka form-control" value='' readonly>
										</div>
										
									</td>	
								</tr>
								<tr>
									<td colspan="5" class="text-right">
										<label for="total">PAJAK (11%)</label>
									</td>	
									<td>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="pajak" id="pajak" class="angka form-control" onkeyup="ubah_angka(this.value,this.id),hitung_total()" value='${format_angka(pajak_ok)}'>
										</div>
										
									</td>	
								</tr>
								<tr>
									<td colspan="5" class="text-right">
										<label for="total">TOTAL TAGIHAN</label>
									</td>	
									<td>
										<div class="input-group mb-1">
											<div class="input-group-append">
												<span class="input-group-text"><b>Rp</b>
												</span>
											</div>		
											<input type="text" size="5" name="total_all" id="total_all" class="angka form-control" value='0' readonly>
										</div>
										
									</td>	
								</tr>
							</tfoot>`;

					rowNum = no-1 
					$('#bucket').val(rowNum);					
					$("#table_list_item").html(list);
					hitung_total()	
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

	function acc_inv(no_invoice,status_owner) 
	{	
		var user        = "<?= $this->session->userdata('username')?>"
		var acc_owner   = status_owner
		// var acc_admin   = $('#modal_status_inv_admin').val()
		var no_inv      = no_invoice
		
		if(user=='bumagda' || user=='developer' || user=='yolanda_zu')
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
						jenis     : 'verif_inv_beli'
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
	
	function close_modal()
	{
		$('#modalForm').modal('hide');
		reloadTable()
	}
	
	function kosong()
	{
		$tgl = '<?= date('Y-m-d') ?>'	
		rowNum = 0
		$("#no_inv_beli").val('AUTO') 
		$("#nm_penjual").val('') 
		$("#tgl_inv").val($tgl) 
		$("#nm_pembeli").val('PT. Gemilang Sarana Mandiri (6285647553198)') 
		$("#jam_inv").val('') 
		$("#alamat_kirim1").val('Jl. Mangesti Raya Jl. Springville Residence No.1, Dusun II, Waru, Kec. Baki, Kabupaten Sukoharjo, Jawa Tengah 57556')

		$("#nm_produk0").val('');		
		$("#satuan0").val('');		
		$("#jumlah0").val(0);		
		$("#harga0").val(0);		
		$("#total_harga0").val(0);		

		clearRow()
		hitung_total()
		
		swal.close()
	}

	function simpan() 
	{
		var no_inv_beli   = $("#no_inv_beli").val();
		var nm_penjual    = $("#nm_penjual").val();
		var tgl_inv       = $("#tgl_inv").val();
		var nm_pembeli    = $("#nm_pembeli").val();
		var alamat_kirim1 = $("#alamat_kirim1").val();
		var nm_produk0    = $("#nm_produk0").val();
		var satuan0       = $("#satuan0").val();
		var jumlah0       = $("#jumlah0").val();
		var harga0        = $("#harga0").val();
		var total_harga0  = $("#total_harga0").val();	
		
		if ( no_inv_beli =='' || nm_penjual =='' || tgl_inv =='' || nm_pembeli =='' || alamat_kirim1 =='' || nm_produk0 =='' || satuan0 =='' || jumlah0 =='' || harga0 =='' || total_harga0 =='' ) 
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
			url        : '<?= base_url(); ?>Logistik/insert_inv_umum',
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

	function deleteData(id,no_inv_beli) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "HAPUS PEMBAYARAN",
			html: "<p> Apakah Anda yakin ingin menghapus Invoice ini ?</p><br>"
			+"<strong>" +no_inv_beli+ " </strong> ",
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
				url: '<?= base_url(); ?>Logistik/hapus',
				data: ({
					id         : no_inv_beli,
					jenis      : 'inv_umum',
					field      : 'no_inv_beli'
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
