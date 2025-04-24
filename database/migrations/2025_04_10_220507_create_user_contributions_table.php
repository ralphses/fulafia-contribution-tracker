<?php

use App\Utils\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_contributions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('contribution_scheme_id')->constrained('contribution_schemes');
            $table->double('total_amount');
            $table->enum('withdrawal_status', Utils::WITHDRAWAL_STATUSES)->default(Utils::class::WITHDRAWAL_STATUS_REQUESTED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_contributions');
    }
};
