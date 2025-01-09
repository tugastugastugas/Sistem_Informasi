<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JurusanController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view_jurusan()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk ke Jurusan.',
        ]);

        $jurusan = DB::table('jurusan')
            ->select(
                'jurusan.id_jurusan',
                'jurusan.nama_jurusan',
            )
            ->get();

        echo view('header');
        echo view('menu');
        echo view('jurusan', compact('jurusan'));
        echo view('footer');
    }


    public function buat_jurusan(Request $request)
    {

        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Membuat Jurusan.',
        ]);

        try {
            $request->validate([
                'nama_jurusan' => 'required',
            ]);

            // Mendapatkan id_user dari session
            $id_user = Session::get('id');

            // Simpan data ke tabel surat
            $jurusan = new Jurusan();
            $jurusan->nama_jurusan = $request->input('nama_jurusan');

            // Simpan ke database
            $jurusan->save();

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
            'description' => 'User Mengatur Jurusan.',
        ]);
        // Validasi input
        try {
            $request->validate([
                'nama_jurusan' => 'required|string|max:255',
            ]);

            // Cari pengumuman berdasarkan ID
            $jurusan = Jurusan::findOrFail($id);

            // Update data
            $jurusan->nama_jurusan = $request->nama_jurusan;
            $jurusan->save();
            return redirect()->back()->with('success', 'Folder berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan surat: ' . $e->getMessage());
            return redirect()->route('view_jurusan')->with('success', 'Pengumuman berhasil diperbarui.');
        }
    }


    public function jurusan_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Jurusan.',
        ]);

        // Cari data user berdasarkan ID
        $jurusan = Jurusan::findOrFail($id);

        // Hapus data user (soft delete)
        $jurusan->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data user berhasil dihapus');
    }
}
