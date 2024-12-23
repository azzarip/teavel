<x-forms::base :action="route('password.change')" :button="trans('teavel::auth.reset_password')" >

    @error('token')
        <p style="padding: 0.25rem 0.5rem; color: #000000; background-color: #FCA5A5; border-radius: 0.75rem;" />
        @lang('teavel::auth.token')</p>
    @enderror

    <x-forms::field.password />
    <x-forms::field.password new=true />

    <p>@lang('teavel::auth.message.request')</p>

</x-forms::base>