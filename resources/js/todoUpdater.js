$(document).ready(function() {
    // Event listener for checkbox change
    $('.todo-checkbox').change(function(event) {
        event.preventDefault(); // Prevent the default action

        var checkbox = $(this);
        var todoId = checkbox.data('id');
        var isDone = checkbox.is(':checked') ? '1' : '0'; 
        
        // AJAX request to update the to-do item status
        $.ajax({
            url: '/api/updateToDo/' + todoId,
            type: 'POST',
            data: {
                id: todoId,
                isDone: isDone
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr, status, error) {
                if (xhr.status === 401) {
                    alert('ERRORE: Utente non autorizzato!');
                } else {
                    alert('ERRORE: Aggiornamento fallito, riprova!');
                }
            }
        });
    });
});
