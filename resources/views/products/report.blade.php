<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Majoo Clone - Laporan Penjualan</title>
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
            padding: 30px;
        }
        .card-stat {
            border: none;
            border-radius: 16px;
            color: #fff;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
                    <li class="nav-item"><a class="nav-link active" href="{{ route('reports.index') }}">📊 Laporan Penjualan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('employees.index') }}">👥 Manajemen Karyawan</a></li>
                </ul>
            </div>
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <h4 class="fw-bold mb-4 text-dark">📊 Analisis Penjualan</h4>
                <div class="row mb-4">
                    <div class="col-md-4"><div class="card-stat bg-primary"><h6>Total Omset</h6><h2 class="fw-bold">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h2></div></div>
                    <div class="col-md-4"><div class="card-stat bg-success"><h6>Keuntungan (Profit)</h6><h2 class="fw-bold">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h2></div></div>
                    <div class="col-md-4"><div class="card-stat bg-warning text-dark"><h6>Item Terjual</h6><h2 class="fw-bold">{{ $totalTerjual }} Pcs</h2></div></div>
                </div>
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3">Riwayat Transaksi Terakhir</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center small">
                            <thead class="table-light"><tr><th>No</th><th>Invoice</th><th>Kasir</th><th>Waktu</th><th>Total Belanja</th><th>Aksi</th></tr></thead>
                            <tbody>
                                @forelse($allTransactions as $index => $trx)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-bold text-primary">{{ $trx->invoice_number }}</td>
                                        <td><span class="badge bg-dark">{{ $trx->employee->name ?? 'User' }}</span></td>
                                        <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
                                        <td class="text-end fw-bold text-success">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                                        <td><a href="{{ route('transactions.print', $trx->id) }}" target="_blank" class="btn btn-sm btn-outline-dark fw-bold">Print Struk</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="p-5 text-muted">Belum ada transaksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>