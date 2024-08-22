<?php
class M_keuangan extends CI_Model
{
 
	function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');
		$this->username = $this->session->userdata('username');
		$this->waktu    = date('Y-m-d H:i:s');
		$this->load->model('m_master');
	}

	function save_ju()
	{
		$status_input = $this->input->post('sts_input');
		if($status_input == 'add')
		{
			$tgl_voucher   = $this->input->post('tgl_voucher');
			$tanggal       = explode('-',$tgl_voucher);
			$tahun         = $tanggal[0];
			$bulan         = $tanggal[1];
			
			$c_no_voc      = $this->m_fungsi->urut_transaksi('JURNAL_UMUM');
			$m_no_voucher  = $c_no_voc.'/'.'JURUM/'.$bulan.'/'.$tahun;
			// rinci

			$rowloop       = $this->input->post('bucket');
			for($loop = 0; $loop <= $rowloop; $loop++)
			{				
				$debit    = str_replace('.','',$this->input->post('debit['.$loop.']'));
				$kredit   = str_replace('.','',$this->input->post('kredit['.$loop.']'));

				$data_jurnal    = array(
					'id_hub'          => $this->input->post('id_hub'),
					'tgl_transaksi'   => $this->input->post('tgl_voucher'),
					'tgl_input'       => date("Y:m:d"),
					'jam_input'       => date("H:i:s"),
					'no_voucher'      => $m_no_voucher,
					'no_transaksi'    => $m_no_voucher,
					'kode_rek'        => $this->input->post('kd_rek['.$loop.']'),
					'ket'             => $this->input->post('ket'),
					'debet'           => $debit,
					'kredit'          => $kredit,
				);
				$result_jurnal = $this->db->insert('jurnal_d', $data_jurnal);

			}		

			return $result_jurnal;
			
		}else{
			// delete rinci

			$no_voucher = $this->input->post('no_voucher');
			$del_detail = $this->db->query("DELETE FROM jurnal_d where no_voucher='$no_voucher' ");

			// rinci
			if($del_detail)
			{
				$rowloop       = $this->input->post('bucket');
				for($loop = 0; $loop <= $rowloop; $loop++)
				{				
					$debit    = str_replace('.','',$this->input->post('debit['.$loop.']'));
					$kredit   = str_replace('.','',$this->input->post('kredit['.$loop.']'));

					$data_jurnal    = array(
						'id_hub'          => $this->input->post('id_hub'),
						'tgl_transaksi'   => $this->input->post('tgl_voucher'),
						'tgl_input'       => date("Y:m:d"),
						'jam_input'       => date("H:i:s"),
						'no_voucher'      => $no_voucher,
						'no_transaksi'    => $no_voucher,
						'kode_rek'        => $this->input->post('kd_rek['.$loop.']'),
						'ket'             => $this->input->post('ket'),
						'debet'           => $debit,
						'kredit'          => $kredit,
					);
					$result_jurnal = $this->db->insert('jurnal_d', $data_jurnal);

				}
				return $result_jurnal;
			}
		}
		
	}	

}
