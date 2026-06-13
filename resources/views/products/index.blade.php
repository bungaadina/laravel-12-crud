<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Kamar Dagang - Laravel 12</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-brand-custom {
            font-weight: 700;
            color: #2c3e50 !important;
            letter-spacing: 0.5px;
        }
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }
        .table-custom thead {
            background-color: #4f46e5;
            color: #ffffff;
        }
        .table-custom th {
            font-weight: 600;
            padding: 15px;
            border: none;
        }
        .table-custom td {
            padding: 15px;
            vertical-align: middle;
        }
        .product-img {
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .product-img:hover {
            transform: scale(1.05);
        }
        .badge-stock {
            padding: 6px 12px;
            border-radius: 30px;
            font-weight: 500;
        }
        .btn-action {
            border-radius: 8px;
            padding: 6px 12px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom" href="{{ route('products.index') }}">
                <i class="fa-solid fa-boxes-stacked text-primary me-2"></i>SIJA_STORE
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto mt-2 mt-lg-0">
                    <span class="navbar-text d-none d-md-inline-block">
                        <i class="fa-regular fa-calendar me-1"></i> {{ date('l, d F Y') }}
                    </span>
                </div>

                <div class="navbar-nav align-items-center gap-3 mt-2 mt-lg-0">
                    <span class="fw-semibold text-secondary">
                        <i class="fa-solid fa-user-circle me-1 text-primary"></i> 
                        {{ Auth::user()->name }}
                    </span>
                    
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                
                <div class="card card-custom">
                    <div class="card-body p-4">
                        
                        <div class="row g-3 mb-4 align-items-center">
                            <div class="col-lg-6 d-flex flex-wrap gap-2">
                                <a href="{{ route('products.create') }}" class="btn btn-success btn-action px-3">
                                    <i class="fa-solid fa-plus me-2"></i>Tambah Produk
                                </a>
                                <a href="{{ route('products.export-pdf') }}" class="btn btn-outline-danger btn-action px-3">
                                    <i class="fa-solid fa-file-pdf me-2"></i>Ekspor PDF
                                </a>
                            </div>
                            
                            <div class="col-lg-5 ms-auto">
                                <form action="{{ route('products.index') }}" method="GET" class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control border-start-0 ps-0 text-sm" placeholder="Cari aset produk Anda..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary px-4 btn-action" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">Cari</button>
                                    @if(request('search'))
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-action ms-2">Reset</a>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="border-top-left-radius: 10px; width: 15%">GAMBAR</th>
                                        <th scope="col" style="width: 35%">NAMA PRODUK</th>
                                        <th scope="col" style="width: 18%">HARGA JUAL</th>
                                        <th scope="col" class="text-center" style="width: 12%">STOK</th>
                                        <th scope="col" class="text-center" style="border-top-right-radius: 10px; width: 20%">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('/storage/products/'.$product->image) }}" class="product-img" width="100" height="70">
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $product->title }}</div>
                                                <small class="text-muted">ID: #PROD-0{{ $product->id }}</small>
                                            </td>
                                            <td class="text-primary fw-semibold">
                                                {{ "Rp " . number_format($product->price,0,',','.') }}
                                            </td>
                                            <td class="text-center">
                                                @if($product->stock > 10)
                                                    <span class="badge bg-success-subtle text-success badge-stock">
                                                        <i class="fa-solid fa-circle text-xs me-1"></i> {{ $product->stock }} Pcs
                                                    </span>
                                                @elseif($product->stock > 0)
                                                    <span class="badge bg-warning-subtle text-warning badge-stock">
                                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $product->stock }} Tipis
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger badge-stock">
                                                        Habis
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-light btn-action text-muted" title="Detail">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary btn-action" title="Ubah">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-action" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <img src="https://illustrations.popsy.co/amber/falling.svg" alt="Empty" style="width: 150px;" class="mb-3">
                                                <div class="text-muted fw-medium">Oops! Data produk tidak ditemukan atau masih kosong.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <small class="text-muted">
                                Menampilkan {{ $products->firstItem() ?? 0 }} sampai {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
                            </small>
                            <div>
                                {{ $products->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                            </div>
                        </div>

                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                background: '#ffffff',
                iconColor: '#10b981'
            });
        @endif
    </script>
</body>
</html>