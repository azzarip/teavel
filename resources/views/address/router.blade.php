<div>
    @if ($mode == 'create')
        <x-forms::address.create :$type />
    @elseif($mode == 'edit')
        <x-forms::address.edit :$type :$address />
    @else
        @if(auth()->user()->has_address)
            @livewire('address-manager', ['backUrl' => $backUrl])
        @else
            <x-forms::address.new :backUrl="request()->url()" />
        @endif
    @endif
</div>
