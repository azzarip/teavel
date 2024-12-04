@props([
    'button' => trans('teavel::auth.register'),
    'action' => route('register'),
    'privacy_policy' => true
])
<x-forms::base :$action :$button>

<x-forms::field.first_name />

<x-forms::field.last_name />

<x-forms::field.email />

<x-forms::field.phone />

<x-forms::field.password new=true />

@if($privacy_policy)
<x-forms::field.privacy_policy />
@endif
</x-forms::base>