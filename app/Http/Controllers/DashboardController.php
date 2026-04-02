<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product; 
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data barang & user
        $products = Product::all(); 
        $users = User::all(); 

        // 2. Hitung statistik untuk kartu (Cards)
        $totalUser = User::count();
        $totalProduct = Product::count();

        // 3. Kirim data ke view dashboard.blade.php
        return view('dashboard', compact('products', 'users', 'totalUser', 'totalProduct'));
    }

    // FUNGSI SIMPAN BARANG + HITUNG WAKTU ENKRIPSI
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // --- MULAI HITUNG WAKTU ---
        $startTime = microtime(true);

        // Buat data (Enkripsi otomatis terjadi di Model Product)
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        // --- STOP HITUNG WAKTU ---
        $endTime = microtime(true);
        $duration = ($endTime - $startTime) * 1000; // Konversi ke Milidetik (ms)

        // Simpan hasil durasi ke database
        $product->update(['encryption_time' => $duration]);

        return redirect()->route('dashboard')->with('success', 'Barang dienkripsi dalam ' . round($duration, 4) . ' ms');
    }

    // FUNGSI UPDATE BARANG + HITUNG WAKTU ENKRIPSI
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);

        // --- MULAI HITUNG WAKTU ---
        $startTime = microtime(true);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        // --- STOP HITUNG WAKTU ---
        $endTime = microtime(true);
        $duration = ($endTime - $startTime) * 1000; // konversi ke milidetik (ms)

        // Update hasil durasi
        $product->update(['encryption_time' => $duration]);

        return redirect()->route('dashboard')->with('success', 'Data diperbarui & dienkripsi ulang dalam ' . round($duration, 4) . ' ms');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Barang berhasil dihapus.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('edit-product', compact('product'));
    }
}