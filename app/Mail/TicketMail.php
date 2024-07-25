<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

use App\Helpers\TicketHelper;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $bookingNo;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData, $bookingNo = null)
    {
        $this->mailData = $mailData;
        $this->bookingNo = $bookingNo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-replay@andamanexpress.com', 'Tigerline Ferry'),
            subject: 'Tigerline Ferry Booking Confirmation (Ticket Number : '. $this->mailData['ticketno'] .').',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.ticket',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if($this->bookingNo != null) {
            $t = new TicketHelper();
            $t->makePdf($this->bookingNo);

            return [
                Attachment::fromStorageDisk('attachments', $this->bookingNo.'.pdf')
                    ->as('ticket.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}
