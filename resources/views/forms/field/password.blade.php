@props(['new' => false])
<?php $string = $new ? 'new-password' : 'current-password'; ?>

<div>
    <label for="password" class="block">Password:</label>
    <input type="password" id="password" name="password"
        class="input-text"
        placeholder="@lang("a::forms.placeholder.$string")" required autocomplete="{{ $string }}" />
    @error('password')
    <p class="error-msg">{{ $message }}</p>
    @enderror
</div>
