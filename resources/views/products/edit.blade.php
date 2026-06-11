<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Majoo Clone - Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Edit Data Produk</h4>

                        <form action="{{ route('products.update', $product->id) }}" method="POST">
                            @csrf
                            @method('PUT') <div class="mb-3">
                                <label class="form-label fw-bold">SKU / Barcode Produk</label>
                                <input type="text" class="form-control bg-secondary-subtle" name="sku" value="{{ old('sku', $product->sku) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Produk</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Harga Beli (Modal)</label>
                                    <input type="number" class="form-control @error('price_buy') is-invalid @enderror" name="price_buy" value="{{ old('price_buy', $product->price_buy) }}">
                                    @error('price_buy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Harga Jual</label>
                                    <input type="number" class="form-control @error('price_sell') is-invalid @enderror" name="price_sell" value="{{ old('price_sell', $product->price_sell) }}">
                                    @error('price_sell')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Stok Barang</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $product->stock) }}">
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-warning fw-bold text-white">Update Produk</button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary fw-bold">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>