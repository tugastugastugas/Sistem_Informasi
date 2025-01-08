<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengumumanGuru extends Authenticatable
{
    use HasFactory;

    protected $table = 'pengumuman_guru'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_pengumuman_guru'; // Menetapkan primary key yang benar


    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'id_user',
        'judul_pengumuman_guru',
        'file_pengumuman_guru',
        'isi_pengumuman',
        'tgl_buat',
        'id_kelas',
        'id_jurusan',
        'created_at',
        'updated_at',
    ];

  
}
