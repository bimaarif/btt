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
        // $cek_ulang = " SELECT * FROM adempiere.mv_suz_mixcode_v limit 1 ";
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
                $queryBtt = "SELECT csv_detail.barcode, csv_detail.fak_supp, tb_rcv.no_btt, tb_faktur.no_rcv, tb_faktur.tagihan  FROM tb_rcv
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
                        }else{
                           $jml = 0;
                        }

                        if($jml > 0){
                            $front = substr($resultCek[0]['internal'], 0, 7);
                            $back  = substr($resultCek[0]['internal'], 9, 2);
                            
                            $internal = $front . $back;
                        }else{
                            $cek_bpartner = "SELECT m_product_id,c_bpartner_id,vendorproductno from C_BPartner_Product where vendorproductno ='$values[barcode]'";

                            $resultBpn = $this->db3->query($cek_bpartner)->result_array();

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

                        $resultIdemp = $this->db2->query($sql)->result_array();
var_dump($resultIdemp);die;
                        if($resultIdemp){
                            $count = count($resultIdemp);
                        }else{
                            $count = 0;
                        }

                        if($count > 0){

                            // selisih qty
                            $qty = (float)$resultIdemp[0]['qtystockrcv'] - $values['qty'];

                            // selisih unit
                            $hargaQty = $resultIdemp[0]['unitprice']-$values['harga'];

                            // selisih total
                            $hargaTotal = (float)$resultIdemp[0]['totalamountrcv'] - (float)$values['total'];

                            $productId = substr($resultIdemp[0]['productno'], 0, 7);
                            $product = substr($resultIdemp[0]['productno'], 9, 2);

                            $valueid = $productId.$product;

                            //cek mr line
                            $sqlCekMrLine = "SELECT mi2.m_inoutline_id,mi2.m_product_id FROM adempiere.m_inout mi join m_inoutline mi2 on mi.m_inout_id = mi2.m_inout_id join m_product mp on mp.m_product_id = mi2.m_product_id where documentno ='$values[no_rcv]' and value ='$valueid'";

                            $resultIdemps = $this->db3->query($sqlCekMrLine)->result_array();

                            $mr_line_id = $resultIdemp[0]['m_inoutline_id'];
                            $total = intval($hargaTotal);


                            $date = date('Y-m-d');

                            //insert ke dump
                            $sqlIdemp = "";
                        }

                    }               
                }
            }
        }
    }
}
