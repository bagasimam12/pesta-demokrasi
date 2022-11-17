<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KandidatOsis extends Model
{
    use HasFactory;

    protected $table = 'kandidat_osis';

    protected $fillable = [
        'paslon_no',
        'ketua',
        'wakil',
        'gambar',
        'visi',
        'misi'
    ];
}
