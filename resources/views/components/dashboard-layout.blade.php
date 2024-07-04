<x-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="flex gap-4 dashboard-container">
        <aside class="sidebar w-1/5 border">
            <ul>
                <li class="menu-item">
                    <a href="/dashboard/home" class="block py-2 px-4 main-menu-link {{ request()->is('dashboard/home*') ? 'active' : '' }}">
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
                <li class="menu-item ">
                    <a href="javascript:void(0);" class="block py-2 px-4 main-menu-link {{ request()->is('dashboard/expenses/*') ? 'active' : '' }}">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-euro-sign"></i>
                            </div>
                            <div>
                                <span>Gestione Spese</span>
                            </div>
                        </div>
                    </a>
                    <ul class="submenu hidden">
                        <li class="">
                            <a href="/dashboard/expenses/new_expense" class="block py-2 px-4 {{ request()->is('dashboard/expenses/new_expense') ? 'active' : '' }}">
                                Inserisci Spesa
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/expenses/edit_expense" class="block py-2 px-4 {{ request()->is('dashboard/expenses/edit_expense') ? 'active' : '' }}">
                                Modifica Spesa
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item {{ request()->is('dashboard/new_incoming') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="block py-2 px-4 main-menu-link">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-euro-sign"></i>
                            </div>
                            <div>
                                <span>Gestione Entrate</span>
                            </div>
                        </div>
                    </a>
                    <ul class="submenu hidden">
                        <li>
                            <a href="/dashboard/new_expense/category" class="block py-2 px-4">
                                Inserisci Entrata
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/new_expense/date" class="block py-2 px-4">
                                Modifica Entrata
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/new_expense/date" class="block py-2 px-4">
                                Elimina Entrata
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item {{ request()->is('dashboard/new_expense') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="block py-2 px-4 main-menu-link">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-euro-sign"></i>
                            </div>
                            <div>
                                <span>Gestione Scadenze</span>
                            </div>
                        </div>
                    </a>
                    <ul class="submenu hidden">
                        <li>
                            <a href="/dashboard/new_expense/category" class="block py-2 px-4">
                                Inserisci Scadenza
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/new_expense/date" class="block py-2 px-4">
                                Modifica Scadenza
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/new_expense/date" class="block py-2 px-4">
                                Elimina Scadenza
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item {{ request()->is('dashboard/new_expense') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="block py-2 px-4 main-menu-link">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-euro-sign"></i>
                            </div>
                            <div>
                                <span>Gestione Crediti/Debiti</span>
                            </div>
                        </div>
                    </a>
                    <ul class="submenu hidden">
                        <li>
                            <a href="/dashboard/new_expense/category" class="block py-2 px-4">
                                Inserisci Credito/Debito
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/new_expense/date" class="block py-2 px-4">
                                Modifica Credito/Debito
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/new_expense/date" class="block py-2 px-4">
                                Elimina Credito/Debito
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item {{ request()->is('dashboard/new_expense') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="block py-2 px-4 main-menu-link">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-euro-sign"></i>
                            </div>
                            <div>
                                <span>Gestione Spese</span>
                            </div>
                        </div>
                    </a>
                    <ul class="submenu hidden">
                        <li>
                            <a href="/dashboard/new_expense/category" class="block py-2 px-4">
                                Inserisci spesa
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/new_expense/date" class="block py-2 px-4">
                                Modifica Spesa
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item {{ request()->is('dashboard/new_expense') ? 'active' : '' }}">
                    <a href="/dashboard/summary" class="block py-2 px-4 main-menu-link">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fas fa-euro-sign"></i>
                            </div>
                            <div>
                                <span>Riassunto Anno</span>
                            </div>
                        </div>
                    </a>
                   
                </li>
                
            </ul>
        </aside>
        
        <div class="dashboard-content w-4/5 border">

            {{$slot}}

            <x-bottom-buttons />
            
        </div>
    </div>
</x-layout>

