<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE_NAME = 'settings';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('document_type');
            $table->string('document_format');
            $table->foreignId('user_id');
            $table->jsonb('settings');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['document_type', 'document_format', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
