<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public string $name,
        public string $purpose = 'activate'
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->purpose === 'register'
            ? 'Verifikasi Pendaftaran Akun - SAPA BK SMAN 4 Jember'
            : 'Verifikasi Aktivasi Akun Siswa - SAPA BK SMAN 4 Jember';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.otp_verification');
    }

    public function attachments(): array
    {
        return [];
    }
}
