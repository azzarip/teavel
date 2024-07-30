<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\EmailContent;
use Azzarip\Teavel\Models\Contact;
use Azzarip\Teavel\Models\Sequence;
use Azzarip\Teavel\Models\EmailFile;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    protected $fillable = ['file_id', 'sequence_id'];


    public static function name(string $file, $sequence = null)
    {
        $emailFile = EmailFile::file($file);

        if($sequence) {

            if(is_string($sequence)) {
                $sequenceId = Sequence::name($sequence);
            }
            if(is_int($sequence)) {
                $sequenceId = $sequence;
            }

            $email = $emailFile->emails()->where('sequence_id', $sequenceId)->first();

        } else {
            $email = $emailFile->emails()->whereNull('sequence_id')->first();
        }

        if (! $email) {
            $email = self::create([
                'file_id' => $emailFile->id,
                'sequence_id' => $sequence ? $sequenceId : null,
            ]);
        }

        return $email;
    }

    public function getContent() {
        return new EmailContent($this->emailFile, $this->uuid);
    }

    public function getLinks() {
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
