<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang - Toko CBG</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body style="padding: 50px; background: #f4f7f6;">
    <div style="max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h2><i class="fa-solid fa-pen-to-square"></i> Edit Barang</h2>
        <hr>
        <form method="POST" action="/products/{{ $product->id }}">
            @csrf
            @method('PUT')
            
            <label>Nama Barang</label>
            <input type="text" name="name" value="{{ $product->name }}" required style="width: 100%; padding: 10px; margin: 10px 0;">
            
            <label>Harga</label>
            <input type="number" name="price" value="{{ $product->price }}" required style="width: 100%; padding: 10px; margin: 10px 0;">
            
            <label>Stok</label>
            <input type="number" name="stock" value="{{ $product->stock }}" required style="width: 100%; padding: 10px; margin: 10px 0;">
            
            <button type="submit" style="background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; width: 100%; margin-top: 15px;">Simpan Perubahan</button>
            <a href="/dashboard" style="display: block; text-align: center; margin-top: 15px; color: #777; text-decoration: none;">Batal</a>
        </form>
    </div>
</body>
</html>