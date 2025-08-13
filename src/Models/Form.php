<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Jobs\CompleteForm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_form')->using(CompiledForm::class)
            ->withPivot(['id', 'created_at', 'utm_source_id', 'utm_click_id', 'utm_medium_id', 'utm_campaign_id', 'utm_term_id', 'utm_content_id']);
    }

    public static function name(string $name)
    {
        $form = self::where('name', $name)->first();

        if (! $form) {
            $form = self::create([
                'name' => $name,
                'description' => 'Automatic Generated Form',
            ]);
        }

        return $form;
    }

    public static function dispatchAfterResponse(Contact $contact): void 
    {
        \Azzarip\Teavel\Jobs\CompleteForm::dispatchAfterResponse($contact, self);
    }
}
