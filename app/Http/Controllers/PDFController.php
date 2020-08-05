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
    public function index()
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 16,
            'default_font' => 'sarabun'
        ]);
        $output = "การเดินทาง";
        
        $mpdf->debug = true;
        $mpdf->AddPage();
        $mpdf->WriteHTML($output);
        $mpdf->Output();
    }

}
