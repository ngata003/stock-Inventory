<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class suggestions extends Mailable
{
    use Queueable, SerializesModels;

    private $nom_admin;
    private $nom_boutique;
    private $suggestion;

    /**
     * Create a new message instance.
     */
    public function __construct($nom_admin , $nom_boutique , $suggestion)
    {
        //
        $this->nom_admin = $nom_admin;
        $this->nom_boutique = $nom_boutique;
        $this->message = $suggestion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Suggestions',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'SuperAdmin.suggestions_mail',
            with:[
                'nom_admin' => $this->nom_admin,
                'nom_boutique' => $this->nom_boutique,
                'suggestion' => $this->suggestion,
            ]
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
