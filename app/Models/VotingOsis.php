<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingOsis extends Model
{
    use HasFactory;

    protected $table = 'voting_osis';

    protected $fillable = [
        'user_id',
        'kandidat_osis_id',
        'signature'
    ];

    public static function getVotingData()
    {
        return self::rightJoin(
            'kandidat_osis', 'kandidat_osis.id', '=', 'voting_osis.kandidat_osis_id'
        )->join(
            'users as u1', 'u1.id', '=', 'kandidat_osis.ketua'
        )->join(
            'users as u2', 'u2.id', '=', 'kandidat_osis.wakil'
        )->selectRaw(
            'u1.name as ketua, u2.name as wakil, kandidat_osis.gambar, kandidat_osis.paslon_no, count(voting_osis.id) as suara'
        )->groupBy(
            ['u1.name', 'u2.name', 'gambar', 'paslon_no']
        )->orderBy(
            'kandidat_osis.paslon_no', 'ASC'
        )->get();
    }
}
