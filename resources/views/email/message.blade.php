<x-teavel::email.layout>

{{-- Body --}}
{{ $slot }}


{{-- Footer --}}
<x-slot:footer>
<x-teavel::email.footer>
    <p style="align-text: center;">@lang('teavel::email.ask_unsubscribe') </p>
    <p style="align-text: center;"><a href="{{ $unsubscribeLink }}">@lang('teavel::email.unsubscribe')</a></p>
</x-teavel::email.footer>
</x-slot:footer>
</x-teavel::email.layout>
