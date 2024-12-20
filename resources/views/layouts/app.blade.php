<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('dark') === 'true'} "
    x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
    x-bind:class="{ 'dark': darkMode }"
        >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LivewireSaaS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased">


    <div x-data="{ sidebarIsOpen: false }" class="relative flex flex-col w-full md:flex-row">
        <!-- This allows screen readers to skip the sidebar and go directly to the main content. -->
        <a class="sr-only" href="#main-content">skip to the main content</a>

        <!-- dark overlay for when the sidebar is open on smaller screens  -->
        <div x-cloak x-show="sidebarIsOpen" class="fixed inset-0 z-20 bg-neutral-950/10 backdrop-blur-sm md:hidden"
            aria-hidden="true" x-on:click="sidebarIsOpen = false" x-transition.opacity></div>


        <nav x-cloak
            class="fixed left-0 z-30 flex flex-col p-4 transition-transform duration-300 border-r h-svh w-60 shrink-0 border-neutral-300 bg-neutral-50 md:w-64 md:translate-x-0 md:relative dark:border-neutral-700 dark:bg-neutral-900"
            x-bind:class="sidebarIsOpen ? 'translate-x-0' : '-translate-x-60'" aria-label="sidebar navigation">
            <!-- logo  -->
            <a href="{{ route('welcome') }}" class="w-12 mb-4 ml-2 text-2xl font-bold text-neutral-900 dark:text-white" wire:navigate>
                <x-application-logo />

                {{-- {{ config('app.name', 'Laravel') }} --}}
            </a>



            <!-- sidebar links  -->
            <div class="flex flex-col gap-2 pb-3 overflow-y-auto">

                <x-nav-link :active="request()->routeIs('dashboard')" href="{{ route('dashboard') }}" wire:navigate>
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </x-nav-link>


            </div>


            @persist('sidebar')


            <!-- collapsible item  -->
            <div x-data="{ isExpanded: false }" class="flex flex-col">
                <button type="button" x-on:click="isExpanded = ! isExpanded" id="user-management-btn"
                    aria-controls="user-management" x-bind:aria-expanded="isExpanded ? 'true' : 'false'"
                    class="flex items-center justify-between rounded-md gap-2 px-2 py-1.5 text-sm font-medium underline-offset-2 focus:outline-none focus-visible:underline"
                    x-bind:class="isExpanded ? 'text-neutral-900 bg-black/10 dark:text-white dark:bg-white/10' :  'text-neutral-600 hover:bg-black/5 hover:text-neutral-900 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-white/5'">

                    <i class="fa-solid fa-user"></i>

                    <span class="mr-auto text-left">User Management</span>

                    <i class="transition-transform fa-solid fa-angle-up "
                    x-bind:class="isExpanded ? 'rotate-0' : 'rotate-180'" aria-hidden="true"></i>
                </button>

                <ul x-cloak x-collapse x-show="isExpanded" aria-labelledby="user-management-btn" id="user-management">
                    <li class="px-1 py-0.5 first:mt-2">
                        <x-nav-link  href="{{ route('play-ground') }}" wire:navigate>
                            <i class="fa-solid fa-play fa-spin"></i>
                            <span>Play Ground</span>
                        </x-nav-link>
                    </li>
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="#"
                            class="flex items-center rounded-md gap-2 px-2 py-1.5 text-sm text-neutral-600 underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus:outline-none focus-visible:underline dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white">Permissions</a>
                    </li>
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="#"
                            class="flex items-center rounded-md gap-2 px-2 py-1.5 text-sm text-neutral-600 underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus:outline-none focus-visible:underline dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white">Activity
                            Log</a>
                    </li>
                </ul>
            </div>


            <!-- collapsible item  -->
            <div x-data="{ isExpanded: false }" class="flex flex-col">
                <button type="button" x-on:click="isExpanded = ! isExpanded" id="user-management-btn"
                    aria-controls="user-management" x-bind:aria-expanded="isExpanded ? 'true' : 'false'"
                    class="flex items-center justify-between rounded-md gap-2 px-2 py-1.5 text-sm font-medium underline-offset-2 focus:outline-none focus-visible:underline"
                    x-bind:class="isExpanded ? 'text-neutral-900 bg-black/10 dark:text-white dark:bg-white/10' :  'text-neutral-600 hover:bg-black/5 hover:text-neutral-900 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-white/5'">

                    <i class="fa-solid fa-user"></i>

                    <span class="mr-auto text-left">User Management</span>

                    <i class="transition-transform fa-solid fa-angle-up "
                        x-bind:class="isExpanded ? 'rotate-0' : 'rotate-180'" aria-hidden="true"></i>
                </button>

                <ul x-cloak x-collapse x-show="isExpanded" aria-labelledby="user-management-btn" id="user-management">
                    <li class="px-1 py-0.5 first:mt-2">
                        <a href="#"
                            class="flex items-center rounded-md gap-2 px-2 py-1.5 text-sm text-neutral-600 underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus:outline-none focus-visible:underline dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white">Users</a>
                    </li>

                </ul>
            </div>

            @endpersist('sidebar')
        </nav>
        <!-- top navbar & main content  -->
        <div class="w-full overflow-y-auto bg-white h-svh dark:bg-neutral-950">
            <!-- top navbar  -->
            <nav class="sticky top-0 z-10 flex items-center justify-between px-4 py-2 border-b border-neutral-300 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900"
                aria-label="top navibation bar">

                <!-- sidebar toggle button for small screens  -->
                <button type="button" class="inline-block md:hidden text-neutral-600 dark:text-neutral-300"
                    x-on:click="sidebarIsOpen = true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5"
                        aria-hidden="true">
                        <path
                            d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z" />
                    </svg>
                    <span class="sr-only ">sidebar toggle</span>
                </button>

                <!-- breadcrumbs  -->
                <div></div>
                {{--
                <nav class="hidden text-sm font-medium md:inline-block text-neutral-600 dark:text-neutral-300"
                    aria-label="breadcrumb">
                    <ol class="flex flex-wrap items-center gap-1">
                        <li class="flex items-center gap-1">
                            <a href="#" class="hover:text-neutral-900 dark:hover:text-white">Dashboard</a>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor"
                                fill="none" stroke-width="2" class="size-4" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </li>

                        <li class="flex items-center gap-1 font-bold text-neutral-900 dark:text-white"
                            aria-current="page">
                            Marketing</li>
                    </ol>
                </nav>
                --}}


                <!-- Profile Menu  -->
                <div class="flex items-center gap-5">
                    <x-theme-toggle />
                    <div x-data="{ userDropdownIsOpen: false }" class="relative" x-on:keydown.esc.window="userDropdownIsOpen = false">
                        <button type="button"
                            class="flex items-center w-full gap-2 p-2 text-left rounded-md cursor-pointer text-neutral-600 hover:bg-black/5 hover:text-neutral-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white dark:focus-visible:outline-white"
                            x-bind:class="userDropdownIsOpen ? 'bg-black/10 dark:bg-white/10' : ''" aria-haspopup="true"
                            x-on:click="userDropdownIsOpen = ! userDropdownIsOpen" x-bind:aria-expanded="userDropdownIsOpen">
                            <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-7.webp"
                                class="object-cover rounded-md size-8" alt="avatar" aria-hidden="true" />
                            <div class="flex-col hidden md:flex">
                                <span class="text-sm font-bold text-neutral-900 dark:text-white">{{ Auth::user()->name
                                    }}</span>
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ Auth::user()->email
                                    }}</span>
                                <span class="sr-only">profile settings</span>
                            </div>
                        </button>

                        <!-- menu -->
                        <div x-cloak x-show="userDropdownIsOpen"
                            class="absolute right-0 z-20 w-48 bg-white border divide-y rounded-md top-14 h-fit divide-neutral-300 border-neutral-300 dark:divide-neutral-700 dark:border-neutral-700 dark:bg-neutral-950"
                            role="menu" x-on:click.outside="userDropdownIsOpen = false" x-on:keydown.down.prevent="$focus.wrap().next()"
                            x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition="" x-trap="userDropdownIsOpen">

                            <div class="flex flex-col py-1.5">
                                <a href="{{ route('profile') }}" wire:navigate
                                    class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus-visible:underline focus:outline-none dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white"
                                    role="menuitem">
                                    <i class="fa-regular fa-user"></i>
                                    <span>Profile</span>
                                </a>
                            </div>

                            {{-- <div class="flex flex-col py-1.5">
                                <a href="#"
                                    class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus-visible:underline focus:outline-none dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white"
                                    role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 shrink-0"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M7.84 1.804A1 1 0 0 1 8.82 1h2.36a1 1 0 0 1 .98.804l.331 1.652a6.993 6.993 0 0 1 1.929 1.115l1.598-.54a1 1 0 0 1 1.186.447l1.18 2.044a1 1 0 0 1-.205 1.251l-1.267 1.113a7.047 7.047 0 0 1 0 2.228l1.267 1.113a1 1 0 0 1 .206 1.25l-1.18 2.045a1 1 0 0 1-1.187.447l-1.598-.54a6.993 6.993 0 0 1-1.929 1.115l-.33 1.652a1 1 0 0 1-.98.804H8.82a1 1 0 0 1-.98-.804l-.331-1.652a6.993 6.993 0 0 1-1.929-1.115l-1.598.54a1 1 0 0 1-1.186-.447l-1.18-2.044a1 1 0 0 1 .205-1.251l1.267-1.114a7.05 7.05 0 0 1 0-2.227L1.821 7.773a1 1 0 0 1-.206-1.25l1.18-2.045a1 1 0 0 1 1.187-.447l1.598.54A6.992 6.992 0 0 1 7.51 3.456l.33-1.652ZM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Settings</span>
                                </a>
                                <a href="#"
                                    class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium text-neutral-600 underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus-visible:underline focus:outline-none dark:text-neutral-300 dark:hover:bg-white/5 dark:hover:text-white"
                                    role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 shrink-0"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M2.5 4A1.5 1.5 0 0 0 1 5.5V6h18v-.5A1.5 1.5 0 0 0 17.5 4h-15ZM19 8.5H1v6A1.5 1.5 0 0 0 2.5 16h15a1.5 1.5 0 0 0 1.5-1.5v-6ZM3 13.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75Zm4.75-.75a.75.75 0 0 0 0 1.5h3.5a.75.75 0 0 0 0-1.5h-3.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Payments</span>
                                </a>
                            </div> --}}

                            <div class="flex flex-col">
                               <livewire:pages.auth.logout />
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- main content  -->
            <div id="main-content" class="p-4">
                <div class="overflow-y-auto">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
</body>

</html>
