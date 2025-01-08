<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\PengumumanSekolah;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class PengumumanSekolahController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function pengumuman_sekolah()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk ke Pengumuman User.',
        ]);

        $pengumuman = DB::table('pengumuman_sekolah')
            ->join('user', 'user.id_user', '=', 'pengumuman_sekolah.id_user')
            ->select(
                'user.username',
                'pengumuman_sekolah.judul_pengumuman_sekolah',
                'pengumuman_sekolah.isi_pengumuman',
                'pengumuman_sekolah.tgl_buat',
                'pengumuman_sekolah.id_pengumuman_sekolah',
                'pengumuman_sekolah.id_user',
            )
            ->get();
        $jurusan = Jurusan::all(); // Ambil semua jurusan
        $kelas = Kelas::all();

        echo view('header');
        echo view('menu');
        echo view('pengumuman_sekolah', compact('pengumuman', 'jurusan', 'kelas'));
        echo view('footer');
    }


    public function buat_pengumuman(Request $request)
    {

        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Membuat Pengumuman Umum.',
        ]);

        try {
            $request->validate([
                'judul_pengumuman_sekolah' => 'required',
                'isi_pengumuman' => 'required',
            ]);

            // Mendapatkan id_user dari session
            $id_user = Session::get('id');

            // Simpan data ke tabel surat
            $pengumuman_sekolah = new PengumumanSekolah();
            $pengumuman_sekolah->judul_pengumuman_sekolah = $request->input('judul_pengumuman_sekolah');
            $pengumuman_sekolah->isi_pengumuman = $request->input('isi_pengumuman');
            $pengumuman_sekolah->tgl_buat = Carbon::now();
            $pengumuman_sekolah->id_user = $id_user;

           
            // Simpan ke database
            $pengumuman_sekolah->save();

            // Redirect ke halaman lain
            return redirect()->back()->with('success', 'Folder berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Log error detail
            Log::error('Gagal menyimpan surat: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan surat. Silakan coba lagi.']);
        }
    }

     public function update(Request $request, $id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Mengatur Pengumuman Umum.',
        ]);
        // Validasi input
        
        $request->validate([
            'judul_pengumuman_sekolah' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
        ]);

        // Cari pengumuman berdasarkan ID
        $pengumuman = PengumumanSekolah::findOrFail($id);

        // Update data
        $pengumuman->judul_pengumuman_sekolah = $request->judul_pengumuman_sekolah;
        $pengumuman->isi_pengumuman = $request->isi_pengumuman;
        $pengumuman->save();

        // Redirect dengan pesan sukses
        return redirect()->route('pengumuman_umum')->with('success', 'Pengumuman berhasil diperbarui.');
    }


    public function pengumuman_sekolah_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Pengumuman Sekolah.',
        ]);

        // Cari data user berdasarkan ID
        $pengumuman_sekolah = PengumumanSekolah::findOrFail($id);

        // Hapus data user (soft delete)
        $pengumuman_sekolah->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data user berhasil dihapus');
    }
}
