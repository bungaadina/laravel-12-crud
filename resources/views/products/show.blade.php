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
            border-radius: 16px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
            background: #ffffff;
            overflow: hidden;
        }
        .product-img-detail {
            width: 100%;
            height: 100%;
            object-fit: cover;
            min-height: 300px;
            max-height: 380px; /* Kita batasi tingginya agar tidak kebesaran */
        }
        .badge-stock {
            padding: 6px 14px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
        }
        .price-box {
            background-color: #f8fafc;
            border-radius: 10px;
            padding: 12px 15px;
            border-left: 4px solid #4f46e5;
        }
        .price-tag {
            font-size: 24px;
            font-weight: 700;
            color: #4f46e5;
        }
        .btn-back {
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
        }
    </style>
</head>
<body>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                
                <div class="mb-3">
                    <a href="{{ route('products.index') }}" class="btn btn-white bg-white btn-back text-muted shadow-sm border border-light">
                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>

                <div class="card card-custom">
                    <div class="row g-0">
                        
                        <div class="col-md-5">
                            <img src="{{ asset('/storage/products/'.$product->image) }}" class="product-img-detail" alt="{{ $product->title }}">
                        </div>
                        
                        <div class="col-md-7 d-flex flex-column justify-content-between p-4">
                            <div>
                                <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">{{ $product->title }}</h3>
                                <p class="text-muted small mb-3">ID Aset: #PROD-0{{ $product->id }}</p>
                                
                                <div class="mb-3">
                                    @if($product->stock > 10)
                                        <span class="badge bg-success-subtle text-success badge-stock">
                                            <i class="fa-solid fa-circle-check me-1"></i>Stok Aman ({{ $product->stock }} Pcs)
                                        </span>
                                    @elseif($product->stock > 0)
                                        <span class="badge bg-warning-subtle text-warning badge-stock">
                                            <i class="fa-solid fa-triangle-exclamation me-1"></i>Stok Menipis ({{ $product->stock }} Pcs)
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger badge-stock">
                                            <i class="fa-solid fa-circle-xmark me-1"></i>Stok Habis
                                        </span>
                                    @endif
                                </div>

                                <div class="price-box mb-3">
                                    <small class="text-muted d-block fw-semibold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Harga Jual</small>
                                    <span class="price-tag">{{ "Rp " . number_format($product->price, 0, ',', '.') }}</span>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted d-block fw-semibold mb-1" style="font-size: 12px;">Deskripsi:</small>
                                    <p class="text-secondary small lh-base mb-0" style="white-space: pre-line; max-height: 120px; overflow-y: auto;">
                                        {{ $product->description }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-muted small pt-3 mt-3 border-top border-light" style="font-size: 11px;">
                                <i class="fa-solid fa-user-shield me-1"></i> Data terverifikasi oleh SIJA_STORE
                            </div>

                        </div>
                    </div>
                </div> </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>