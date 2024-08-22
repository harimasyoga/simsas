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

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="card shadow mb-3">
			<div class="card-header" style="font-family:Cambria;" >
				<h3 class="card-title" style="color:#4e73df;"><b><?= $judul ?></b></h3>

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
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">Type</div>
							<div class="col-md-3">
								<input type="hidden" name="jenis" id="jenis" value="invoice">
								<input type="hidden" class="form-control" value="Add" name="status" id="status">
								<select name="type_po" id="type_po" class="form-control select2" style="width: 100%" onchange="noinv(),no_inv2()">
									<option value="">-- PILIH --</option>
									<option value="roll">Roll</option>
									<option value="sheet">Sheet</option>
									<option value="box">Box</option>
								</select>
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
								<button type="button" class="btn btn-primary" id="btn-simpan" onclick="load_sj()"><i class="fas fa-search"></i><b></b></button>
							</div>
							
							
						</div>

						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							
							<div class="col-md-2">No Invoice</div>
							<div class="col-md-1">
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
						<a href="<?= base_url('Logistik/Invoice')?>" class="btn btn-danger"><i class="fa fa-undo"></i> <b>Kembali</b></a>
						
						<button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i><b> Simpan</b></button>
					</div>
				</div>
				<br>
				<br>
			</form>	
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
	rowNum = 0;
	$(document).ready(function() {
		// getMax();
		$("#id_pl").prop('disabled', true);
		$('.select2').select2({
			containerCssClass: "wrap",
			placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
	});
	
	function simpan() 
	{
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
					location.href = "<?= base_url()?>Logistik/Invoice";

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
		$("#tgl_po").val("<?= date('Y-m-d') ?>");

		if (c != 's') {
			// getMax();

		}
		$("#btn-print").hide();

		$("#id_pelanggan").select2("val", "");
		$('#id_pelanggan').val("").trigger('change');		
		$("#id_pelanggan").prop("", false);

		$("#kode_po").val("");
		// $("#eta").val("");

		$("#txt_kota").val("");
		$("#txt_no_telp").val("");
		$("#txt_fax").val("");
		$("#txt_top").val("");
		$("#txt_marketing").val("");

		// clearRow();
		status = 'insert';
		$("#status").val(status);

		$("#btn-simpan").show();
		// $("#btn-simpan-plan").show();
		$("#btn-verif_acc").hide();
		$("#btn-verif_hold").hide();
		$("#btn-verif_r").hide();

		$(".btn-tambah-produk").show();
		$('#removeRow').show();
		$("#header_del").show();
	}

	var no_po = ''

	function load_sj() 
	{
		var tgl_sj    = $("#tgl_sj").val()
		var type_po   = $("#type_po").val()
		var stat      = 'add'
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
		var kpd                 = $('#id_pl option:selected').attr('data-nm');
		var id_perusahaan       = $('#id_pl option:selected').attr('data-id_perusahaan');
		var nm_perusahaan       = $('#id_pl option:selected').attr('data-nm_perusahaan');
		var alamat_perusahaan   = $('#id_pl option:selected').attr('data-alamat_perusahaan');
		$("#id_perusahaan").val(id_perusahaan)
		$("#kpd").val(kpd)
		$("#nm_perusahaan").val(nm_perusahaan)
		$("#alamat_perusahaan").val(alamat_perusahaan)

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
		var type    = $('#type_po').val()
		var pajak   = $('#pajak').val()
		var cek_inv = $('#cek_inv').val()
		var tgl_inv = $('#tgl_inv').val()

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
		var bucket = $('#bucket').val();
		for (var e = bucket; e > 0; e--) {
			jQuery('#itemRow' + e).remove();
			jQuery('#item_tambahan' + e).remove();
			rowNum--;
		}

		$('#removeRow').hide();
		$('#bucket').val(rowNum);
		$('#id_produk0').val('').trigger('change');
		$('#qty0').val('');
		$('#p110').val('0');
		$('#price_inc0').val('');
		$('#price_exc0').val('');
		$('#txt_detail_produk0').html('');
		$("#btn-hapus-0").show();
		$("#detail-hapus-0").show();
		$("#p11_det0").show();

		$("#qty0").prop("", false);
		$("#id_produk0").prop("", false);
		$("#price_inc0").prop("", false);
		$("#price_exc0").prop("", false);		
		$("#ppn0").prop("", false);
		$('#cek_rm0').prop("", false);
		$('#cek_rm0').prop('checked', false);
		$("#eta_ket0").prop("", false);

		$("#cek_rm0").val(0);		
		$("#eta_ket0").val(0);		
		$("#tl_al0").val('');		
		$("#bmf0").val('');		
		$("#bl0").val('');		
		$("#cmf0").val('');		
		$("#cl0").val('');		
		$("#tl_al_i0").val(0);		
		$("#bmf_i0").val(0);		
		$("#bl_i0").val(0);		
		$("#cmf_i0").val(0);		
		$("#cl_i0").val(0);		
		$("#ii_lebar0").val(0);		
		$("#qty_plan0").val(0);		
		$("#i_lebar_roll0").val(0);		
		$("#out_plan0").val(0);		
		$("#trim0").val(0);		
		$("#c_off0").val(0);		
		$("#rm_plan0").val(0);		
		$("#ton_plan0").val(0);	
	
		$("#tl_al0").prop("", true);		
		$("#bmf0").prop("", true);		
		$("#bl0").prop("", true);		
		$("#cmf0").prop("", true);		
		$("#cl0").prop("", true);		
		$("#tl_al_i0").prop("", true);		
		$("#bmf_i0").prop("", true);		
		$("#bl_i0").prop("", true);		
		$("#cmf_i0").prop("", true);		
		$("#cl_i0").prop("", true);		
		$("#ii_lebar0").prop("", true);		
		$("#qty_plan0").prop("", true);		
		$("#i_lebar_roll0").prop("", true);		
		$("#out_plan0").prop("", true);		
		$("#trim0").prop("", true);		
		$("#c_off0").prop("", true);		
		$("#rm_plan0").prop("", true);		
		$("#ton_plan0").prop("", true);		
		
		<?php if ($this->session->userdata('level') != "PPIC"){ ?>
			$('#subs0').hide();
			$('#subs_i0').hide();
			$('#subs_hitung0').hide();
			$('#subs_hasil_hitung0').hide();
		<?php } ?>
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

</script>
