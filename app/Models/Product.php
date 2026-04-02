<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Tentukan kolom mana saja yang boleh diisi (Mass Assignment)
    protected $fillable = ['name', 'price', 'stock', 'encryption_time'];

    /**
     * Fitur Casts: Otomatis Enkripsi AES
     * Laravel menggunakan AES-256-CBC secara default menggunakan APP_KEY kamu.
     */
    protected $casts = [
    'name'  => 'encrypted',
    'price' => 'encrypted',
    'stock' => 'encrypted',
    ];
}