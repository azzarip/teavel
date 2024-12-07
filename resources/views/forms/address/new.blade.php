@props(['shipping' => true, 'backUrl' => url()->previous()])
<div class="max-w-xl mx-auto mt-2 mb-4">
    <x-forms::base :action="route('address.create')" :button="trans('teavel::address.save')">
        <input type="hidden" name="redirect" value="{{ $backUrl }}">
        <input type="hidden" name="shipping" value="true">
        <input type="hidden" name="billing" value="true">

        <div>
            <label for="name" class="block text-xl text-left">Name:</label>
            <input type="text" id="name" name="name" class="input-text"
                placeholder="@lang('teavel::forms.placeholder.name')""
                    value="{{ old('name') ?? auth()->user()->full_name }}"
                required autocomplete="name">
            @error('name')
                <p class="error-msg"> {{ $message }}</p>
            @enderror
        </div>

        <div x-data="{ co: {{ old('co')  ? 'true' : 'false'  }} }">
            <p class="pl-2 text-sm cursor-pointer link" x-show="!co" @click="co = true"><x-heroicon-s-plus-circle
                    class="inline w-5 h-5 mb-1" /> c/o</p>
            <div x-show="co" x-cloak>
                <label for="co" class="block text-xl text-left"><x-heroicon-s-minus-circle
                        class="inline w-5 h-5 mb-1" @click="co = false; clear('co')" />c/o:</label>
                <input type="text" id="co" name="co" class="input-text"
                    value="{{ old('co') }}"
             placeholder="(Optional)">
                @error('co')
                    <p class="error-msg"> {{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="line1" class="block text-xl text-left">@lang('teavel::address.line1'):</label>
            <input type="text" id="line1" name="line1" value="{{ old('line1') }}" class="input-text"
            placeholder="@lang('teavel::address.line1-placeholder')" required autocomplete="address-line1">
            @error('line1')
                <p class="error-msg"> {{ $message }}</p>
            @enderror
        </div>

        <div x-data="{ line2: {{ old('line2') ? 'true' : 'false'  }} }">
            <p class="pl-2 text-sm cursor-pointer link" x-show="!line2" @click="line2 = true"><x-heroicon-s-plus-circle
                    class="inline w-5 h-5 mb-1" /> @lang('teavel::address.line2-label')</p>
            <div x-show="line2" x-cloak>
                <label for="line2" class="block text-xl text-left"><x-heroicon-s-minus-circle
                        class="inline w-5 h-5 mb-1 link" @click="line2 = false; clear('line2')" />@lang('teavel::address.line2'):</label>
                <input type="text" id="line2" name="line2" class="input-text" value="{{ old('line2') }}"
                placeholder="(Optional)" autocomplete="address-line2">
                @error('line2')
                    <p class="error-msg"> {{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-4 gap-2">
            <div class="col-span-3 my-2">
                <label for="city" class="block text-xl text-left">@lang('teavel::address.city'):</label>
                <input type="text" id="city" name="city" value="{{ old('city') }}" class="input-text"
                placeholder="@lang('teavel::address.city')" required autocomplete="address-level2">
            </div>

            <div class="col-span-1 my-2">
                <label for="zip" class="block text-xl text-left">Plz:</label>
                <input type="text" maxlength="4" pattern="\d*" id="zip" name="zip" value="{{ old('zip') }}" class="input-text"
                placeholder="1234" required autocomplete="postal-code">
            </div>
        </div>
        @error('city')
            <p class="error-msg"> {{ $message }}</p>
        @enderror
        @error('zip')
            <p class="error-msg"> {{ $message }}</p>
        @enderror

        @if($shipping)
        <div x-data="{ info: {{ old('info') ? 'true' : 'false'  }} }">
            <p class="pl-2 text-sm cursor-pointer link" x-show="!info" @click="info = true"><x-heroicon-s-plus-circle
                    class="inline w-5 h-5 mb-1" /> @lang('teavel::address.info')</p>
            <div x-show="info" x-cloak>
                <label for="info" class="block text-xl text-left"><x-heroicon-s-minus-circle
                        class="inline w-5 h-5 mb-1 link" @click="info = false; clear('info')" />@lang('teavel::address.info'):</label>
                <textarea type="text" id="info" maxlength="500" name="info" class="input-text" value="{{ old('info') }}"
                placeholder="(Optional)"></textarea>
                @error('info')
                    <p class="error-msg"> {{ $message }}</p>
                @enderror
            </div>
        </div>
        @endif
    </x-form::base>
</div>

@push('scripts')
<script>
function clear(inputId) {
    var inputElement = document.getElementById(inputId);

    inputElement.value = '';
}
</script>
@endpush

