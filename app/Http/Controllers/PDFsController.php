<?php

namespace App\Http\Controllers;
use PDF;

use Illuminate\Http\Request;

class PDFsController extends Controller
{

    public function convenio(){
        $pdf = PDF::loadView('pdfs.convenio');
        return $pdf->download('convenio.pdf');
    }
    
    public function rescisao(){
        $pdf = PDF::loadView('pdfs.rescisao');
        return $pdf->download('rescisao.pdf');
    }

    public function aditivo(){
        $pdf = PDF::loadView('pdfs.aditivo');
        return $pdf->download('aditivo.pdf');

    public function renovacao(){
        $pdf = PDF::loadView('pdfs.renovacao');
        return $pdf->download('renovacao.pdf');
    }

    public function termo(){
        $pdf = PDF::loadView('pdfs.termo');
        return $pdf->download('termo.pdf');

    }
}
