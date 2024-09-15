<div>
<h1 style="margin-bottom: 1rem; font-size: 1.875rem; line-height: 1.5; text-align: center; color: #000000;">@lang('teavel::auth.title.reset')</h1>

<x-forms::base :action="route('password.reset')" :button="__('teavel::auth.reset_password')" >

    <p>@lang('teavel::auth.message.reset')</p>

    <x-forms::field.password new=true />

    <input type="hidden" name="token" value="{{ request()->get('token') }}">
    <input type="hidden" name="uuid" value="{{ request()->get('uuid') }}">

</x-forms::base>
</div>
