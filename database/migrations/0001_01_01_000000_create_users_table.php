<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Birincil anahtar
            $table->string('name'); // Kullanıcı adı
            $table->string('email')->unique(); // E-posta adresi (uniques)
            $table->string('ethereum_address')->unique()->nullable(false); // Ethereum adresi
            $table->timestamp('email_verified_at')->nullable(); // E-posta doğrulama zamanı (isteğe bağlı)
            $table->string('password'); // Şifre
            $table->rememberToken(); // Remember me token
            $table->timestamps(); // Oluşturulma ve güncellenme zamanları
        });

        // Şifre sıfırlama için tokenlar tablosu
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // E-posta adresi
            $table->string('token'); // Token
            $table->timestamp('created_at')->nullable(); // Token oluşturulma zamanı
        });

        // Kullanıcı oturumları tablosu
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Oturum ID'si
            $table->foreignId('user_id')->nullable()->index(); // Kullanıcı ilişkisi
            $table->string('ip_address', 45)->nullable(); // IP adresi
            $table->text('user_agent')->nullable(); // Kullanıcı ajansı
            $table->longText('payload'); // Oturum yükü
            $table->integer('last_activity')->index(); // Son aktivite zamanı
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
