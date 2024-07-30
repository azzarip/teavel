<x-mail::layout>

@foreach ($parts as $part)
    {{ Illuminate\Mail\Markdown::parse($part) }}

@if(!$loop->last)
    <x-mail::button :url="$cta[$loop->index]['link']">
        {{ $cta[$loop->index]['text'] }}
    </x-mail::button>
@endif

@endforeach

<x-slot:footer>
<x-mail::footer>
    @lang('teavel::email.footer_pre') {{ $contact->marketing_at->format(trans('teavel::email.footer_date')) }} @lang('teavel::email.footer_post')

    <a href="{{ $unsubscribeLink }}">@lang('teavel::email.unsubscribe')</a>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
