<x-dashboard-layout>

    <x-slot name="title">Inserisci Sotto-Categoria</x-slot>

    <div class="new_forms-div">
        <h1>Inserisci Sotto-Categoria</h1>
        <form id="category-form" action="" method="POST">
            @csrf

            <label for="type">Categoria:</label>
            <select id="type" name="type" required>
                <option data-id="" value="" selected disabled>Seleziona categoria Entrate</option>
                
                <option data-id="Primaria" value="Primaria">Primaria</option>
                <option data-id="Secondaria" value="Secondaria">Secondaria</option>   
                
                <option data-id="" value="" selected disabled>Seleziona categoria Spese</option>

                <option data-id="Necessità" value="Necessità">Necessità</option>
                <option data-id="Desideri" value="Desideri">Desideri</option>   
                <option data-id="Risparmio" value="Risparmio">Risparmio</option> 
            </select>
    
            <label for="subtype">Sotto-Categoria:</label>
            <input type="text" id="subtype" name="subtype" required>{{ old('subtype') }}</input>
    
            <label for="description">Descrizione:</label>
            <textarea id="description" name="description" maxlength="255" required>{{ old('description') }}</textarea>
    
            <button type="submit">Inserisci Sotto-Categoria</button>
        </form>
    </div>

    @push('scripts')
        @vite('resources/js/categories/newCategoryFormHandler.js')
    @endpush

</x-dashboard-layout>
