@props(['email' => null])
<div>
    <label for="email" class="block">Email:</label>
    <input id="email" name="email"
        type="email"
        inputmode="email"
        autocomplete="email"
        class="input-text"
        aria-required="true" 
        placeholder="@lang('teavel::forms.email.placeholder')" 
        value="{{ $email ?? old('email') }}"
        required />
    @error('email')
        <p class="error-msg">{{ $message }}</p>
    @enderror
</div>
