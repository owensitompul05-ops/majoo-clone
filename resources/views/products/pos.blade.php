<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Majoo POS - Mesin Kasir Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }
        /* Sidebar Styling */
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
        .sidebar-brand span {
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
        
        /* Main Layout Content */
        .main-content {
            margin-left: 260px;
            padding: 25px;
        }
        
        /* Modern Card Elements */
        .card-premium {
            background: #ffffff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
            height: 100%;
        }
        
        /* Product Grid Items */
        .product-grid {
            max-height: 280px;
            overflow-y: auto;
            padding-right: 5px;
        }
        .product-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: left;
        }
        .product-card:hover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        
        /* Cart Table Customization */
        .cart-wrapper {
            max-height: 320px;
            overflow-y: auto;
        }
        .table-cart thead {
            background-color: #f8fafc;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .table-cart th {
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 600;
            padding: 12px;
        }
        .table-cart td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        
        /* Checkout Box Side */
        .total-box {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff;
            padding: 24px;
            border-radius: 12px;
            text-align: center;
            box-shadow: inset 0 0 12px rgba(0,0,0,0.2);
        }
        .total-box h1 {
            color: #f97316;
            font-weight: 700;
            font-size: 2.25rem;
            margin-top: 5px;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="sidebar-brand fw-bold border-bottom border-secondary pb-3">✨ MAJOO <span>POS</span></div>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">📦 Manajemen Barang</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('transactions.index') }}">🖥️ Mesin Kasir</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">📊 Laporan Penjualan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('employees.index') }}">👥 Manajemen Karyawan</a></li>
                </ul>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <div class="row g-4">
                    
                    <div class="col-lg-7">
                        <div class="d-flex flex-column gap-4">
                            
                            <div class="card card-premium p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold m-0">⚡ Etalase Produk Sentuh</h5>
                                    <input type="text" id="search_product" class="form-control form-control-sm w-50" placeholder="🔍 Cari nama produk / scan SKU...">
                                </div>
                                
                                <div class="row row-cols-1 row-cols-md-3 g-2 product-grid" id="product_cards_container">
                                    @foreach($products as $product)
                                        <div class="col product-item" data-name="{{ strtolower($product->name) }}">
                                            <div class="product-card" onclick="addToCartClick('{{ $product->id }}', '{{ $product->name }}', {{ $product->price_sell }}, {{ $product->stock }})">
                                                <div class="fw-bold text-truncate text-dark" style="font-size: 14px;">{{ $product->name }}</div>
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <span class="text-success fw-bold small">Rp {{ number_format($product->price_sell, 0, ',', '.') }}</span>
                                                    <span class="badge bg-light text-secondary border small">Stok: {{ $product->stock }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card card-premium p-4">
                                <h5 class="fw-bold mb-3">🛒 Item dalam Keranjang</h5>
                                <div class="cart-wrapper">
                                    <table class="table table-cart align-middle text-center m-0">
                                        <thead>
                                            <tr>
                                                <th class="text-start">Nama Produk</th>
                                                <th>Harga</th>
                                                <th style="width: 110px;">Qty</th>
                                                <th>Subtotal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart_tbody">
                                            <tr id="empty_cart_row">
                                                <td colspan="5" class="p-5 text-muted small">Keranjang belanja kosong. Klik produk di atas untuk menambah item.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card card-premium p-4">
                            <form action="{{ route('transactions.store') }}" method="POST">
                                @csrf
                                <div id="hidden_cart_inputs"></div>
                                
                                <div class="mb-3">
                                    <label class="fw-bold text-secondary small mb-1">KASIR YANG BERTUGAS</label>
                                    <select class="form-select form-select-md fw-semibold text-dark" name="employee_id" required>
                                        <option value="">-- Pilih Nama Kasir --</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->role }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="total-box my-4">
                                    <small class="text-uppercase tracking-wide fw-semibold text-muted" style="font-size: 11px;">TOTAL NOMINAL TAGIHAN</small>
                                    <h1 class="m-0" id="total_tagihan_display">Rp 0</h1>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-bold text-secondary small mb-1">UANG TUNAI YANG DITERIMA (CASH)</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                                        <input type="number" class="form-control fw-bold text-success" name="total_accepted" id="cash_input" placeholder="0" required disabled style="font-size: 22px;">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center bg-light rounded-3 p-3 mb-4 border">
                                    <span class="text-muted small fw-medium">Uang Kembalian Pelanggan:</span>
                                    <span class="fw-bold text-danger fs-4" id="kembalian_display">Rp 0</span>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold py-3 rounded-3 shadow-sm mb-2" id="btn_submit_order" disabled style="font-size: 16px; letter-spacing: 0.5px;">PROSES & CETAK STRUK</button>
                            </form>
                            
                            @if(session('success'))
                                <div class="alert alert-success border-0 rounded-3 p-3 mt-2 mb-0 d-flex flex-column align-items-center text-center shadow-sm" style="background-color: #ecfdf5; color: #10b981;">
                                    <span class="fw-semibold mb-2">✓ {{ session('success') }}</span>
                                    @if(session('print_id'))
                                        <a href="{{ route('transactions.print', session('print_id')) }}" target="_blank" class="btn btn-dark btn-sm fw-bold px-4 rounded-3">🖨️ PRINT NOTA SEKARANG</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </main>
        </div>
    </div>

    <script>
        const cartTbody = document.getElementById('cart_tbody');
        const emptyCartRow = document.getElementById('empty_cart_row');
        const totalTagihanDisplay = document.getElementById('total_tagihan_display');
        const cashInput = document.getElementById('cash_input');
        const kembalianDisplay = document.getElementById('kembalian_display');
        const btnSubmitOrder = document.getElementById('btn_submit_order');
        const hiddenCartInputs = document.getElementById('hidden_cart_inputs');
        const searchProduct = document.getElementById('search_product');

        let cartData = {}; 
        let totalTagihan = 0;

        // Fitur Live Search untuk Filter Produk di Etalase
        searchProduct.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.product-item');
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if(name.includes(query)) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });

        // Trigger fungsi saat card produk di-klik
        function addToCartClick(id, name, price, stock) {
            if (stock <= 0) return alert('Stok produk ini sedang kosong di gudang!');
            
            if (cartData[id]) {
                if (cartData[id].qty >= stock) return alert('Kuantitas keranjang melampaui sisa stok!');
                cartData[id].qty += 1;
            } else {
                cartData[id] = { id: id, name: name, price: price, qty: 1, stock: stock };
            }
            renderCart();
        }

        function renderCart() {
            cartTbody.innerHTML = '';
            const keys = Object.keys(cartData);

            if (keys.length === 0) {
                cartTbody.appendChild(emptyCartRow);
                totalTagihan = 0;
                totalTagihanDisplay.innerText = 'Rp 0';
                cashInput.disabled = true;
                cashInput.value = '';
                btnSubmitOrder.disabled = true;
                hiddenCartInputs.innerHTML = '';
                return;
            }

            totalTagihan = 0;
            hiddenCartInputs.innerHTML = '';

            keys.forEach((id, index) => {
                const item = cartData[id];
                const subtotal = item.price * item.qty;
                totalTagihan += subtotal;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="text-start fw-bold text-dark">${item.name}</td>
                    <td>Rp ${item.price.toLocaleString('id-ID')}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm text-center fw-bold" value="${item.qty}" min="1" onchange="updateQty('${id}', this.value)">
                    </td>
                    <td class="text-success fw-bold">Rp ${subtotal.toLocaleString('id-ID')}</td>
                    <td><button type="button" class="btn btn-sm text-danger fw-semibold text-decoration-none" onclick="removeItem('${id}')">✕</button></td>
                `;
                cartTbody.appendChild(tr);

                hiddenCartInputs.innerHTML += `
                    <input type="hidden" name="cart[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="cart[${index}][qty]" value="${item.qty}">
                `;
            });

            totalTagihanDisplay.innerText = 'Rp ' + totalTagihan.toLocaleString('id-ID');
            cashInput.disabled = false;
            hitungKembalian();
        }

        window.updateQty = function(id, val) {
            let parsed = parseInt(val) || 1;
            if (parsed < 1) parsed = 1;
            if (parsed > cartData[id].stock) {
                alert('Stok gudang tidak mencukupi nominal tersebut!');
                parsed = cartData[id].stock;
            }
            cartData[id].qty = parsed;
            renderCart();
        }

        window.removeItem = function(id) {
            delete cartData[id];
            renderCart();
        }

        function hitungKembalian() {
            const uang = parseInt(cashInput.value) || 0;
            const sisa = uang - totalTagihan;

            if (sisa >= 0) {
                kembalianDisplay.innerText = 'Rp ' + sisa.toLocaleString('id-ID');
                kembalianDisplay.className = "fw-bold text-success fs-4";
                btnSubmitOrder.disabled = false;
            } else {
                kembalianDisplay.innerText = 'Uang Kurang';
                kembalianDisplay.className = "fw-bold text-danger fs-4";
                btnSubmitOrder.disabled = true;
            }
        }

        cashInput.addEventListener('input', hitungKembalian);
    </script>
</body>
</html>