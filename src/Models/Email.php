<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Models\Sequence;
use Azzarip\Teavel\Models\EmailFile;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    protected $fillable = ['file_id', 'sequence_id'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class)
            ->withPivot(['sent_at', 'clicked_at']);
    }

    public static function name(string $file, ?string $sequence_name = null)
    {
        $emailFile = EmailFile::file($file);

        if($sequence_name) {
            $sequence = Sequence::name($sequence_name);
            $email = $emailFile->emails()->where('sequence_id', $sequence->id)->first();

        } else {
            $email = $emailFile->emails()->whereNull('sequence_id')->first();
        }

        if (! $email) {
            $email = self::create([
                'file_id' => $emailFile->id,
                'sequence_id' => $sequence_name ? $sequence->id : null,
            ]);
        }

        return $email;
    }

    public function emailFile()
    {
        return $this->belongsTo(EmailFile::class, 'file_id');
    }

    public function sequence()
    {
        return $this->belongsTo(Sequence::class);
    }
}
