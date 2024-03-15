<?php

namespace App\Listeners;

use App\Events\UserSocialUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserSocialSignIn implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserSocialUpdated $event): void
    {
        $user = $event->user->user;
        Auth::login($user);
        return;
    }
}
