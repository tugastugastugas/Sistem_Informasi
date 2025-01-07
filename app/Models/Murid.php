<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Murid extends Authenticatable
{
    use HasFactory;

    protected $table = 'murid'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_murid'; // Menetapkan primary key yang benar


    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'nama_murid',
        'id_kelas',
        'email_murid',
        'email_ortu',
        'nohp_murid',
        'nohp_ortu',
        'created_at',
        'updated_at',
    ];

  
}
