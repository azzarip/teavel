<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge, chrome=1">
    <title>{{ config('app.name') }} - Email @lang('teavel.unsubscribe')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="w-full min-h-screen bg-stone-100">
    <div class="flex flex-col items-center justify-center h-screen px-2">
        <div class="max-w-xl bg-white p-6 border rounded-lg shadow-md">
            <h1 class="mb-6 text-4xl font-bold text-center text-gray-800">
                {{ config('app.name') }}
            </h1>
            <p class="text-xl text-center">
                @lang('teavel::email.success')
            </p>
            <p class="mt-8 text-center">
                <a class="underline text-slate-600 " href={{ url('/') }}>@lang('teavel::email.back')</a>
            </p>
        </div>

    </div>

</div>
</body>
</html>
