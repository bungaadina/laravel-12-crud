<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Produk - SIJA_STORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: #ffffff;
            overflow: hidden;
        }
        .product-img-detail {
            width: 100%;
            height: 100%;
            object-fit: cover;
            min-height: 350px;
            max-height: 500px;
        }
        .badge-stock {
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
        }
        .price-tag {
            font-size: 28px;
            font-weight: 700;
            color: #4f46e5;
        }
        .btn-back {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }
    </style>
</head>
<body>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                
                <div class="mb-4">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-back text-muted shadow-sm">
                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>

                <div class="card card-custom">
                    <div class="row g-0">
                        
                        <div class="col-md-6">
                            <img src="{{ asset('/storage/products/'.$product->image) }}" class="product-img-detail" alt="{{ $product->title }}">
                        </div>
                        
                        <div class="col-md-6 d-flex flex-column justify-content-between p-4 p-lg-5">
                            <div>
                                <h2 class="fw-bold text-dark mb-1">{{ $product->title }}</h2>
                                <p class="text-muted small mb-4">ID Aset: #PROD-0{{ $product->id }}</p>
                                
                                <hr class="text-muted opacity-25">

                                <div class="mb-4">
                                    <small class="text-muted d-block uppercase fw-semibold tracking-wider">Harga Jual</small>
                                    <span class="price-tag">{{ "Rp " . number_format($product->price, 0, ',', '.') }}</span>
                                </div>

                                <div class="mb-4">
                                    <small class="text-muted d-block fw-semibold mb-2">Status Ketersediaan</small>
                                    @if($product->stock > 10)
                                        <span class="badge bg-success-subtle text-success badge-stock">
                                            <i class="fa-solid fa-circle-check me-2"></i>Stok Aman ({{ $product->stock }} Pcs)
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span class="badge bg-warning-subtle text-warning badge-stock">
                                            <i class="fa-solid fa-triangle-exclamation me-2"></i>Stok Menipis ({{ $product->stock }} Pcs)
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger badge-stock">
                                            <i class="fa-solid fa-circle-xmark me-2"></i>Stok Habis
                                        </span>
                                    @endif
                                </div>

                                <hr class="text-muted opacity-25">

                                <div class="mb-4">
                                    <small class="text-muted d-block fw-semibold mb-2">Deskripsi Produk</small>
                                    <p class="text-secondary lh-base" style="white-space: pre-line;">
                                        {{ $product->description }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-muted small pt-3 border-top border-light">
                                <i class="fa-solid fa-user-shield me-1"></i> Terdaftar dalam database SIJA_STORE
                            </div>

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>