<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipping;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function AWB($data, $mpdf = null)
    {
        if(is_null($mpdf)){
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 16,
                'default_font' => 'sarabun'
            ]);
        }
        // return explode('',$data->deduct_tax_identification);
        $output = '<style>
                    table {
                        font-size: 15px;
                        border-collapse: collapse;
                        width:100%
                    }

                    table th, td {
                        border: 0.5px solid #6d6d6d;
                    }
                </style>
                <div style="margin:-35px;padding-top:-83px">
                <h4 align="center" style="padding-bottom: -8px;">หนังสือรับรองการหักภาษี ณ ที่จ่าย</h4><h5 align="right" style="padding-top: -55px; padding-right: 105px">No:</h5>
                <h5 align="center" style="padding-top: -28px;margin-bottom: -5px; font-size: 15px">ตามมาตรา 50 ทวิ แห่งประมวลรัษฎากร</h5>
                    <table width="101%">
                        <tr>
                            <th width="55%" align="left" style="vertical-align: top;">
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;ผู้มีหน้าที่หักภาษี  ณ  ที่จ่าย : &nbsp;</span><span  style="font-size: 12px" >เลขประจำตัวผู้เสียภาษีอากร </span>';
                            $bor = 0.5;
                        for($i=0;$i<strlen($data->deduct_tax_identification);$i++){
                            $bor = $bor+0.01;
                            $output .= '<span style="border: '.$bor.'px solid #6d6d6d;" >&nbsp;'.$data->deduct_tax_identification[$i].'&nbsp;</span>';
                        }
                        $output .= '<br>
                                <br>
                                <span align="left" style="font-size: 13px">&nbsp;&nbsp;ชื่อ &nbsp; &nbsp; </span><span  style="font-size: 16px" >'.$data->deduct_name.'</span>
                                <br>
                                <span align="left" style="font-size: 12px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(ให้ระบุว่าเป็นบุคคล นิติบุคคล บริษัท สมาคม หรือคณะบุคคล)</span>
                                <br>
                                <span align="left" style="font-size: 13px">&nbsp;&nbsp;ที่อยู่ &nbsp; </span><span  style="font-size: 16px" >'.$data->address_number.' '.$data->address_moo.' '.$data->address_alley.' '.$data->address_street.' '.$data->address_subdistrict.' '.$data->address_district.' '.$data->address_province.' '.$data->address_zipcode.' '.$data->phone.'</span>
                                <br>
                                <span align="left" style="font-size: 13px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(ให้ระบุ เลขที่ ตรอก/ซอย หมู่ที่ ตำบล/แขวง อำเภอ/ตำบล จังหวัด และเบอร์โทรศัพท์)</span>
                            </th>
                            <th width="45%" align="left" style="vertical-align: top;">
                                <span style="font-size: 12px" >&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; เลขประจำตัวผู้เสียภาษีอากร </span>';
                                $bor = 0.5;
                            for($i=0;$i<strlen($data->represent_tax_identification);$i++){
                                $bor = $bor+0.01;
                                $output .= '<span style="border: '.$bor.'px solid #6d6d6d;" >&nbsp;'.$data->represent_tax_identification[$i].'&nbsp;</span>';
                            }
                            $output .= '
                                <br>
                                <br>
                                <span  style="font-size: 13px" >กระทำการแทน</span>
                                <br>
                                <span  style="font-size: 13px" >โดยตัวแทน &nbsp; &nbsp; </span><span  style="font-size: 16px" >'.$data->represent_name.'</span>
                                <br>
                                <span  style="font-size: 13px" >ที่อยู่ &nbsp; </span><span  style="font-size: 16px" >'.$data->represent_address.'</span>
                            </th>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <th style="border-bottom: 0.5px solid white;border-right: 0.5px solid white" width="50%" align="left">
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;ผู้ถูกหักภาษี  ณ  ที่จ่าย : 
                            </th>
                            <th width="50%" style="border-bottom: 0.5px solid white;" align="right">
                            </span><span style="font-size: 12px" >เลขประจำตัวผู้เสียภาษีอากร </spsn>';
                            $bor = 0.5;
                        for($i=0;$i<strlen($data->pay_tax_identification);$i++){
                            $bor = $bor+0.01;
                            $output .= '<span style="font-size: 15px; border: '.$bor.'px solid #6d6d6d;" >&nbsp;'.$data->pay_tax_identification[$i].'&nbsp;</span>';
                        }
                        $output .= ' &nbsp; &nbsp; &nbsp;
                            </th>
                        </tr>
                        <tr>
                            <th width="50%" style="border-right: 0.5px solid white" align="left">
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;ชื่อ &nbsp; &nbsp; </span><span  style="font-size: 16px" >'.$data->pay_name.'</span>
                                <br>
                                <span align="left" style="font-size: 12px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (ให้ระบุว่าเป็นบุคคล นิติบุคคล บริษัท สมาคม หรือคณะบุคคล) </span>
                                <br>
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;ที่อยู่ &nbsp; </span><span  style="font-size: 16px" >'.$data->pay_address.'</span>
                                <br>
                                <span align="left" style="font-size: 12px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (ให้ระบุ เลขที่ ตรอก/ซอย หมู่ที่ ตำบล/แขวง อำเภอ/ตำบล จังหวัด และเบอร์โทรศัพท์)</span>
                            </th>
                            <th width="50%" align="right">
                            <span style="font-size: 16px">ใบเสร็จรับเงิน &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span>
                            <br>
                            <span style="font-size: 16px">AWB NO &nbsp; '.$data->awb_no.' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span>
                            <br>
                            <br>
                            <br>
                            </th>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <th width="30%" align="left" style="vertical-align: top; border-right: 0.5px solid white">
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;ลำดับที่</span> &nbsp; <input type="text"><span align="left" style="font-size: 16px"> &nbsp; ในรูปแบบ </span>
                            </th>
                            <th width="70%" align="left">
                                <input type="checkbox">&nbsp; (1) ภ.ง.ด. 1ก. &nbsp; &nbsp; &nbsp; <input type="checkbox">&nbsp; (2) ภ.ง.ด. 1ก. พิเศษ &nbsp; &nbsp; &nbsp; <input type="checkbox">&nbsp; (3) ภ.ง.ด. 2 &nbsp; &nbsp; &nbsp; <input type="checkbox">&nbsp; (4) ภ.ง.ด. 3 &nbsp; &nbsp; &nbsp; <br><input type="checkbox">&nbsp; (5) ภ.ง.ด. 2ก. &nbsp; &nbsp; &nbsp; <input type="checkbox">&nbsp; (6) ภ.ง.ด. 3ก. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-size:12px;font-family:fontawesome;" class="fa">&#xf14a; </span>&nbsp; (7) ภ.ง.ด. 53
                            </th>
                        </tr>
                    </table>
                    <div width="100%" cellpadding="20" style="padding: 10px;border: 1px solid #6d6d6d;">
                                <table width="100%" >
                                    <tr>
                                        <th width="50%" align="center">
                                            <span align="center">ประเภทเงินได้ที่จ่าย</span>
                                        </th>
                                        <th width="15%" align="center">
                                            <span align="center">วัน เดือน หรือปีภาษีที่จ่าย</span>
                                        </th>
                                        <th width="20%" align="center" colSpan="2">
                                            <span align="center">จำนวนเงินที่จ่าย</span>
                                        </th>
                                        <th width="20%" align="center" colSpan="2">
                                            <span align="center">ภาษีที่หัก และนำส่งไว้</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%" align="left" >
                                            <span align="left">&nbsp;&nbsp;&nbsp;1. เงินเดือน ค่าจ้าง เบี้ยเลี้ยง โบนัส ฯลฯ ตามมาตรา 40 (1)</span><br>
                                            <span style="" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เงินเดือน และค่าบริการ</span><br>
                                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;โบนัส</span><br>
                                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าอาหาร และค่าเช้าบ้าน</span><br>
                                            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ภาษาีออกให้ และรายได้อื่นๆ</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;2. ค่าธรรมเนียม ค่านายหน้า ฯลฯ ตามมาตรา 40 (2)</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;3. ค่าแห่งลิขสิทธิ์ ฯลฯ ตามมาตรา 40 (3)</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;4. (1) ค่าดอกเบี้ย ฯลฯ ตามมาตรา 40 (4) (ก)</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(2) เงินปันผล เงินส่วนแบ่งกำไร ฯลฯ ตามมาตรา 40 (4) (ข)</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ที่จ่ายจาก</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ก) กิจกรรมที่ต้องเสียภาษีเงินได้นิติบุคคลในอัตราร้อยละ 30</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ของกำไรสุทธิ</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ข) กิจการในเขตส่งเสริมการลงทุนตามมาตรา 35 (2) แห่ง</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; พระราชบัญญัติส่งเสริมการลงทุน พ.ศ.2520 ที่ต้อง</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เสียภาษีเงินได้นิติบุคคลในอัตรากึ่งหนึ่งของอัตราตาม (ก)</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ค) กิจการวิเเทศธนกิจที่ต้องเสียภาษีเงินได้นิติบุคคลใน</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ในอัตราร้อยละ 10 ของกำไรสุทธิ</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ง) กิจการที่ต้องเสียภาษีเงินได้นิติบุคคลในอัตราอื่นนอก</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; จาก (ก) (ข) หรือ (ค)</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;5. การจ่ายเงินได้ที่ต้องหักภาษี ณ ที่จ่ายตามคำสั่งกรมสรรพากร</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ที่ออกตามมาตรา 3 เตรส เช่น ค่าซื้อพืชผลทางการเกษตร</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ยางพารา มันสำปะหลัง ปอ ข้าว ฯลฯ) รางวัลในการประกวด</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;การแข่งขัน การชิงโชค ค่าแสดงภาพยนต์ ร้องเพลง ดนตรี</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าจ้างทำของ ค่าจ้างโฆษณา ค่าเช่า ฯลฯ</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;6. อื่นๆ (ระบุ) ค่าบริการ 3% ...................................................</span><br>
                                            <span align="left">&nbsp;&nbsp;&nbsp;7. ..............................................................................................  </span><br>
                                        </th>
                                        <th width="15%" align="right" style="vertical-align: bottom;">
                                            <span align="right">'.$data->date_current.'</span>
                                        </th>
                                        <th width="20%" align="right" style="vertical-align: bottom;">
                                            <span align="right">'.$data->pay_price.'</span>
                                        </th>
                                        <th width="3%" align="right">
                                            <span align="right"></span>
                                        </th>
                                        <th width="20%" align="right" style="vertical-align: bottom;">
                                            <span align="right">'.$data->pay_tax.'</span>
                                        </th>
                                        <th width="3%" align="left">
                                            <span align="left"></span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="50%" colSpan="2" align="right">
                                            <span  style="font-size: 16px">รวมเงินที่จ่ายและภาษีที่หักนำส่ง </span>
                                        </th>
                                        <th width="20%" align="center">
                                        </th>
                                        <th width="3%" align="left">
                                        </th>
                                        <th width="20%" align="center">
                                        </th>
                                        <th width="3%" align="left">
                                        </th>
                                    </tr>
                                </table>
                                <table>
                                <tr>
                                    <th width="30%" align="right">
                                        <span  style="font-size: 16px"><i>รวมภาษีที่หักนำส่ง (ตัวอักษร)</i> &nbsp;</span>
                                    </th>
                                    <th  align="left" colSpan="5" style="background: #f1f1f1">
                                    &nbsp;'.$data->pay_tax_text.'
                                    </th>


                                </tr>
                            </table>
                    </div>
                    <table width="100%">
                        <tr>
                            <th width="100%" align="left">
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;เงินสะสมจ่ายเข้ากองทุนสำรองเลี้ยงชีพใบอนุญาติเลขที่..........................................................................................จำนวนเงิน...........................................................................บาท</span>
                            </th>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <th width="100%" align="center">
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;เงินสมทบจ่ายเข้ากองทุนประกันสังคม จำนวนเงิน..........................................................................................บาท</span>
                            </th>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <th width="25%" align="left">
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;ผู้จ่ายเงิน</span><br>
                                <span align="left" style="font-size: 16px"><input size="3">&nbsp;&nbsp;หักภาษี ณ ที่จ่าย</span><br>
                                <span align="left" style="font-size: 16px"><input size="3">&nbsp;&nbsp;ออกภาษีให้ตลอดไป</span><br>
                                <span align="left" style="font-size: 16px"><input size="3">&nbsp;&nbsp;ออกภาษีให้ครั้งเดียว</span><br>
                                <span align="left" style="font-size: 16px"><input size="3">&nbsp;&nbsp;อื่นๆ ให้ระบุ.......................</span>
                            </th>
                            <th width="75%" align="left">
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;&nbsp;ขอรับรองว่า ข้อความและตัวเลขดังกล่าวข้างต้นถูกต้องตรงกับความจริงทุกประการ</span><br>
                                <br>
                                <br>
                                <br>
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;&nbsp;ลงชื่อ.........................................................................................มีหน้าที่หักภาษี ณ ที่จ่าย</span><br>
                                <span align="left" style="font-size: 16px"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; '.$data->date_current.' &nbsp; &nbsp; &nbsp; วัน เดือน ปี ที่ออกหนังสือรับรอง</span>
                            </th>
                        </tr>

                    </table>
                                <span align="left" style="font-size: 16px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หมายเหตุ ให้สามารถอ้างอิงหรือสอบยันกันได้ระหว่างลำดับที่ตามหนังสือรับรองฯ กับแบบรายการภาษีหัก ณ ที่จ่าย</span>
            </div>';

        $mpdf->debug = true;
        $mpdf->AddPage();
        $mpdf->WriteHTML($output);
        return $mpdf;
    }
    public static function PND53($data = null, $month_param, $year, $mpdf = null){
        
        if(is_null($mpdf)){
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 16,
                'default_font' => 'sarabun'
            ]);
        }

    $shipping = Shipping::where('ref_customer_id',$data->ref_customer_id)->orderBy('id','DESC')->get();

        // return explode('',$data->deduct_tax_identification);
        $month_pay = explode(' ',$data->month_pay);
        $month = [
            1=>"มกราคม &nbsp; &nbsp; &nbsp;",
            2=>"กุมภาพันธ์ &nbsp; &nbsp; &nbsp;",
            3=>"มีนาคม &nbsp; &nbsp; &nbsp; &nbsp;",
            4=>"เมษายน &nbsp; &nbsp; ",
            5=>"พฤษภาคม &nbsp; ",
            6=>"มิถุนาคม &nbsp; &nbsp; &nbsp; &nbsp;",
            7=>"กรกฎาคม &nbsp; &nbsp; ",
            8=>"สิงหาคม &nbsp; &nbsp; ",
            9=>"กันยาคม &nbsp; &nbsp; ",
            10=>"ตุลาคม &nbsp; &nbsp; &nbsp; &nbsp; ",
            11=>"พฤศจิกาคม ",
            12=>"ธันวาคม &nbsp; &nbsp; &nbsp;",
        ];
        $month2 = [
            "01"=>"มกราคม",
            "02"=>"กุมภาพันธ์",
            "03"=>"มีนาคม",
            "04"=>"เมษายน",
            "05"=>"พฤษภาคม",
            "06"=>"มิถุนาคม",
            "07"=>"กรกฎาคม",
            "08"=>"สิงหาคม",
            "09"=>"กันยาคม",
            10=>"ตุลาคม",
            11=>"พฤศจิกาคม",
            12=>"ธันวาคม",
        ];
        $deduct_tax_identification = '1549867584235';
        $attachment1 = '&#xf096;';
        $attachment2 = '&#xf096;';
        $att1_qty_case = ' ';
        $att1_qty_sheet = ' &nbsp;';
        $att2_qty_case = ' ';
        $att2_qty_sheet = ' ';
        if($data->attachment == 1){
            $attachment1 = '&#xf14a;';
            $att1_qty_case = $data->qty_case;
            $att1_qty_sheet = $data->qty_sheet;
        }else{
            $attachment2 = '&#xf14a;';
            $att2_qty_case = $data->qty_case;
            $att2_qty_sheet = $data->qty_sheet;
        }
        $output = 
        '<style>
        table {
            font-size: 18px;
            border-collapse: collapse;
            width:100%
        }
    
        table th, td {
            border: unset;
        }
        article {
            float: left;
            // width: 50%;
        }
    </style>
    <div>
        <article width="79.5%" style="background:rgb(219,219,219);border-radius: 15px;">
            <div align="center" style="font-size:20px;padding-top:5px;padding-bottom:-3px;"><b>แบบยื่นรายการภาษีเงินได้ ณ ที่จ่าย</b></div>
            <div align="center" style="font-size:15px;padding-top:-4px;padding-bottom:-2px;">ตามมาตรา 3 เตรส และมาตรา 69 ทวิ</div>
            <div align="center" style="font-size:15px;padding-top:-4px">และการเสียภาษีตามมาตรา 65 จัตวา แห่งประมวลรัษฎากร</div>
        </article>
        <article align="center" width="20%" style="float:right;font-size:50px;background:rgb(219,219,219);border-radius: 15px;padding:-5px 0;">
       <b>ภ.ง.ด.53</b>
       </article>
          <table width="100%" style="margin-top:5px;">
             <tr>
                 <td width="55%" align="left" style="border-bottom:0.5px solid #6d6d6d;border-right:0.5px solid #6d6d6d;">
                     <span align="left" style="font-size: 14px;"><b>เลขประจำตัวผู้เสียภาษีอากร(13หลัก)* </span>&nbsp;';
                     $bor = 0.5;
                     for($i=0;$i<strlen($data->deduct_tax_identification);$i++){
                         $bor = $bor+0.01;
                         $output .= '<span style="border: '.$bor.'px solid #6d6d6d;font-size: 15px;" >&nbsp;'.$data->deduct_tax_identification[$i].'&nbsp;</span>';
                         if(in_array($i,[0,4,9,11])){
                            $output .= '--';
                         }
                     }
                    //  <span style="float:rigth;" style="border: 1px solid #6d6d6d;" >&nbsp; &nbsp;</span>
                    $output .= '</b> <br>
                     <span style="font-size: 13px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<i>(ของผู้มีหน้าที่หักภาษี ณ ที่จ่าย)</i></span>
                
                     <br>
                     <br>
                     <span style="font-size: 17px;"> <b>ชื่อผู้มีหน้าที่หักภาษี ณ ที่จ่าย</b> <i>(หน่วยงาน)</i> :&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>สาขาที่</b></span>
                     <span style="border: 0.5px solid #6d6d6d;font-size: 15px;" > &nbsp; &nbsp;
                     </span><span style="border: 0.51px solid #6d6d6d;font-size: 15px;" > &nbsp; &nbsp;
                     </span><span style="border: 0.5px solid #6d6d6d;font-size: 15px;" > &nbsp; &nbsp;
                     </span><span style="border: 0.51px solid #6d6d6d;font-size: 15px;" > &nbsp; &nbsp;
                     </span><span style="border: 0.5px solid #6d6d6d;font-size: 15px;" >&nbsp;&nbsp; &nbsp;</span>
                     <br>
                     <span style="font-size: 17px;"> &nbsp; &nbsp;<b>'.$data->deduct_name.'</b></span>
                     <br>
                     <span style="font-size: 17px;"><b>ที่อยู่</b> : อาคาร &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ห้องเลขที่ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ชั้นที่ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; หมู่บ้าน</span>
                     <br>
                     <span style="font-size: 17px;">เลขที่ &nbsp;<b>'.$data->address_number.'</b>&nbsp; &nbsp; &nbsp; หมู่ที่ &nbsp;<b>'.$data->address_moo.'</b>&nbsp; &nbsp; &nbsp; ตรอก/ซอย &nbsp;<b>'.$data->address_alley.'</b></span>
                     <br>
                     <span style="font-size: 17px;">ถนน &nbsp; <b>'.$data->address_street.'</b>&nbsp; &nbsp; &nbsp;ตำบล/แขวง &nbsp;<b>'.$data->address_subdistrict.'</b></span>
                     <br>
                     <span style="font-size: 17px;">อำเภอ/เขต &nbsp;<b>'.$data->address_district.'</b>&nbsp; &nbsp; &nbsp; จังหวัด &nbsp;<b>'.$data->address_province.'</b></span>
                     <br>
                     <span style="font-size: 17px;">รหัสไปรษณีย์ &nbsp;<b>'.$data->address_zipcode.'</b>&nbsp; &nbsp; &nbsp; โทรศัพท์ &nbsp;<b>'.$data->phone.'</b></span>
                 </td>
                 <td width="45%" align="center" style="" >
                     <span style="width:500px;background:rgb(219,219,219);">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; นำส่งภาษีตาม &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span>
                     <br>
                     <br>
                     <span style="font-family:fontawesome;font-size: 15px;" class="fa">&#xf14a;</span> (1)&nbsp; มาตรา <b>3 เตรส </b>&nbsp; แห่งประมวลรัษฎากร
                     <br>
                     <input type="checkbox"> (2) มาตรา <b>65 จัตวา</b> แห่งประมวลรัษฎากร
                     <br>
                     <input type="checkbox"> (2)&nbsp; มาตรา <b>69 ทวิ </b>&nbsp; แห่งประมวลรัษฎากร
                     <hr>
                     <span style="font-family:fontawesome;font-size: 15px;" class="fa">&#xf14a;</span> ยื่น<b>ปกติ</b>&nbsp; &nbsp; &nbsp; &nbsp; 
                     <input type="checkbox"> ยื่น<b>เพิ่มเติม</b>ครั้งที่
                     <hr>
    
                 </td>
             </tr>
          </table>
          <table width="100%">
             <tr>
                 <td style="font-size:16px;border-bottom:0.5px solid #6d6d6d;border-right:0.5px solid #6d6d6d;" width="55%" align="left">
                     <span align="left" style=""><b>เดือนที่จ่ายเงินได้พึงประเมิน</b>(ให้ทำเครื่องหมาย <span style="font-family:fontawesome;" class="fa">&#xf14a; </span> ลงใน <span style="font-family:fontawesome;" class="fa">&#xf096; </span> หน้าชื่อเดือน) พ.ศ. <b>'.$year.'</b> <br></span>';
                     foreach($month as $key => $mo){
                        //  echo $key;
                        $check = $month_param==$key?"&#xf14a;":"&#xf096;";
                        $output .= '<span style="font-family:fontawesome;" class="fa">'.$check.' </span> ('.$key.') '.$mo;
                     }
                 $output .= '</td>
                 <td style="border-bottom: 0.5px solid #6d6d6d;vertical-align: bottom;" align="center">
                 <span style="" >สำหรับบันทึกข้อมูลรายระบบ TCL </span>
                 </td>
             </tr>
          </table>
          <table>
          <tr>
                 <td align="center" width="45%">
                     <span align="left" style="">มีรายละเอียดการหักเป็นรายผู้มีเงินได้<br> ปรากฏตามรายการที่แนบอย่างใดอย่างหนึ่ง ดังนี้</span>
                 </td>
                 <td align="left">
                 <br>
                 <span style=""><span style="font-family:fontawesome;font-size: 15px;" class="fa">&#xf14a;</span> <b>ใบแนบ ภ.ง.ด.53</b> ที่แนบมาพร้อมนี้: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; จำนวน &nbsp; &nbsp; &nbsp;'.count($shipping).'&nbsp; &nbsp; &nbsp;รายการ <br>
                 &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                 <span>จำนวน&nbsp; &nbsp; &nbsp;&nbsp;1 &nbsp; &nbsp; แผ่น</span><br>
                    &nbsp; &nbsp; &nbsp; หรือ<br><br>
                    <span style="font-family:fontawesome;font-size: 15px;" class="fa">&#xf096;</span> <b>สื่อบันทึกในคอมพิวเตอร์</b> ที่แนบมาพร้อมนี้:  &nbsp; &nbsp; &nbsp; จำนวน &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;รายการ <br>
                    &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                    <span>จำนวน &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;แผ่น</span><br>
                    &nbsp; &nbsp; &nbsp; <span style="font-size: 15px;"><i>(ตามหนังสือแสดงความประสงค์ ทะเบียนรับเลขที่..........................................................)</i></span>
                </span>
                 </td>
             </tr>
          </table>
          <div style="padding: 0 15%">
           <table>
            <tr>
                 <th width="70%" align="center" style="background:rgb(219,219,219);">
                    สรุปรายการภาษีที่นำส่ง
                 </th>
                 <th width="30%" align="center" style="border: 0.5px solid #6d6d6d">
                    จำนวนเงิน
                 </th>
            </tr>
            <tr>
                 <td align="left" style="padding-bottom:-4px;">
                    <b>1. รวม</b>ยอดเงินได้ทั้งสิ้น
                 </td>
                 <td align="right" style="font-size:20px;border:0.5px solid #6d6d6d;padding-bottom:-4px;">
                    <b>'.number_format($data->total_amount,2).'</b>
                 </td>
            </tr>
            <tr>
                 <td align="left" style="padding-bottom:-4px;">
                 <b>2. รวม</b>ยอดภาษีที่นำส่งทั้งสิ้น
                 </td>
                 <td align="right" style="font-size:20px;border:0.5px solid #6d6d6d;padding-bottom:-4px;">
                 <b>'.number_format($data->total_tax,2).'</b>
                 </td>
            </tr>
            <tr>
                 <td align="left" style="padding-bottom:-4px;">
                    3. เงินเพิ่ม (ถ้ามี)
                 </td>
                 <td align="right" style="font-size:20px;border:0.5px solid #6d6d6d;padding-bottom:-4px;">
                 <b>'.number_format($data->extra_money,2).'</b>
                 </td>
            </tr>
            <tr>
                 <td align="left" style="padding-bottom:-4px;">
                    <b>4. รวม</b>ยอดภาษีที่นำส่งทั้งสิ้น และเงินเพิ่ม (2. + 3.)
                 </td>
                 <td align="right" style="font-size:20px;border:0.5px solid #6d6d6d;padding-bottom:-4px;">
                 <b>'.number_format($data->total_tax_delivered,2).'</b>
                 </td>
            </tr>
          </table>
        </div>
        <hr>

        <table>
         <tr>
              <td style="font-size: 18px;" align="center">
              <span>ข้าพเจ้าขอรับรองว่า รายการที่แจ้งไว้ข้างต้นนี้ เป็นรายการที่ถูกต้องและครบถ้วนทุกประการ</span><br>
              <span>ลงชื่อ....................................................................................ผู้จ่ายเงิน</span><br>
              <span>(.........................................................)</span><br>
              <span>ตำแหน่ง <b>เจ้าหน้าที่การเงิน</b></span><br>
              <span>ยื่นวันที่ เดือน พ.ศ.</span>
              </td>
         </tr>
         <tr>
              <td style="font-size: 15px;vertical-align: top;" align="right">
                <hr>
              (ก่อนกรอกรายการ ดูคำชี้แจงด้านหลัง)
              </td>
         </tr>
         <tr>
              <td style="font-size: 15px;">
              <u>หมายเหตุ</u> เลขประจำตัวผู้เสียภาษีอากร(13หลัก)* หมายถึง<br>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;1.กรณีบุคคลธรรมดา ให้ใช้เลขประจำตัวประชาชนที่กรมการปกครองออกให้<br>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2.กรณีนิติบุคคล ให้ใช้เลขทะเบียนนิติบุคคลที่กรมพัฒนาธุรกิจการค้าออกให้<br>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2.กรณีอื่นๆนอกเหนือจาก 1.และ2. ให้ใช้เลขประจำตัวภาษีอากร (13)หลักที่กรมสรรพากรออกให้<br>
              </td>
         </tr>
         <tr>
              <td style="font-size: 18px;">
              <br>
              <i>สอบถามข้อมูลเพิ่มเติมได้ที่ศูนย์บริการข้อมูลสรรพากร</i> RD Call Center <i>โทร. 1161</i>
              </td>
         </tr>
       </table>
    </div>';
    
        $output2 = '<style>
                table {
                    font-size: 14px;
                    border-collapse: collapse;
                    width:100%;
                }
                table th, td {
                    border: 0.5px solid #6d6d6d;
                }
                article {
                    float: left;
                    // width: 50%;
                    font-size: 14px;
                }
                // div {
                //     border: 0.5px solid #6d6d6d;
                //     height:85%;

                // }
            </style>
                <article width="35%" style="">
                    ใบต่อ ภ.ง.ด.53 <b>สำหรับเดือน '.$month2[$month_param].' '.$year.'</b> <br>
                    <b>เลขประจำตัวผู้เสียภาษีอากร (ของผู้จ่ายเงินได้) 13 หลัก '.$data->deduct_tax_identification.'</b>
                </article>
                <article style="">
            <b>แบบยื่นรายงานภาษีเงินได้หัก ณ ที่จ่าย ตามมาตรา 3 เตรส และมาตรา 69 ทวิ แห่งประมวลรัษฎากร<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ชื่อผู่จ่ายเงินได้ซึ่งมีหน้าที่หักภาษี ณ ที่จ่าย</b> ITALYAI INDUSTRIAL CO.,LTD<br><br>
            </article>
            <div>
            <table>
                    <tr>
                        <th align="center" style="font-size: 13px;">
                        ลำดับที่
                        </th>
                        <th align="center" style="font-size: 13px;padding-top:4px;" >
                        ชื่อผู้รับเงินได้พึงประเมิน <br>
                        ( ให้ระบุว่าเป็นบริษัทจำกัด ห้างหุ้นส่วนจำกัด หรือห้างหุ่นส่วนสามัญนิติบุคคล ) <br>
                        ที่อยู่ของผู้รับเงินได้พึงประสงค์ <br>
                        (ให้ระบุ เลขที่ ตรอก/ซอย ถนน ตำบล/แขวง อำเภอ/เขต จังหวัดโดยละเอียด) <br>
                        </th>
                        <th align="center" style="font-size: 13px;" >
                        วัน เดือน ปี
                        </th>
                        <th align="center" style="font-size: 13px;" >
                        รายละเอียดการจ่ายเงินได้พึงประเมิน<br>ปรเภทเงินได้พึงประเมินที่จ่าย
                        </th>
                        <th align="center" style="font-size: 13px;" >
                        จำนวนเงินที่จ่าย
                        </th>
                        <th align="center" style="font-size: 13px;" >
                        จำนวนเงินภาษี<br>ที่นำส่งต่ออำเภอ
                        </th>
                    </tr>';
            $output2 .= '<tr>
                        <td align="center" style="vertical-align: top; height:480px;border-bottom: unset;">';
                        
                    $num = 1;
                    foreach ($shipping as $fi) { 
                        $output2 .= $num++.'<br><br>';
                    }
            $output2 .= '</td>
                        <td style="vertical-align: top;border-bottom: unset;" >
                        ';
                        foreach ($shipping as $fi) { 
                            $output2 .= $fi->deduct_name.' (Tax ID'.$fi->deduct_tax_identification.') <br>
                            '.$fi->address_number.' '.$fi->address_moo.' '.$fi->address_alley.' '.$fi->address_street.' '.$fi->address_subdistrict.' '.$fi->address_district.' '.$fi->address_province.' '.$fi->address_zipcode.' <br>';
                        }
                        
            $output2 .= '</td>
                        <td align="center" style="vertical-align: top;border-bottom: unset;" >';
                        foreach ($shipping as $fi) { 
                            $output2 .= date('d/m/Y',strtotime($fi->created_at)).'<br><br>';
                        }
            $output2 .= '</td>
                        <td align="center" style="vertical-align: top;border-bottom: unset;" >';
                        foreach ($shipping as $fi) { 
                            $output2 .= 'ค่าบริการ<br><br>';
                        }
            $output2 .= '</td>
                        <td align="right" style="vertical-align: top;" >';
                        $all_pay_price = 0;
                        foreach ($shipping as $fi) { 
                            $output2 .= number_format($fi->pay_price, 2).'&nbsp;<br><br>';
                            $all_pay_price = $fi->pay_price+$all_pay_price;
                        }
            $output2 .= '</td>
                        <td align="right" style="vertical-align: top;" >';
                        $all_pay_tax = 0;
                        foreach ($shipping as $fi) { 
                            $output2 .= number_format($fi->pay_tax, 2).'&nbsp;<br><br>';
                            $all_pay_tax = $fi->pay_tax+$all_pay_tax;
                        }
            $output2 .= '
            </td>
            </tr>
            <tr>
            <td style="border-top: unset;">
            </td>
            <td style="border-top: unset;">
            รวมยอดเงินได้และภาษีที่นำส่ง (ยกไปรวมกับแผ่นแรก)
            </td>
            <td style="border-top: unset;">
            </td>
            <td style="border-top: unset;">
            </td>
            <td align="right" style="">
            '.number_format($all_pay_price, 2).'&nbsp;
            </td>
            <td align="right" style="">
            '.number_format($all_pay_tax, 2).'&nbsp;
            </td>
            </tr>
            </table>
            <p style="font-size: 14px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;ลงชื่อ________________________ผู้จ่ายเงิน ตำแหน่ง_____เจ้าหน้าที่การเงิน________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            ยื่นวันที่ เดือน พ.ศ.</p>
            </div>';
    
    $mpdf->debug = true;
    $mpdf->AddPage();
    $mpdf->WriteHTML($output);
    $mpdf->AddPage('L');
    $mpdf->WriteHTML($output2);
        // $mpdf->Output();
        return $mpdf;
    }

}
