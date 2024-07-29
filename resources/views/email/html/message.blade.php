<x-mail::layout>

{{-- Body --}}
{{ $slot }}


{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
    <p style="align-text: center;">@lang('teavel::email.ask_unsubscribe') </p>
    <p style="align-text: center;"><a href="{{ $unsubscribeLink }}">@lang('teavel::email.unsubscribe')</a></p>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
