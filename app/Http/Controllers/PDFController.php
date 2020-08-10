<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function AWB($data)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 16,
            'default_font' => 'sarabun'
        ]);
        // return explode('',$data->deduct_tax_identification);
        $output = '
                <style>
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
                             <th width="55%" align="left" style="padding-top:-4px;">
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
                                 <span align="left" style="font-size: 13px">&nbsp;&nbsp;ที่อยู่ &nbsp; </span><span  style="font-size: 16px" >'.$data->deduct_address.'</span>
                                 <br>
                                 <span align="left" style="font-size: 13px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(ให้ระบุ เลขที่ ตรอก/ซอย หมู่ที่ ตำบล/แขวง อำเภอ/ตำบล จังหวัด และเบอร์โทรศัพท์)</span>
                             </th>
                             <th width="45%" align="left" >
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
                                <input type="checkbox">&nbsp; (1) ภ.ง.ด. 1ก. &nbsp; &nbsp; &nbsp; <input type="checkbox">&nbsp; (2) ภ.ง.ด. 1ก. พิเศษ &nbsp; &nbsp; &nbsp; <input type="checkbox">&nbsp; (3) ภ.ง.ด. 2 &nbsp; &nbsp; &nbsp; <input type="checkbox">&nbsp; (4) ภ.ง.ด. 3 &nbsp; &nbsp; &nbsp; <br><input type="checkbox">&nbsp; (5) ภ.ง.ด. 2ก. &nbsp; &nbsp; &nbsp; <input type="checkbox">&nbsp; (6) ภ.ง.ด. 3ก. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type="checkbox">&nbsp; (7) ภ.ง.ด. 53
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
                                 <span align="left" style="font-size: 16px"><input size="3">&nbsp;&nbsp;ผออกภาษีให้ครั้งเดียว</span><br>
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
</div>
                    ';

        $mpdf->debug = true;
        $mpdf->AddPage();
        $mpdf->WriteHTML($output);
        $mpdf->Output();
    }

}
