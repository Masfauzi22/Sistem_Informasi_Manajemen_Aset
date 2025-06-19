<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AssetController extends Controller
{
    use AuthorizesRequests;
    
    public function index(Request $request)
    {
        // Pengecekan izin: apakah user boleh melihat daftar aset?
        $this->authorize('view assets');

        $search = $request->input('search');
        $query = Asset::with(['category', 'location']);

        // Filter agar hanya menampilkan aset yang statusnya 'Tersedia' (Aktif)
        $query->where('status', 'Tersedia');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        $assets = $query->latest()->paginate(6);
        return view('pages.assets.index', compact('assets', 'search'));
    }

    public function create()
    {
        // Pengecekan izin: apakah user boleh membuat aset?
        $this->authorize('create assets');

        $categories = Category::all();
        $locations = Location::all();
        return view('pages.assets.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        // Pengecekan izin: apakah user boleh menyimpan aset baru?
        $this->authorize('create assets');

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'serial_number' => 'nullable|string|max:255|unique:assets,serial_number',
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        $data = $request->all();

        // LOGIKA APPROVAL: Tentukan status aset berdasarkan peran user
        if (!auth()->user()->hasRole('admin')) {
            // Jika yang membuat BUKAN admin (misal: staf), paksa statusnya menjadi 'Menunggu Persetujuan'
            $data['status'] = 'Menunggu Persetujuan';
        }
        
        Asset::create($data);

        return redirect()->route('aset.index')->with('success', 'Aset baru berhasil diajukan dan menunggu persetujuan.');
    }

    public function show(Asset $aset)
    {
        // Untuk saat ini kita tidak menggunakan halaman detail tunggal
    }

    public function edit(Asset $aset)
    {
        // Pengecekan izin: apakah user boleh mengedit aset ini?
        $this->authorize('edit assets', $aset);

        $categories = Category::all();
        $locations = Location::all();
        return view('pages.assets.edit', compact('aset', 'categories', 'locations'));
    }

    public function update(Request $request, Asset $aset)
    {
        // Pengecekan izin: apakah user boleh mengupdate aset ini?
        $this->authorize('edit assets', $aset);

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
        // Pengecekan izin: apakah user boleh menghapus aset ini?
        $this->authorize('delete assets', $aset);
        
        $aset->delete();
        
        return redirect()->route('aset.index')->with('success', 'Aset berhasil dihapus.');
    }
}