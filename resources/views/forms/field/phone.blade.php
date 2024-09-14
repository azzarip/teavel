<div id='phone_field'>
    <label for="tel" class="block">@lang('a::forms.label.phone'):</label>
    <input type="tel" name="tel" id="tel"
        class="input-text"
        value="{{ old('tel') }}" autocomplete="tel-national">

    @error('phone')
        <p class="error-msg">{{ $message }}</p>
    @enderror
</div>

@push('scripts')
<script>
    const country_code = document.querySelector("#country_code");

    const input = document.querySelector("#tel");
    const iti = window.intlTelInput(input, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.0.1/build/js/utils.js",
        initialCountry: '{{ old('country_code') ?? 'ch' }}', // Use old value or fallback to 'ch'
        hiddenInput: function(telInputName) {
            return {
                phone: "phone",
                country: "country_code"
            };
        },
        preferredCountries: ['ch', 'de', 'at', 'it', 'fr'],
    });

    var form = input.closest('form');
    form.addEventListener('submit', function(event) {
        input.setCustomValidity('');

        console.log(iti.getValidationError());
        if (!iti.isValidNumber()) {
            input.setCustomValidity("@lang('a::validation.phone')");
            event.preventDefault();
            input.reportValidity();
        }
    });
</script>
@endpush

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.0.1/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.0.1/build/js/intlTelInput.min.js"></script>
    <style>.iti {width: 100%;}</style>
@endpush
