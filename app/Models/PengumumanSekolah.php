<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengumumanSekolah extends Authenticatable
{
    use HasFactory;

    protected $table = 'pengumuman_sekolah'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_pengumuman_sekolah'; // Menetapkan primary key yang benar


    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'id_user',
        'judul_pengumuman_sekolah',
        'file_pengumuman_sekolah',
        'isi_pengumuman',
        'tgl_buat',
        'created_at',
        'updated_at',
    ];

  
}
