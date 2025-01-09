<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Murid;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\PengumumanGuru;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\MailService;
use Illuminate\Support\Facades\Storage;

class PengumumanGuruController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

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
                'pengumuman_guru.file_pengumuman_guru',
                'pengumuman_guru.isi_pengumuman',
                'pengumuman_guru.tgl_buat',
                'pengumuman_guru.id_pengumuman_guru',
                'pengumuman_guru.id_user',
            )
            ->get();

        $jurusan = Jurusan::all(); // Ambil semua jurusan
        $kelas = Kelas::all();

        echo view('header');
        echo view('menu');
        echo view('pengumuman_terpilih', compact('pengumuman', 'jurusan', 'kelas'));
        echo view('footer');
    }


    public function buat_pengumuman_guru(Request $request)
    {

        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Membuat Pengumuman Terpilih.',
            'file_pengumuman_guru' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png|max:10240',
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

            if ($request->hasFile('file_pengumuman_guru')) {
                $file = $request->file('file_pengumuman_guru');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->move(public_path('uploads'), $fileName);
                $pengumuman_guru->file_pengumuman_guru = $fileName;
            }

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
        Log::info('Update Pengumuman Request', [
            'all_data' => $request->all(),
            'route_id' => $id
        ]);

        try {
            // Catat aktivitas user
            ActivityLog::create([
                'action' => 'create',
                'user_id' => Session::get('id'), // ID pengguna yang sedang login
                'description' => 'User Mengatur Pengumuman Terpilih.',
            ]);
            Log::info('Activity Log berhasil dibuat.');

            // Validasi input
            $validatedData = $request->validate([
                'id_pengumuman_guru' => 'required|exists:pengumuman_guru,id_pengumuman_guru',
                'judul_pengumuman_guru' => 'required|string|max:255',
                'isi_pengumuman' => 'required|string',
                'file_pengumuman_guru' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png|max:10240',
            ]);
            Log::info('Validasi input berhasil.', ['validated_data' => $validatedData]);

            // Cari pengumuman berdasarkan ID
            $pengumuman = PengumumanGuru::findOrFail($request->input('id_pengumuman_guru'));
            Log::info('Pengumuman ditemukan.', ['pengumuman' => $pengumuman]);

            // Update data teks
            $pengumuman->judul_pengumuman_guru = $request->input('judul_pengumuman_guru');
            $pengumuman->isi_pengumuman = $request->input('isi_pengumuman');
            Log::info('Data teks berhasil diupdate.');

            // Proses upload file jika ada
            if ($request->hasFile('file_pengumuman_guru')) {
                $file = $request->file('file_pengumuman_guru');
                Log::info('File baru ditemukan.', ['file' => $file->getClientOriginalName()]);

                // Hapus file lama jika ada
                if ($pengumuman->file_pengumuman_guru) {
                    $oldFilePath = public_path('uploads/' . $pengumuman->file_pengumuman_guru);
                    if (file_exists($oldFilePath)) {
                        Log::info("File lama ditemukan: $oldFilePath");
                        if (unlink($oldFilePath)) {
                            Log::info("File lama berhasil dihapus.");
                        } else {
                            Log::warning("Gagal menghapus file lama: $oldFilePath");
                        }
                    } else {
                        Log::warning("File lama tidak ditemukan: $oldFilePath");
                    }
                }

                // Generate nama file baru
                $fileName = time() . '_' . $file->getClientOriginalName();
                Log::info('Nama file baru dibuat.', ['file_name' => $fileName]);

                // Pindahkan file
                $file->move(public_path('uploads'), $fileName);
                Log::info('File berhasil diupload.', ['path' => public_path('uploads/' . $fileName)]);

                // Update nama file
                $pengumuman->file_pengumuman_guru = $fileName;
            }

            // Simpan pengumuman
            $pengumuman->save();
            Log::info('Data pengumuman berhasil disimpan.', ['pengumuman' => $pengumuman]);

            return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi input gagal.', [
                'errors' => $e->validator->errors(),
                'input' => $request->all()
            ]);
            return redirect()->back()->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            Log::error('Error Update Pengumuman.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);

            return redirect()->back()->withErrors([
                'unexpected' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
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

    public function sendEmail(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'email' => 'nullable|email',
            'judul_pengumuman_guru' => 'required|string',
            'isi_pengumuman' => 'required|string',
            'file_pengumuman_guru' => 'nullable|file|max:10240', // Maksimal 10MB
            'jurusan' => 'nullable|array', // Harus berupa array
            'jurusan.*' => 'exists:jurusan,id_jurusan', // Validasi isi array
            'kelas' => 'nullable|array', // Harus berupa array
            'kelas.*' => 'exists:kelas,id_kelas', // Validasi isi array
        ]);

        // Jika ada file, simpan ke storage
        $filePath = null;
        if ($request->hasFile('file_pengumuman_guru')) {
            $file = $request->file('file_pengumuman_guru');
            if ($file->isValid()) {
                $filePath = $file->store('uploads', 'public');
            }
        }

        // Ambil data murid berdasarkan jurusan dan/atau kelas
        $query = Murid::query();

        // Jika jurusan dipilih
        if (!empty($validated['jurusan'])) {
            $query->whereIn('id_jurusan', $validated['jurusan']);
        }

        // Jika kelas dipilih
        if (!empty($validated['kelas'])) {
            $query->whereIn('id_kelas', $validated['kelas']);
        }

        // Ambil email murid dan email orang tua
        $emails = $query->get(['email_murid', 'email_ortu']);

        // Gabungkan email murid dan orang tua ke dalam satu array
        $allEmails = $emails->flatMap(function ($item) {
            return array_filter([$item->email_murid, $item->email_ortu]); // Hanya ambil email valid
        })->unique()->toArray(); // Hapus duplikat

        // Kirim email
        $subject = $validated['judul_pengumuman_guru'];
        $body = $validated['isi_pengumuman'];

        foreach ($allEmails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if ($filePath) {
                    $fullFilePath = public_path('storage/' . $filePath);
                    $this->mailService->sendEmailWithAttachment($email, $subject, $body, $fullFilePath);
                } else {
                    $this->mailService->sendEmail($email, $subject, $body);
                }
            }
        }

        return response()->json(['message' => 'Email sent successfully!']);
    }



}
