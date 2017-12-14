<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body class="bg-grey-lightest h-screen" >
    <div id="app" class="">
        <flash></flash>
        <transition name="fade" >
            <div v-cloak class="absolute pin w-full h-full bg-smoke-light z-10 " v-if="sidebar" @click="sidebar = false"></div>
        </transition>
        <div class=" h-screen flex">
            <div class="bg-brand-darkest shadow-lg fixed h-full z-20 sidebar sidebar-mobile lg:sidebar-desktop md:sidebar-desktop" v-cloak :class="[sidebar ? 'sidebar-active' : '']">
                <section id="sidebar" class="w-16 h-full flex-initial inline">
                    @component('components.sidebar')
                        @slot('url')
                        {{url('/home') }}
                        @endslot
                    Dashboard
                    @endcomponent
                    @component('components.sidebar')
                        @slot('url')
                        {{url('/accounts') }}
                        @endslot
                        Accounts
                    @endcomponent
                    @component('components.sidebar')
                        @slot('url')
                        {{url('/projects') }}
                        @endslot
                        Projects
                    @endcomponent
                    @component('components.sidebar')
                        @slot('url')
                        {{url('/settings') }}
                        @endslot
                        Settings
                    @endcomponent
                </section>
            </div>
            <div class="flex-initial w-full h-screen">
                <div class="h-12 flex-initial bg-white shadow-md p-4 fixed w-full z-0 lg:inline ">
                    <button class="inline md:hidden lg:hidden w-8" @click="sidebar = !sidebar">
                        M
                    </button>
                    <span class="pl-0 md:pl-28 lg:pl-28">
                        @yield('title')
                    </span>
                    <ul class="list-reset flex float-right align-middle">
                        @auth
                            <li class="mr-6">
                            <span class="text-grey-darker text-sm pr-4">{{ Auth::user()->name }}</span>
                            </li>
                            <li class="mr-6">
                            <a href="{{ route('logout') }}"
                                class="no-underline hover:underline text-grey-darker text-sm"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            </li>
                        @endauth
                    </ul>
                </div>

                <div class="flex pl-0 md:pl-16 lg:pl-16 pt-12 h-screen" >
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
