<x-dashboard-layout>

    <x-slot name="title">Inserisci Spesa Da Fare</x-slot>

    <div class="new_forms-div">
        <h1>Inserisci Spesa Da Fare</h1>
        <form id="todo-form" action="/api/todos/newToDo" method="POST">
            @csrf

            <label for="type">Spesa Da Fare:</label>

            <input type="text" id="title" name="title" required>{{ old('title') }}</input>
    
            <label for="amount">Importo:</label>
            <input type="number" min="0" id="amount" name="amount" required>{{ old('amount') }}</input>
    
            <button type="submit">Inserisci Spesa Da Fare</button>
        </form>
    </div>

</x-dashboard-layout>
