<div>
    <h1 class="mb-2 text-3xl leading-normal text-center text-black">@lang('login')</h1>


    <x-forms::base :action="route('login')" :button="trans('login')" >
        @error('user')
        <p class="px-2 py-1 text-black rounded-xl" style="background-color: #fca5a5;"><x-heroicon-o-exclamation-triangle
            style="display: inline; width: 24px; height: 24px;" />
            @lang("teavel::auth.$message")</p>
        @enderror

        @if(session()->has('info'))
        <p class="px-2 py-1 text-black rounded-xl" style="background-color: #86efac;"><x-heroicon-o-information-circle style="display: inline; width: 24px; height: 24px;" />
            {{ session('info') }}</p>
        @endif

        <x-forms::field.email />

        <x-forms::field.password />
    </x-forms::base>
    <a class="block mt-4 text-center underline cursor-pointer" href={{ route('password.request') }}>@lang('teavel::auth.link.forgot')?</a>
</div>
