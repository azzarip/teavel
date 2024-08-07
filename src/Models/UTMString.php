<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UTMString extends Model
{
    use HasFactory;

    protected $fillable = ['string'];

    public $timestamps = false;

    protected $table = 'utm_strings';
}
