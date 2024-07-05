<x-dashboard-layout>

    @php
        
        $creditDebits        = session('creditDebits', []);
        $startDate           = session('start_date', null);
      
       
    @endphp

    <x-slot name="title">Modifica Credito/Debito</x-slot>

    <div class="edit_creditDebit-div">
        <h1>Modifica Credito/Debito</h1>

        <!-- Search Form by Date Range -->
        <form action="/api/creditDebits/searchCreditDebit" method="GET" class="creditDebits-search-form" id="creditDebits-search-form">
            @csrf
            <label for="start_date">Data inizio:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}" required>
        
            <label for="end_date">Data fine:</label>
            <input type="date" id="end_date" name="end_date" value="{{ now()->format('Y-m-d') }}" required>
        
            <button id="search-button" type="submit">Cerca per Data</button>
      
            

        </form>
        

         <!-- Expense List Table -->
        @if(isset($creditDebits) && count($creditDebits) > 0)

            <table class="creditDebit-list-table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Descrizione</th>
                        <th>Totale</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($creditDebits as $exp)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($exp->date)->format('d/m/Y') }}</td>
                        <td>{{ $exp->type }}</td>
                        <td>{{ $exp->description }}</td>
                        <td>{{ number_format($exp->amount, 2, ",", ".") }} €</td>
                        <td>
                            <a href="" class="edit-creditDebit" data-creditDebit-id="{{ $exp->id }}">Modifica</a>
                            <a href="" class="delete-creditDebit" data-creditDebit-id="{{ $exp->id }}">Elimina</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif(isset($creditDebits) && count($creditDebits) === 0)
            <p>Nessun credito/debito trovato nel periodo selezionato.</p>
        @endif

        <!-- Expense Edit Form -->
        <form action="/api/creditDebits/editCreditDebit" method="POST" class="edit-form" id="edit-form">
            <div id="edit-form-div" style="display: none;">
                
                @csrf
                <!-- Input fields for editing a specific expense -->

                <input type="number" id="id" name="id" value="" hidden>

                <label for="date">Data:</label>
                <input type="date" id="date" name="date" value="" required>
        
                <label for="type">Tipo:</label>
                <select id="type" name="type" required>
                    <option data-id="" value="" selected disabled>Seleziona Tipo</option>
                    <option data-id="Credito" value="Credito">Credito</option>
                    <option data-id="Debito" value="Debito">Debito</option> 
                </select>

        
                <label for="description">Descrizione:</label>
                <textarea id="description" name="description" maxlength="255"></textarea>
        
                <label for="amount">Totale:</label>
                <input type="number" id="amount" name="amount" step="0.50" min="0" value="" required>
        
                <button type="submit">Salva Modifiche</button>
            </div>
            
        </form> 
   

   
    </div>

    @push('scripts')
        @vite('resources/js/creditDebits/editCreditDebitFormHandler.js')
    @endpush

</x-dashboard-layout>


