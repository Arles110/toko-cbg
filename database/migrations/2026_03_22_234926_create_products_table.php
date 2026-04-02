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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->text('name');  // OK
        $table->text('price'); // UBAH DARI integer KE text
        $table->text('stock'); // UBAH DARI integer KE text
        $table->double('encryption_time')->nullable(); // TAMBAHKAN INI agar tidak error di Controller
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
