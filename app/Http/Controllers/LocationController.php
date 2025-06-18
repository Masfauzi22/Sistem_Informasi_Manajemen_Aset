<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil kata kunci pencarian dari request
        $search = $request->input('search');

        // 2. Buat query dasar
        $query = Location::query();

        // 3. Jika ada kata kunci pencarian, tambahkan kondisi 'where'
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // 4. Ambil data dengan paginasi (6 data per halaman)
        $locations = $query->paginate(6);

        // 5. Tampilkan view dan kirim data lokasi
        return view('pages.locations.index', compact('locations', 'search'));
    }

    public function create()
    {
        return view('pages.locations.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        Location::create($request->all());
        return redirect()->route('lokasi.index')->with('success', 'Lokasi baru berhasil ditambahkan.');
    }

    public function show(Location $lokasi)
    {
        //
    }

    public function edit(Location $lokasi)
    {
        return view('pages.locations.edit', compact('lokasi'));
    }

    public function update(Request $request, Location $lokasi)
    {
        $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        $lokasi->update($request->all());
        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $lokasi)
    {
        $lokasi->delete();
        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}