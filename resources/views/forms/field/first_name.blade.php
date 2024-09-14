@props(['wire' => false])
<div>
    <label for="first_name" class="block">@lang('a::forms.label.first_name'):</label>
    <input type="text" id="first_name" name="first_name"
        @if('wire')wire:model="first_name"@endif
        class="input-text"
        placeholder="@lang('a::forms.placeholder.first_name')"
        autocomplete="given-name"
        value="{{ old('first_name') }}"
        required />
    @error('first_name')
        <p class="error-msg">{{ $message }}</p>
    @enderror
</div>
