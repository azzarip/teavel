@props(['star' => false])
<div style="padding-top: 4px;">
    @error('privacy_policy')
        <p class="error-msg">{{ $message }}</p>
    @enderror
    <div {{ $attributes->merge(['class' => 'inline-flex items-start']) }}>
        <input 
            type="checkbox" 
            name="privacy_policy" id="privacy_policy" 
            @checked(old('privacy_policy')) 
            class="w-4 h-4 mt-1" 
            required>
        <label for="privacy_policy" class="ml-2">{!! trans('teavel::forms.privacy_policy', ['link' => '<a href="/privacy-policy"
        class="inline-link">Privacy Policy</a>']) !!}@if($star)<span class="text-red-600 text-sm">*</span>@endif</label>
        </div>
</div>
