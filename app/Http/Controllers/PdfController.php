<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use PDF;

class PdfController extends Controller
{
    public function pdf_recibo(Request $request){

        $data = $request->all();
        $data['fecha'] = new DateTime($data['fecha']);
        $pdf = PDF::loadView('ventas.pdf', $data);
        $pdf->setPaper(array(0, 0, 595.275, 439.37), 'portrait');
        return $pdf->download('factura.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
