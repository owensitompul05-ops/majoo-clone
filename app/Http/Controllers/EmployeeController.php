<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // 1. Tampilkan semua daftar karyawan
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    // 2. Tampilkan form tambah karyawan
    public function create()
    {
        return view('employees.create');
    }

    // 3. Simpan data karyawan baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'phone' => 'nullable|numeric',
        ]);

        Employee::create($validated);
        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil didaftarkan!');
    }

    // 4. Tampilkan form edit karyawan
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    // 5. Update data karyawan di database
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'phone' => 'nullable|numeric',
        ]);

        $employee->update($validated);
        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    // 6. Hapus karyawan dari database
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus!');
    }
}