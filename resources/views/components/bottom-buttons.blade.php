<a href="#" class="circle-button" id="main-button">
    <i class="fas fa-plus" id="main-icon"></i> 
</a>
<a href="{{ url('/dashboard/new_expense') }}" class="circle-button new-button" id="new_expense-button" data-tooltip="Nuova Spesa">
    <i class="fa-solid fa-sack-dollar"></i>
</a>
<a href="{{ url('/dashboard/new_incoming') }}" class="circle-button new-button" id="new_incoming-button" data-tooltip="Nuova Entrata">
    <i class="fa-solid fa-hand-holding-dollar"></i>
</a>

<a href="{{ url('/dashboard/remove_expense') }}" class="circle-button remove-button" id="remove_expense-button" data-tooltip="Rimuovi Spesa">
    <i class="fa-solid fa-sack-dollar"></i>
</a>
<a href="{{ url('/dashboard/remove_incoming') }}" class="circle-button remove-button" id="remove_incoming-button" data-tooltip="Rimuovi Entrata">
    <i class="fa-solid fa-hand-holding-dollar"></i>
</a>
