<x-dashboard-layout>

    @php
        
        $deadlines           = session('deadlines', []);
        $startDate           = session('start_date', null);
      
       
    @endphp

    <x-slot name="title">Modifica Scadenza</x-slot>

    <div class="edit_forms-div">
        <h1>Modifica Scadenza</h1>

        <!-- Search Form by Date Range -->
        <form action="/api/deadlines/searchDeadline" method="GET" class="search-form" id="search-form">
            @csrf
            <label for="start_date">Data inizio:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}" required>
        
            <label for="end_date">Data fine:</label>
            <input type="date" id="end_date" name="end_date" value="{{ now()->format('Y-m-d') }}" required>
        
            <button id="search-button" type="submit">Cerca per Data</button>
      
        </form>
        
        @if(isset($deadlines) && count($deadlines) > 0)

            <table class="form-list-table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Titolo</th>
                        <th>Totale</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deadlines as $exp)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($exp->date)->format('d/m/Y') }}</td>
                        <td>{{ $exp->title }}</td>
                        <td>{{ number_format($exp->amount, 2, ",", ".") }} €</td>
                        <td>
                            <a href="" class="edit-deadline" data-deadline-id="{{ $exp->id }}">Modifica</a>
                            <a href="" class="delete-deadline delete-form-button" data-deadline-id="{{ $exp->id }}">Elimina</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif(isset($deadlines) && count($deadlines) === 0)
            <p>Nessuna scadenza trovata nel periodo selezionato.</p>
        @endif

        <!-- Expense Edit Form -->
        <form action="/api/deadlines/editDeadline" method="POST" class="edit-form" id="edit-form">
            <div id="edit-form-div" style="display: none;">
                
                @csrf
                <!-- Input fields for editing a specific expense -->

                <input type="number" id="id" name="id" value="" hidden>

                <label for="date">Data:</label>
                <input type="date" id="date" name="date" value="" required>
        
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
        @vite('resources/js/deadlines/editDeadlineFormHandler.js')
    @endpush

</x-dashboard-layout>


