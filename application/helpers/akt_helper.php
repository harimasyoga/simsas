<?php

    function load_rek($field='', $kd='')
    {
        $CI       = & get_instance();
        $result_jurnal = $CI->db->query("SELECT*FROM(
            select kd_akun as kd,nm_akun as nm,jenis,dk from m_kode_akun
            union all
            select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk from m_kode_kelompok
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk from m_kode_jenis
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk from m_kode_rinci
            )p
            order by kd");
        return $result_jurnal;
    } 
   
    function cari_data_rek($field='', $kd='')
    {
        $CI       = & get_instance();
        $result_jurnal = $CI->db->query("SELECT*FROM(
            select kd_akun as kd,nm_akun as nm,jenis,dk from m_kode_akun
            union all
            select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk from m_kode_kelompok
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk from m_kode_jenis
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk from m_kode_rinci
            )p
            where p.$field like '%$kd%'
            order by kd");
        return $result_jurnal;
    } 
    
    function cari_rek($kd='')
    {
        $CI       = & get_instance();
        $result_jurnal = $CI->db->query("SELECT*FROM(
            select kd_akun as kd,nm_akun as nm,jenis,dk from m_kode_akun
            union all
            select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk from m_kode_kelompok
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk from m_kode_jenis
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk from m_kode_rinci
            )p
            where p.kd='$kd'
            order by kd");
        return $result_jurnal->row()->nm;
    } 
   
    function add_jurnal($id_hub,$tgl_transaksi='', $no_transaksi='',$kode_rek='',$ket='' ,$debit=0, $kredit=0)
    {
        $CI       = & get_instance();
        $thn      = date('Y');
        $month    = date('m');

        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => $kode_rek,
            'ket'             => $ket,
            'debet'           => $debit,
            'kredit'          => $kredit,
            'id_hub'          => $id_hub,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);
    } 
    
    function del_jurnal( $no_transaksi='',$kode_rek='')
    {
        $CI       = & get_instance();
        if($kode_rek=='')
        {
            $rek = "";
        }else{
            $rek = "and kode_rek='$kode_rek'";
        }
        
        $CI->db->query("DELETE FROM jurnal_d where no_transaksi='$no_transaksi' $rek ");
    } 
    
    function add_jurnal_all($tgl_transaksi='', $no_transaksi='', $nominal='')
    {
        $CI       = & get_instance();
        $thn      = date('Y');
        $month    = date('m');

        // Persediaan Bahan Baku
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.06',
            'jns_transaksi'   => '1',
            'ket'             => 'Persediaan Bahan Baku',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);
       
        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Beban Transport
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '6.05',
            'jns_transaksi'   => '6',
            'ket'             => 'Beban Transport',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        
        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // BCA 1
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.02.01',
            'jns_transaksi'   => '1',
            'ket'             => 'BCA 1',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Modal
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '3.01',
            'jns_transaksi'   => '3',
            'ket'             => 'Modal',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // BCA 1
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.02.01',
            'jns_transaksi'   => '1',
            'ket'             => 'BCA 1',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Beban Maklon
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '5.04',
            'jns_transaksi'   => '5',
            'ket'             => 'Beban Maklon',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Persediaan Dagang
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.05',
            'jns_transaksi'   => '1',
            'ket'             => 'Persediaan Dagang',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Persediaan Bahan Baku
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.06',
            'jns_transaksi'   => '1',
            'ket'             => 'Persediaan Bahan Baku',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // BCA 1
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '1.01.02.01',
            'jns_transaksi'   => '1',
            'ket'             => 'BCA 1',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Hutang Usaha
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang Usaha',
            'debet'           => $nominal,
            'kredit'          => 0,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);

        // Hutang PPh 23
        $data_jurnal    = array(
            'tgl_transaksi'   => $tgl_transaksi,
            'tgl_input'       => date("Y:m:d"),
            'jam_input'       => date("H:i:s"),
            'no_voucher'      => $CI->m_fungsi->urut_transaksi('VOUCHER').'/JURNAL'.'/'.$month.'/'.$thn,
            'no_transaksi'    => $no_transaksi,
            'kode_rek'        => '2.01.03.01',
            'jns_transaksi'   => '2',
            'ket'             => 'Hutang PPh 23',
            'debet'           => 0,
            'kredit'          => $nominal,
        );
        $result_jurnal = $CI->db->insert('jurnal_d', $data_jurnal);



        return $result_jurnal;
    } 

    function load_lr($field='')
    {
        $CI       = & get_instance();
        $result_jurnal = $CI->db->query("SELECT LENGTH(p.kd)length,p.* FROM(
            select kd_akun as kd,nm_akun as nm,jenis,dk,IFNULL((select sum(debet) from jurnal_d where left(kode_rek,1)=kd),0)debet, IFNULL((select sum(kredit) from jurnal_d where left(kode_rek,1)=kd),0)kredit from m_kode_akun
            union all
            select concat(kd_akun,'.',kd_kelompok) as kd,nm_kelompok as nm,jenis,dk,IFNULL((select sum(debet) from jurnal_d where left(kode_rek,4)=concat(kd_akun,'.',kd_kelompok)),0)debet, IFNULL((select sum(kredit) from jurnal_d where left(kode_rek,4)=kd),0)kredit from m_kode_kelompok
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis) as kd,nm_jenis as nm,jenis,dk,IFNULL((select sum(debet) from jurnal_d where left(kode_rek,7)=concat(kd_akun,'.',kd_kelompok,'.',kd_jenis)),0)debet, IFNULL((select sum(kredit) from jurnal_d where left(kode_rek,7)=kd),0)kredit from m_kode_jenis
            union all
            select concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci) as kd,nm_rinci as nm,jenis,dk,IFNULL((select sum(debet) from jurnal_d where left(kode_rek,10)=concat(kd_akun,'.',kd_kelompok,'.',kd_jenis,'.',kd_rinci)),0)debet, IFNULL((select sum(kredit) from jurnal_d where left(kode_rek,10)=kd),0)kredit from m_kode_rinci
            )p where jenis='$field'
            order by kd");
        return $result_jurnal;
    } 
    
    function load_lr2($field='')
    {
        $CI       = & get_instance();
        $result_jurnal = $CI->db->query("SELECT*from mapping_lr where kode_1 in 
        (
        select ''kode_rek
        UNION ALL
        select LEFT(kode_rek,1)kode_rek from jurnal_d group by LEFT(kode_rek,1)
        UNION ALL
        select LEFT(kode_rek,4)kode_rek from jurnal_d group by LEFT(kode_rek,4)
        UNION ALL
        select LEFT(kode_rek,7)kode_rek from jurnal_d group by LEFT(kode_rek,7)
        UNION ALL
        select LEFT(kode_rek,10)kode_rek from jurnal_d group by LEFT(kode_rek,10)
        )
        ORDER BY no_urut");
        return $result_jurnal;
    } 
   
    function total_penjualan($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        
        $total_penjualan = $CI->db->query("SELECT sum(nominal) as nominal FROM(
            SELECT IFNULL(kredit,0)nominal from jurnal_d 
            WHERE left(kode_rek,4) in (4.01) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(debet,0)*-1 as nominal from jurnal_d 
            WHERE left(kode_rek,4) in (4.02) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(debet,0)*-1 as nominal from jurnal_d 
            WHERE left(kode_rek,4) in (4.03) $tahunn $bulann $hub
            )p");
        return $total_penjualan;
    } 
    
    function hp_penjualan($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        $total_penjualan = $CI->db->query("SELECT sum(nominal) as nominal FROM(
            SELECT IFNULL(debet,0)nominal from jurnal_d 
            where left(kode_rek,4) in (5.01) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(kredit,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (5.02) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(kredit,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (5.03) $tahunn $bulann $hub
            )p");
        return $total_penjualan;
    } 
    
    function lr_kotor($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }
        
        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }
        
        $CI       = & get_instance();
        $total_penjualan = $CI->db->query("SELECT sum(nominal) as nominal FROM(
            -- total_penjualan
            SELECT IFNULL(kredit,0)nominal from jurnal_d 
            where left(kode_rek,4) in (4.01) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(debet,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (4.02) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(debet,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (4.03) $tahunn $bulann $hub
            union ALL
            -- hp_penjualan
            SELECT IFNULL(debet,0)*-1 nominal from jurnal_d 
            where left(kode_rek,4) in (5.01) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(kredit,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (5.02) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(kredit,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (5.03) $tahunn $bulann $hub
            union ALL
            -- beban
            SELECT IFNULL(debet,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (5.04 ,5.05 ,5.06 ,5.07 ,5.08 ,5.09 ,5.10 ,5.11) $tahunn $bulann $hub
            )p");
        return $total_penjualan;
    } 
    
    function jum_beban($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        $total_penjualan = $CI->db->query("SELECT sum(nominal) as nominal FROM(
            -- biaya
            SELECT IFNULL(debet-kredit,0) as nominal from jurnal_d 
            where left(kode_rek,4) in (6.01 ,6.02 ,6.03 ,6.04 ,6.05 ,6.06 ,6.07 ,6.08 ,6.09 ,6.10 ,6.11 ,6.12 ,6.13 ,6.14 ,6.15 ,6.16 ,6.17 ,6.18 ,6.19 ,6.20 ,6.21 ,6.22 ,6.23 ,6.24 ,6.25 ,6.26 ,6.27 ,6.28 ,6.29 ,6.30 ,6.31 ,6.32 ,6.33 ,6.34 ,6.35 ,6.36 ,6.37 ,6.38) $tahunn $bulann $hub
            )p");
        return $total_penjualan;
    } 
    
    function pll($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }
        
        $CI   = & get_instance();
        $pll  = $CI->db->query("SELECT sum(nominal) as nominal FROM(
            -- biaya
            SELECT IFNULL(debet,0) as nominal from jurnal_d 
            where left(kode_rek,4) in (7.01 ,7.02 ,7.03 ,7.04 ,7.05 ,7.06 ,7.07 ,7.08 ,7.09 ,7.10 ,7.11) $tahunn $bulann $hub
            )p");
        return $pll;
    } 

    function load_map_nrc()
    {
        $CI               = & get_instance();
        $result_jurnal    = $CI->db->query("SELECT*from mapping_nrc where kode_1 in
        (
        select ''kode_rek
        UNION ALL
        select '3.03'kode_rek
        UNION ALL
        select '3.04'kode_rek
        UNION ALL
        select LEFT(kode_rek,1)kode_rek from jurnal_d group by LEFT(kode_rek,1)
        UNION ALL
        select LEFT(kode_rek,4)kode_rek from jurnal_d group by LEFT(kode_rek,4)
        UNION ALL
        select LEFT(kode_rek,7)kode_rek from jurnal_d group by LEFT(kode_rek,7)
        UNION ALL
        select LEFT(kode_rek,10)kode_rek from jurnal_d group by LEFT(kode_rek,10)
        )
        ORDER BY no_urut");
        return $result_jurnal;
    } 

    function total_aset_lancar($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        
        $total_aset_lancar = $CI->db->query("SELECT IFNULL(sum(debet)-sum(kredit),0)nominal 
            from jurnal_d where left(kode_rek,4) in ('1.01')
            $tahunn $bulann $hub
            GROUP BY left(kode_rek,4)
            
            ");
        return $total_aset_lancar;
    } 

    function aset_tetap($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        
        $total_aset_lancar = $CI->db->query("SELECT IFNULL(sum(debet)-sum(kredit),0)nominal 
            from jurnal_d where left(kode_rek,4) in ('1.02')
            $tahunn $bulann $hub
            GROUP BY left(kode_rek,4)
            
            ");
        return $total_aset_lancar;
    } 
    
    function akumulasi_penyusutan($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        
        $total_akumulasi_penyusutan = $CI->db->query("SELECT IFNULL(sum(debet)-sum(kredit),0)nominal 
            from jurnal_d where left(kode_rek,4) in ('1.03')
            $tahunn $bulann $hub
            GROUP BY left(kode_rek,4)
            
            ");
        return $total_akumulasi_penyusutan;
    } 
    
    function total_aset($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        
        $total_total_aset = $CI->db->query("SELECT IFNULL(sum(debet)-sum(kredit),0)nominal 
            from jurnal_d where left(kode_rek,1) in ('1')
            $tahunn $bulann $hub
            GROUP BY left(kode_rek,1)
            
            ");
        return $total_total_aset;
    } 
    
    function total_kewajiban_lancar($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        
        $total_total_kewajiban_lancar = $CI->db->query("SELECT IFNULL(sum(kredit)-sum(debet),0)nominal 
            from jurnal_d where left(kode_rek,4) in ('2.01')
            $tahunn $bulann $hub
            GROUP BY left(kode_rek,4)
            
            ");
        return $total_total_kewajiban_lancar;
    } 
    
    function total_kewajiban_jp($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        
        $total_total_kewajiban_jp = $CI->db->query("SELECT IFNULL(sum(debet)-sum(kredit)*-1,0)nominal 
            from jurnal_d where left(kode_rek,4) in ('2.02')
            $tahunn $bulann $hub
            GROUP BY left(kode_rek,4)
            
            ");
        return $total_total_kewajiban_jp;
    } 
    
    function total_kewajiban($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        
        $total_total_kewajiban = $CI->db->query("SELECT IFNULL(sum(debet)-sum(kredit),0)*-1 nominal 
            from jurnal_d where left(kode_rek,1) in ('2')
            $tahunn $bulann $hub
            GROUP BY left(kode_rek,1)
            
            ");
        return $total_total_kewajiban;
    } 
    
    function total_ekuitas($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        
        $total_ekuitas = $CI->db->query("SELECT IFNULL(sum(debet)-sum(kredit)*-1,0)nominal 
            from jurnal_d where left(kode_rek,1) in ('3')
            $tahunn $bulann $hub
            GROUP BY left(kode_rek,1)
            
            ");
        return $total_ekuitas;
    } 
    
    function lr_ditahan($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        
        $lr_ditahan = $CI->db->query("SELECT IFNULL(sum(debet)-sum(kredit)*-1,0)nominal 
            from jurnal_d where left(kode_rek,1) in ('3')
            $tahunn $bulann $hub
            GROUP BY left(kode_rek,1)
            ");
        return $lr_ditahan;
    } 

    function lr_kotor_nrc($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }
        
        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }
        
        $CI       = & get_instance();
        $total_penjualan = $CI->db->query("SELECT sum(nominal) as nominal FROM(
            -- total_penjualan
            SELECT IFNULL(kredit,0)nominal from jurnal_d 
            where left(kode_rek,4) in (4.01) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(debet,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (4.02) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(debet,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (4.03) $tahunn $bulann $hub
            union ALL
            -- hp_penjualan
            SELECT IFNULL(debet,0)*-1 nominal from jurnal_d 
            where left(kode_rek,4) in (5.01) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(kredit,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (5.02) $tahunn $bulann $hub
            union ALL
            SELECT IFNULL(kredit,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (5.03) $tahunn $bulann $hub
            union ALL
            -- beban
            SELECT IFNULL(debet,0)*-1 as nominal from jurnal_d 
            where left(kode_rek,4) in (5.04 ,5.05 ,5.06 ,5.07 ,5.08 ,5.09 ,5.10 ,5.11) $tahunn $bulann $hub
            )p");
        return $total_penjualan;
    } 
    
    function jum_beban_nrc($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }

        $CI       = & get_instance();
        $total_penjualan = $CI->db->query("SELECT sum(nominal) as nominal FROM(
            -- biaya
            SELECT IFNULL(debet-kredit,0) as nominal from jurnal_d 
            where left(kode_rek,4) in (6.01 ,6.02 ,6.03 ,6.04 ,6.05 ,6.06 ,6.07 ,6.08 ,6.09 ,6.10 ,6.11 ,6.12 ,6.13 ,6.14 ,6.15 ,6.16 ,6.17 ,6.18 ,6.19 ,6.20 ,6.21 ,6.22 ,6.23 ,6.24 ,6.25 ,6.26 ,6.27 ,6.28 ,6.29 ,6.30 ,6.31 ,6.32 ,6.33 ,6.34 ,6.35 ,6.36 ,6.37 ,6.38) $tahunn $bulann $hub
            )p");
        return $total_penjualan;
    } 
    
    function pll_nrc($ket='',$ket_bln='',$bulan='',$thn='',$attn='')
    {
        if($attn=='')
        {
            $hub ='';
        }else{
            $hub ='and id_hub in ('.$attn.')';
        }

        if($ket=='now')
        {
            $bulann   = "and MONTH(tgl_transaksi)<='$bulan' ";
            $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            
        }else{
            if($ket_bln=='all')
            {
                $bulann   = "";
                $tahunn   = "and YEAR(tgl_transaksi)<'$thn' ";
            }else{
                $bulann   = "and MONTH(tgl_transaksi)<'$bulan' ";
                $tahunn   = "and YEAR(tgl_transaksi)='$thn' ";
            }
        }
        
        $CI   = & get_instance();
        $pll  = $CI->db->query("SELECT sum(nominal) as nominal FROM(
            -- biaya
            SELECT IFNULL(debet,0) as nominal from jurnal_d 
            where left(kode_rek,4) in (7.01 ,7.02 ,7.03 ,7.04 ,7.05 ,7.06 ,7.07 ,7.08 ,7.09 ,7.10 ,7.11) $tahunn $bulann $hub
            )p");
        return $pll;
    } 
?>