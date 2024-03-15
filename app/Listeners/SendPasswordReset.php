<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\PasswordReseting;
use Illuminate\Support\Facades\Auth;


class SendPasswordReset implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.`
     */
    public function handle(UserCreated $event): void
    {
        $user = $event->user->user;
        if(isset($user->password)){
            Auth::login($user);
            return;
        }
        $user->notify(new PasswordReseting($user));
    }
}
