@props(['button' => false])
<form
{{ $attributes }}
method="POST">
    @csrf
    <div class="space-y-4">
        {{ $slot }}
    </div>
    @if($button)
    <x-button type="submit">{{ $button }}</x-button>
    @endif

</form>
