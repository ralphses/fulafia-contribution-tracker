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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // staff/student
            $table->foreignId('user_contribution_id')->constrained()->onDelete('cascade'); // scheme it's under

            $table->decimal('amount', 10);
            $table->date('contributed_at');
            $table->text('note')->nullable();

            $table->string('receipt_path')->nullable();
            $table->enum('status', Utils::STATUSES)->default(Utils::STATUS_ACTIVE);
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
