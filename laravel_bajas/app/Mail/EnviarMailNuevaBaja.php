<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use Illuminate\Mail\Mailables\Address;


class EnviarMailNuevaBaja extends Mailable
{
    use Queueable, SerializesModels;

    /*
      Create a new message instance.
     
    public function __construct()
    {
        //
    }
    */

    public array $datosEmail; // Añado esta propiedad para almacenar los datos

    /**
     * Create a new message instance.
     */
    public function __construct(array $datosEmail) // Recibe los datos aquí
    {
        $this->datosEmail = $datosEmail; // Almacena los datos en la propiedad
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('analiangxin@gmail.com', 'Ana'),
            subject: 'Nueva Baja Registrada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.mailBaja',
            with: ['bajaNueva' => $this->datosEmail]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
