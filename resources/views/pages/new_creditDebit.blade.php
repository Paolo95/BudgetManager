<x-dashboard-layout>

    <x-slot name="title">Inserisci Credito/Debito</x-slot>

    <div class="new_forms-div">
        <h1>Inserisci una nuova credito/debito</h1>
        <form action="/api/creditDebits/newCreditDebit" method="POST">
            @csrf
    
            <label for="date">Data:</label>
            <input type="date" id="date" name="date" value="{{ old('date') }}" required>

            <label for="type">Tipo:</label>
            <select id="type" name="type" required>
                <option data-id="" value="" selected disabled>Seleziona Tipo</option>
                <option data-id="Credito" value="Credito">Credito</option>
                <option data-id="Debito" value="Debito">Debito</option>      
            </select>
    
            <label for="description">Descrizione:</label>
            <textarea id="description" name="description" maxlength="255" required>{{ old('description') }}</textarea>
    
            <label for="amount">Totale:</label>
            <input type="number" id="amount" name="amount" step="0.50" min=0 value="{{ old('amount') }}" required>
    
            <button type="submit">Inserisci Credito/Debito</button>
        </form>
    </div>

</x-dashboard-layout>
