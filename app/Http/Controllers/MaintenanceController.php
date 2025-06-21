<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MaintenanceController extends Controller
{
    use AuthorizesRequests;

     public function index()
    {
        $this->authorize('view assets');
        $maintenances = Maintenance::with('asset')->latest()->paginate(6);

        return view('pages.maintenances.index', compact('maintenances'));
    }

    public function create()
    {
        $this->authorize('create assets'); // Izin untuk membuat catatan perawatan
        $assets = Asset::where('status', '!=', 'Menunggu Persetujuan')->get();
        return view('pages.maintenances.create', compact('assets'));
    }

    public function store(Request $request)
    {
        $this->authorize('create assets');
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'maintenance_date' => 'required|date',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'nullable|numeric|min:0',
            'next_maintenance_date' => 'nullable|date|after_or_equal:maintenance_date',
        ]);
        Maintenance::create($request->all());
        return redirect()->route('perawatan.index')->with('success', 'Catatan perawatan berhasil ditambahkan.');
    }

    public function show(Maintenance $perawatan)
    {
        //
    }

    public function edit(Maintenance $perawatan)
    {
        $this->authorize('edit assets'); // Menggunakan izin edit aset
        $assets = Asset::all();
        return view('pages.maintenances.edit', compact('perawatan', 'assets'));
    }

    public function update(Request $request, Maintenance $perawatan)
    {
        $this->authorize('edit assets');
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'maintenance_date' => 'required|date',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'nullable|numeric|min:0',
            'next_maintenance_date' => 'nullable|date|after_or_equal:maintenance_date',
        ]);
        $perawatan->update($request->all());
        return redirect()->route('perawatan.index')->with('success', 'Catatan perawatan berhasil diperbarui.');
    }

    public function destroy(Maintenance $perawatan)
    {
        $this->authorize('delete assets'); // Menggunakan izin delete aset
        $perawatan->delete();
        return redirect()->route('perawatan.index')->with('success', 'Catatan perawatan berhasil dihapus.');
    }
}