<div>
    @if($backUrl)
    <a href="{{ $backUrl }}" class="block mb-2 ml-2"><x-heroicon-o-arrow-left class="inline w-6 mr-1" />@lang('Back')</a>
    @endif
    <h1 class="font-head text-3xl font-semibold text-center">@lang('a::address.manage')</h1>

    <div class="w-full my-4 grid gap-x-16 gap-y-2 grid-cols-1 lg:grid-cols-2 max-lg:max-w-lg mx-auto">

        <div>
            <p class="font-head font-semibold py-3 text-2xl">@lang('a::address.shipping')</p>
            <div class="lg:min-h-[120px]">
            <div class="flex w-full items-start">
                <x-heroicon-o-truck class="w-16 lg:w-1/3 h-20 mx-auto" />
                <div class="w-2/3 mx-auto pl-6 border-l-2">
                    @foreach ($shippingAddress->toArray() as $line)
                        <p>{{ $line }}</p>
                    @endforeach
                </div>
            </div>
            @if($shippingAddress->info)
            <div x-data="{info: false}">
                <p class="mt-4 italic text-sm">{{ $shippingAddress->info }}</p>
            </div>
            @endif
            </div>
        </div>
        <div class="order-3 lg:order-2">
            <p class="font-head font-semibold py-3 text-2xl">@lang('a::address.billing')</p>
            <div class="flex w-full items-start lg:h-[120px]">
                <x-heroicon-o-clipboard-document-list class="w-16 lg:w-1/3 h-20 mx-auto" />
                <div class="w-2/3 mx-auto pl-6 border-l-2">
                    @foreach ($billingAddress->toArray() as $line)
                        <p>{{ $line }}</p>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="shippingInfo" class="w-full max-md:mb-8 order-2 lg:order-3">
            <div class="mt-8 border-2 rounded-lg w-full">
                <table>
                    @foreach ($addresses as $id => $address)
                        <tr
                            class="border-b rounded-lg cursor-pointer w-full {{ $shippingAddress->id == $id ? 'bg-amber-100' : 'hover:bg-amber-50' }}">
                            <td class="px-2 w-1/12">
                                <div class="border-2 border-black w-3 rounded-full aspect-square
                            {{ $shippingAddress->id == $id ? 'bg-yellow-600' : '' }}"
                                    wire:click="selectAddress('{{ $id }}', 'shipping')">

                                </div>
                            </td>
                            <td class="text-sm w-full" wire:click="selectAddress('{{ $id }}', 'shipping')">
                                {!! $address !!}
                            </td>
                            <td class="w-1/12 relative" x-data="{ open: false }" @click="open = !open"
                                @click.outside="open = false">
                                <x-heroicon-o-ellipsis-vertical class="w-6 hover:bg-slate-100 rounded-lg p-1 z-10" />
                                <div class="absolute bg-white top-full max-md:right-0 border rounded-lg min-w-max py-1 z-20"
                                    x-show=open>
                                    <form method="GET">
                                        <input type="hidden" name="mode" value="edit">
                                        <input type="hidden" name="type" value="shipping">
                                        <input type="hidden" name="aid" value="{{ $id }}">
                                    <button
                                        class="text-sm w-full cursor-pointer hover:bg-slate-200  mx-auto block px-2 font-semibold text-black"
                                        type="submit">
                                        <x-heroicon-o-pencil class="inline w-3 aspect-auto mr-1" /> @lang('modify')
                                    </button> </form>
                                    @if($count > 1)
                                    <button
                                        class="text-sm w-full cursor-pointer hover:bg-slate-200  mx-auto block px-2 font-semibold  text-red-700"
                                        type="button" wire:click="delete('{{ $id }}')"
                                        wire:confirm="Sind Sie sicher, dass Sie diese Adresse löschen möchten?">
                                        <x-heroicon-s-x-mark class="inline w-3 aspect-auto mr-1" /> @lang('delete')
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="mt-4">
                <form method="GET">
                    <input type="hidden" name="mode" value="create">
                    <input type="hidden" name="type" value="shipping">
                    <button type="submit"
                        class="w-8/12 text-md mx-auto block border-2 py-1 px-2 border-black hover:bg-black hover:text-white  bg-white text-black"><x-heroicon-s-plus
                            class="inline w-4 h-5 mr-5 mb-1" />@lang('a::address.new')</button>
                </form>
            </div>
        </div>


        <div id="billingInfo" class="w-full max-md:mb-8  order-4">

            <div class="mt-8 border-2 rounded-lg w-full">
                <table>
                    @foreach ($addresses as $id => $address)
                        <tr
                            class="border-b rounded-lg cursor-pointer w-full {{ $billingAddress->id == $id ? 'bg-amber-100' : 'hover:bg-amber-50' }}">
                            <td class="px-2 w-1/12">
                                <div class="border-2 border-black w-3 rounded-full aspect-square
                            {{ $billingAddress->id == $id ? 'bg-yellow-600' : '' }}"
                                    wire:click="selectAddress('{{ $id }}', 'billing')">

                                </div>
                            </td>
                            <td class="text-sm w-full" wire:click="selectAddress('{{ $id }}', 'billing')">
                                {!! $address !!}
                            </td>
                            <td class="w-1/12 relative" x-data="{ open: false }" @click="open = !open"
                                @click.outside="open = false">
                                <x-heroicon-o-ellipsis-vertical class="w-6 hover:bg-slate-100 rounded-lg p-1 z-10" />
                                <div class="absolute bg-white top-full max-md:right-0 border rounded-lg min-w-max py-1 z-20"
                                    x-show=open>

                                <form method="GET">
                                    <input type="hidden" name="mode" value="edit">
                                    <input type="hidden" name="type" value="billing">
                                    <input type="hidden" name="aid" value="{{ $id }}">

                                    <button
                                        class="text-sm w-full cursor-pointer hover:bg-slate-200  mx-auto block px-2 font-semibold text-black"
                                        type="submit">
                                        <x-heroicon-o-pencil class="inline w-3 aspect-auto mr-1" /> @lang('modify')
                                    </button></form>
                                    @if($count > 1)
                                    <button
                                        class="text-sm w-full cursor-pointer hover:bg-slate-200  mx-auto block px-2 font-semibold  text-red-700"
                                        type="button" wire:click="delete('{{ $id }}')"
                                        wire:confirm="Sind Sie sicher, dass Sie diese Adresse löschen möchten?">
                                        <x-heroicon-s-x-mark class="inline w-3 aspect-auto mr-1" /> @lang('delete')
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="mt-4">
                <form method="GET">
                    <input type="hidden" name="mode" value="create">
                    <input type="hidden" name="type" value="shipping">
                    <button type="submit"
                        class="w-8/12 text-md mx-auto block border-2 py-1 px-2 border-black hover:bg-black hover:text-white  bg-white text-black"><x-heroicon-s-plus
                            class="inline w-4 h-5 mr-5 mb-1" />@lang('a::address.new')</button>
                </form>
            </div>
        </div>


    </div>
</div>
</div>
