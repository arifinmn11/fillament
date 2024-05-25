@php
$cabang = App\Models\Cabang::all();
$default = App\Models\Cabang::find(Auth::user()->cabang_id);
@endphp

<div class="fi-topbar sticky top-0 z-20 overflow-x-clip">
    <nav class="flex h-16 items-center gap-x-4 bg-white px-4 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 md:px-6 lg:px-8">

        <button style="--c-300:var(--gray-300);--c-400:var(--gray-400);--c-500:var(--gray-500);--c-600:var(--gray-600);" class="fi-icon-btn relative flex items-center justify-center rounded-lg outline-none transition duration-75 focus-visible:ring-2 disabled:pointer-events-none disabled:opacity-70 -m-1.5 h-9 w-9 text-gray-400 hover:text-gray-500 focus-visible:ring-primary-600 dark:text-gray-500 dark:hover:text-gray-400 dark:focus-visible:ring-primary-500 fi-color-gray fi-topbar-open-sidebar-btn lg:hidden" title="Expand sidebar" type="button" x-data="{}" x-on:click="$store.sidebar.open()" x-show="! $store.sidebar.isOpen">
            <span class="sr-only">Expand sidebar</span>
            <svg class="fi-icon-btn-icon h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
            </svg>
        </button>

        <button style="--c-300: var(--gray-300); --c-400: var(--gray-400); --c-500: var(--gray-500); --c-600: var(--gray-600); display: none;" class="fi-icon-btn relative flex items-center justify-center rounded-lg outline-none transition duration-75 focus-visible:ring-2 disabled:pointer-events-none disabled:opacity-70 -m-1.5 h-9 w-9 text-gray-400 hover:text-gray-500 focus-visible:ring-primary-600 dark:text-gray-500 dark:hover:text-gray-400 dark:focus-visible:ring-primary-500 fi-color-gray fi-topbar-close-sidebar-btn lg:hidden" title="Collapse sidebar" type="button" x-data="{}" x-on:click="$store.sidebar.close()" x-show="$store.sidebar.isOpen">
            <span class="sr-only">Collapse sidebar</span>
            <svg class="fi-icon-btn-icon h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div x-persist="topbar.end" class="ms-auto flex items-center gap-x-4">
            <form method="POST" action="{{ route('update-cabang') }}">
                @csrf
                <x-filament::input.select class="fi-topbar-selector border-gray-400 focus:border-primary-600 focus:ring focus:ring-primary-600 focus:ring-opacity-50 rounded-md shadow-sm dark:border-gray-600 dark:focus:border-primary-500 dark:focus:ring-primary-500 dark:text-white" name="cabang_id" onchange="this.form.submit()">
                    @foreach($cabang as $c)
                    <option value="{{ $c->id }}" {{ $default->id == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                    @endforeach
                </x-filament::input.select>
            </form>
            <div x-data="{ toggle: function (event) { $refs.panel.toggle(event) }, open: function (event) { $refs.panel.open(event) }, close: function (event) { $refs.panel.close(event) } }" class="fi-dropdown fi-user-menu">
                <div x-on:click="toggle" class="fi-dropdown-trigger flex cursor-pointer">
                    <button aria-label="User menu" type="button" class="shrink-0">
                        <img class="fi-avatar object-cover object-center fi-circular rounded-full h-8 w-8 fi-user-avatar" src="https://ui-avatars.com/api/?name=T+U&amp;color=FFFFFF&amp;background=09090b">
                    </button>
                </div>
                <div x-float.placement.bottom-end.flip.teleport.offset="{ offset: 8 }" x-ref="panel" x-transition:enter-start="opacity-0" x-transition:leave-end="opacity-0" class="fi-dropdown-panel absolute z-10 w-screen divide-y divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-gray-950/5 transition dark:divide-white/5 dark:bg-gray-900 dark:ring-white/10 max-w-[14rem]" style="position: fixed; display: block; left: 1424px; top: 56px;">
                    <!-- User menu content -->
                </div>
            </div>
        </div>
    </nav>
</div>

<script>
</script>
