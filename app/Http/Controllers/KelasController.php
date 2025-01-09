<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Murid;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KelasController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view_kelas()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk ke Jurusan.',
        ]);

        $kelas = DB::table('kelas')
            ->join('jurusan', 'jurusan.id_jurusan', '=', 'kelas.id_jurusan')
            ->select(
                'kelas.id_kelas',
                'kelas.nama_kelas',
                'kelas.id_jurusan',
                'kelas.id_user',
                'jurusan.nama_jurusan',
            )
            ->get();


        $jurusan = Jurusan::all(); // Ambil semua data jurusan dari tabel

        echo view('header');
        echo view('menu');
        echo view('kelas', compact('kelas'), compact('jurusan'));
        echo view('footer');
    }

    public function getMuridByKelas($id)
    {
        $murid = Murid::where('id_kelas', $id)->get();
        return response()->json($murid);
    }


    public function buat_kelas(Request $request)
    {

        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Membuat Kelas.',
        ]);

        try {
            $request->validate([
                'nama_kelas' => 'required',
            ]);

            // Mendapatkan id_user dari session
            $id_user = Session::get('id');

            // Simpan data ke tabel surat
            $kelas = new kelas();
            $kelas->nama_kelas = $request->input('nama_kelas');
            $kelas->id_jurusan = $request->input('jurusan');
            $kelas->id_user = $id_user;
            // Simpan ke database
            $kelas->save();

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
            'description' => 'User Mengatur Kelas.',
        ]);
        // Validasi input
        try {
            $request->validate([
                'nama_kelas' => 'required|string|max:255',
            ]);

            // Cari pengumuman berdasarkan ID
            $kelas = Kelas::findOrFail($id);
            $id_user = Session::get('id');
            // Update data
            $kelas->nama_kelas = $request->nama_kelas;
            $kelas->id_jurusan = $request->jurusan;
            $kelas->id_user = $id_user;
            $kelas->save();
            return redirect()->back()->with('success', 'Folder berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan tes: ' . $e->getMessage());
            return redirect()->route('view_kelas')->with('success', 'Pengumuman berhasil diperbarui.');
        }
    }


    public function kelas_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Kelas.',
        ]);

        // Cari data user berdasarkan ID
        $kelas = Kelas::findOrFail($id);

        // Hapus data user (soft delete)
        $kelas->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data user berhasil dihapus');
    }

    public function murid_store(Request $request)
    {
        try {
            $request->validate([
                'id_kelas' => 'required|exists:kelas,id_kelas',
                'nama_murid.*' => 'required|string|max:255',
                'email_murid.*' => 'required|email',
                'email_ortu.*' => 'required|email',
                'nohp_murid.*' => 'required',
                'nohp_ortu.*' => 'required',
            ]);

            foreach ($request->nama_murid as $index => $namaMurid) {
                Murid::create([
                    'id_kelas' => $request->id_kelas,
                    'nama_murid' => $namaMurid,
                    'email_murid' => $request->email_murid[$index],
                    'email_ortu' => $request->email_ortu[$index],
                    'nohp_murid' => $request->nohp_murid[$index],
                    'nohp_ortu' => $request->nohp_ortu[$index],
                ]);
            }

            return redirect()->back()->with('success', 'Murid berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan tes: ' . $e->getMessage());
            return redirect()->route('view_kelas')->with('success', 'Pengumuman berhasil diperbarui.');
        }
    }

    public function hapusMurid($id)
    {
        $murid = Murid::find($id);

        if ($murid) {
            $murid->delete();

            return redirect()->back()->with('success', 'Murid berhasil ditambahkan.');
        }
    }

}
