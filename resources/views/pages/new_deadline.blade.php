<x-dashboard-layout>

    <x-slot name="title">Inserisci Scadenza</x-slot>

    <div class="new_deadline-div">
        <h1>Inserisci una nuova scadenza</h1>
        <form action="/api/deadlines/newDeadline" method="POST">
            @csrf
    
            <label for="date">Data:</label>
            <input type="date" id="date" name="date" value="{{ old('date') }}" required>
    
            <label for="title">Titolo:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" maxlength="255" required>
    
            <label for="description">Descrizione:</label>
            <textarea id="description" name="description" maxlength="255">{{ old('description') }}</textarea>
    
            <label for="amount">Totale:</label>
            <input type="number" id="amount" name="amount" step="0.50" min=0 value="{{ old('amount') }}" required>
    
            <button type="submit">Inserisci Scadenza</button>
        </form>
    </div>

</x-dashboard-layout>
