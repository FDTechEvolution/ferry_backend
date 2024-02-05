<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;

class EmailHelper {
    public static function ticket() {
        $mailData = [
            'title' => 'Test Send Email',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
        ];

        Mail::to('nauthiz.fdtech@gmail.com')->send(new TicketMail($mailData));
    }
}
