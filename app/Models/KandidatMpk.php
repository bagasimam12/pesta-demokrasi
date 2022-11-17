<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KandidatMpk extends Model
{
    use HasFactory;

    protected $table = 'kandidat_mpk';

    protected $fillable = [
        'user_id',
        'type',
        'gambar',
        'visi',
        'misi'
    ];
}
