<div>
    @if ($mode == 'create')
        <x-forms::create-address :$type />
    @elseif($mode == 'edit')
        <x-forms::edit-address :$type :$address />
    @else
        @if(auth()->user()->has_address)
            @livewire('address-manager', ['backUrl' => $backUrl])
        @else
            <x-forms::new-address :backUrl="request()->url()" />
        @endif
    @endif
</div>
