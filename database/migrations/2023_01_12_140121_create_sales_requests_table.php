<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\SalesRequest;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->float('price');
            $table->text('description');
            $table->enum('status', SalesRequest::statuses())->default(SalesRequest::STATUS_PENDING);
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
        Schema::dropIfExists('sales_requests');
    }
};
