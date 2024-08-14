<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Model;
use Azzarip\Teavel\Exceptions\TeavelException;

class EmailFile extends Model
{
    protected $fillable = ['file'];

    public static function file(string $filename)
    {
        return self::firstOrCreate(['file' => $filename]);
    }

    public function emails()
    {
        return $this->hasMany(Email::class, 'file_id');
    }
}
