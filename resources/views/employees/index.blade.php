<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Majoo Clone - Manajemen Karyawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f3f6;
            color: #333;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 24px 0;
            width: 260px;
            background-color: #1e3a8a;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }
        .sidebar-brand {
            font-size: 20px;
            letter-spacing: 0.5px;
            color: #ffffff;
            padding: 0 24px;
            margin-bottom: 30px;
            text-align: center;
        }
        .sidebar-brand span.text-info {
            color: #fb923c !important;
        }
        .sidebar .nav-link {
            padding: 14px 24px;
            color: #cbd5e1;
            font-weight: 500;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
            margin-right: 16px;
            border-radius: 0 8px 8px 0;
            text-decoration: none;
        }
        .sidebar .nav-link:hover {
            background-color: #2563eb;
            color: #ffffff;
        }
        .sidebar .nav-link.active {
            background-color: #fb923c;
            color: #ffffff;
        }
        .main-content {
            margin-left: 260px;
            padding: 40px;
        }
        .card-premium {
            background: #ffffff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .table-premium thead {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 13px;
        }
        .table-premium th, .table-premium td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
        }
        .btn-premium-primary {
            background-color: #fb923c;
            color: #ffffff;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            font-size: 14px;
            transition: all 0.15s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .btn-premium-primary:hover {
            background-color: #f97316;
            color: #ffffff;
        }
        .btn-action {
            font-size: 13px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            color: #475569;
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-action:hover {
            background-color: #f1f5f9;
        }
        .btn-delete {
            color: #ef4444;
            border-color: #fecaca;
        }
        .btn-delete:hover {
            background-color: #fef2f2;
            color: #b91c1c;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="sidebar-brand fw-bold border-bottom border-secondary pb-3">✨ MAJOO <span class="text-info">POS</span></div>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">📦 Manajemen Barang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('transactions.index') }}">🖥️ Mesin Kasir</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">📊 Laporan Penjualan</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('employees.index') }}">👥 Manajemen Karyawan</a></li>
                </ul>
            </div>
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <div class="card card-premium p-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold m-0 text-dark">Data Staf Kasir</h4>
                                <p class="text-muted small m-0 mt-1">Daftar lengkap karyawan aktif yang mengoperasikan kasir</p>
                            </div>
                            <a href="{{ route('employees.create') }}" class="btn btn-premium-primary shadow-sm">+ Tambah Staf Baru</a>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success border-0 rounded-3 p-3 mb-4 shadow-sm" style="background-color: #ecfdf5; color: #10b981;">
                                ✓ Sukses! {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-premium table-hover text-center align-middle m-0">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">NO</th>
                                        <th class="text-start">NAMA LENGKAP</th>
                                        <th>JABATAN</th>
                                        <th>NO. TELEPON</th>
                                        <th style="width: 180px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($employees as $index => $emp)
                                        <tr>
                                            <td class="text-muted small fw-bold">{{ $index + 1 }}</td>
                                            <td class="fw-semibold text-start text-dark px-3" style="font-size: 15px;">{{ $emp->name }}</td>
                                            <td><span class="badge px-3 py-2 fw-semibold rounded-3 text-white" style="background-color: #3b82f6; font-size: 13px;">💼 {{ $emp->role }}</span></td>
                                            <td class="text-secondary small">{{ $emp->phone ?? '-' }}</td>
                                            <td>
                                                <form onsubmit="return confirm('Hapus staf ini?');" action="{{ route('employees.destroy', $emp->id) }}" method="POST">
                                                    <a href="{{ route('employees.edit', $emp->id) }}" class="btn-action me-1">Edit</a>
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-muted p-5">Belum ada data staf kasir yang terdaftar.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>