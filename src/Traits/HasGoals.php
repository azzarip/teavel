<?php

namespace Azzarip\Teavel\Traits;

use Azzarip\Teavel\Events\FormSubmitted;
use Azzarip\Teavel\Models\CompiledForm;
use Azzarip\Teavel\Models\Form;
use Azzarip\Teavel\Models\UTMString;
use Illuminate\Support\Facades\Session;

trait HasGoals
{
    public function forms()
    {
        return $this->belongsToMany(Form::class, 'contact_form')->using(CompiledForm::class)
            ->withPivot(['id', 'created_at', 'utm_source_id', 'utm_click_id', 'utm_medium_id', 'utm_campaign_id', 'utm_term_id', 'utm_content_id']);
    }

    public function completeForm($name)
    {
        $form = Form::name($name);

        $this->forms()->attach($form->id, $this->retrieveUtm());

        FormSubmitted::dispatch($form, $this);

        return $this;
    }

    protected function retrieveUtm()
    {
        $utm = [];

        if (! Session::has('utm.source')) {
            return [];
        }

        $utm['utm_source_id'] = $this->getStringId('utm.source');
        $utm['utm_medium_id'] = $this->getStringId('utm.medium');
        $utm['utm_campaign_id'] = $this->getStringId('utm.campaign');
        $utm['utm_content_id'] = $this->getStringId('utm.content');
        $utm['utm_term_id'] = $this->getStringId('utm.term');

        $utm['utm_click_id'] = Session::get('utm.click_id');

        return $utm;
    }

    protected function getStringId(string $field): ?int
    {
        $string = Session::get($field);
        if (! $string) {
            return null;
        }

        $utm_string = UTMString::firstOrCreate(['string' => $string]);

        return $utm_string->id;
    }
}
