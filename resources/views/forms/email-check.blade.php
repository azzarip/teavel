@props([
    'button' => trans('teavel::forms.continue'),
    'action' => route('auth.check'),
])
<x-forms::base :$action :$button>

<x-forms::field.email />

<x-forms::field.privacy_policy />

</x-forms::base>