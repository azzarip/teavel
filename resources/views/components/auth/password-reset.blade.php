<div>
<h1 class="mb-4 text-3xl leading-normal text-center text-black">@lang('teavel::auth.title.reset')</h1>

<form action="{{ route('password.reset') }}" method="POST">
    @csrf
    <div class="space-y-4">
        <p class="text-center">@lang('teavel::auth.message.reset')</p>
        <div>
            <label for="password" class="">Password:</label>
            <input type="password" id="password" name="password"
                class="w-full p-2 border border-gray-400 rounded-md hover:border-primary focus:border-primary"
                placeholder="@lang('teavel::auth.email.placeholder')" required aria-label="Password" autocomplete="new-password" />
                <input type="hidden" name="token" value="{{ request()->get('token') }}">
                <input type="hidden" name="uuid" value="{{ request()->get('uuid') }}">
        @error('password')
        <p class="error-msg">{{ $message }}</p>
        @enderror
    </div>
        <div class="pt-4">
            <button type="submit" class="block w-full max-w-lg py-3 mx-auto text-2xl big-button">@lang('teavel::auth.button.reset')
            </button>
        </div>
    </div>
</form>
</div>
