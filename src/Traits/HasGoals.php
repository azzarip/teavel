<?php

namespace Azzarip\Teavel\Traits;

use Azzarip\Teavel\Models\Form;
use Azzarip\Teavel\Models\UTMString;
use Illuminate\Support\Facades\Cache;
use Azzarip\Teavel\Models\CompiledForm;
use Illuminate\Support\Facades\Session;
use Azzarip\Teavel\Events\FormSubmitted;

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

        if (Session::has('utm')) {
            $data = Cache::get(Session::get('utm'));
        } else {
            return [];
        }

        $utm['utm_source_id'] = $this->getStringId($data, 'source');
        $utm['utm_medium_id'] = $this->getStringId($data, 'medium');
        $utm['utm_campaign_id'] = $this->getStringId($data, 'campaign');
        $utm['utm_content_id'] = $this->getStringId($data, 'content');
        $utm['utm_term_id'] = $this->getStringId($data, 'term');

        $utm['utm_click_id'] = $data['click_id'];

        return $utm;
    }

    protected function getStringId(array $data, string $field): ?int
    {

        if (! array_key_exists($field, $data)) {
            return null;
        }

        $utm_string = UTMString::firstOrCreate(['string' => $data[$field]]);

        return $utm_string->id;
    }
}
