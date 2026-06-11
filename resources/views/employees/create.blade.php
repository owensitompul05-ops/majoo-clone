<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Majoo Clone - Tambah Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; padding: 20px 0; box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1); width: 240px; }
        .main-content { margin-left: 240px; padding: 25px; }
        .sidebar .nav-link { padding: 12px 20px; color: #ccc; font-weight: 500; }
        .sidebar .nav-link:hover { background-color: #343a40; color: #fff; }
        .sidebar .nav-link.active { background-color: #0d6efd; color: #fff; }
    </style>
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="px-3 mb-4">
                    <h3 class="text-white fw-bold m-0 text-center py-2 border-bottom border-secondary">Majoo POS</h3>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">📦 Manajemen Barang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('transactions.index') }}">🖥️ Mesin Kasir</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">📊 Laporan Penjualan</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="{{ route('employees.index') }}">👥 Manajemen Karyawan</a></li>
                </ul>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <div class="container" style="max-width: 600px; margin-top: 20px;">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Tambah Karyawan Baru</h4>
                            
                            <form action="{{ route('employees.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name" required placeholder="Contoh: Margent Sitompul">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jabatan (Role)</label>
                                    <select class="form-select" name="role" required>
                                        <option value="Kasir">Kasir</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Manager">Manager</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">No. Telepon</label>
                                    <input type="number" class="form-control" name="phone" placeholder="0812xxxxxxxx">
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('employees.index') }}" class="btn btn-secondary fw-bold">Kembali</a>
                                    <button type="submit" class="btn btn-primary fw-bold">Simpan Karyawan</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>