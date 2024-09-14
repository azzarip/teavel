@props(['button' => false, 'action' => null, 'id' => null])
<form
@if($action) action="{{ $action }}" @endif
@if($id) id="{{ $id }}" @endif
method="POST">
    @csrf
    <div class="space-y-4">
        {{ $slot }}
    </div>
    @if($button)
    <x-button type="submit">{{ $button }}</x-button>
    @endif

</form>
