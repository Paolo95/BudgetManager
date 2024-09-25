<x-dashboard-layout>

    @php
        
        $expenseCategories = session('expenseCategories', []);
        $incomingCategories = session('incomingCategories', []);          
        $selectedValue = session('selectedValue', ''); 
    @endphp

    <x-slot name="title">Modifica Categoria</x-slot>

    <div class="edit_forms-div">
        <h1>Modifica Categoria</h1>

        <!-- Search Form by Date Range -->
        <form action="" method="GET" class="search-form" id="search-form">
            @csrf
            <select id="search-type" name="search-type" required>
                <option value="" disabled {{ $selectedValue === '' ? 'selected' : ''}}>Seleziona tipologia</option>
                <option value="Entrate" {{ $selectedValue === 'Entrate' ? 'selected' : ''}}>Entrate</option>
                <option value="Spese" {{ $selectedValue === 'Spese' ? 'selected' : ''}}>Spese</option>
            </select>
        
            <button id="search-button" type="submit">Cerca</button>
      
            

        </form>
        

         <!-- Expense List Table -->
        @if( isset($expenseCategories) && count($expenseCategories) > 0)

            <table class="form-list-table">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Sotto-Categoria</th>
                        <th>Descrizione</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenseCategories as $exp)
                    <tr>
                        <td>{{ $exp->type }}</td>
                        <td>{{ $exp->subtype }}</td>
                        <td>{{ $exp->description}}</td>
                        <td>
                            <a href="" class="edit-category" data-category-id="{{ $exp->id }}">Modifica</a>
                            <a href="" class="delete-category delete-form-button" data-category-id="{{ $exp->id }}">Elimina</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif( isset($incomingCategories) && count($incomingCategories) > 0)
            <table class="form-list-table">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Sotto-Categoria</th>
                        <th>Descrizione</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incomingCategories as $exp)
                    <tr>
                        <td>{{ $exp->type }}</td>
                        <td>{{ $exp->subtype }}</td>
                        <td>{{ $exp->description}}</td>
                        <td>
                            <a href="" class="edit-category" data-category-id="{{ $exp->id }}">Modifica</a>
                            <a href="" class="delete-category delete-form-button" data-category-id="{{ $exp->id }}">Elimina</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Expense Edit Form -->
        <form action="" method="POST" class="edit-form" id="edit-form">
            <div id="edit-form-div" style="display: none;">
                
                @csrf
                <!-- Input fields for editing a specific expense -->

                <input type="number" id="id" name="id" value="" hidden>
        
                <label for="type">Categoria:</label>
                <select id="type" name="type" required>
                    <option value="" disabled {{ $selectedValue === '' ? 'selected' : ''}}>Seleziona categoria</option>
                    @if($selectedValue === 'Entrate')
                        <option value="Primaria">Primaria</option>
                        <option value="Secondaria">Secondaria</option>
                    @else
                        <option value="Necessità">Necessità</option>
                        <option value="Desideri">Desideri</option>
                        <option value="Risparmio">Risparmio</option>
                    @endif
                </select>

                <label for="subtype">Sotto-Categoria:</label>
                <input type="text" id="subtype" name="subtype" value="">

        
                <label for="description">Descrizione:</label>
                <textarea id="description" name="description" maxlength="255"></textarea>
    
        
                <button type="submit">Salva Modifiche</button>
            </div>
            
        </form> 
   

   
    </div>

    @push('scripts')
        @vite('resources/js/categories/editCategoriesFormHandler.js')
    @endpush

</x-dashboard-layout>


