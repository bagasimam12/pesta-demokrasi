<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaDpk extends Model
{
    use HasFactory;

    protected $table = 'anggota_dpk';

    protected $fillable = [
    	'user_id'
    ];
}
