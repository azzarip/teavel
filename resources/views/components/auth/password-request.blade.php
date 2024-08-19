<div>
    <h1 class="text-3xl leading-normal text-center text-black">Reset Password</h1>

    <form action="{{ route('password.request') }}" method="POST">
        @csrf
        <div class="pt-4 space-y-4">
            @error('token')
                <p class="px-2 py-1 text-black bg-red-300 rounded-xl"><x-heroicon-o-exclamation-triangle class="inline w-6 aspect-auto" />
                    @lang('teavel::auth.error.token')</p>
            @enderror

            <div>
                <label for="email" class="">Email:</label>
                <input type="text" id="email" name="email"
                    class="w-full p-2 border border-gray-400 rounded-md outline-none hover:border-primary focus:border-primary"
                    placeholder="@lang('teavel::auth.email.placeholder')" aria-label="Email" autocomplete="email" />
            </div>

            @error('email')
            <p class="error-msg">{{ $message }}</p>
            @enderror
            <p>@lang('teavel::auth.message.request')</p>
            <div class="pt-4">
                <button type="submit" class="block w-full max-w-lg py-3 mx-auto text-2xl big-button"> Reset Password
                </button>
            </div>
        </div>
    </form>
    <a class="block mt-4 text-center underline cursor-pointer" href={{ route('login') }}>@lang('teavel::auth.link.back')</a>
</div>
