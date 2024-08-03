<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $fillable = [
        'judul',
        'pengaran',
        'tanggal_publikasi',
    ];
    // protected $primaryKey = 'id_buku';
    // public $timestamps = false;
}
