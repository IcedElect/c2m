<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('user_id');
            $table->foreignId('queue_id')->nullable();
            $table->enum('type', array_keys(Transaction::TYPES));
            $table->decimal('amount')->default(Transaction::DEFAULT_AMOUNT);
            $table->string('currency')->default('RUB');
            $table->enum('status', array_keys(Transaction::STATUSES))->default(Transaction::STATUSES['pending']);
            $table->jsonb('payload')->default(json_encode(new stdClass()));
            $table->jsonb('result')->default(json_encode(new stdClass()));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
