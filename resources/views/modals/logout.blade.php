<div x-data="{logout: false}" x-cloak x-show="logout" @logout.window="logout = true" class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center bg-black/50">
    <div x-show="logout" x-transition.scale.origin.right.50 @click.outside="logout = false"
        class="fixed z-50 w-2/3 bg-white rounded-lg md:w-1/4 ">
        <p class="py-5 text-2xl text-center">Logout?</p>
        <form action="{{ route('logout') }}" method="POST" class="flex justify-around py-5 text-lg">
            @csrf
            <button class="h-full text-center w-[100px] border-2 border-black rounded-lg bg-black text-white" type=button @click="logout = false">Cancel</button>
            <button class="h-full text-center w-[100px] border-2 border-black rounded-lg"><x-heroicon-o-arrow-left-start-on-rectangle class="inline w-5 h-5 mb-1 text-red-500" /> Logout  </button>
        </form>
    </div>
</div>
