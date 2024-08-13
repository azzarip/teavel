<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Mail\EmailContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Email extends Model
{
    protected $fillable = ['file_id', 'sequence_id'];

    public static function name(string $file, $sequence = null)
    {
        $emailFile = EmailFile::file($file);

        if ($sequence) {

            if (is_string($sequence)) {
                $sequence_id = Sequence::name($sequence)->id;
            }
            if (is_int($sequence)) {
                $sequence_id = $sequence;
            }

            $email = $emailFile->emails()->where('sequence_id', $sequence_id)->first();

        } else {
            $email = $emailFile->emails()->whereNull('sequence_id')->first();
        }

        if (! $email) {
            $email = self::create([
                'file_id' => $emailFile->id,
                'sequence_id' => $sequence ? $sequence_id : null,
            ]);
        }

        return $email;
    }

    public function getContent()
    {
        if (App::environment('production')) {
            return Cache::remember('teavel_mail_'.$this->emailFile->file, 910, function () {
                return new EmailContent($this->emailFile, $this->uuid);
            });
        } else {
            return new EmailContent($this->emailFile, $this->uuid);
        }
    }

    public function getLinks()
    {
        return $this->getContent()->getLinks();
    }

    public function emailFile()
    {
        return $this->belongsTo(EmailFile::class, 'file_id');
    }

    public function sequence()
    {
        return $this->belongsTo(Sequence::class);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class)
            ->using(ContactEmail::class)
            ->withPivot(['sent_at', 'clicked_at']);
    }

    public static function findUuid(string $uuid)
    {
        return self::where('uuid', $uuid)->first();
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($model) {
            $model->uuid = \Illuminate\Support\Str::uuid();
        });
    }
}
