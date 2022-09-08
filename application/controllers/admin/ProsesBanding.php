<?php

defined('BASEPATH') or exit('No direct script access allowed');


class ProsesBanding extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // checklogin();
        $this->db2 = $this->load->database('database2', TRUE);
        $this->db3 = $this->load->database('database3', TRUE);

        // $this->load->model('FakturModel');
    }

    public function rcv_vs_erp()
    {
        // $cek_ulang = "SELECT * FROM adempiere.mv_suz_mixcode_v WHERE mixcode='8999999571931' ";
        // $resultCek = $this->db3->query($cek_ulang)->result_array(); 
        // var_dump($resultCek); die;
        
        //ambil data dari btt
        $bttt = "SELECT no_btt,create_at FROM tb_nobtt WHERE status='confirm'";
        $resultBttt = $this->db2->query($bttt)->result_array();
        // var_dump($resultBttt); die;

        foreach ($resultBttt as $valBtt) {
            $create_at = $valBtt['create_at'];
            // mengambil no bttt dari dari tabel tb_nobtt
            $bttt = "SELECT * FROM tb_nobtt where no_btt = '$valBtt[no_btt]'";
            $resultBtt = $this->db2->query($bttt)->result_array();
            // var_dump($resultBtt); die;
            foreach ($resultBtt as $value) {
                $queryBtt = "SELECT csv_detail.barcode, tb_faktur.fak_pjk, csv_detail.fak_supp, tb_rcv.no_btt, tb_faktur.no_rcv, tb_faktur.tagihan, csv_detail.qty, csv_detail.harga, csv_detail.total 
                 FROM tb_rcv
                 JOIN tb_faktur ON tb_rcv.no_rcv = tb_faktur.no_rcv
                 JOIN csv_detail ON tb_faktur.no_faktur = csv_detail.fak_supp
                 WHERE tb_rcv.no_btt = '$value[no_btt]'";

                $resultBtt1 = $this->db2->query($queryBtt)->result_array();

                // var_dump($resultBtt1); die;
                
                if ($resultBtt1) {
                   $cekResult = count($resultBtt1);
                }else{
                   $cekResult = 0; 
                }

                if($cekResult > 0){
                    foreach($resultBtt1 as $values){
                        $cek_ulang = "SELECT * FROM mv_suz_mixcode_v WHERE mixcode='$values[barcode]'";
                        $resultCek = $this->db3->query($cek_ulang)->result_array(); 
                        // var_dump($resultCek);die;
                        // try {
                        //     //code...
                        //     $resultCek = $this->db3->query("SELECT * FROM mv_suz_mixcode_v limit 1 ")->result_array(); 

                        //     var_dump($resultCek); die;

                        // } catch (\Throwable $th) {
                        //     var_dump($th);die;
                        // }
                       
                        if($resultCek){
                           $jml = count($resultCek);
                        //    var_dump($jml);die;
                        }else{
                           $jml = 0;
                        }

                        if($jml > 0){
                            $front = substr($resultCek[0]['internal'], 0, 7);
                            $back  = substr($resultCek[0]['internal'], 9, 2);
                            
                            $internal = $front . $back;
                            // var_dump($internal); die;
                        }else{
                            $cek_bpartner = "SELECT m_product_id,c_bpartner_id,vendorproductno from C_BPartner_Product where vendorproductno ='$values[barcode]'";

                            $resultBpn = $this->db3->query($cek_bpartner)->result_array();
                            // var_dump($resultBpn); die;
                            if($resultBpn){
                            //    var_dump($resultBpn); die;                               
                               $prod_id = $resultBpn[0]['m_product_id'];
                            }else{
                               $prod_id = '';
                            }
                        }
                      
                        $sql = "SELECT rh.rcvno,rh.pono,oh.topindays,oh.duedatepo,rh.rcvdate,rh.description,rh.totalrcv,
                        case when od.upc ISNULL THEN od.barcode ELSE od.upc END AS upc,rd.productno,od.uompurchase,
                        od.qtyorder,rd.qtyreceipt,(rd.qtyreceipt*u.dividerate) qtystockrcv, (od.unitprice/(od.qtyorder*u.dividerate)) unitprice, 
                        (rd.qtyreceipt * (od.totalamount/od.qtyorder)) totalamountrcv
                        FROM mv_suz_receiving_header_v rh  
                        LEFT JOIN mv_suz_order_header_v oh ON rh.pono=oh.pono
                        LEFT JOIN (select nopo,productno,qtyorder,qtyreceipt,statuspo from mv_suz_receiving_detail_v) rd ON rh.pono=rd.nopo 
                        LEFT JOIN mv_suz_order_detail_v od ON rh.pono=od.nopo AND oh.pono=od.nopo AND rd.nopo=od.nopo AND concat(LEFT(rd.productno,7),RIGHT(rd.productno,2)) =concat(LEFT(od.product,7),RIGHT(od.product,2))
                        LEFT JOIN (select value,m_product_id from m_product) p ON concat(LEFT(rd.productno,7),RIGHT(rd.productno,2))=p.value 
                        LEFT JOIN C_UOM_Conversion u ON p.m_product_id=u.m_product_id AND SUBSTR(rd.productno,8,2)=u.uom
                        WHERE rh.rcvno='$values[no_rcv]'  AND rd.qtyreceipt>0";

                        if($jml > 0){
                            $sql .= "AND concat(LEFT(rd.productno,7),RIGHT(rd.productno,2)) ='$internal'";
                        }else{
                            $sql .= "AND p.m_product_id =' $prod_id'";
                        }

                        $resultIdemp = $this->db3->query($sql)->result_array();
                        // var_dump($resultIdemp); die;
                        if($resultIdemp){            
                            // var_dump($resultIdemp); die;
                            $count = count($resultIdemp);
                            // var_dump($count); die;
                        }else{
                            $count = 0;
                        }

                        if($count > 0){

                            // selisih qty
                            $qty = (float)$resultIdemp[0]['qtystockrcv'] - $values['qty'];

                            // selisih unit
                            $hargaQty = $resultIdemp[0]['unitprice'] - $values['harga'];

                            // selisih total
                            $hargaTotal = (float) $resultIdemp[0]['totalamountrcv'] - (float) $values['total'];

                            // var_dump($hargaQty);die;

                            $productId = substr($resultIdemp[0]['productno'], 0, 7);
                            $product = substr($resultIdemp[0]['productno'], 9, 2);

                            $valueid = $productId.$product;

                            //var_dump($valueid);die;

                            //cek mr line
                            $sqlCekMrLine = "SELECT mi2.m_inoutline_id,mi2.m_product_id FROM adempiere.m_inout mi join m_inoutline mi2 on mi.m_inout_id = mi2.m_inout_id join m_product mp on mp.m_product_id = mi2.m_product_id where documentno ='$values[no_rcv]' and value ='$valueid'";
                            
                            $resulQuery = $this->db3->query($sqlCekMrLine);
                            $resultIdemps = $resulQuery->result_array();

                            // var_dump($resultIdemps);die;

                            $mr_line_id = $resultIdemps[0]['m_inoutline_id'];
                            $total = intval($hargaTotal);

                            // var_dump($create_at);die;

                            $date = date('Y-m-d');

                            //insert ke dump
                            $sqlIdemDump = "REPLACE INTO idem_dump(no_bttt, url_fak_pjk, document_mr, mr_line_id, product, selisih_qty,selisih_unit_prc, selisih_total_prc, date_create)
                            VALUES('$value[no_btt]','$values[fak_pjk]',
                                   '$values[no_rcv]','$mr_line_id',
                                   '$values[barcode]','$qty',
                                   '$hargaQty','$total','$create_at')";

                            $resultIdempDump = $this->db2->query($sqlIdemDump);

                            // var_dump($resultIdemp1);die;

                            $sqlSuzzBttt = "SELECT * FROM suz_bttt where bttt='$value[no_btt]' and document_mr='$values[no_rcv]' and mr_line_id='$mr_line_id' and url_fp ='$values[fak_pjk]' and adjustment ='$hargaTotal' and bttt_date ='$create_at'";
                            
                            $resultIdemp2 = $this->db2->query($sqlSuzzBttt)->result_array();

                            $hrg = count($resultIdemp2);

                            if($hargaTotal > 0){
                                $total = $hargaTotal;
                            }else{
                                $total = 0;
                            }

                            echo "sukses insert ke dump local";
                        }else{
                            $psn = 'err';
                            $norcv = $values['no_rcv'];
                            $nofak = $values['no_fak_supp'];
                            $btt = $values['no_btt'];
                            $barcode = $values['barcode'];
                            $kode = $values['kode_supp'];
    
                            $msg = "BTTT $btt pada No Receiving $norcv Faktur $nofak data barcode $barcode tidak terdaftar";
    
    
                            $errmsg = "REPLACE INTO log_error(btt_no,no_faktur,no_rcv,msg,kode_supp) VALUES('$btt','$nofak','$norcv','$msg','$kode')";
                            $errmsg = $this->db2->query();
                           
                            echo $msg;
                        }

                    }               
                }else{
                    $psnErr = 'kosong';
                    echo "data tidak ada";
                }
            }

            if($psn){
                echo 'err';
            }else if($psnErr){
                echo 'kosong';
            }else{
                $sqlIdemp4 = "SELECT * FROM idem_dump WHERE no_bttt = '$value[no_btt]' AND selisih_total_prc >= '0'";
                $sqlIdemp4 = $this->db2->query($sqlIdemp4)->result_array();

                $jumlah = count($sqlIdemp4);

                foreach($sqlIdemp4 as $key => $val){
                    $sqlSuzzBttt2 = "INSERT INTO suz_bttt(bttt,bttt_date,document_mr,mr_line_id ,url_fp,adjustment) VALUES ('$val[no_bttt]','$val[date_create]','$val[document_mr]','$val[mr_line_id]','$val[url_faktur_pajak]','$val[selisih_total_prc]'";

                    $sqlSuzzBttt2 = $this->db2->query($sqlSuzzBttt2);
                }
            }
        }
    }
}
