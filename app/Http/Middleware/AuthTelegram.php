<?php

namespace App\Http\Middleware;

use App;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class AuthTelegram
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $updates = Telegram::getWebhookUpdates();
        $from = $updates->getMessage()->get('from');

        $user = User::find($from->id);
        if (! ($user instanceof User)) {
            $user = User::create([
                'id' => $from->id,
                'first_name' => $from->first_name,
                'last_name' => $from->last_name,
                'username' => $from->username,
            ]);
        }

        app()->instance(User::class, $user);

        return $next($request);
    }
}
