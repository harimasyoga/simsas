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
								<select id="cek_inv" name="cek_inv" class="form-control select2" style="width: 100%">
									<option value="baru">BARU</option>
									<option value="revisi">REVISI</option>
								</select>
								<input type="hidden" name="cek_inv2" id="cek_inv2">
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">Type</div>
							<div class="col-md-3">
								<input type="hidden" name="jenis" id="jenis" value="invoice">

								<input type="hidden" class="form-control" value="Add" name="status" id="status">

								<input type="hidden" class="form-control" value="<?= $id ?>" name="id_header" id="id_header">

								<input type="hidden" class="form-control" value="<?= $no_inv ?>" name="no_invoice" id="no_invoice">

								<select name="type_po" id="type_po" class="form-control select2" style="width: 100%" >
															
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
								<input type="date" id="tgl_inv" name="tgl_inv" class="form-control" autocomplete="off" placeholder="Tanggal Invoice" onchange="noinv()">
							</div>
							<div class="col-md-1"></div>
							<div class="col-md-2">Pajak</div>
							<div class="col-md-3">
								<select id="pajak" name="pajak" class="form-control select2" style="width: 100%" onchange="noinv()">
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
								<input type="date" id="tgl_sj" name="tgl_sj" class="form-control" autocomplete="off" placeholder="Tanggal Surat Jalan" onchange="load_sj()" >
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
							<div class="col-md-9">
								<select class="form-control select2" id="id_pl" name="id_pl" style="width: 100%" autocomplete="off" >
								</select>
								<!-- onchange="load_cs()" -->
							</div>
							
							<!-- <div class="col-md-1">
								<button type="button" class="btn btn-primary" id="btn-simpan" onclick="load_sj()"><i class="fas fa-search"></i><b></b></button>
							</div> -->
							
						</div>

						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">						
							
							<div class="col-md-2">No Invoice</div>
							<div class="col-md-1">
								<input style="" type="hidden" id="id_inv" name="id_inv" class="input-border-none" autocomplete="off"  readonly>

								<input style="" type="hidden" id="no_inv_old" name="no_inv_old" class="input-border-none" autocomplete="off"  readonly>

								<input style="height: calc(2.25rem + 2px);font-size: 1rem;" type="text" id="no_inv_kd" name="no_inv_kd" class="input-border-none" autocomplete="off"  readonly>
							</div>
							<div class="col-md-1">
								<input style="height: calc(2.25rem + 2px);font-size: 1rem;"  type="text" id="no_inv" name="no_inv" class="input-border-none" autocomplete="off" readonly>
							</div>
							<div class="col-md-3">
								<input style="height: calc(2.25rem + 2px);font-size: 1rem;"  type="text" id="no_inv_tgl" name="no_inv_tgl" class="input-border-none" autocomplete="off" readonly>
							</div>
							
							<div class="col-md-4"></div>
							
						</div>

							<hr>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
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
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-2" style="padding-right:0">List Item</div>
								<div class="col-md-10">&nbsp;
								</div>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">		
							<div class="col-md-12"	style="overflow:auto;white-space:nowrap;" width="100%">	
									<table id="datatable_input" class="table table-hover table- table-bordered table-condensed table-scrollable">
										
									</table>
								</div>
							</div>
							<div class="card-body row" style="padding-bottom:5px;font-weight:bold">
								<div class="col-md-12">
										
									<a href="<?= base_url('Logistik/Invoice')?>" class="btn btn-danger"><i class="fa fa-undo"></i> <b>Kembali</b></a>
									
									<button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpan()"><i class="fas fa-save"></i><b> Update</b></button>
									
									<button type="button" class="btn btn-danger" id="btn-print" onclick="Cetak()" ><i class="fas fa-print"></i> <b>Print</b></button>
									
								</div>
							</div>
							<br>
							<br>
							
						
					</div>
				</div>
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
		load_data();
		$('.select2').select2({
			containerCssClass: "wrap",
			placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
	});

	status = "insert";
	$(".tambah_data").click(function(event) 
	{
		kosong();
		
		$("#judul").html('<h3> Form Tambah Data</h3>');
		status = "insert";
		$("#status").val("insert");
		$("#id_produk0").val("").prop("", true).html(`<option value="">-- Pilih --</option>`);
	});

	function setProduk(cek,pelanggan,id) 
	{
		if(cek=='new'){
			clearRow();
		}
		if (status == 'insert' ){

			$("#id_produk"+id).val("").prop("", false);
			if (pelanggan!=''){
				option = "";
				$.ajax({
					type: 'POST',
					url: "<?= base_url(); ?>Logistik/load_produk",
					data: { idp: pelanggan, kd: '' },
					dataType: 'json',
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
							option = "<option>-- Pilih --</option>";
							$.each(data.data, function(index, val) {
							option += "<option value='"+val.id_produk+"'>"+val.nm_produk+"</option>";
							});
		
							$('#id_produk'+id).html(option);
							swal.close();
						}else{	
							option += "<option value=''></option>";
							$('#id_produk'+id).html(option);						
							$("#txt_detail_produk"+id).html("");	
							swal.close();
						}
					}
				});
			}
		}
		
	}

	function load_data() 
	{
		var id            = $('#id_header').val()
		var no_invoice    = $('#no_invoice').val()
		var type_po       = $('#type_po').val()

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

	function reloadTable() 
	{
		table = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}
	
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

		$.ajax({
			url        : '<?= base_url(); ?>Logistik/update_inv',
			type       : "POST",
			data       : $('#myForm').serialize(),
			dataType   : "JSON",
			success: function(data) {
				if(data.status=='1'){

					swal.close();
					swal({
						title               : "Data",
						html                : "Berhasil Disimpan",
						type                : "success"
						// confirmButtonText   : "OK"
					});
					location.href = "<?= base_url()?>Logistik/Invoice_edit?id="+data.id+"&no_inv="+no_inv_ok+"";
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

				} else if(data.status=='4'){

					swal.close();
					swal({
						title               : "CEK KEMBALI",
						html                : "<p><strong>Nomor Invoice</strong></p>"
											+"Tidak Boleh Lebih dari data master " 
											+data.id+"",
						type                : "error",
						confirmButtonText   : "OK"
					});
					return;

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
				// reloadTable();
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

		clearRow();
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

	function tampil_edit(id, act) 
	{
		// kosong('s');
		kosong();
		var cek = '<?= $this->session->userdata('level') ?>';
		$(".btn-tambah-produk").hide();
		$("#btn-print").show();
		
		$("#status").val("update");
		status    = 'update';

		
		if (act == 'detail') {
			$("#judul").html('<h3> Detail Data</h3>');
			$("#btn-simpan").hide();
		} else {
			$("#judul").html('<h3> Form Edit Data</h3>');
			$("#btn-simpan").show();
		} 

		status = "update";

		$.ajax({
				url: '<?= base_url('Logistik/get_edit'); ?>',
				type: 'POST',
				data: {
					id       : id,
					jenis    : "trs_po",
					field    : 'id'
				},
				dataType: "JSON",
			})
			.done(function(data) {
				
				btn_verif(data)
				no_po = data[0].no_po

				$("#no_po").val(data[0].no_po);
				$("#tgl_po").val(data[0].tgl_po);
				
				$('#id_pelanggan').val(data[0].id_pelanggan).trigger('change');

				kodepo    = (data[0].kode_po == '' ) ? '-' : data[0].kode_po ;
				
				$("#kode_po").val(kodepo);
				// $("#eta").val(eta); 
				
				$("#header_del").hide();

				if (cek !='PPIC')
				{
					$("#header_p11").show();
				}else{
					$("#header_p11").hide();
				}

				$.each(data, function(index, value) {
					eta       = (value.eta == '' ) ? '-' : value.eta ;
					
					$("#detail-hapus-0").hide();
					$("#detail-hapus-"+index).hide();
					$("#btn-hapus-"+index).hide();
					$("#eta_item"+index).val(eta); 
					
					if (cek !='PPIC')
					{
						$("#p11_det"+index).show();
						$("#id_pelanggan").prop("", false);
						$("#kode_po").prop("", false);
						$("#eta_item"+index).prop("", false); 

						$('#subs'+index).hide();
						$('#subs_i'+index).hide();
						$('#subs_hitung'+index).hide();
						$('#subs_hasil_hitung'+index).hide();
						
					}else{
						$("#p11_det"+index).hide();
						$("#id_pelanggan").prop("", true);
						$("#kode_po").prop("", true);
						$("#eta_item"+index).prop("", true); 

						$('#subs'+index).show();
						$('#subs_i'+index).show();
						$('#subs_hitung'+index).show();
						$('#subs_hasil_hitung'+index).show();
						
					}
					
					
					
					var opt_produk = $("<option selected></option>").val(value.id_produk).text(value.nm_produk);

					var opt_ppn = $("<option selected></option>").val(value.ppn).text(value.ppn);
					
					$('#id_produk'+index).append(opt_produk).trigger('change');
					$("#qty"+index).val(format_angka(value.qty));

					if(value.cek_rm==1)
					{
						$('#cek_rm'+index).prop('checked', true);
					}else{
						$('#cek_rm'+index).prop('checked', false);

					}

					$('#ppn'+index).append(opt_ppn).trigger('change');
					// $("#ppn"+index).val(value.ppn);
					$('#price_inc'+index).val(format_angka(value.price_inc));
					$('#price_exc'+index).val(format_angka(value.price_exc));
					$("#eta_ket"+index).val(value.eta_ket); 
					
					$("#p11"+index).val(value.p11);

					if (act == 'detail') {
						$("#id_pelanggan").prop("", true);
						$("#qty"+index).prop("", true);
						// $("#qty_dec"+index).prop("", true);
						$('#cek_rm'+index).prop("", true);
						$("#id_produk"+index).prop("", true);
						$("#ppn"+index).prop("", true);
						$("#price_inc"+index).prop("", true);
						$("#price_exc"+index).prop("", true);
						$("#eta_ket"+index).prop("", true);
					} else {
						$("#id_pelanggan").prop("", false);
						$("#qty"+index).prop("", false);
						// $("#qty_dec"+index).prop("", false);
						$('#cek_rm'+index).prop("", false);
						$("#id_produk"+index).prop("", false);
						$("#ppn"+index).prop("", false);
						$("#price_inc"+index).prop("", false);
						$("#price_exc"+index).prop("", false);
						$("#eta_ket"+index).prop("", false);
					}
					
					if (index != (data.length) - 1) {
						addRow();
					}
					// console.log(index, data.length);
				});
			})
	}

	function deleteData(id,no) 
	{
		// let cek = confirm("Apakah Anda Yakin?");
		swal({
			title: "PO",
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
				url: '<?= base_url(); ?>Logistik/hapus',
				data: ({
					id: id,
					jenis: 'trs_po',
					field: 'no_po'
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

	function load_sj() 
	{
		var tgl_sj            = $("#tgl_sj").val()
		var type_po           = $("#type_po").val()
		var id_pl_sementara   = $("#id_pl_sementara").val()
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
		var kpd                 = $('#id_pl option:selected').attr('data-nm');
		var id_perusahaan       = $('#id_pl option:selected').attr('data-id_perusahaan');
		var nm_perusahaan       = $('#id_pl option:selected').attr('data-nm_perusahaan');
		var alamat_perusahaan   = $('#id_pl option:selected').attr('data-alamat_perusahaan');
		$("#id_perusahaan").val(id_perusahaan)
		$("#kpd").val(kpd)
		$("#nm_perusahaan").val(nm_perusahaan)
		$("#alamat_perusahaan").val(alamat_perusahaan)


	}

	function noinv()
	{
		var type    = $('#type_po').val()
		var tgl_inv = $('#tgl_inv').val()
		var pajak   = $('#pajak').val()

		const myArray   = tgl_inv.split("-");
		let year        = myArray[0];
		let month       = myArray[1];
		let day         = myArray[2];

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
		
		if(tgl_inv)
		{
			$('#no_inv_tgl').val('/'+month+'/'+year);
		}
		
	}
	
	function no_inv2()
	{
		var type    = $('#type_po').val()

		$.ajax({
				type        : 'POST',
				url         : "<?= base_url(); ?>Logistik/load_no_inv",
				data        : { type },
				dataType    : 'json',
				success:function(val){			
						
						var qty_po = $("#no_inv").val(val)
					
				}
			});
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
			var qty    = $('#qty'+id).val().split('.').join('')
			var retur  = val.split('.').join('')
			var hasil  = qty - retur
		}

		$('#hasil'+id).val(format_angka(hasil));

	}
	
	function Cetak() 
	{
		no_invoice = $("#no_invoice").val();
		var url = "<?= base_url('Logistik/Cetak_Invoice'); ?>";
		window.open(url + '?no_invoice=' + no_invoice, '_blank');
	}

</script>
