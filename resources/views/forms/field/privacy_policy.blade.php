<div style="padding-top: 4px;">
    @error('privacy_policy')
        <p class="error-msg">{{ $message }}</p>
    @enderror
    <div class="inline-flex items-center">
        <input type="checkbox" name="privacy_policy" id="privacy_policy" @checked(old('privacy_policy')) class="w-4 h-4" required>
        <label for="privacy_policy" class="pl-2 ">{!! trans('a::forms.privacy_policy', ['link' => '<a href="/privacy-policy"
        class="inline-link">Privacy Policy</a>']) !!}</label>
        </div>
</div>
