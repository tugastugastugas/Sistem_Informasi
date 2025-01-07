<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Authenticatable
{
    use HasFactory;

    protected $table = 'jurusan'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_jurusan'; // Menetapkan primary key yang benar


    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'nama_jurusan',
        'created_at',
        'updated_at',
    ];

  
}
