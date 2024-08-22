<?php
    function cek_subs_bcf($kualitas)
    {	
        $CI =& get_instance();	  
        $substance = $CI->db->query("SELECT * FROM m_p11 where '$kualitas'=concat(substance1,'/',substance2,'/',substance3,'/',substance4,'/',substance5) ")->row();
        return $substance->BCF;
    } 

    function cek_subs_flute($kualitas,$flute)
    {	
        $CI =& get_instance();	  
        $substance = $CI->db->query("SELECT * FROM m_p11 where '$kualitas'=concat(substance1,'/',substance2,'/',substance5) ")->row();
        return $substance->$flute;
    } 
    
    function history_tr($menu, $sub_menu, $tindakan, $no_transaksi, $ket)
    {	
        // CONTOH PENGGUNAAN 
        // history_tr('PO', 'TAMBAH_DATA', 'ADD', 'PO/2024/I/0703')
        $CI =& get_instance();	  

        $data = array(
            'menu'            => $menu,
            'tgl_transaksi'   => date('Y-m-d H:i:s'),
            'sub_menu'        => $sub_menu,
            'tindakan'        => $tindakan,
            'no_transaksi'    => $no_transaksi,
            'user'            => $CI->session->userdata('nm_user'),
            'ket'             => $ket,
        );
        
        $result= $CI->db->insert('m_history_transaksi',$data);
        return $result;
    } 

    function stok_bahanbaku($no_transaksi, $id_hub, $tgl_input, $jenis, $masuk, $keluar, $ket, $status, $id_produk='')
    {	
        // CONTOH PENGGUNAAN 
        // stok_bahanbaku('0036/STOK/2024', '4', '2024-03-01', 'HUB', '10000', '0', 'MASUK DENGAN PO','MASUK')
        $CI =& get_instance();	  

        $data_stok_berjalan = array(				
            'no_transaksi'    => $no_transaksi,
            'id_hub'          => $id_hub,
            'tgl_input'       => $tgl_input,
            'jam_input'       => date("H:i:s"),
            'jenis'           => $jenis,
            'masuk'           => $masuk,
            'keluar'          => $keluar,
            'ket'             => $ket,
            'status'          => $status,
            'id_produk'       => $id_produk,
        );
        $result_stok_berjalan = $CI->db->insert('trs_stok_bahanbaku', $data_stok_berjalan);

        return $result_stok_berjalan;
    } 

    function inv_bahan($no_stok,$status='')
    {	        
        $CI =& get_instance();	  
        $harga_bhn = 2300;

        if($status=='edit')
        {
            $CI->db->query("DELETE FROM invoice_bhn where no_stok='$no_stok' ");
        }

        $query = $CI->db->query("SELECT*FROM trs_h_stok_bb a
        JOIN trs_d_stok_bb b ON a.no_stok=b.no_stok
        JOIN m_hub c ON b.id_hub=c.id_hub 
        where status='Open' AND a.no_stok ='$no_stok'
        ORDER BY tgl_stok ,a.no_stok,id_stok");

        foreach ($query->result() as $detail)
        {
             // input_inv
            $tgl_stok   = $detail->tgl_stok;
            $tanggal    = explode('-',$tgl_stok);
            $tahun      = $tanggal[0];
            $bulan      = $tanggal[1];
            
            $c_no_inv    = $CI->m_fungsi->urut_transaksi('INV_BHN');
            $m_no_inv    = $c_no_inv.'/INV/BHN/'.$bulan.'/'.$tahun;

            $data = array(
                'no_inv_bhn'    => $m_no_inv,
                'tgl_inv_bhn'   => $detail->tgl_stok,
                'id_stok_d'   	=> $detail->id_stok_d,
                'no_stok'   	=> $detail->no_stok,
                'id_hub'        => $detail->id_hub,
                'ket'           => '-',
                'qty'           => $detail->datang_bhn_bk, 
                'nominal'       => $harga_bhn,
                'total_bayar'   => $detail->datang_bhn_bk*$harga_bhn,
                'acc_owner'     => 'N',
                
            );

            $result_header = $CI->db->insert('invoice_bhn', $data);
        }
       
    } 
    
?>