<x-mail::layout>

@foreach ($texts as $text)
    {{ Illuminate\Mail\Markdown::parse($text) }}

@if(!$loop->last)
    <x-mail::button>
        {{ $ctas[$loop->index] }}
    </x-mail::button>
@endif

@endforeach

<x-slot:footer>
<x-mail::footer>
@lang('teavel::email.footer_pre')
{{ $contact->marketing_at->format(trans('teavel::email.footer_date')) }}
@lang('teavel::email.footer_post')

<p><a href="{{ $unsubscribeLink }}">@lang('teavel::email.unsubscribe')</a></p>

<p>{{ config('teavel.company') }}</p>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
