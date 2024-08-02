<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Automatable
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    protected string $automationPath = 'Goals\\Forms';

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
}
