<x-dashboard-layout>

    <x-slot name="title">Inserisci Entrata</x-slot>

    <div class="new_incoming-div">
        <h1>Inserisci una nuova entrata</h1>
        <form action="/api/incomings/newIncoming" method="POST">
            @csrf
    
            <label for="date">Data:</label>
            <input type="date" id="date" name="date" value="{{ old('date') }}" required>
    
            <label for="type">Categoria:</label>
            <select id="type" name="type" required>
                <option data-id="" value="" selected disabled>Seleziona Categoria</option>
                <option data-id="Primaria" value="Primaria">Primaria</option>
                <option data-id="Secondaria" value="Secondaria">Secondaria</option>     
            </select>

            <label for="subtype">Sotto-categoria:</label>
            <select id="subtype" name="subtype" required disabled>
                <option value="" disabled selected>Seleziona Sotto-categoria</option>               
            </select>
    
            <label for="title">Titolo:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" maxlength="255" required>
    
            <label for="description">Descrizione:</label>
            <textarea id="description" name="description" maxlength="255">{{ old('description') }}</textarea>
    
            <label for="amount">Totale:</label>
            <input type="number" id="amount" name="amount" step="0.50" min=0 value="{{ old('amount') }}" required>
    
            <button type="submit">Inserisci Entrata</button>
        </form>
    </div>

    @push('scripts')
        @vite('resources/js/incomings/newIncomingFormHandler.js')
    @endpush

</x-dashboard-layout>
