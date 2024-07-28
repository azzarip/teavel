<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge, chrome=1">
    <title>{{ config('app.name') }} - Email @lang('teavel::email.unsubscribe')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="w-full min-h-screen bg-stone-100">
        <div class="flex flex-col items-center justify-center h-screen px-2">
            <div class="max-w-xl p-6 border rounded-lg shadow-md">
                <h1 class="mb-2 text-4xl font-bold text-center text-gray-800">
                    {{ config('app.name') }}
                </h1>
                <h2 class="mb-6 text-3xl font-bold text-center text-gray-800"> @lang('teavel::email.unsubscribe')</h2>
                <p class="text-xl text-center">
                    @lang('teavel::email.question')
                </p>
                <form action="{{ url()->current() }}" method="POST">
                    @csrf
                    <input type="hidden" name="contact" value="{{ $contactUuid }}" />
                    <input type="hidden" name="email" value="{{ $emailUuid }}" />
                    <div class="mx-auto mt-6">
                        <button type="submit"
                            class="block w-4/5 py-2 mx-auto text-center bg-red-100 border-4 border-red-700 rounded-lg hover:bg-red-200">
                            @lang('teavel::email.unsubscribe')
                        </button>
                    </div>
                </form>
            </div>
            <p class="mt-10">
                <a class="text-center underline text-slate-600 " href={{ url('/') }}>@lang('teavel::email.back')</a>
            </p>
        </div>
    </div>
</body>

</html>
