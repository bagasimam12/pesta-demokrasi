<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingMpk extends Model
{
    use HasFactory;

    protected $table = 'voting_mpk';

    protected $fillable = [
        'user_id',
        'kandidat_mpk_id',
        'signature'
    ];

    public static function getVotingData(string $where)
    {
        throw_if(
            !in_array($where, ['wakil','ketua']), 'RuntimeException', '$where must in array of ["wakil","ketua"]'
        );

        return self::rightJoin(
            'kandidat_mpk', 'kandidat_mpk.id', '=', 'voting_mpk.kandidat_mpk_id'
        )->where(
            [ 'kandidat_mpk.type' => $where ]
        )->join(
            'users', 'users.id', '=', 'kandidat_mpk.user_id'
        )->selectRaw(
            'users.name as kandidat, kandidat_mpk.id, kandidat_mpk.gambar, kandidat_mpk.kandidat_no, count(voting_mpk.id) as suara'
        )->groupBy(
            ['users.name', 'gambar', 'kandidat_no', 'kandidat_mpk.id']
        )->orderBy(
            'kandidat_mpk.kandidat_no', 'ASC'
        )->get();
    }

    public static function checkStatusVote(string $where): bool
    {
        $ids = [];
        foreach (self::getVotingData($where) as $row) {
            $ids []= $row->id;
        }

        return VotingMpk::whereIn('kandidat_mpk_id', $ids)->where('user_id', auth()->user()->id)->first() !== null;
    }
}
