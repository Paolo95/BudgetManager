<x-dashboard-layout>

    @php
        
        $expenses            = session('expenses', []);
        $startDate           = session('start_date', null);
      
       
    @endphp

    <x-slot name="title">Modifica Spesa</x-slot>

    <div class="edit_forms-div">
        <h1>Modifica Spesa</h1>

        <!-- Search Form by Date Range -->
        <form action="/api/expenses/searchExpense" method="GET" class="search-form" id="search-form">
            @csrf
            <label for="start_date">Data inizio:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}" required>
        
            <label for="end_date">Data fine:</label>
            <input type="date" id="end_date" name="end_date" value="{{ now()->format('Y-m-d') }}" required>
        
            <button id="search-button" type="submit">Cerca per Data</button>
      
            

        </form>
        

         <!-- Expense List Table -->
        @if(isset($expenses) && count($expenses) > 0)

            <table class="form-list-table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Categoria</th>
                        <th>Sotto-Categoria</th>
                        <th>Titolo</th>
                        <th>Totale</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $exp)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($exp->date)->format('d/m/Y') }}</td>
                        <td>{{ $exp->type }}</td>
                        <td>{{ $exp->subtype }}</td>
                        <td>{{ $exp->title }}</td>
                        <td>{{ number_format($exp->amount, 2, ",", ".") }} €</td>
                        <td>
                            <a href="" class="edit-expense" data-expense-id="{{ $exp->id }}">Modifica</a>
                            <a href="" class="delete-expense delete-form-button" data-expense-id="{{ $exp->id }}">Elimina</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif(isset($expenses) && count($expenses) === 0)
            <p>Nessuna spesa trovata nel periodo selezionato.</p>
        @endif

        <!-- Expense Edit Form -->
        <form action="/api/expenses/editExpense" method="POST" class="edit-form" id="edit-form">
            <div id="edit-form-div" style="display: none;">
                
                @csrf
                <!-- Input fields for editing a specific expense -->

                <input type="number" id="id" name="id" value="" hidden>

                <label for="date">Data:</label>
                <input type="date" id="date" name="date" value="" required>
        
                <label for="type">Categoria:</label>
                <select id="type" name="type" required>
             
                </select>
        
                <label for="subtype">Sotto-categoria:</label>
                <select id="subtype" name="subtype" required disabled>
   
                </select>
        
                <label for="deadline_id">Scadenza:</label>
                <select id="deadline_id" name="deadline_id">
                    <option value="" disabled selected>Seleziona Scadenza</option>
      
                </select>
        
                <label for="title">Titolo:</label>
                <input type="text" id="title" name="title" value="" maxlength="255" required>
        
                <label for="description">Descrizione:</label>
                <textarea id="description" name="description" maxlength="255"></textarea>
        
                <label for="amount">Totale:</label>
                <input type="number" id="amount" name="amount" step="0.50" min="0" value="" required>
        
                <button type="submit">Salva Modifiche</button>
            </div>
            
        </form> 
   

   
    </div>

    @push('scripts')
        @vite('resources/js/expenses/editExpenseFormHandler.js')
    @endpush

</x-dashboard-layout>


