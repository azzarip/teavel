<x-forms::base :action="route('password.change')" :button="trans('teavel::auth.reset_password')" >

    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <p style="padding: 0.25rem 0.5rem; color: #000000; background-color: #FCA5A5; border-radius: 0.75rem;">{{ $error }}</p>
    @endforeach
    @endif
    <p>@lang('teavel::auth.message.change')</p>
    
    <div>
        <label for="password" class="block">@lang('teavel::forms.current_password.current'):</label>
        <input type="password" id="password" name="password"
            class="input-text"
            placeholder="@lang('teavel::forms.current_password.current')" required autocomplete="current-password" />
    </div>

    <div>
        <label for="password" class="block">@lang('teavel::forms.new_password.placeholder'):</label>
        <input type="new_password" id="new_password" name="new_password"
            class="input-text"
            placeholder="@lang('teavel::teavel::forms.new_password.placeholder')" required autocomplete="new-password" />
    </div>

</x-forms::base>