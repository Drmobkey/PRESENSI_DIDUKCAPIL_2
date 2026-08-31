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
        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('tpdk_id')->nullable()->constrained('tpdk')->cascadeOnDelete();
            $table->date('date');
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->decimal('lat_in', 10, 8)->nullable();
            $table->decimal('long_in', 11, 8)->nullable();
            $table->string('photo_in')->nullable();
            $table->string('photo_out')->nullable();
            $table->enum('status', ['hadir', 'alpa', 'izin', 'sakit', 'cuti', 'dinas_luar'])->default('hadir')->after('date');
            $table->boolean('is_late')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
