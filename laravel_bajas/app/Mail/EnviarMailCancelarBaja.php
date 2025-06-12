<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use Illuminate\Mail\Mailables\Address;

class EnviarMailCancelarBaja extends Mailable
{
    use Queueable, SerializesModels;


    public array $datosEmailCancelar; // Añado esta propiedad para almacenar los datos

    /**
     * Create a new message instance.
     */
    public function __construct(array $datosEmailCancelar) 
    {
        $this->datosEmailCancelar = $datosEmailCancelar; 
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('analiangxin@gmail.com', 'Ana'),
            subject: 'Se ha cancelado una baja',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.mailBajaCancelar',
            with: ['bajaCancelar' => $this->datosEmailCancelar]
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
