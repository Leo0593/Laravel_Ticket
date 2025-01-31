<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\M_Tickets;

class C_Qr extends Controller
{
    public function generarQr($id)
    {
        // Buscar el ticket en la base de datos
        $ticket = Ticket::findOrFail($id);

        // Generar un código aleatorio: 1 letra + 9 dígitos
        $codigo = chr(rand(65, 90)) . rand(100000000, 999999999);

        // Generar la URL a la que redirigirá el QR
        $url = url('/ticket/' . $ticket->id . '/' . $codigo);

        // Generar el código QR
        $qrCode = QrCode::size(200)->generate($url);

        // Guardar el código QR en el ticket (opcional)
        $ticket->qr = $qrCode;
        $ticket->save();

        return response()->json([
            'success' => true,
            'url' => $url
        ]);

        // Pasar el QR y el código a la vista
        //return view('qr', compact('qrCode', 'codigo'));

        // Generar QR
        // 1 letra, 9 digitos

        // id Ticket
        // SELECT * QR_VALIDO = 1

        // Vista que seleccione los datos del id del Ticket
    }
}
