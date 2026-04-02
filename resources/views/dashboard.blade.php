<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Toko CBG</title>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="dashboard-page">

<nav class="navbar">
    {{-- BAGIAN LOGO: Dipastikan hanya satu teks --}}
    <div style="display: flex; align-items: center; gap: 12px;">
        @if(file_exists(public_path('img/logo.png')))
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height: 35px; width: auto;">
        @else
            <i class="fa-solid fa-store" style="font-size: 22px; color: #f1c40f;"></i>
        @endif
        
        <h2 style="margin: 0; font-weight: bold; letter-spacing: 1px;">Toko CBG</h2>
    </div>
    
    <div>
        <span>Halo, <strong>{{ auth()->user()->name }}</strong> 
            @php
                $role = strtolower(auth()->user()->role);
                $roleColor = '#3498db'; 
                if($role == 'admin') $roleColor = '#e74c3c'; 
                if($role == 'bos') $roleColor = '#8e44ad'; 
            @endphp
            <span class="badge-role" style="background: {{ $roleColor }}; color: white; padding: 3px 10px; border-radius: 5px; margin-left: 5px; font-size: 12px; font-weight: bold;">
                {{ strtoupper($role ?? 'USER') }}
            </span>
        </span>
        
        <form method="POST" action="{{ route('logout') }}" style="display:inline; margin-left: 15px;">
            @csrf
            <button type="submit" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </form>
    </div>
</nav>

<div class="dashboard-container">
    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="header">
        <h1>Selamat Datang 👋</h1>
        <p>Aplikasi Inventaris barang berbasis website.</p>
    </div>

    <div class="card-container">
        <div class="card">
            <i class="fa-solid fa-users icon-card"></i>
            <h3>Total User</h3>
            <p>{{ $totalUser ?? 0 }}</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-box-open icon-card"></i>
            <h3>Total Barang</h3>
            <p>{{ $totalProduct ?? 0 }}</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-shield-halved icon-card"></i>
            <h3>Status AES</h3>
            <p style="color: #2ecc71;">Aktif</p>
        </div>
    </div>

    <div class="dashboard-grid">
        {{-- SISI KIRI: DAFTAR BARANG --}}
        <div class="project-list-wrapper">
            <h2 style="margin-bottom: 20px;"><i class="fa-solid fa-list"></i> Daftar Barang</h2>
            
            @forelse($products as $product)
                <div class="project-item">
                    <div style="flex: 1;">
                        <strong class="project-title">{{ $product->name }}</strong>
                        <small class="project-desc">Harga: Rp{{ number_format($product->price, 0, ',', '.') }} | Stok: {{ $product->stock }}</small>
                        
                        <div class="aes-visual-box">
                            <small class="text-muted"><i class="fa-solid fa-lock"></i> Encrypted (DB):</small>
                            <code class="aes-code">{{ Str::limit($product->getRawOriginal('name'), 30) }}</code>
                            <br>
                            <small class="text-success"><i class="fa-solid fa-lock-open"></i> Decrypted (View):</small>
                            <span class="text-success">{{ $product->name }}</span>
                            
                            {{-- PENAMBAHAN INFO SPEED ENKRIPSI --}}
                            <div style="margin-top: 8px; padding-top: 5px; border-top: 1px dashed #ddd; background: #f9f9f9; padding: 5px; border-radius: 4px;">
                                <small style="color: #8e44ad; font-weight: bold; display: block;">
                                    <i class="fa-solid fa-bolt"></i> Waktu Enkripsi: 
                                    @if($product->encryption_time > 0)
                                    {{ number_format($product->encryption_time, 6) }} ms
                                    @else
                                    <span style="color: #e74c3c;">Terlalu Cepat (< 0.000001 ms)</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->role == 'admin')
                    <div class="action-buttons">
                        <a href="/products/{{ $product->id }}/edit" class="btn-edit"><i class="fa-solid fa-pen"></i></a>
                        <form action="/products/{{ $product->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                    @endif
                </div>
            @empty
                <p class="text-center">Belum ada data barang.</p>
            @endforelse
        </div>

        {{-- SISI KANAN: FORM / INFO BOX --}}
        <div class="right-column">
            @if(auth()->user()->role == 'admin')
                <div class="form-section">
                    <h2><i class="fa-solid fa-plus-circle"></i> Tambah Barang</h2>
                    <form method="POST" action="/products">
                        @csrf
                        <label>Nama Barang</label>
                        <input type="text" name="name" placeholder="Contoh: Oli Mesin" required>
                        <div style="display: flex; gap: 10px;">
                            <div style="flex: 2;">
                                <label>Harga</label>
                                <input type="number" name="price" placeholder="Rp" required>
                            </div>
                            <div style="flex: 1;">
                                <label>Stok</label>
                                <input type="number" name="stock" placeholder="0" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-submit">Simpan ke Database (Encrypted)</button>
                    </form>
                </div>
            @elseif(auth()->user()->role == 'bos')
                <div class="view-only-box" style="border: 2px dashed #8e44ad; background: #f4ecf7; padding: 20px; border-radius: 12px;">
                    <h3 style="color: #8e44ad;"><i class="fa-solid fa-user-tie"></i> Mode Owner (Bos)</h3>
                    <p>Anda memantau inventaris secara real-time. Seluruh data nama barang dienkripsi dengan algoritma AES-256 demi keamanan database.</p>
                </div>
            @else
                <div class="view-only-box">
                    <h3><i class="fa-solid fa-user-shield"></i> Mode Staff</h3>
                    <p>Anda hanya dapat melihat daftar barang yang telah terenkripsi.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- TABEL USER --}}
    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'bos')
        <div class="user-list-section" style="margin-top: 40px; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <h2 style="margin-bottom: 20px; color: #2c3e50;">
                <i class="fa-solid fa-users-gear"></i> 
                {{ auth()->user()->role == 'bos' ? 'Daftar Karyawan Toko' : 'Manajemen Pengguna Sistem' }}
            </h2>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th style="padding: 15px; border-bottom: 2px solid #eee;">Nama Pengguna</th>
                            <th style="padding: 15px; border-bottom: 2px solid #eee;">Email</th>
                            <th style="padding: 15px; border-bottom: 2px solid #eee;">Otoritas (Role)</th>
                            <th style="padding: 15px; border-bottom: 2px solid #eee;">Terdaftar Pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;"><strong>{{ $user->name }}</strong></td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;">{{ $user->email }}</td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;">
                                @php
                                    $uRole = strtolower($user->role);
                                    $uColor = $uRole == 'admin' ? '#e74c3c' : ($uRole == 'bos' ? '#8e44ad' : '#3498db');
                                @endphp
                                <span style="background: {{ $uColor }}; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">
                                    {{ strtoupper($uRole) }}
                                </span>
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee; color: #666;">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div> 

</body>
</html>