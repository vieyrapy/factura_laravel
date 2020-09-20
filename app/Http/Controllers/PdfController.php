<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    public function pdf_recibo(Request $request){

        $CONVERSION_CM_PT = 28.3464;
        $cm_alto = 15.5;
        $cm_ancho = 21;
        $data = $request->all();
        $data['fecha'] = new DateTime($data['fecha']);
        $pdf = PDF::loadView('ventas.pdf', $data);
        $pdf->setPaper(array(0, 0, $cm_ancho * $CONVERSION_CM_PT, $cm_alto * $CONVERSION_CM_PT), 'portrait');
        return $pdf->download('factura.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
