<header class="fixed w-full bg-white">
    <nav class="py-2.5 shadow-md bg-white border-gray-100">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
            {{-- <a href="{{ route('home') }}" class="flex items-center">
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{
                    __('layout.nav.name') }}</span>
            </a> --}}

            <div class="flex items-center lg:order-2">
                @guest
                <a href="{{ route('login') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('layout.nav.login') }}
                </a>
                <a href="{{ route('register') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                    {{ __('layout.nav.register') }}
                </a>
                @endguest

                @auth
                <div class="flex items-center lg:order-2">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('layout.nav.profile') }}
                    </x-dropdown-link>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                        {{ __('layout.nav.logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                @endauth
            </div>

            <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
                @auth
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="{{ route('settings.index') }}"
                            class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                            {{ __('layout.nav.menu.settings') }} </a>
                    </li>
                    <li>
                        <a href="{{ route('documents.index') }}"
                            class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                            {{ __('layout.nav.menu.documents') }} </a>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>
</header>
