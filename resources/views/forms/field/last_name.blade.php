@props(['wire' => false])
<div>
    <label for="last_name" class="block">@lang('teavel::forms.last_name.label'):</label>
    <input type="text" id="last_name" name="last_name"
        @if('wire')wire:model="last_name"@endif
        class="input-text"
        placeholder="@lang('teavel::forms.last_name.placeholder)"
        autocomplete="family-name"
        value="{{ old('last_name') }}"
        required />
    @error('last_name')
        <p class="error-msg">{{ $message }}</p>
    @enderror
</div>
