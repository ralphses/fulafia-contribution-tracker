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

        Schema::create('contribution_schemes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Monthly Dues, Welfare, Building Fund
            $table->dateTime('payment_date'); // e.g., Monthly Dues, Welfare, Building Fund
            $table->double('penalty_fee'); // e.g., Monthly Dues, Welfare, Building Fund
            $table->enum('type', Utils::TYPES); // e.g., recurring, one-time
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // user who created the scheme
            $table->foreignId('corperative_id')->constrained('corperatives')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status', Utils::STATUSES)->default(Utils::STATUS_ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribution_schemes');
    }
};
