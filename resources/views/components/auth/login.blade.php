<div>
    <h1 class="mb-2 text-3xl leading-normal text-center text-black">@lang('teavel::auth.login')</h1>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="space-y-4">
            @error('user')
            <p class="px-2 py-1 text-black rounded-xl" style="background-color: #fca5a5;"><x-heroicon-o-exclamation-triangle class="inline w-6 aspect-auto" />
                {{ $message }}</p>
            @enderror

            @if(session()->has('info'))
            <p class="px-2 py-1 text-black rounded-xl" style="background-color: #86efac;"><x-heroicon-o-information-circle class="inline w-6 aspect-auto" />
                {{ session('info') }}</p>
            @endif
            <div>
                <label for="email" class="">Email:</label>
                <input type="text" id="email" name="email"
                    class="w-full p-2 border border-gray-400 rounded-md hover:border-primary focus:border-primary"
                    placeholder="@lang('teavel::auth.email.placeholder')"  aria-label="Email" autocomplete="email" value="{{ old('email') }}" />
                    @error('email')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
            </div>
            <div>
                <label for="password" class="">Password:</label>
                <input type="password" id="password" name="password"
                    class="w-full p-2 border border-gray-400 rounded-md hover:border-primary focus:border-primary"
                    placeholder="@lang('teavel::auth.password.placeholder')"  aria-label="Password" autocomplete="current-password" />
                    @error('password')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="block w-full max-w-lg py-3 mx-auto text-2xl big-button"> @lang('teavel::auth.login')
                </button>
            </div>
        </div>
    </form>
    <a class="block mt-4 text-center underline cursor-pointer" href={{ route('password.request') }}>@lang('teavel::auth.link.forgot')?</a>
</div>
