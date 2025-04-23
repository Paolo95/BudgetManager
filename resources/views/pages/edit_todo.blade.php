<x-dashboard-layout>

    @php
        
        $todos               = session('todos', []);
        $startDate           = session('start_date', null);
    @endphp

    <x-slot name="title">Modifica Spesa da Fare</x-slot>

    <div class="edit_forms-div">
        <h1>Modifica Spesa da Fare</h1>

        <form action="/api/todos/searchToDo" method="GET" class="search-form" id="search-form">
            @csrf
            <label for="start_date">Data inizio:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}" required>
        
            <label for="end_date">Data fine:</label>
            <input type="date" id="end_date" name="end_date" value="{{ now()->format('Y-m-d') }}" required>
        
            <button id="search-button" type="submit">Cerca</button>
      
            

        </form>
        

        @if(isset($todos) && count($todos) > 0)
            <div class="form-table-div">
                <table class="form-list-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Titolo</th>
                            <th>Fatta Si/No</th>
                            <th>Totale</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todos as $todo)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($todo->date)->format('d/m/Y') }}</td>
                            <td>{{ $todo->title }}</td>
                            <td>{{ $todo->isDone === 1 ? 'Si' : 'No'}}</td>
                            <td>{{ number_format($todo->amount, 2, ",", ".") }} €</td>
                            <td class="table-action">
                                <a href="" class="edit-todo" data-todo-id="{{ $todo->id }}">Modifica</a>
                                <a href="" class="delete-todo delete-form-button" data-todo-id="{{ $todo->id }}">Elimina</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif(isset($todos) && count($todos) === 0)
            <p>Nessuna spesa da fare trovata nel periodo selezionato.</p>
        @endif

        <form action="/api/todos/editToDo" method="POST" class="edit-form" id="edit-form">
            <div id="edit-form-div" style="display: none;">
                
                @csrf

                <input type="number" id="id" name="id" value="" hidden>

                <label for="date">Data:</label>
                <input type="date" id="date" name="date" value="" required>
        
                <label for="title">Titolo:</label>
                <input type="text" id="title" name="title" value="" maxlength="255" required>
        
                <label for="isDone">Fatta Si/No:</label>
                <select id="isDone" name="isDone" required>
                    <option value="1" >Si</option>
                    <option value="0" >No</option>
                </select>
        
                <label for="amount">Totale:</label>
                <input type="number" id="amount" name="amount" step="0.50" min="0" value="" required>
        
                <button type="submit">Salva Modifiche</button>
            </div>
            
        </form> 
   

   
    </div>

    @push('scripts')
        @vite('resources/js/todos/editToDoFormHandler.js')
    @endpush

</x-dashboard-layout>


