@props(['email' => null])
<div>
    <label for="email" class="block">Email:</label>
    <input type="text" id="email" name="email"
        class="input-text"
        placeholder="@lang('teavel::forms.email.placeholder')" autocomplete="email" value="{{ $email ?? old('email') }}"
        required />
    @error('email')
        <p class="error-msg">{{ $message }}</p>
    @enderror
</div>
