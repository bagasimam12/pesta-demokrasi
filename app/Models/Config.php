<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = [
    	'title',
    	'title_prefix',
    	'periode',
    	'email_prefix',
    	'voting'
    ];

    public static function getConfig()
    {
    	return self::find(1);
    }
}
