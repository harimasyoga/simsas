<?php
class M_logistik extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');
		$this->username = $this->session->userdata('username');
		$this->waktu    = date('Y-m-d H:i:s');
		$this->load->model('m_master');
	}

	function save_inv_bhn()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$tgl_inv       = $this->input->post('tgl_inv');
			$tanggal       = explode('-',$tgl_inv);
			$tahun         = $tanggal[0];
			$bulan         = $tanggal[1];
			
			$c_no_inv    = $this->m_fungsi->urut_transaksi('INV_BHN');
			$m_no_inv    = $c_no_inv.'/INV/BHN/'.$bulan.'/'.$tahun;

			$data_header = array(
				'no_inv_bhn'    => $m_no_inv,
				'tgl_inv_bhn'   => $this->input->post('tgl_inv'),
				'id_stok_d'   	=> $this->input->post('id_stok_d'),
				'no_stok'   	=> $this->input->post('no_stok'),
				'id_hub'        => $this->input->post('id_hub'),
				'ket'           => $this->input->post('ket'),
				'qty'           => str_replace('.','',$this->input->post('qty')), 
				'nominal'       => str_replace('.','',$this->input->post('nom')),
				'total_bayar'   => str_replace('.','',$this->input->post('total_bayar')),
				'acc_owner'     => 'N',
				
			);

			$result_header = $this->db->insert('invoice_bhn', $data_header);

			return $result_header;
			
		}else{
			
			$no_inv_bhn    = $this->input->post('no_inv_bhn');

			$data_header = array(
				'no_inv_bhn'    => $no_inv_bhn,
				'tgl_inv_bhn'   => $this->input->post('tgl_inv'),
				'id_stok_d'   	=> $this->input->post('id_stok_d'),
				'no_stok'   	=> $this->input->post('no_stok'),
				'id_hub'        => $this->input->post('id_hub'),
				'ket'           => $this->input->post('ket'),
				'qty'           => str_replace('.','',$this->input->post('qty')), 
				'nominal'       => str_replace('.','',$this->input->post('nom')),
				'total_bayar'   => str_replace('.','',$this->input->post('total_bayar')),
				'acc_owner'     => 'N',
			);

			$this->db->where('id_inv_bhn', $this->input->post('id_inv_bhn'));
			$result_header = $this->db->update('invoice_bhn', $data_header);
			return $result_header;
		}
		
	}

	function verif_inv_bhn()
	{
		$no_inv       = $this->input->post('no_inv');
		$acc          = $this->input->post('acc');
		$app          = "";
		
		$data_bhn   = $this->db->query("SELECT*from invoice_bhn a
		join m_hub b on a.id_hub=b.id_hub
		WHERE no_inv_bhn='$no_inv'
		order by tgl_inv_bhn desc, id_inv_bhn
		")->row();

		// KHUSUS ADMIN //
		if ( in_array($this->session->userdata('level'), ['Admin','Owner']) ) 
		{
			if($acc=='N')
			{
				$total_bayar = $data_bhn->qty*$data_bhn->nominal;

				add_jurnal($data_bhn->id_hub,$data_bhn->tgl_inv_bhn, $no_inv,'1.01.06','Persediaan Bahan Baku', $total_bayar, 0);

				add_jurnal($data_bhn->id_hub,$data_bhn->tgl_inv_bhn, $no_inv,'2.01.01','Hutang Usaha', 0,$total_bayar);
				
				$this->db->set("acc_owner", 'Y');
			}else{
				
				// delete jurnal pendapatan
				del_jurnal( $no_inv );

				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_inv_bhn",$no_inv);
			$valid = $this->db->update("invoice_bhn");

		} else {
			
			$valid = false;

		}

		return $valid;
	}
	
	function save_inv_tokped()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$tgl_inv       = $this->input->post('tgl_inv');
			$tanggal       = explode('-',$tgl_inv);
			$tahun         = $tanggal[0];
			$bulan         = $tanggal[1];
			$tgl           = $tanggal[2];
			
			$no_acak = "";
			for($i=0;$i<10;$i++)
			{
				$no_acak .= rand(0,9);
			}

			$no_tgl    = $tahun.$bulan.$tgl;
			$m_no_inv  = 'INV/'.$no_tgl.'/'.'MPL/'.$no_acak;

			$data_header = array(
				'no_inv_beli'   => $m_no_inv,
				'tgl_inv'       => $this->input->post('tgl_inv'),
				'nm_penjual'    => $this->input->post('nm_penjual'),
				'nm_pembeli'    => $this->input->post('nm_pembeli'),
				'jam_inv'       => $this->input->post('jam_inv'),
				'alamat_kirim1' => $this->input->post('alamat_kirim1'),
				'kurir'         => $this->input->post('kurir'),
				'alamat_kirim2' => $this->input->post('alamat_kirim2'),
				'ongkir'        => str_replace('.','',$this->input->post('ongkir')),
				'asuransi'      => str_replace('.','',$this->input->post('asuransi')),
				'jasa'          => str_replace('.','',$this->input->post('jasa')),
				'acc_owner'     => 'N',
			);

			$result_header = $this->db->insert('invoice_header_beli', $data_header);
	
			// rinci

			$rowloop     = $this->input->post('bucket');
			for($loop = 0; $loop <= $rowloop; $loop++)
			{
				$data_detail = array(				
					'no_inv_beli'       => $m_no_inv,
					'nm_produk'     	=> $this->input->post('nm_produk['.$loop.']'),
					'berat'     		=> str_replace('.','',$this->input->post('berat['.$loop.']')),
					'jumlah'     		=> str_replace('.','',$this->input->post('jumlah['.$loop.']')),
					'harga'     		=> str_replace('.','',$this->input->post('harga['.$loop.']')),
					'total_harga'     	=> str_replace('.','',$this->input->post('total_harga['.$loop.']')),
				);

				$result_detail = $this->db->insert('invoice_detail_beli', $data_detail);

			}		

			return $result_detail;
			
		}else{
			
			$no_inv_beli         = $this->input->post('no_inv_beli');
			$tgl_inv             = $this->input->post('tgl_inv');

			$no_inv_beli_edit    = explode('/',$no_inv_beli);
			$inv                 = $no_inv_beli_edit[0];
			$tgll                = $no_inv_beli_edit[1];
			$mpl                 = $no_inv_beli_edit[2];
			$no_acak             = $no_inv_beli_edit[3];

			$tanggal             = explode('-',$tgl_inv);
			$tahun               = $tanggal[0];
			$bulan               = $tanggal[1];
			$tgl                 = $tanggal[2];
			$no_tgl              = $tahun.$bulan.$tgl;
			
			if($tgll == $no_tgl)
			{
				$tgl_edit = $tgll;
			}else{
				$tgl_edit = $no_tgl;
			}
			
			$m_no_inv  = $inv.'/'.$tgl_edit.'/'.$mpl.'/'.$no_acak;

			$data_header = array(
				'no_inv_beli'   => $m_no_inv,
				'tgl_inv'       => $this->input->post('tgl_inv'),
				'nm_penjual'    => $this->input->post('nm_penjual'),
				'nm_pembeli'    => $this->input->post('nm_pembeli'),
				'jam_inv'       => $this->input->post('jam_inv'),
				'alamat_kirim1' => $this->input->post('alamat_kirim1'),
				'kurir'         => $this->input->post('kurir'),
				'alamat_kirim2' => $this->input->post('alamat_kirim2'),
				'ongkir'        => str_replace('.','',$this->input->post('ongkir')),
				'asuransi'      => str_replace('.','',$this->input->post('asuransi')),
				'jasa'          => str_replace('.','',$this->input->post('jasa')),
				'acc_owner'     => 'N',
			);

			$this->db->where('id_header_beli', $this->input->post('id_header_beli'));
			$result_header = $this->db->update('invoice_header_beli', $data_header);
	
			// delete rinci
			$del_detail = $this->db->query("DELETE FROM invoice_detail_beli where no_inv_beli='$no_inv_beli' ");

			// rinci
			if($del_detail)
			{
				$rowloop     = $this->input->post('bucket');
				for($loop = 0; $loop <= $rowloop; $loop++)
				{
					$data_detail = array(				
						'no_inv_beli'       => $m_no_inv,
						'nm_produk'     	=> $this->input->post('nm_produk['.$loop.']'),
						'berat'     		=> str_replace('.','',$this->input->post('berat['.$loop.']')),
						'jumlah'     		=> str_replace('.','',$this->input->post('jumlah['.$loop.']')),
						'harga'     		=> str_replace('.','',$this->input->post('harga['.$loop.']')),
						'total_harga'     	=> str_replace('.','',$this->input->post('total_harga['.$loop.']')),
					);
	
					$result_detail = $this->db->insert('invoice_detail_beli', $data_detail);
				}		
				return $result_detail;
			}
			
		}
		
	}
	
	function save_inv_umum()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$tgl_inv       = $this->input->post('tgl_inv');
			$tanggal       = explode('-',$tgl_inv);
			$tahun         = $tanggal[0];
			$bulan         = $tanggal[1];
			$tgl           = $tanggal[2];

			$blnRomami     = $this->m_fungsi->blnRomami($tgl_inv);
			$id_penjual    = $this->input->post('nm_penjual');
			
			$cek_penjual   = $this->db->query("SELECT*from m_penjual where id ='$id_penjual'")->row();
			$no_urut       = $cek_penjual->no_urut+1 ;
			$m_no_inv      = $no_urut.'/'.$cek_penjual->kode.'/'.$blnRomami.'/'.$tahun;

			$data_header = array(
				'no_inv_beli'   => $m_no_inv,
				'tgl_inv'       => $this->input->post('tgl_inv'),
				'nm_penjual'    => $this->input->post('nm_penjual'),
				'nm_pembeli'    => $this->input->post('nm_pembeli'),
				'alamat_kirim1' => $this->input->post('alamat_kirim1'),
				'pajak'         => str_replace('.','',$this->input->post('pajak')),
				'acc_owner'     => 'N',
			);

			$result_header   = $this->db->insert('invoice_header_umum', $data_header);
	
			$update_no_urut  = $this->db->query("UPDATE m_penjual set no_urut = $no_urut where id ='$id_penjual'");
			// rinci

			$rowloop     = $this->input->post('bucket');
			for($loop = 0; $loop <= $rowloop; $loop++)
			{
				$data_detail = array(				
					'no_inv_beli'       => $m_no_inv,
					'nm_produk'     	=> $this->input->post('nm_produk['.$loop.']'),
					'jumlah'     		=> str_replace('.','',$this->input->post('jumlah['.$loop.']')),
					'satuan'     		=> str_replace('.','',$this->input->post('satuan['.$loop.']')),
					'harga'     		=> str_replace('.','',$this->input->post('harga['.$loop.']')),
					'total_harga'     	=> str_replace('.','',$this->input->post('total_harga['.$loop.']')),
				);

				$result_detail = $this->db->insert('invoice_detail_umum', $data_detail);

			}		

			return $result_detail;
			
		}else{
			
			$no_inv_beli    = $this->input->post('no_inv_beli');

			$data_header = array(
				'no_inv_beli'   => $no_inv_beli,
				'tgl_inv'       => $this->input->post('tgl_inv'),
				'nm_penjual'    => $this->input->post('nm_penjual'),
				'nm_pembeli'    => $this->input->post('nm_pembeli'),
				'alamat_kirim1' => $this->input->post('alamat_kirim1'),
				'pajak'         => str_replace('.','',$this->input->post('pajak')),
				'acc_owner'     => 'N',
			);

			$this->db->where('id_header_beli', $this->input->post('id_header_beli'));
			$result_header = $this->db->update('invoice_header_umum', $data_header);
	
			// delete rinci
			$del_detail = $this->db->query("DELETE FROM invoice_detail_umum where no_inv_beli='$no_inv_beli' ");

			// rinci
			if($del_detail)
			{
				$rowloop     = $this->input->post('bucket');
				for($loop = 0; $loop <= $rowloop; $loop++)
				{
					$data_detail = array(				
						'no_inv_beli'       => $this->input->post('no_inv_beli'),
						'nm_produk'     	=> $this->input->post('nm_produk['.$loop.']'),
						'satuan'     		=> str_replace('.','',$this->input->post('satuan['.$loop.']')),
						'jumlah'     		=> str_replace('.','',$this->input->post('jumlah['.$loop.']')),
						'harga'     		=> str_replace('.','',$this->input->post('harga['.$loop.']')),
						'total_harga'     	=> str_replace('.','',$this->input->post('total_harga['.$loop.']')),
					);
	
					$result_detail = $this->db->insert('invoice_detail_umum', $data_detail);
				}		
				return $result_detail;
			}
			
		}
		
	}

	function batal_inv_beli()
	{
		$id       = $this->input->post('id');
		$app      = "";

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{

			$this->db->set("acc_admin", 'N');
			$this->db->set("acc_owner", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "karina") 
		{
			$this->db->set("acc_admin", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		} else {
	
			$this->db->set("acc_owner", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		}

		return $valid;
	}

	function verif_inv_beli()
	{
		$no_inv       = $this->input->post('no_inv');
		$acc          = $this->input->post('acc');
		$app          = "";
		
			$cek_detail   = $this->db->query("SELECT*FROM invoice_header_beli a
			join invoice_detail_beli b on a.no_inv_beli=b.no_inv_beli
			join m_hub c ON a.id_hub=c.id_hub
			join m_supp d ON a.id_supp=d.id_supp
			join 
			(SELECT*FROM(
						select kd_akun as kd,nm_akun as nm,jenis,dk from m_kode_akun
						union all
						select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk from m_kode_kelompok
						union all
						select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk from m_kode_jenis
						union all
						select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk from m_kode_rinci
						)b )e
			ON b.jns_beban=e.kd
			where b.no_inv_beli='$no_inv'
			")->result();

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{
			if($acc=='N')
			{				
				foreach ( $cek_detail as $row ) 
				{
					add_jurnal($row->id_hub,$row->tgl_inv_beli, $no_inv,$row->jns_beban,$row->nm, $row->nominal, 0);
					add_jurnal($row->id_hub,$row->tgl_inv_beli, $no_inv,'2.01.01','Hutang Usaha', 0,$row->nominal);
					
				}
				$this->db->set("acc_owner", 'Y');
			}else{
				
				foreach ( $cek_detail as $row ) 
				{
					// delete jurnal pendapatan
					del_jurnal( $no_inv );

				}
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_inv_beli",$no_inv);
			$valid = $this->db->update("invoice_header_beli");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "bumagda") 
		{
			if($acc=='N')
			{
				foreach ( $cek_detail as $row ) 
				{
					// jurnal
					add_jurnal($row->id_hub,$row->tgl_inv_beli, $no_inv,$row->jns_beban,$row->nm, $row->nominal, 0);
					add_jurnal($row->id_hub,$row->tgl_inv_beli, $no_inv,'2.01.01','Hutang Usaha', 0,$row->nominal);
				}

				$this->db->set("acc_owner", 'Y');
			}else{

				foreach ( $cek_detail as $row ) 
				{
					
					// delete jurnal
					del_jurnal( $no_inv );
						
				}
				
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_inv_beli",$no_inv);
			$valid = $this->db->update("invoice_header_beli");

		} else {
			
			$valid = false;

		}

		return $valid;
	}
	
	function save_invoice()
	{
		$cek_inv        = $this->input->post('cek_inv');
		$c_no_inv_tgl   = $this->input->post('no_inv_tgl');

		$type           = $this->input->post('type_po');
		$pajak          = $this->input->post('pajak');
		$tgl_inv        = $this->input->post('tgl_inv');
		$tanggal        = explode('-',$tgl_inv);
		$tahun          = $tanggal[0];

		($type=='roll')? $type_ok=$type : $type_ok='SHEET_BOX';
		
		($pajak=='nonppn')? $pajak_ok='non' : $pajak_ok='ppn';
		$c_no_inv_kd   = $this->input->post('no_inv_kd');

		if($cek_inv=='revisi')
		{
			$c_no_inv    = $this->input->post('no_inv');
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
		}else{
			$c_no_inv    = $this->m_fungsi->tampil_no_urut($type_ok.'_'.$pajak_ok.'_'.$tahun);
			$m_no_inv    = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;
		}

		$data_header = array(
			'no_invoice'         => $m_no_inv,
			'type'               => $this->input->post('type_po'),
			'cek_inv'    		 => $cek_inv,
			'tgl_invoice'        => $this->input->post('tgl_inv'),
			'tgl_sj'             => $this->input->post('tgl_sj'),
			'pajak'              => $this->input->post('pajak'),
			'inc_exc'            => $this->input->post('inc_exc'),
			'tgl_jatuh_tempo'    => $this->input->post('tgl_tempo'),
			'id_perusahaan'      => $this->input->post('id_perusahaan'),
			'kepada'             => $this->input->post('kpd'),
			'nm_perusahaan'      => $this->input->post('nm_perusahaan'),
			'alamat_perusahaan'  => $this->input->post('alamat_perusahaan'),
			'bank'  			 => $this->input->post('bank'),
			'acc_admin'          => 'Y',
		);
	
		$result_header = $this->db->insert('invoice_header', $data_header);

		$db2              = $this->load->database('database_simroll', TRUE);
		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');

		if ($type == 'roll')
		{
			$query = $db2->query("SELECT c.nm_perusahaan,a.id_pl,b.id,a.nm_ker,a.g_label,a.width,COUNT(a.roll) AS qty,SUM(weight)-SUM(seset) AS weight,b.no_po,b.no_po_sj,b.no_surat
			FROM m_timbangan a 
			INNER JOIN pl b ON a.id_pl = b.id 
			LEFT JOIN m_perusahaan c ON b.id_perusahaan=c.id
			WHERE b.no_pl_inv = '0' AND b.tgl='$tgl_sj' AND b.id_perusahaan='$id_perusahaan'
			GROUP BY b.no_po,a.nm_ker,a.g_label,a.width 
			ORDER BY a.g_label,b.no_surat,b.no_po,a.nm_ker DESC,a.g_label,a.width ")->result();

			$no = 1;
			foreach ( $query as $row ) 
			{

				$cek = $this->input->post('aksi['.$no.']');
				if($cek == 1)
				{
					$harga_ok    = $this->input->post('hrg['.$no.']');
					$harga_inc   = $this->input->post('inc['.$no.']');
					$harga_inc1  = str_replace('.','',$harga_inc);

					$hasil_ok    = $this->input->post('hasil['.$no.']');
					$id_pl_roll  = $this->input->post('id_pl_roll['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('nm_ker['.$no.']'),
						'g_label'      => $this->input->post('g_label['.$no.']'),
						'width'        => $this->input->post('width['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'include'      => str_replace(',','.',$harga_inc1),
						'weight'       => $this->input->post('weight['.$no.']'),
						'seset'        => $this->input->post('seset['.$no.']'),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$update_no_pl   = $db2->query("UPDATE pl set no_pl_inv = 1 where id ='$id_pl_roll'");

					$result_rinci   = $this->db->insert("invoice_detail", $data);

				}
				$no++;
			}
		}else{
			if ($tgl_sj >= '2024-07-01' )
			{
				if ($type == 'box')
				{				
					$where_po    = 'and d.kategori ="K_BOX"';
				}else{
					$where_po    = 'and d.kategori ="K_SHEET"';
				}
				
				$query = $this->db->query("SELECT b.id as id_pl, sum(a.qty_muat) as qty, 'pcs' as qty_ket, b.tgl, b.id_perusahaan, c.nm_pelanggan as nm_perusahaan, b.no_surat, b.no_po, b.no_kendaraan, d.nm_produk as item, 
				d.kualitas, d.ukuran as ukuran2,d.ukuran, d.flute, d.kategori, a.id_produk as id_produk_simcorr 
				FROM m_rencana_kirim a 
				JOIN pl_box b ON a.id_pl_box = b.id 
				JOIN m_pelanggan c ON a.id_pelanggan=c.id_pelanggan 
				JOIN m_produk d ON a.id_produk=d.id_produk 
				WHERE b.no_pl_inv = '0' AND b.tgl = '$tgl_sj' AND b.id_perusahaan='$id_perusahaan' $where_po 
				GROUP BY id_perusahaan, no_surat,no_po,a.id_produk
				ORDER BY b.tgl desc ")->result();

			}else{

				if ($type == 'box')
				{				
					$where_po    = 'and d.po ="box"';
				}else{
					$where_po    = 'and d.po is null';
				}

				$query = $db2->query("SELECT b.id as id_pl, a.qty, a.qty_ket, b.tgl, b.id_perusahaan, c.nm_perusahaan, b.no_surat, b.no_po, b.no_kendaraan, d.item, d.kualitas, d.ukuran2,d.ukuran, 
				d.flute, d.po, a.id_produk_simcorr
				FROM m_box a 
				JOIN pl_box b ON a.id_pl = b.id 
				LEFT JOIN m_perusahaan2 c ON b.id_perusahaan=c.id
				JOIN po_box_master d ON b.no_po=d.no_po and a.ukuran=d.ukuran
				WHERE b.no_pl_inv = '0' AND b.tgl = '$tgl_sj' AND b.id_perusahaan='$id_perusahaan' $where_po
				ORDER BY b.tgl desc ")->result();

			}
			
			$no = 1;
			foreach ( $query as $row ) 
			{
				$cek = $this->input->post('aksi['.$no.']');
				if($cek == 1)
				{
					$harga_ok            = $this->input->post('hrg['.$no.']');
					$harga_inc           = $this->input->post('inc['.$no.']');
					$harga_inc1          = str_replace('.','',$harga_inc);

					$hasil_ok            = $this->input->post('hasil['.$no.']');
					$id_pl_roll          = $this->input->post('id_pl_roll['.$no.']');
					$no_po               = $this->input->post('no_po['.$no.']');
					$id_produk_simcorr   = $this->input->post('id_produk_simcorr['.$no.']');
					$data = [
						'no_invoice'          => $m_no_inv,
						'type'                => $type,
						'no_surat'            => $this->input->post('no_surat['.$no.']'),
						'nm_ker'              => $this->input->post('item['.$no.']'),
						'id_produk_simcorr'   => $id_produk_simcorr,
						'g_label'             => $this->input->post('ukuran['.$no.']'),
						'kualitas'            => $this->input->post('kualitas['.$no.']'),
						'qty'                 => $this->input->post('qty['.$no.']'),
						'retur_qty'           => $this->input->post('retur_qty['.$no.']'),
						'id_pl'               => $id_pl_roll,
						'harga'               => str_replace('.','',$harga_ok),
						'include'             => str_replace(',','.',$harga_inc1),
						'hasil'               => str_replace('.','',$hasil_ok),
						'no_po'               => $this->input->post('no_po['.$no.']'),
					];

					if ($tgl_sj >= '2024-07-01' )
					{
						$update_no_pl   = $this->db->query("UPDATE pl_box set no_pl_inv = 1 where id ='$id_pl_roll'");
					}else{
						$update_no_pl   = $db2->query("UPDATE pl_box set no_pl_inv = 1 where id ='$id_pl_roll'");
					}
					

					$result_rinci   = $this->db->insert("invoice_detail", $data);

				}
				$no++;
			}
		}

		if($result_rinci){
			$query = $this->db->query("SELECT*FROM invoice_header where no_invoice ='$m_no_inv' ")->row();
			return $query->id;
		}else{
			return 0;

		}
			
	}
	
	function save_byr_invoice()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$data_header = array(
				'id_invoice_h'   => $this->input->post('id_invoice_h'),
				'id_perusahaan'  => $this->input->post('id_perusahaan'),
				'tgl_sj'         => $this->input->post('tgl_inv'),
				'no_inv'         => $this->input->post('no_inv'),
				'tgl_inv'        => $this->input->post('tgl_inv'),
				'alasan_retur'   => $this->input->post('alasan'),
				'total_inv'      => str_replace('.','',$this->input->post('total_inv')),
				'tgl_jt'         => $this->input->post('tgl_jt'),
				'tgl_bayar'      => $this->input->post('tgl_byr'),
				'jumlah_bayar'   => str_replace('.','',$this->input->post('jml_byr')),
				'status_jt'      => $this->input->post('status_jt'),
				'status_lunas'   => $this->input->post('sts_lunas'),
				'sales'          => $this->input->post('sales'),
				'TOP'            => $this->input->post('top'),
			);
		
			$result_header = $this->db->insert('trs_bayar_inv', $data_header);
			
		}else{

			$data_header = array(
				'id_invoice_h'   => $this->input->post('id_invoice_h'),
				'id_perusahaan'  => $this->input->post('id_perusahaan'),
				'tgl_sj'         => $this->input->post('tgl_inv'),
				'no_inv'         => $this->input->post('no_inv'),
				'tgl_inv'        => $this->input->post('tgl_inv'),
				'alasan_retur'   => $this->input->post('alasan'),
				'total_inv'      => str_replace('.','',$this->input->post('total_inv')),
				'tgl_jt'         => $this->input->post('tgl_jt'),
				'tgl_bayar'      => $this->input->post('tgl_byr'),
				'jumlah_bayar'   => str_replace('.','',$this->input->post('jml_byr')),
				'status_jt'      => $this->input->post('status_jt'),
				'status_lunas'   => $this->input->post('sts_lunas'),
				'sales'          => $this->input->post('sales'),
				'TOP'            => $this->input->post('top'),
			);
		
			$this->db->where('id_bayar_inv', $this->input->post('id_byr_inv'));
			$result_header = $this->db->update('trs_bayar_inv', $data_header);
			
		}
		return $result_header;
			
	}
	
	function save_byr_invoice_beli()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$data_header = array(
				'id_invoice_h'   => $this->input->post('id_header_beli'),
				'no_inv_beli'    => $this->input->post('no_inv_beli'),
				'tgl_inv'        => $this->input->post('tgl_inv'),
				'total_inv'      => str_replace('.','',$this->input->post('total_inv')),
				'tgl_bayar'      => $this->input->post('tgl_byr'),
				'jumlah_bayar'   => str_replace('.','',$this->input->post('jml_byr')),
			);
		
			$result_header = $this->db->insert('trs_bayar_inv_beli', $data_header);
			
		}else{

			$data_header = array(
				'id_invoice_h'   => $this->input->post('id_header_beli'),
				'no_inv_beli'    => $this->input->post('no_inv_beli'),
				'tgl_inv'        => $this->input->post('tgl_inv'),
				'total_inv'      => str_replace('.','',$this->input->post('total_inv')),
				'tgl_bayar'      => $this->input->post('tgl_byr'),
				'jumlah_bayar'   => str_replace('.','',$this->input->post('jml_byr')),
			);
		
			$this->db->where('id_bayar_inv', $this->input->post('id_byr_inv'));
			$result_header = $this->db->update('trs_bayar_inv_beli', $data_header);
			
		}
		return $result_header;
			
	}

	function addTimbangan()
	{
		$tgl = $_POST["tgl"];
		$urut = $_POST["urut"];
		$plat = $_POST["plat"];
		$supir = $_POST["supir"];
		$tb_truk = $_POST["tb_truk"];
		$timbangan = $_POST["timbangan"];

		if($supir == "" || $timbangan < 0 || $timbangan == 0 || $tb_truk == "" || $timbangan == ""){
			$data = false; $result = false; $msg = 'HARAP LENGKAPI DATA!';
		}else if($tb_truk == $timbangan){
			$data = false; $result = false; $msg = 'BERAT TRUK TIDAK BOLEH SAMA DENGAN BERAT BERSIH!';
		}else if($tb_truk < $timbangan){
			$data = false; $result = false; $msg = 'BERAT TRUK HARUS LEBIH BESAR DARI BERAT BERSIH!';
		}else{
			// KELUAR
			$now = date("Y-m-d");
			if($now == $tgl){
				$date_keluar = date("Y-m-d H:i:s");
			}else{
				$k_detik = strtotime($tgl) + rand(1, 60); // 1 menit
				$k_jam = $k_detik + 7200; // 2 jam
				$k_rand = $k_jam + rand(28800, 57600); // 8 pagi - 4 sore
				$date_keluar = date("Y-m-d H:i:s", $k_rand);
			}
			// DATE MASUK
			$detik = strtotime($date_keluar) - rand(1, 60); // 1 menit
			$jam = $detik - 3600; // 1 jam
			$rand = $jam - rand(60, 1800); // 1 menit - 30 menit
			$date_masuk = date("Y-m-d H:i:s", $rand);
			// CATATAN
			$getCatatan = $this->db->query("SELECT p.*,c.nm_pelanggan FROM pl_box p
			INNER JOIN m_pelanggan c ON p.id_perusahaan=c.id_pelanggan
			WHERE p.tgl='$tgl' AND p.no_pl_urut='$urut' AND p.no_kendaraan='$plat'
			GROUP BY p.id_perusahaan ORDER BY c.nm_pelanggan");
			$catatan = '';
			if($getCatatan->num_rows() == 1){
				$catatan .= $getCatatan->row()->nm_pelanggan;
			}else{
				$i = 0;
				foreach($getCatatan->result() as $c){
					$i++;
					$catatan .= $c->nm_pelanggan;
					if($getCatatan->num_rows() != $i){
						$catatan .= ' ';
					}
				}
			}
			// CEK DATA TIMBANGAN
			$qTimb = $this->db->query("SELECT*FROM m_jembatan_timbang WHERE urut_t='$urut' AND tgl_t='$tgl' GROUP BY urut_t,tgl_t");
			if($qTimb->num_rows() == 0){
				$no_timbangan = $this->m_fungsi->urut_transaksi('TIMBANGAN').'/TIMB'.'/'.date('Y');
			}else{
				$no_timbangan = $qTimb->row()->no_timbangan;
			}
			$berat_kotor = $tb_truk - $timbangan;
			// DATA
			$data = array(
				'no_timbangan' => $no_timbangan,
				'id_pelanggan' => null,
				'input_t' => 'CORR',
				'suplier' => 'PT. PRIMA PAPER INDONESIA',
				'alamat' => 'Timang Kulon, Wonokerto, Wonogiri',
				'no_polisi' => $plat,
				'date_masuk' => $date_masuk,
				'date_keluar' => $date_keluar,
				'nm_barang' => 'KARTON BOX',
				'berat_kotor' => $berat_kotor,
				'berat_truk' => $tb_truk,
				'berat_bersih' => $timbangan,
				'potongan' => 0,
				'catatan' => $catatan,
				'nm_penimbang' => 'Feri S',
				'nm_sopir' => $supir,
				'keterangan' => 'KIRIM',
				'permintaan' => 'KIRIMAN',
				'urut_t' => $urut,
				'tgl_t' => $tgl,
				'pilih_po' => 'TIDAK',
			);
			// INSERT - UPDATE
			if($qTimb->num_rows() == 0){
				$result = $this->db->insert("m_jembatan_timbang", $data);
				$msg = 'insert';
			}else{
				$this->db->where("urut_t", $urut);
				$this->db->where("tgl_t", $tgl);
				$result = $this->db->update("m_jembatan_timbang", $data);
				$msg = 'update';
			}
		}
		// RETURN
		return [
			'data' => $data,
			'result' => $result,
			'msg' => $msg,
		];
	}
	//

	function simpanTimbangan_2()
	{
		$thn = date('Y');
		$no_timbangan   = $this->m_fungsi->urut_transaksi('TIMBANGAN').'/TIMB'.'/'.$thn;
		// $rowloop        = $this->input->post('plh_input');
		// for($loop = 0; $loop <= $rowloop+1; $loop++)
		// {
		// 	$data_detail = array(
		// 		'no_timbangan'   => $no_timbangan,
		// 		'id_item'   => $this->input->post('item_po['.$loop.']'),
		// 		'berat_bahan'   => str_replace('.','',$this->input->post('qty['.$loop.']')),
		// 	);
		// 	$result_detail = $this->db->insert('m_jembatan_timbang_d', $data_detail);
		// }

		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$data_header = array(
				'input_t'     	 => $this->input->post('plh_input'),
				'no_timbangan'   => $no_timbangan,
				'id_pelanggan'   => $this->input->post('cust'),
				'keterangan'     => $this->input->post('jns'),
				'nm_penimbang'   => $this->input->post('penimbang'),
				'permintaan'     => $this->input->post('permintaan'),
				'suplier'        => $this->input->post('supplier'),
				'date_masuk'     => $this->input->post('masuk'),
				'alamat'         => $this->input->post('alamat'),
				'date_keluar'    => $this->input->post('keluar'),
				'no_polisi'      => $this->input->post('nopol'),
				'berat_kotor'    => str_replace('.','',$this->input->post('b_kotor')),
				'nm_barang'      => $this->input->post('barang'),
				'berat_truk'     => str_replace('.','',$this->input->post('berat_truk')),
				'nm_sopir'       => $this->input->post('sopir'),
				'berat_bersih'   => str_replace('.','',$this->input->post('berat_bersih')),
				'catatan'        => $this->input->post('cttn'),
				'potongan'       => str_replace('.','',$this->input->post('pot')),
				'urut_t'         => $this->input->post('urut_t'),
				'tgl_t'          => $this->input->post('tgl_t'),
				'pilih_po'       => $this->input->post('pilih_po'),
			);
		
			$result_header = $this->db->insert('m_jembatan_timbang', $data_header);	
				
		}else{

			$data_header = array(
				'input_t'     	 => $this->input->post('plh_input'),
				'no_timbangan'   => $this->input->post('no_timbangan'),
				'id_pelanggan'   => $this->input->post('cust'),
				'keterangan'     => $this->input->post('jns'),
				'nm_penimbang'   => $this->input->post('penimbang'),
				'permintaan'     => $this->input->post('permintaan'),
				'suplier'        => $this->input->post('supplier'),
				'date_masuk'     => $this->input->post('masuk'),
				'alamat'         => $this->input->post('alamat'),
				'date_keluar'    => $this->input->post('keluar'),
				'no_polisi'      => $this->input->post('nopol'),
				'berat_kotor'    => str_replace('.','',$this->input->post('b_kotor')),
				'nm_barang'      => $this->input->post('barang'),
				'berat_truk'     => str_replace('.','',$this->input->post('berat_truk')),
				'nm_sopir'       => $this->input->post('sopir'),
				'berat_bersih'   => str_replace('.','',$this->input->post('berat_bersih')),
				'catatan'        => $this->input->post('cttn'),
				'potongan'       => str_replace('.','',$this->input->post('pot')),
				'urut_t'         => $this->input->post('urut_t'),
				'tgl_t'          => $this->input->post('tgl_t'),
				'pilih_po'       => $this->input->post('pilih_po'),
			);
		
			
			$this->db->where('id_timbangan', $this->input->post('id_timbangan'));
			$result_header = $this->db->update('m_jembatan_timbang', $data_header);		
			
		}
		return $result_header;
	}

	function simpanTimbangan()
	{
		if($_POST["plh_input"] == "" || $_POST["permintaan"] == "" || $_POST["supplier"] == "" || $_POST["alamat"] == "" || $_POST["nopol"] == "" || $_POST["tgl_masuk"] == "" || $_POST["tgl_keluar"] == "" || $_POST["nm_barang"] == "" || $_POST["bb_kotor"] == "" || $_POST["bb_truk"] == "" || $_POST["bb_bersih"] == "" || $_POST["potongan"] == "" || $_POST["catatan"] == "" || $_POST["nm_penimbang"] == "" || $_POST["nm_supir"] == "" || $_POST["keterangan"] == ""){
			$result = false;
			$msg = 'HARAP LENGKAPI FORM!';
		}else{
			$data = [
				'input_t' => $_POST["plh_input"],
				'permintaan' => $_POST["permintaan"],
				'suplier' => $_POST["supplier"],
				'alamat' => $_POST["alamat"],
				'no_polisi' => $_POST["nopol"],
				'date_masuk' => $_POST["tgl_masuk"],
				'date_keluar' => $_POST["tgl_keluar"],
				'nm_barang' => $_POST["nm_barang"],
				'berat_kotor' => $_POST["bb_kotor"],
				'berat_truk' => $_POST["bb_truk"],
				'berat_bersih' => $_POST["bb_bersih"],
				'potongan' => $_POST["potongan"],
				'catatan' => $_POST["catatan"],
				'nm_penimbang' => $_POST["nm_penimbang"],
				'nm_sopir' => $_POST["nm_supir"],
				'keterangan' => $_POST["keterangan"],
				'urut_t' => $_POST["urut"],
				'tgl_t' => $_POST["tgl"],
			];
			if($_POST["opsiInput"] == 'insert'){
				$result = $this->db->insert('m_jembatan_timbang', $data);
				$msg = 'BERHASIL TAMBAH DATA!';
			}else{
				$this->db->where('id_timbangan', $_POST["id_timbangan"]);
				$result = $this->db->update('m_jembatan_timbang', $data);
				$msg = 'BERHASIL EDIT DATA!';
			}
		}
		return [
			'data' => $result,
			'msg' => $msg,
		];
	}

	function deleteTimbangan()
	{
		$this->db->where('id_timbangan', $_POST["id_timbangan"]);
		$data = $this->db->delete('m_jembatan_timbang');
		return [
			'data' => $data,
		];
	}
	//

	function update_invoice()
	{
		$id_inv         = $this->input->post('id_inv');
		$cek_inv        = $this->input->post('cek_inv2');
		$c_no_inv_kd    = $this->input->post('no_inv_kd');
		$c_no_inv       = $this->input->post('no_inv');
		$c_no_inv_tgl   = $this->input->post('no_inv_tgl');

		$type           = $this->input->post('type_po2');
		$pajak          = $this->input->post('pajak2');
		$no_inv_old     = $this->input->post('no_inv_old');

		$m_no_inv       = $c_no_inv_kd.''.$c_no_inv.''.$c_no_inv_tgl;

		$data_header = array(
			'no_invoice'         => $m_no_inv,
			'type'               => $type,
			'cek_inv'    		 => $cek_inv,
			'tgl_invoice'        => $this->input->post('tgl_inv'),
			'tgl_sj'             => $this->input->post('tgl_sj'),
			'pajak'              => $this->input->post('pajak2'),
			'inc_exc'            => $this->input->post('inc_exc'),
			'tgl_jatuh_tempo'    => $this->input->post('tgl_tempo'),
			'id_perusahaan'      => $this->input->post('id_perusahaan'),
			'kepada'             => $this->input->post('kpd'),
			'nm_perusahaan'      => $this->input->post('nm_perusahaan'),
			'alamat_perusahaan'  => $this->input->post('alamat_perusahaan'),
			'bank'  			 => $this->input->post('bank'),
			'acc_owner' 		 => 'N',
			
			// 'status'             => 'Open',
		);

		$result_header = $this->db->update("invoice_header", $data_header,
			array(
				'id' => $id_inv
			)
		);

		$cek_detail   = $this->db->query("SELECT*FROM invoice_header a
		join invoice_detail b on a.no_invoice=b.no_invoice
		where b.no_invoice='$m_no_inv' ")->result();
		foreach ( $cek_detail as $row ) 
		{
			if($row->type=='box' || $row->type=='sheet' )
			{
				// delete stok berjalan HUB
				$cek_po = $this->db->query("SELECT * FROM trs_po a 
				join trs_po_detail b on a.kode_po=b.kode_po 
				join m_produk c on b.id_produk=c.id_produk
				where b.kode_po in ('$row->no_po') and b.id_produk='$row->id_produk_simcorr'")->row();
				
				// delete jurnal
				del_jurnal( $m_no_inv );

				$del_stok    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$m_no_inv' and id_hub='$cek_po->id_hub' and id_produk='$row->id_produk_simcorr' ");
				
			}
		}

		$tgl_sj           = $this->input->post('tgl_sj');
		$id_perusahaan    = $this->input->post('id_perusahaan');

		$query = $this->db->query("SELECT *FROM invoice_detail where no_invoice='$no_inv_old' ")->result();

		if ($type == 'roll')
		{
			$no = 1;
			foreach ( $query as $row ) 
			{

					$harga_ok        = $this->input->post('hrg['.$no.']');
					$hasil_ok        = $this->input->post('hasil['.$no.']');
					$harga_inc       = $this->input->post('inc['.$no.']');
					$harga_inc1      = str_replace('.','',$harga_inc);

					$seset_ok        = $this->input->post('seset['.$no.']');
					$id_pl_roll      = $this->input->post('id_pl_roll['.$no.']');
					$id_inv_detail   = $this->input->post('id_inv_detail['.$no.']');
					$data = [					
						'no_invoice'   => $m_no_inv,
						'type'         => $type,
						'no_surat'     => $this->input->post('no_surat['.$no.']'),
						'nm_ker'       => $this->input->post('nm_ker['.$no.']'),
						'g_label'      => $this->input->post('g_label['.$no.']'),
						'width'        => $this->input->post('width['.$no.']'),
						'qty'          => $this->input->post('qty['.$no.']'),
						'retur_qty'    => $this->input->post('retur_qty['.$no.']'),
						'id_pl'        => $id_pl_roll,
						'harga'        => str_replace('.','',$harga_ok),
						'include'      => str_replace(',','.',$harga_inc1),
						'weight'       => $this->input->post('weight['.$no.']'),
						'seset'        => str_replace('.','',$seset_ok),
						'hasil'        => str_replace('.','',$hasil_ok),
						'no_po'        => $this->input->post('no_po['.$no.']'),
					];

					$result_rinci = $this->db->update("invoice_detail", $data,
						array(
							'id' => $id_inv_detail
						)
					);

				$no++;
			}
		}else{
			
			$no = 1;
			foreach ( $query as $row ) 
			{
				$harga_ok             = $this->input->post('hrg['.$no.']');
				$hasil_ok             = $this->input->post('hasil['.$no.']');
				
				$harga_inc            = $this->input->post('inc['.$no.']');
				$harga_inc1           = str_replace('.','',$harga_inc);

				$retur_qty_ok         = $this->input->post('retur_qty['.$no.']');
				$id_pl_roll           = $this->input->post('id_pl_roll['.$no.']');
				$id_inv_detail        = $this->input->post('id_inv_detail['.$no.']');
				$no_po                = $this->input->post('no_po['.$no.']');
				$id_produk_simcorr    = $this->input->post('id_produk_simcorr['.$no.']');

				$data = [					
					'no_invoice'           => $m_no_inv,
					'type'                 => $type,
					'no_surat'             => $this->input->post('no_surat['.$no.']'),
					'nm_ker'               => $this->input->post('item['.$no.']'),
					'id_produk_simcorr'    => $id_produk_simcorr,
					'g_label'              => $this->input->post('ukuran['.$no.']'),
					'kualitas'             => $this->input->post('kualitas['.$no.']'),
					'qty'                  => $this->input->post('qty['.$no.']'),
					'retur_qty'            => str_replace('.','',$retur_qty_ok),
					'id_pl'                => $id_pl_roll,
					'harga'                => str_replace('.','',$harga_ok),
					'include'              => str_replace(',','.',$harga_inc1),
					'hasil'                => str_replace('.','',$hasil_ok),
					'no_po'                => $no_po,
				];

				$result_rinci = $this->db->update("invoice_detail", $data,
					array(
						'id' => $id_inv_detail
					)
				);

				// HAPUS STOK
				$cek_po = $this->db->query("SELECT * FROM trs_po a 
				join trs_po_detail b on a.kode_po=b.kode_po 
				join m_produk c on b.id_produk=c.id_produk
				where b.kode_po in ('$no_po') and b.id_produk='$id_produk_simcorr'")->row();
				
				$del_stok    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$m_no_inv' and id_hub='$cek_po->id_hub' and id_produk='$id_produk_simcorr' ");
				$no++;
			}
		}

		if($result_rinci){
			$query = $this->db->query("SELECT*FROM invoice_header where no_invoice ='$m_no_inv' ")->row();
			return $query->id;
		}else{
			return 0;

		}
	}

	function verif_inv()
	{ //
		$no_inv       = $this->input->post('no_inv');
		$acc          = $this->input->post('acc');
		$app          = "";
		
		$cek_detail   = $this->db->query("SELECT*,b.no_po as no_po FROM invoice_header a
		join invoice_detail b on a.no_invoice=b.no_invoice
		join trs_po c on b.no_po=c.kode_po
		join m_hub d on c.id_hub=d.id_hub
		where b.no_invoice='$no_inv' ")->result();

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{
			if($acc=='N')
			{				
				foreach ( $cek_detail as $row ) 
				{
					if($row->type=='box' || $row->type=='sheet' )
					{
						// input stok berjalan HUB
						$cek_po = $this->db->query("SELECT * FROM trs_po a 
						join trs_po_detail b on a.kode_po=b.kode_po 
						join m_produk c on b.id_produk=c.id_produk
						where b.kode_po in ('$row->no_po') and b.id_produk='$row->id_produk_simcorr'")->row();

						// pendapatan tanpa di kurangi retur
						$pendapatan       = ($row->harga*$row->qty);
						$pajak_pendapatan = ($row->harga*$row->qty)*0.5/100;
						
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.03','Pendapatan', $pendapatan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'4.01','Pendapatan', 0,$pendapatan);
						// pajak pendapatan
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'6.37','Pajak Pendapatan', $pajak_pendapatan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'2.01.04','Pajak Pendapatan', 0,$pajak_pendapatan);
						
						
						// pembelian bahan baku		
						$harga_bahan        = 2300;
						$ton_tanpa_retur    = ($row->hasil * $cek_po->berat_bersih);
						$bhn_bk_tanpa_retur = ($ton_tanpa_retur / 0.7);
						$nominal_bahan      = $bhn_bk_tanpa_retur*$harga_bahan;

						// $cek_po = $this->db->query(" hrd : $row->harga,<br> bb : $cek_po->berat_bersih <br> bhn bk  : $bhn_bk_tanpa_retur <br> $nominal_bahan x x")->row();

						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Penggunaan Bahan Baku',$nominal_bahan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.06','Penggunaan Bahan Baku',0, $nominal_bahan);

						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'5.01','Pembelian Bahan Baku', $nominal_bahan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Pembelian Bahan Baku', 0,$nominal_bahan);
						
						
						
						if($row->retur_qty > 0)
						{
							// retur pendapatan
							// $retur            = ($row->harga*$row->retur_qty);
							// $pajak_retur      = ($row->harga*$row->retur_qty)*0.5/100;
							
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'4.03','Retur Pendapatan', $retur, 0);
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.03','Retur Pendapatan', 0,$retur);
							// // pajak retur
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'2.01.04','Pajak Retur Pendapatan', $pajak_retur, 0);
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'6.37','Pajak Retur Pendapatan', 0,$pajak_retur);

							// // retur
							// $nominal_retur_bahan = ($row->retur_qty*$harga_bahan);

							// // retur jadi bahan baku
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'5.01','Retur Bahan Baku', $nominal_retur_bahan, 0);
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Retur Bahan Baku', 0,$nominal_retur_bahan);
						}
						
						// stok bahan setelah di kurangi retur
						$ton            = ($row->hasil * $cek_po->berat_bersih);
						$bhn_bk         = ($ton / 0.7);

						stok_bahanbaku($no_inv, $cek_po->id_hub, $row->tgl_invoice, 'HUB', 0, $bhn_bk, 'KELUAR DENGAN INVs', 'KELUAR', $row->id_produk_simcorr);
						
						
					}
				}
				$this->db->set("acc_admin", 'Y');
				$this->db->set("acc_owner", 'Y');
			}else{
				
				foreach ( $cek_detail as $row ) 
				{
					if($row->type=='box' || $row->type=='sheet' )
					{
						// input stok berjalan HUB
						$cek_po = $this->db->query("SELECT * FROM trs_po a 
						join trs_po_detail b on a.kode_po=b.kode_po 
						join m_produk c on b.id_produk=c.id_produk
						where b.kode_po in ('$row->no_po') and b.id_produk='$row->id_produk_simcorr'")->row();
						
						// delete jurnal pendapatan
						del_jurnal( $no_inv );

						$del_stok    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$no_inv' and id_hub='$cek_po->id_hub' and id_produk='$row->id_produk_simcorr' ");
						
					}
				}
				$this->db->set("acc_admin", 'Y');
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_invoice",$no_inv);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "karina") 
		{
			if($acc=='N')
			{
				$this->db->set("acc_admin", 'Y');
			}else{
				$this->db->set("acc_admin", 'N');
			}
			
			$this->db->where("no_invoice",$no_inv);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "bumagda") 
		{
			if($acc=='N')
			{
				foreach ( $cek_detail as $row ) 
				{
					if($row->type=='box' || $row->type=='sheet' )
					{
						// input stok berjalan HUB
						$cek_po = $this->db->query("SELECT * FROM trs_po a 
						join trs_po_detail b on a.kode_po=b.kode_po 
						join m_produk c on b.id_produk=c.id_produk
						where b.kode_po in ('$row->no_po') and b.id_produk='$row->id_produk_simcorr'")->row();

						// pendapatan tanpa di kurangi retur
						$pendapatan       = ($row->harga*$row->qty);
						$pajak_pendapatan = ($row->harga*$row->qty)*0.5/100;
						
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.03','Pendapatan', $pendapatan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'4.01','Pendapatan', 0,$pendapatan);
						// pajak pendapatan
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'6.37','Pajak Pendapatan', $pajak_pendapatan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'2.01.04','Pajak Pendapatan', 0,$pajak_pendapatan);
						
						
						// pembelian bahan baku		
						$harga_bahan        = 2300;
						$ton_tanpa_retur    = ($row->hasil * $cek_po->berat_bersih);
						$bhn_bk_tanpa_retur = ($ton_tanpa_retur / 0.7);
						$nominal_bahan      = $bhn_bk_tanpa_retur*$harga_bahan;

						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Penggunaan Bahan Baku',$nominal_bahan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.06','Penggunaan Bahan Baku',0, $nominal_bahan);

						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'5.01','Pembelian Bahan Baku', $nominal_bahan, 0);
						add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Pembelian Bahan Baku', 0,$nominal_bahan);

						if($row->retur_qty > 0)
						{
							// // retur pendapatan
							// $retur            = ($row->harga*$row->retur_qty);
							// $pajak_retur      = ($row->harga*$row->retur_qty)*0.5/100;
							
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'4.03','Retur Pendapatan', $retur, 0);
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.03','Retur Pendapatan', 0,$retur);
							// // pajak retur
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'2.01.04','Pajak Retur Pendapatan', $pajak_retur, 0);
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'6.37','Pajak Retur Pendapatan', 0,$pajak_retur);

							// // retur
							// $nominal_retur_bahan = ($row->retur_qty*$harga_bahan);

							// // retur jadi bahan baku
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'5.01','Retur Bahan Baku', $nominal_retur_bahan, 0);
							// add_jurnal($row->id_hub,$row->tgl_invoice, $no_inv,'1.01.05','Retur Bahan Baku', 0,$nominal_retur_bahan);
						}
						
						// stok bahan setelah di kurangi retur
						$ton            = ($row->hasil * $cek_po->berat_bersih);
						$bhn_bk         = ($ton / 0.7);

						stok_bahanbaku($no_inv, $cek_po->id_hub, $row->tgl_invoice, 'HUB', 0, $bhn_bk, 'KELUAR DENGAN INV', 'KELUAR', $row->id_produk_simcorr);
						
					}
				}

				$this->db->set("acc_owner", 'Y');
			}else{

				foreach ( $cek_detail as $row ) 
				{
					if($row->type=='box' || $row->type=='sheet' )
					{
						// input stok berjalan HUB
						$cek_po = $this->db->query("SELECT * FROM trs_po a 
						join trs_po_detail b on a.kode_po=b.kode_po 
						join m_produk c on b.id_produk=c.id_produk
						where b.kode_po in ('$row->no_po') and b.id_produk='$row->id_produk_simcorr'")->row();
						
						// delete jurnal
						del_jurnal( $no_inv );

						$del_stok    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$no_inv' and id_hub='$cek_po->id_hub' and id_produk='$row->id_produk_simcorr' ");
						
					}
				}
				
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("no_invoice",$no_inv);
			$valid = $this->db->update("invoice_header");

		} else {
			
			$valid = false;

		}

		return $valid;
	}
	
	function verif_byr_inv()
	{
		$id   = $this->input->post('id');
		$acc  = $this->input->post('acc');
		$app  = "";
		
		$cek_detail   = $this->db->query(" SELECT *,a.id_bayar_inv as id_ok,a.acc_owner 
		FROM trs_bayar_inv a 
		join invoice_header b on a.no_inv=b.no_invoice 
		where id_bayar_inv='$id' 
		ORDER BY id_bayar_inv")->result();

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{
			if($acc=='N')
			{				
				foreach ( $cek_detail as $row ) 
				{
					// input stok berjalan HUB
					$cek_po = $this->db->query("SELECT *, (select id_hub from trs_po b where a.no_po=b.kode_po)id_hub from invoice_detail a where no_invoice='$row->no_inv'")->row();

					// pendapatan tanpa di kurangi retur						
					add_jurnal($cek_po->id_hub,$row->tgl_bayar, $id.'_'.$row->no_inv,'1.01.02','Pembayaran Penjualan', $row->jumlah_bayar, 0);
					add_jurnal($cek_po->id_hub,$row->tgl_bayar, $id.'_'.$row->no_inv,'1.01.03','Pembayaran Penjualan', 0,$row->jumlah_bayar);
				}
				$this->db->set("acc_owner", 'Y');
			}else{
				
				foreach ( $cek_detail as $row ) 
				{
						// delete jurnal pendapatan
						del_jurnal( $id.'_'.$row->no_inv );
						
				}
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("id_bayar_inv",$id);
			$valid = $this->db->update("trs_bayar_inv");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "karina") 
		{
			
		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "bumagda") 
		{
			if($acc=='N')
			{
				foreach ( $cek_detail as $row ) 
				{
					// input stok berjalan HUB
					$cek_po = $this->db->query("SELECT *, (select id_hub from trs_po b where a.no_po=b.kode_po)id_hub from invoice_detail a where no_invoice='$row->no_inv'")->row();

					// pendapatan tanpa di kurangi retur						
					add_jurnal($cek_po->id_hub,$row->tgl_bayar, $row->no_inv,'1.01.02','Pembayaran Penjualan', $row->jumlah_bayar, 0);
					add_jurnal($cek_po->id_hub,$row->tgl_bayar, $row->no_inv,'1.01.03','Pembayaran Penjualan', 0,$row->jumlah_bayar);
				}

				$this->db->set("acc_owner", 'Y');
			}else{

				foreach ( $cek_detail as $row ) 
				{
					
					// delete jurnal pendapatan
					del_jurnal( $id.'_'.$row->no_inv );
				}
				
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("id_bayar_inv",$id);
			$valid = $this->db->update("trs_bayar_inv");

		} else {
			
			$valid = false;

		}

		return $valid;
	}	
	
	function verif_byr_inv_beli()
	{
		
		$id   = $this->input->post('id');
		$acc  = $this->input->post('acc');
		$app  = "";
		
		$cek_detail   = $this->db->query(" SELECT *,IFNULL(
			(select sum(jumlah_bayar) from trs_bayar_inv_beli t
						where t.no_inv_beli=a.no_inv_beli
						group by no_inv_beli),0) jum_bayar,
						
						a.id_bayar_inv as id_ok,a.acc_owner 
				FROM trs_bayar_inv_beli a 
				join invoice_header_beli b on a.no_inv_beli=b.no_inv_beli 
				join m_hub c on b.id_hub=c.id_hub
				join m_supp d on b.id_supp=d.id_supp
				where id_bayar_inv='$id'
				ORDER BY id_bayar_inv")->result();

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{
			if($acc=='N')
			{				
				foreach ( $cek_detail as $row ) 
				{
						// pendapatan tanpa di kurangi
						add_jurnal($row->id_hub,$row->tgl_bayar, $id.'_'.$row->no_inv_beli,'5.04','Pembayaran Maklon', $row->jumlah_bayar, 0);
						add_jurnal($row->id_hub,$row->tgl_bayar, $id.'_'.$row->no_inv_beli,'2.01.01','Pembayaran Maklon', 0,$row->jumlah_bayar);
						add_jurnal($row->id_hub,$row->tgl_bayar, $id.'_'.$row->no_inv_beli,'6.37','Pembayaran Maklon', $row->jumlah_bayar, 0);
						add_jurnal($row->id_hub,$row->tgl_bayar, $id.'_'.$row->no_inv_beli,'2.01.03','Pembayaran Maklon', 0,$row->jumlah_bayar);
				}
				$this->db->set("acc_owner", 'Y');
			}else{
				
				foreach ( $cek_detail as $row ) 
				{
						// delete jurnal pendapatan
						del_jurnal( $id.'_'.$row->no_inv_beli );
						
				}
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("id_bayar_inv",$id);
			$valid = $this->db->update("trs_bayar_inv_beli");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "karina") 
		{
			
		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "bumagda") 
		{
			if($acc=='N')
			{
				foreach ( $cek_detail as $row ) 
				{
					add_jurnal($row->id_hub,$row->tgl_bayar, $id.'_'.$row->no_inv_beli,'5.04','Pembayaran Maklon', $row->jumlah_bayar, 0);
					add_jurnal($row->id_hub,$row->tgl_bayar, $id.'_'.$row->no_inv_beli,'2.01.01','Pembayaran Maklon', 0,$row->jumlah_bayar);
					add_jurnal($row->id_hub,$row->tgl_bayar, $id.'_'.$row->no_inv_beli,'6.37','Pembayaran Maklon', $row->jumlah_bayar, 0);
					add_jurnal($row->id_hub,$row->tgl_bayar, $id.'_'.$row->no_inv_beli,'2.01.03','Pembayaran Maklon', 0,$row->jumlah_bayar);
				}

				$this->db->set("acc_owner", 'Y');
			}else{

				foreach ( $cek_detail as $row ) 
				{
					
					// delete jurnal pendapatan
					del_jurnal( $id.'_'.$row->no_inv_beli );
				}
				
				$this->db->set("acc_owner", 'N');
			}
			
			$this->db->where("id_bayar_inv",$id);
			$valid = $this->db->update("trs_bayar_inv_beli");

		} else {
			
			$valid = false;

		}

		return $valid;
	
	}	

	function batal_inv()
	{
		$id       = $this->input->post('id');
		$app      = "";

		// KHUSUS ADMIN //
		if ($this->session->userdata('level') == "Admin") 
		{

			$this->db->set("acc_admin", 'N');
			$this->db->set("acc_owner", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		} else if ($this->session->userdata('level') == "Keuangan1" && $this->session->userdata('username') == "karina") 
		{
			$this->db->set("acc_admin", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		} else {
	
			$this->db->set("acc_owner", 'N');
			$this->db->where("no_invoice",$id);
			$valid = $this->db->update("invoice_header");

		}

		return $valid;
	}

	function save_stok_bb()
	{
		$sts_input    = $this->input->post('sts_input');
		$thn          = date('Y');

		if($sts_input=='edit')
		{
			$no_stokbb   = $this->input->post('no_stok');
			$rowloop     = $this->input->post('bucket');

			$del_detail  = $this->db->query("DELETE FROM trs_d_stok_bb WHERE no_stok='$no_stokbb' ");

			// delete jurnal & invoice
			$cek_inv = $this->db->query("SELECT*from invoice_bhn where no_stok='$no_stokbb' and no_inv_bhn in (select no_transaksi from jurnal_d)");
			if($cek_inv->num_rows() >0 )
			{
				foreach ($cek_inv->result() as $row_cek)
				{
					del_jurnal( $row_cek->no_inv_bhn );	

					$result = $this->m_master->query("DELETE FROM invoice_bhn WHERE no_stok = '$no_stokbb' and no_inv_bhn='$row_cek->no_inv_bhn' ");
				}
				
			}else{
				$result = $this->m_master->query("DELETE FROM invoice_bhn WHERE no_stok = '$no_stokbb' ");
			}

			if($del_detail)
			{
				for($loop = 0; $loop <= $rowloop; $loop++)
				{
					// pecah stok
					$data_detail = array(				
						'no_stok'       => $no_stokbb,
						'id_hub'        => $this->input->post('id_hub['.$loop.']'),
						'id_po_bhn'     => $this->input->post('id_po_bhn['.$loop.']'),
						'no_po_bhn'     => $this->input->post('no_po['.$loop.']'),
						'tonase_po'     => str_replace('.','',$this->input->post('ton['.$loop.']')),
						'datang_bhn_bk' => str_replace('.','',$this->input->post('datang['.$loop.']')),
					);
					$result_detail = $this->db->insert('trs_d_stok_bb', $data_detail);


					$id_hub_       = $this->input->post('id_hub['.$loop.']');
					$del_detail    = $this->db->query("DELETE FROM trs_stok_bahanbaku WHERE no_transaksi='$no_stokbb' and id_hub='$id_hub_' ");

					stok_bahanbaku($no_stokbb, $this->input->post('id_hub['.$loop.']'), $this->input->post('tgl_stok'), 'HUB', str_replace('.','',$this->input->post('datang['.$loop.']')), 0, 'MASUK DENGAN PO', 'MASUK');

				}

			}			

			$tonase_ppi = str_replace('.','',$this->input->post('tonase_ppi')) ;

			if($result_detail)
			{
				$data_header = array(
					'no_stok'         => $no_stokbb,
					'tgl_stok'        => $this->input->post('tgl_stok'),
					'id_timbangan'    => $this->input->post('id_timb'),
					'no_timbangan'    => $this->input->post('no_timb'),
					'total_timb'      => str_replace('.','',$this->input->post('jum_timb')),
					'muatan_ppi'      => str_replace('.','',$this->input->post('muat_ppi')),
					'tonase_ppi'      => $tonase_ppi,
					'total_item'      => str_replace('.','',$this->input->post('total_bb_item')),
					'sisa_stok'      => str_replace('.','',$this->input->post('sisa_timb')),

				);
			
				$this->db->where('id_stok', $this->input->post('id_stok_h'));
				$result_header = $this->db->update('trs_h_stok_bb', $data_header);

				
					// input stok berjalan PPI
				if($tonase_ppi>0)
				{
					$data_stok_berjalan = array(				
						'no_transaksi'    => $no_stokbb,
						'id_hub'          => null,
						'tgl_input'       => $this->input->post('tgl_stok'),
						'jam_input'       => date("H:i:s"),
						'jenis'           => 'PPI',
						'masuk'           => $tonase_ppi,
						'keluar'          => 0,
						'ket'             => 'MASUK DENGAN PO',
						'status'          => 'MASUK',
					);
					// $result_stok_berjalan = $this->db->insert('trs_stok_bahanbaku', $data_stok_berjalan);

					$this->db->where('no_transaksi', $no_stokbb);
					$this->db->where('jenis', 'PPI');
					$this->db->where('tgl_input', $this->input->post('tgl_stok'));
					$result_stok_berjalan = $this->db->update('trs_stok_bahanbaku', $data_stok_berjalan);
				
				}
				// input invoice bahan
				inv_bahan($no_stokbb,'edit'); 
			}
		}else{
			$no_stokbb   = $this->m_fungsi->urut_transaksi('STOK_BB').'/'.'STOK/'.$thn;
			$tonase_ppi  = str_replace('.','',$this->input->post('tonase_ppi')) ;

			$rowloop     = $this->input->post('bucket');
			for($loop = 0; $loop <= $rowloop; $loop++)
			{
				$data_detail = array(				
					'no_stok'       => $no_stokbb,
					'id_hub'        => $this->input->post('id_hub['.$loop.']'),
					'id_po_bhn'     => $this->input->post('id_po_bhn['.$loop.']'),
					'no_po_bhn'     => $this->input->post('no_po['.$loop.']'),
					'tonase_po'     => str_replace('.','',$this->input->post('ton['.$loop.']')),
					'datang_bhn_bk' => str_replace('.','',$this->input->post('datang['.$loop.']')),
				);
				$result_detail = $this->db->insert('trs_d_stok_bb', $data_detail);

				// input stok berjalan

				stok_bahanbaku($no_stokbb, $this->input->post('id_hub['.$loop.']'), $this->input->post('tgl_stok'), 'HUB', str_replace('.','',$this->input->post('datang['.$loop.']')), 0, 'MASUK DENGAN PO', 'MASUK');
			}

			if($result_detail)
			{
				$data_header = array(
					'no_stok'         => $no_stokbb,
					'tgl_stok'        => $this->input->post('tgl_stok'),
					'id_timbangan'    => $this->input->post('id_timb'),
					'no_timbangan'    => $this->input->post('no_timb'),
					'total_timb'      => str_replace('.','',$this->input->post('jum_timb')),
					'muatan_ppi'      => str_replace('.','',$this->input->post('muat_ppi')),
					'tonase_ppi'      => str_replace('.','',$this->input->post('tonase_ppi')),
					'total_item'      => str_replace('.','',$this->input->post('total_bb_item')),
					'sisa_stok'      => str_replace('.','',$this->input->post('sisa_timb')),

				);
			
				$result_header = $this->db->insert('trs_h_stok_bb', $data_header);
			}

			// input stok berjalan PPI
			if($tonase_ppi>0)
			{

				stok_bahanbaku($no_stokbb, NULL, $this->input->post('tgl_stok'), 'PPI', $tonase_ppi, 0, 'MASUK DENGAN PO', 'MASUK');
			
			}
			// input invoice bahan
			inv_bahan($no_stokbb,'add');
				
		}
		
		return $result_header;
			
	}

	function save_stok_ppi()
	{
		$sts_input    = $this->input->post('sts_input');
		$thn          = date('Y');

		if($sts_input=='edit')
		{
			$no_stok_ppi   = $this->input->post('no_stok_ppi');
			$id_stok_ppi   = $this->input->post('id_stok_ppi');
			$jam_stok      = $this->input->post('jam_stok');
			// delete stok sebelumnya
			$del_detail    = $this->db->query("DELETE FROM trs_stok_ppi WHERE no_stok_ppi='$no_stok_ppi' ");

		}else{
			$no_stok_ppi   = $this->m_fungsi->urut_transaksi('STOK_BB_PPI').'/'.'STOK_PPI/'.$thn;			
			$jam_stok      = date('H:i:s');

		}

		for($loop = 1; $loop <= 8; $loop++)
		{
			$data_detail = array(				
				'no_stok_ppi'   => $no_stok_ppi,
				'tgl_stok'      => $this->input->post('tgl_stok'),
				'ket_header'    => $this->input->post('ket_header'),
				'jam_stok'      => $jam_stok,
				'ket'           => $this->input->post('ket'.$loop),
				'tonase_masuk'  => str_replace('.','',$this->input->post('masuk'.$loop)),
				'tonase_keluar' => str_replace('.','',$this->input->post('keluar'.$loop)),
				'status' 		=> 'Open',
			);
			$result_detail = $this->db->insert('trs_stok_ppi', $data_detail);

			// input stok berjalan PPI

			// stok_bahanbaku($no_stokbb, NULL, $this->input->post('tgl_stok'), 'PPI', $tonase_ppi, 0, 'MASUK DENGAN PO', 'MASUK');
		}
		
		return $result_detail;
			
	}
	

}
