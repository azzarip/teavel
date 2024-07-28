<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge, chrome=1">
    <title>{{ config('app.name') }} - Email @lang('teavel.email.unsubscribe')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="w-full min-h-screen">
    <div class="flex flex-col justify-center items-center h-screen">
        <div class="max-w-md p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-4xl font-bold text-gray-800 mb-6">
                {{ config('app.name') }} - @lang('teavel.email.unsubscribe')
            </h1>
            <p class="text-center text-xl">
                @('teavel.email.question')
            </p>
            <form action="{{ url()->current() }}" method="POST">
                @csrf
                <input type="hidden" name="contact" value="{{ $contactUuid }}"/>
                <input type="hidden" name="email" value="{{ $emailUuid }}"/>
                <div class="mt-6">
                    <button type="submit" class="w-full bg-gray-8">
                        @lang('teavel.email.unsubscribe')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
