<x-dashboard-layout>

    <x-slot name="title">Inserisci Spesa</x-slot>

    <div class="new_expense-div">
        <h1>Inserisci una nuova spesa</h1>
        <form action="/new_expense" method="POST">
            @csrf

            <label for="title">Titolo</label>
            <input type="text" name="title" id="title">

            <label for="subname">Descrizione</label>
            <input type="text" name="description" id="description">

            <label for="amount">Importo</label>
            <input type="text" name="amount" id="amount">

            <button type="submit">Inserisci spesa</button>
          </form>
    </div>

</x-dashboard-layout>
