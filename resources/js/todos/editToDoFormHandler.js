document.addEventListener('DOMContentLoaded', () => {
    const editTodoLinks = document.querySelectorAll('.edit-todo');
    
    editTodoLinks.forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
            
            const todoID = link.getAttribute('data-todo-id');
            const url = `/api/todos/loadToDoData/${todoID}`; // Replace with your API endpoint to fetch expense details
            
            try {
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
                
                const todo = await response.json();
           
                // Populate the edit form fields with retrieved data
                document.getElementById('date').value = todo.date;     
                document.getElementById('id').value = todo.id;
                document.getElementById('title').value = todo.title;
                document.getElementById('isDone').value = todo.isDone;
                document.getElementById('amount').value = parseFloat(todo.amount).toFixed(2);
                
                      
                // Show the edit form if hidden
                document.getElementById('edit-form-div').style.display = 'flex';
            } catch (error) {
                console.error('Error fetching expense details:', error);
                // Handle error display or logging as needed
            }
        });
    });

    const deleteToDoLinks = document.querySelectorAll('.delete-todo');

    deleteToDoLinks.forEach(link => {
        link.addEventListener('click', async (event) => {
            
            event.preventDefault();

            const userConfirmed = confirm('Sei sicuro di voler eliminare questa spesa da fare?');

            if (!userConfirmed) {
                return;
            }
            
            const toDoID = link.getAttribute('data-todo-id');
            const url = `/api/todos/deleteToDo/${toDoID}`;
            
            try {

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ id: toDoID })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
            

                if (response.status === 200) {
                    toastr.success('Spesa da fare eliminata con successo!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000); // 1 second delay
                } else {
                    toastr.error('Errore durante l\'eliminazione della spesa da fare.');
                }                                 
               
            } catch (error) {
                console.error('Error fetching expense details:', error);
            }
        });
    });

});



function formatDate(dateString) {

    let date = new Date(dateString);

    let day = date.getDate().toString().padStart(2, '0');
    let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
    let year = date.getFullYear();

    return `${day}/${month}/${year}`;
}