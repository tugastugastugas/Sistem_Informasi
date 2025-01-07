<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Authenticatable
{
    use HasFactory;

    protected $table = 'kelas'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_kelas'; // Menetapkan primary key yang benar


    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'id_user',
        'id_jurusan',
        'nama_kelas',
        'created_at',
        'updated_at',
    ];

  
}
