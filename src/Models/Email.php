<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Mail\EmailContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Email extends Model
{
    protected $fillable = ['automation', 'sequence_id'];

    public static function name(string $automation, $sequence = null)
    {
        if ($sequence) {

            if (is_string($sequence)) {
                $sequence_id = Sequence::name($sequence)->id;
            }
            if (is_int($sequence)) {
                $sequence_id = $sequence;
            }

            $email = Email::where('automation', $automation)->where('sequence_id', $sequence_id)->first();

        } else {
            $email = Email::where('automation', $automation)->whereNull('sequence_id')->first();
        }

        if (! $email) {
            $email = self::create([
                'automation' => $automation,
                'sequence_id' => $sequence ? $sequence_id : null,
            ]);
        }

        return $email;
    }

    public function getContent()
    {
        $class = $this->getAutomation();
        if (App::environment('production')) {
            return Cache::remember('teavel_mail_'.$class, 910, function () use($class) {
                return new EmailContent($class::getContentPath(), $this->uuid);
            });
        } else {
            return new EmailContent($class::getContentPath(), $this->uuid);
        }
    }

    public function getAutomation() {
        return $this->automation;
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
