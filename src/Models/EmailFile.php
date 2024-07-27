<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Model;

class EmailFile extends Model
{

    protected $fillable = ['file'];

    public static function file(string $filename)
    {
        $email = self::where('file', $filename)->first();

        if (! $email) {
            $filePath = base_path('content/emails/' . $filename . '.md');

            if (! file_exists($filePath)) {
                throw new \Azzarip\Teavel\Exceptions\TeavelException("Email file $filename is missing.");
            }

            $email = self::create([
                'file' => $filename,
            ]);
        }

        return $email;
    }

}
