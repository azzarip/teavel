<?php

namespace Azzarip\Teavel\Traits;

use Azzarip\Teavel\Models\Form;
use Illuminate\Support\Facades\Session;

trait HasGoals
{
    public function forms()
    {
        return $this->belongsToMany(Form::class)
            ->withPivot(['created_at', 'utm_source', 'utm_click_id', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content']);
    }

    public function completeForm(string | Form $name)
    {
        $form = (is_string($name)) ? Form::name($name) : $name;

        $this->forms()->attach($form->id, $this->retrieveUtm());

        return $this;
    }

    protected function retrieveUtm()
    {
        $utm = [];

        if (Session::has('utm.source')) {
            $utm['utm_source'] = Session::get('utm.source');
        }

        if (Session::has('utm.medium')) {
            $utm['utm_medium'] = Session::get('utm.medium');
        }

        if (Session::has('utm.campaign')) {
            $utm['utm_campaign'] = Session::get('utm.campaign');
        }

        if (Session::has('utm.term')) {
            $utm['utm_term'] = Session::get('utm.term');
        }

        if (Session::has('utm.content')) {
            $utm['utm_content'] = Session::get('utm.content');
        }

        if (Session::has('utm.click_id')) {
            $utm['utm_click_id'] = Session::get('utm.click_id');
        }

        return $utm;
    }
}
