<x-forms::base :action="route('password.change')" :button="trans('teavel::auth.reset_password')" >

    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <p style="padding: 0.25rem 0.5rem; color: #000000; background-color: #FCA5A5; border-radius: 0.75rem;">{{ $error }}</p>
    @endforeach
    @endif
    <p>@lang('teavel::auth.message.change')</p>
    
    <div>
        <label for="password" class="block">@lang('teavel::forms.current-password.current'):</label>
        <input type="password" id="password" name="password"
            class="input-text"
        placeholder="@lang('teavel::forms.current-password.current')" required autocomplete="current-password" />
    </div>

    <div>
        <label for="new_password" class="block">@lang('teavel::forms.new-password.placeholder'):</label>
        <input type="password" id="new_password" name="new_password"
            class="input-text"
            placeholder="@lang('teavel::forms.new-password.placeholder')" required autocomplete="new-password" />
    </div>

</x-forms::base>