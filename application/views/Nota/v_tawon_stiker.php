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
					 <!--  AA -->
					 <div class="col-md-12">								
						<br>			
						
						<!-- <div class="card-body row" style="padding-bottom:1px;font-weight:bold">
							<div class="col-md-2">JENIS</div>
							<div class="col-md-3">
								<select name="jns_data" id="jns_data" class="form-control" style="font-weight:bold" onchange="load_data()">
									<option value="box">BOX</option>
									<option value="lm">LAMINASI</option>
								</select>
							</div>
							<div class="col-md-6"></div>
						</div>
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
							<div class="col-md-2">BULAN</div>
							<div class="col-md-3">
								<input type="month" class="form-control " name="bulan" id="bulan" onchange="load_data()">
							</div>
							<div class="col-md-6"></div>
						</div> -->
						
						<div class="card-body row" style="padding-bottom:1px;font-weight:bold">
							<div class="col-md-6">
								
								<button onclick="cetak_nota_tawon(0)"  class="btn btn-primary">
								<i class="fa fa-print"></i> LAYAR</button>
								
								<button onclick="cetak_nota_tawon(1)"  class="btn btn-danger">
								<i class="fa fa-print"></i> PDF</button>

								<!-- <button onclick="cetak_nota_tawon(2)"  class="btn btn-success">
								<i class="fa fa-download"></i> EXCEL</button> -->
									<br>
									<br>
									
							</div>
							<div class="col-md-5"></div>
						</div>
						
						
						<br>
					</div>
					<!-- AA -->

					
					<!-- <div style="overflow:auto;white-space:nowrap;" >

						<div class="row-box">
							<table id="datatable" class="table table-bordered table-striped table-scrollable" width="100%">
								<thead class="color-tabel">
									<tr>
										<th style="text-align: center;">No </th>
										<th style="text-align: center;">No Stok </th>
										<th style="text-align: center;">Tgl Stok </th>
										<th style="text-align: center;">tgl J Tempo </th>
										<th style="text-align: center;">No Timbangan </th>
										<th style="text-align: center;">no Po Bhn </th>
										<th style="text-align: center;">ATTN</th>
										<th style="text-align: center;">Hrg Bahan </th>
										<th style="text-align: center;">Bahan Datang </th>
										<th style="text-align: center;">Total </th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div> -->
				</div>
			</div>
		</div>
		<!-- /.card -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script type="text/javascript">
	rowNum = 0;
	$(document).ready(function() {
		// load_data();
		// getMax();
		$('.select2').select2({
			containerCssClass: "wrap",
			placeholder: '--- Pilih ---',
			dropdownAutoWidth: true
		});
	});

	status = "insert";

	function cetak_nota_tawon(ctk)
	{		
		// var bulan       = $('#bulan').val()
		// var jns_data    = $('#jns_data').val()

		var url    = "<?php echo base_url('Nota/cetak_nota_tawon'); ?>";
		window.open(url+'?ctk='+ctk, '_blank');  
		// window.open(url+'?bulan='+bulan+'&ctk='+ctk+'&jns_data='+jns_data, '_blank');  
		 
	}
	
	function load_data() 
	{
		var bulan       = $('#bulan').val()
		var jns_data    = $('#jns_data').val()
		var table       = $('#datatable').DataTable();

		table.destroy();

		tabel = $('#datatable').DataTable({

			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?= base_url(); ?>Rekapan/load_data/beli_bhn',
				"type": "POST",
				"data" : ({
					bulan    : bulan,jns_data
				}),
				// data  : ({tanggal:tanggal,tanggal_akhir:tanggal_akhir,id_kategori:id_kategori1,id_sub_kategori:id_sub_kategori1}), 
			},
			"aLengthMenu": [
				[10, 15, 20, 25, -1],
				[10, 15, 20, 25, "Semua"] // change per page values here
			],		

			responsive: false,
			"pageLength": 100,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});

	}

	function reloadTable() 
	{
		var jns_data    = $('#jns_data').val()
		table           = $('#datatable').DataTable();
		tabel.ajax.reload(null, false);
	}
	
	var no_po = ''



</script>
