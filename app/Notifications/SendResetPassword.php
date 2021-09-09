<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword;

class SendResetPassword extends ResetPassword implements ShouldQueue
{
    use Queueable;
}
