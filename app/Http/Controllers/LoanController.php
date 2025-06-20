<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class LoanController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // Menampilkan daftar peminjaman dengan paginasi
        $loans = Loan::with(['user', 'asset'])->latest()->paginate(10);
        return view('pages.loans.index', compact('loans'));
    }

    public function create()
    {
        // Menampilkan form untuk mencatat peminjaman baru
        $users = User::all();
        // Hanya aset dengan status 'Tersedia' yang bisa dipinjam
        $assets = Asset::where('status', 'Tersedia')->get();
        return view('pages.loans.create', compact('users', 'assets'));
    }

    public function store(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'asset_id' => 'required|exists:assets,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
            // 'notes' tidak wajib, jadi tidak perlu validation rule 'required'
            'notes' => 'nullable|string|max:500', // Opsional: Tambah validasi max length untuk notes
        ]);

        // Buat entri peminjaman baru
        Loan::create([
            'user_id' => $request->user_id,
            'asset_id' => $request->asset_id,
            'loan_date' => $request->loan_date,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
            'status' => 'Dipinjam', // Status awal saat peminjaman dicatat
        ]);

        // Update status aset menjadi 'Dipinjam'
        $asset = Asset::find($request->asset_id);
        if ($asset) { // Pastikan aset ditemukan sebelum update
            $asset->status = 'Dipinjam';
            $asset->save();
        }

        return redirect()->route('pinjam.index')->with('success', 'Peminjaman aset berhasil dicatat.');
    }

    public function returnAsset(Loan $loan)
    {
        // Otorisasi: Anda mungkin ingin menambahkan otorisasi di sini,
        // misalnya hanya admin atau peminjam yang bisa mengembalikan aset
        // $this->authorize('return loans', $loan); // Contoh otorisasi

        // Pastikan aset belum dikembalikan
        if ($loan->status === 'Dipinjam') {
            // Update status peminjaman menjadi 'Dikembalikan' dan set tanggal kembali
            $loan->status = 'Dikembalikan';
            $loan->return_date = Carbon::now();
            $loan->save();

            // Update status asetnya agar kembali tersedia
            $asset = $loan->asset;
            if ($asset) { // Pastikan aset ditemukan sebelum update
                $asset->status = 'Tersedia';
                $asset->save();
            }
            return redirect()->route('pinjam.index')->with('success', 'Aset telah berhasil dikembalikan.');
        }

        return redirect()->route('pinjam.index')->with('error', 'Aset sudah dikembalikan atau status tidak valid.');
    }

    public function destroy(Loan $loan)
    {
        // 1. Otorisasi: Cek apakah user punya izin 'delete loans'
        // Pastikan Anda sudah mendefinisikan gate atau policy 'delete loans'
        $this->authorize('delete loans');

        // 2. Penting: Kembalikan status aset menjadi 'Tersedia' sebelum hapus riwayat
        // Ini memastikan aset tidak "hilang" jika riwayat peminjamannya dihapus
        $asset = $loan->asset;
        if ($asset) {
            $asset->status = 'Tersedia';
            $asset->save();
        }

        // 3. Hapus data peminjaman
        $loan->delete();

        return redirect()->route('pinjam.index')->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }
}