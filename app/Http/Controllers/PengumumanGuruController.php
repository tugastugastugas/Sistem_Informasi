<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\Kelas;
use App\Models\PengumumanGuru;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class PengumumanGuruController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function pengumuman_guru()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk ke Pengumuman Terpilih.',
        ]);

        $pengumuman = DB::table('pengumuman_guru')
            ->join('user', 'user.id_user', '=', 'pengumuman_guru.id_user')
            ->select(
                'user.username',
                'pengumuman_guru.judul_pengumuman_guru',
                'pengumuman_guru.isi_pengumuman',
                'pengumuman_guru.tgl_buat',
                'pengumuman_guru.id_pengumuman_guru',
                'pengumuman_guru.id_user',
            )
            ->get();

        echo view('header');
        echo view('menu');
        echo view('pengumuman_terpilih', compact('pengumuman'));
        echo view('footer');
    }


    public function buat_pengumuman_guru(Request $request)
    {

        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Membuat Pengumuman Terpilih.',
        ]);

        try {
            $request->validate([
                'judul_pengumuman_guru' => 'required',
                'isi_pengumuman' => 'required',
            ]);

            // Mendapatkan id_user dari session
            $id_user = Session::get('id');

            // Simpan data ke tabel surat
            $pengumuman_guru = new PengumumanGuru();
            $pengumuman_guru->judul_pengumuman_guru = $request->input('judul_pengumuman_guru');
            $pengumuman_guru->isi_pengumuman = $request->input('isi_pengumuman');
            $pengumuman_guru->tgl_buat = Carbon::now();
            $pengumuman_guru->id_user = $id_user;

           
            // Simpan ke database
            $pengumuman_guru->save();

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
            'description' => 'User Mengatur Pengumuman Terpilih.',
        ]);
        // Validasi input
        try {
        $request->validate([
            'judul_pengumuman_guru' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
        ]);

        // Cari pengumuman berdasarkan ID
        $pengumuman = PengumumanGuru::findOrFail($id);

        // Update data
        $pengumuman->judul_pengumuman_guru = $request->judul_pengumuman_guru;
        $pengumuman->isi_pengumuman = $request->isi_pengumuman;
        $pengumuman->save();
        return redirect()->back()->with('success', 'Folder berhasil ditambahkan.');
        
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan surat: ' . $e->getMessage());
        return redirect()->route('pengumuman_terpilih')->with('success', 'Pengumuman berhasil diperbarui.');
        }
    }


    public function pengumuman_guru_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Pengumuman Terpilih.',
        ]);

        // Cari data user berdasarkan ID
        $pengumuman_guru = PengumumanGuru::findOrFail($id);

        // Hapus data user (soft delete)
        $pengumuman_guru->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data user berhasil dihapus');
    }
}
