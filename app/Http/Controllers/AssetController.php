<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan ini tetap ada untuk generate PDF

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
            'status' => 'required|string', // Status awal akan ditimpa jika bukan admin
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
        ]);

        $data = $request->all();

        // LOGIKA UPLOAD GAMBAR SAAT MEMBUAT ASET BARU
        if ($request->hasFile('image')) {
            // Simpan gambar ke folder 'public/images/assets'
            // dan simpan path-nya ke dalam variabel $data
            $data['image'] = $request->file('image')->store('images/assets', 'public');
        } else {
            // Jika tidak ada gambar diupload, pastikan kolom image null atau kosong
            $data['image'] = null; 
        }

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
        // Anda bisa mengimplementasikan halaman detail aset di sini jika diperlukan
        // Contoh: return view('pages.assets.show', compact('aset'));
    }

    public function edit(Asset $aset)
    {
        // Pengecekan izin: apakah user boleh mengedit aset ini?
        $this->authorize('edit assets', $aset); // Pastikan $aset diteruskan ke authorize

        $categories = Category::all();
        $locations = Location::all();
        return view('pages.assets.edit', compact('aset', 'categories', 'locations'));
    }

    public function update(Request $request, Asset $aset)
    {
        // Pengecekan izin: apakah user boleh mengupdate aset ini?
        $this->authorize('edit assets', $aset); // Pastikan $aset diteruskan ke authorize

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'serial_number' => 'nullable|string|max:255|unique:assets,serial_number,' . $aset->id,
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
        ]);
        
        $data = $request->all();

        // LOGIKA UPDATE GAMBAR
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($aset->image && Storage::disk('public')->exists($aset->image)) {
                Storage::disk('public')->delete($aset->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('images/assets', 'public');
        } elseif ($request->input('clear_image')) { // Tambahkan input tersembunyi untuk menghapus gambar
            if ($aset->image && Storage::disk('public')->exists($aset->image)) {
                Storage::disk('public')->delete($aset->image);
            }
            $data['image'] = null;
        } else {
            // Jika tidak ada gambar baru diupload dan tidak ada permintaan hapus, 
            // biarkan gambar yang sudah ada (jangan diupdate)
            unset($data['image']); 
        }

        $aset->update($data);
        
        return redirect()->route('aset.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $aset)
    {
        // Pengecekan izin: apakah user boleh menghapus aset ini?
        $this->authorize('delete assets', $aset);
        
        // Hapus gambar terkait sebelum menghapus aset
        if ($aset->image && Storage::disk('public')->exists($aset->image)) {
            Storage::disk('public')->delete($aset->image);
        }

        $aset->delete();
        
        return redirect()->route('aset.index')->with('success', 'Aset berhasil dihapus.');
    }
    
    public function approvalList()
    {
        $this->authorize('approve assets');

        $pendingAssets = Asset::with(['category', 'location'])
            ->where('status', 'Menunggu Persetujuan')
            ->latest()
            ->paginate(5); 
            
        return view('pages.assets.approval', compact('pendingAssets'));
    }
    
    public function approve(Asset $aset)
    {
        $this->authorize('approve assets');

        // Ubah status aset menjadi 'Tersedia'
        $aset->status = 'Tersedia';
        $aset->save();

        return redirect()->route('aset.approval')->with('success', 'Aset telah disetujui dan sekarang aktif.');
    }

    public function reject(Asset $aset)
    {
        $this->authorize('approve assets');

        // Opsi: Ubah status menjadi 'Ditolak' (direkomendasikan untuk riwayat)
        $aset->status = 'Ditolak'; 
        $aset->save();

        // Jika Anda tetap ingin menghapus aset saat ditolak, gunakan kode di bawah ini:
        // if ($aset->image && Storage::disk('public')->exists($aset->image)) {
        //     Storage::disk('public')->delete($aset->image);
        // }
        // $aset->delete();

        return redirect()->route('aset.approval')->with('success', 'Pengajuan aset telah ditolak.');
    }

    public function generateAssetReportPDF()
    {
        $this->authorize('generate reports');

        // 1. Ambil semua data aset yang aktif
        $assets = Asset::with(['category', 'location'])->where('status', 'Tersedia')->get();

        // 2. Siapkan data untuk dikirim ke view
        $data = [
            'date' => date('d/m/Y'),
            'assets' => $assets
        ];

        // 3. Muat view PDF dengan data
        $pdf = PDF::loadView('pages.assets.report-pdf', $data);

        // 4. Download file PDF dengan nama tertentu
        return $pdf->download('laporan-aset-pelindo.pdf');
    }
}