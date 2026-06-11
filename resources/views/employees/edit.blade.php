<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 500px;">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Edit Data Karyawan</h4>
                
                <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" value="{{ $employee->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jabatan (Role)</label>
                        <select class="form-select" name="role" required>
                            <option value="Kasir" {{ $employee->role == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="Admin" {{ $employee->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Manager" {{ $employee->role == 'Manager' ? 'selected' : '' }}>Manager</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">No. Telepon</label>
                        <input type="number" class="form-control" name="phone" value="{{ $employee->phone }}">
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary fw-bold">Kembali</a>
                        <button type="submit" class="btn btn-warning fw-bold text-white">Update Karyawan</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</body>
</html>