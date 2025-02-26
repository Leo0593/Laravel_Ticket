<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketPDFMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        $pdf = Pdf::loadView('layouts.tickets.ticketPDF', ['ticket' => $this->ticket]);
        return $this->subject('Tu Ticket PDF')
                    ->view('layouts.tickets.mensajeTickect')
                    ->attachData($pdf->output(), 'ticket_' . $this->ticket->id . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
