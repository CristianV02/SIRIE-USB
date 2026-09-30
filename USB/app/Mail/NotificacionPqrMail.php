<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionPqrMail extends Mailable
{
    use Queueable, SerializesModels;

    public $detalles;

    public function __construct($detalles)
    {
        $this->detalles = $detalles;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->detalles['asunto'] ?? 'Notificación Institucional - USB',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notificacion_pqr', // Vista Blade del correo
        );
    }
}
