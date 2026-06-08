<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk - Laravel 12</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/Admission/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <img src="{{ asset('/storage/products/'.$product->image) }}" class="w-100 rounded mb-4">
                        <hr>
                        <h4>{{ $product->title }}</h4>
                        <p class="tmt-3">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <div class="mt-3">
                            {!! $product->description !!}
                        </div>
                        <hr>
                        <p>Stok Tersedia: <b>{{ $product->stock }}</b></p>
                        <a href="{{ route('products.index') }}" class="btn btn-md btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>