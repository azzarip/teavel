<div>
    <h1 style="margin-bottom: 1rem; font-size: 1.875rem; line-height: 1.5; text-align: center; color: #000000;">Reset Password</h1>

    <x-forms::base :action="route('password.request')" button="Reset Password" >

            @error('token')
                <p style="padding: 0.25rem 0.5rem; color: #000000; background-color: #FCA5A5; border-radius: 0.75rem;" />
                @lang('teavel::auth.token')</p>
            @enderror

            <x-forms::field.email />

            <p>@lang('teavel::auth.message.request')</p>

    </x-forms::base>

    <p><a class="block mt-6 text-center underline cursor-pointer" href={{ route('login') }}>@lang('teavel::auth.link.back')</a></p>

</div>
