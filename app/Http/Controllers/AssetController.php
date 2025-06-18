<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Kita mulai query dengan eager loading agar relasi ikut terbawa
        $query = Asset::with(['category', 'location']);

        if ($search) {
            // Cari berdasarkan nama aset. 
            // Nanti bisa kita kembangkan untuk mencari berdasarkan kategori atau lokasi juga.
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Ambil data dengan paginasi (6 data per halaman)
        $assets = $query->paginate(6);

        return view('pages.assets.index', compact('assets', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('pages.assets.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'serial_number' => 'nullable|string|max:255|unique:assets,serial_number',
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);
        Asset::create($request->all());
        return redirect()->route('aset.index')->with('success', 'Aset baru berhasil ditambahkan.');
    }

    public function edit(Asset $aset)
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('pages.assets.edit', compact('aset', 'categories', 'locations'));
    }

    public function update(Request $request, Asset $aset)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'serial_number' => 'nullable|string|max:255|unique:assets,serial_number,' . $aset->id,
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);
        $aset->update($request->all());
        return redirect()->route('aset.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $aset)
    {
        $aset->delete();
        return redirect()->route('aset.index')->with('success', 'Aset berhasil dihapus.');
    }
}