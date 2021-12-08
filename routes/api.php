<?php

use App\Bot\Messages\ContactMessage;
use App\Bot\Messages\QueueJoinMessage;
use App\Http\Controllers\TestController;
use App\Http\Middleware\AuthTelegram;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', TestController::class);

Route::get('set-webhook', function (Request $request) {
    $bot = Telegram::getBotConfig();
    Telegram::setWebhook(['url' => $bot['webhook_url']]);
    dd(route('telegram.webhook', ['token' => $bot['token']]));
});

Route::post('/{token}/webhook', function () {
    $update = Telegram::commandsHandler(true);
    $message = $update->getMessage();
    // $from = $message->get('from');
    $chat = $message->get('chat');
    $contact = $message->get('contact');

    $user = resolve(User::class);

    $callbacks = [
        'Встать в очередь' => QueueJoinMessage::class,
    ];

    if ($contact) {
        $user->phone = $contact->phone_number;
        $user->save();
        app()->instance(User::class, $user);

        $message = new ContactMessage();
        $response = Telegram::sendMessage($message->get($chat->id));
    } else {
        $text = $message->text;
        if (isset($callbacks[$text])) {
            $message = new $callbacks[$text];
            $response = Telegram::sendMessage($message->get($chat->id));
        }
    }

    // Commands handler method returns an Update object.
    // So you can further process $update object
    // to however you want.

    return 'ok';
})->middleware(AuthTelegram::class)->name('telegram.webhook');

Route::get('/transaction/{transaction}', function (Request $request, Transaction $transaction) {
    $transaction->confirm();

    return 'Успешно';
})->name('transaction');
