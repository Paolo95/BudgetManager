<x-layout>
    <x-slot name="title">Dashboard</x-slot>

    <button class="toggle-sidebar-btn" onclick="toggleSidebar()">☰ Menu</button>

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

                <li class="menu-item ">
                    <a href="javascript:void(0);" class="block py-2 px-4 main-menu-link {{ request()->is('dashboard/incomings/*') ? 'active' : '' }}">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fa-solid fa-sack-dollar"></i>
                            </div>
                            <div>
                                <span>Gestione Entrate</span>
                            </div>
                        </div>
                    </a>
                    <ul class="submenu hidden">
                        <li>
                            <a href="/dashboard/incomings/new_incoming" class="block py-2 px-4 {{ request()->is('dashboard/incomings/new_incoming') ? 'active' : '' }}">
                                Inserisci Entrata
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/incomings/edit_incoming" class="block py-2 px-4 {{ request()->is('dashboard/incomings/edit_incoming') ? 'active' : '' }}">
                                Modifica Entrata
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item ">
                    <a href="javascript:void(0);" class="block py-2 px-4 main-menu-link {{ request()->is('dashboard/deadlines/*') ? 'active' : '' }}">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fa-regular fa-calendar"></i>
                            </div>
                            <div>
                                <span>Gestione Scadenze</span>
                            </div>
                        </div>
                    </a>
                    <ul class="submenu hidden">
                        <li>
                            <a href="/dashboard/deadlines/new_deadline" class="block py-2 px-4 {{ request()->is('dashboard/deadlines/new_deadline') ? 'active' : '' }}">
                                Inserisci Scadenza
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/deadlines/edit_deadline" class="block py-2 px-4 {{ request()->is('dashboard/deadlines/edit_deadline') ? 'active' : '' }}">
                                Modifica Scadenza
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item ">
                    <a href="javascript:void(0);" class="block py-2 px-4 main-menu-link {{ request()->is('dashboard/creditDebits/*') ? 'active' : '' }}">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fa-solid fa-hand-holding-dollar"></i>
                            </div>
                            <div>
                                <span>Gestione Crediti/Debiti</span>
                            </div>
                        </div>
                    </a>
                    <ul class="submenu hidden">
                        <li>
                            <a href="/dashboard/creditDebits/new_creditDebit" class="block py-2 px-4 {{ request()->is('dashboard/creditDebits/new_creditDebit') ? 'active' : '' }}">
                                Inserisci Credito/Debito
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/creditDebits/edit_creditDebit" class="block py-2 px-4 {{ request()->is('dashboard/creditDebits/edit_creditDebit') ? 'active' : '' }}">
                                Modifica Credito/Debito
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item ">
                    <a href="javascript:void(0);" class="block py-2 px-4 main-menu-link {{ request()->is('dashboard/categories/*') ? 'active' : '' }}">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                            <div>
                                <span>Gestione Categorie</span>
                            </div>
                        </div>
                    </a>
                    <ul class="submenu hidden">
                        <li>
                            <a href="/dashboard/categories/new_category" class="block py-2 px-4 {{ request()->is('dashboard/categories/new_category') ? 'active' : '' }}">
                                Inserisci Categorie
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/categories/edit_category" class="block py-2 px-4 {{ request()->is('dashboard/categories/edit_category') ? 'active' : '' }}">
                                Modifica Categorie
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item ">
                    <a href="javascript:void(0);" class="block py-2 px-4 main-menu-link {{ request()->is('dashboard/todos/*') ? 'active' : '' }}">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div>
                                <span>Gestione Spese da Fare</span>
                            </div>
                        </div>
                    </a>
                    <ul class="submenu hidden">
                        <li>
                            <a href="/dashboard/todos/new_todo" class="block py-2 px-4 {{ request()->is('dashboard/todos/new_todo') ? 'active' : '' }}">
                                Inserisci Spesa da Fare
                            </a>
                        </li>
                        <li>
                            <a href="/dashboard/todos/edit_todo" class="block py-2 px-4 {{ request()->is('dashboard/todos/edit_todo') ? 'active' : '' }}">
                                Modifica Spesa da Fare
                            </a>
                        </li>
                    </ul>
                </li>

                
                <li class="menu-item ">
                    <a href="/dashboard/summary" class="block py-2 px-4 main-menu-link {{ request()->is('dashboard/summary') ? 'active' : '' }}">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="sidebar-icon fa-solid fa-retweet"></i>
                            </div>
                            <div>
                                <span>Riassunto Anno</span>
                            </div>
                        </div>
                    </a>
                   
                </li>

                <li class="menu-item ">
                    <a href="/dashboard/change_password" class="block py-2 px-4 main-menu-link {{ request()->is('dashboard/change_password') ? 'active' : '' }}">
                        <div class="flex w-auto sidebar-navbar-div">
                            <div class="w-7">
                                <i class="fas fa-key"></i>
                            </div>
                            <div>
                                <span>Cambio Password</span>
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

    @push('scripts')
        @vite('resources/js/sidebarButton/sidebarButtonHandler.js')
    @endpush

</x-layout>

