<x-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="flex gap-4 dashboard-container">
        <aside class="sidebar w-1/5 border">
            <ul>
                <li class="{{ request()->is('dashboard/home') ? 'active' : '' }}">
                    <a href="/dashboard/home" class="block py-2 px-4">
                        <div class="sidebar-navbar-div flex w-auto">
                            <div class="w-7">
                                <i class="fas fa-border-all"></i>
                            </div>
                            <div>
                                <span>Dashboard</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="{{ request()->is('dashboard/new_expense') ? 'active' : '' }}">
                    <a href="/dashboard/new_expense" class="block py-2 px-4">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-euro-sign"></i>
                            </div>
                            <div>
                                <span>Inserisci spesa</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="{{ request()->is('dashboard/new_incoming') ? 'active' : '' }}">
                    <a href="/dashboard/new_incoming" class="block py-2 px-4">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-hand-holding-usd"></i>
                            </div>
                            <div>
                                <span>Inserisci entrata</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="{{ request()->is('dashboard/new_incoming') ? 'active' : '' }}">
                    <a href="/dashboard/new_incoming" class="block py-2 px-4">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <div>
                                <span>Inserisci scadenza</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="{{ request()->is('dashboard/expense_details') ? 'active' : '' }}">
                    <a href="/dashboard/expense_details" class="block py-2 px-4">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-file-invoice-dollar"></i>
                            </div>
                            <div>
                                <span>Dettaglio spese</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="{{ request()->is('dashboard/incoming_details') ? 'active' : '' }}">
                    <a href="/dashboard/incoming_details" class="block py-2 px-4">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-wallet"></i>
                            </div>
                            <div>
                                <span>Dettaglio entrate</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="/dashboard/expenses_details" class="menu-link block py-2 px-4">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-business-time"></i>
                            </div>
                            <div>
                                <span>Dettaglio scadenze</span>
                            </div>
                        </div>
                    </a>
                </li>

                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="/dashboard/summary" class="menu-link block py-2 px-4">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <span>Riepilogo anno</span>
                            </div>
                        </div>
                    </a>
                </li>
               
            </ul>
        </aside>
        <div class="dashboard-content w-4/5 border">
            {{$slot}}
        </div>
    </div>
</x-layout>

