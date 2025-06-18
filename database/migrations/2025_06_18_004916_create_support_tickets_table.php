<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('message');
            $table->enum('type', collect(\App\Enums\TicketType::cases())->pluck('value')->toArray());
            $table->enum('type_status', collect(\App\Enums\TypeStatus::cases())->pluck('value')->toArray());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
