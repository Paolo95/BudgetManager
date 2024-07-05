document.addEventListener('DOMContentLoaded', () => {
    const editDeadlineLinks = document.querySelectorAll('.edit-deadline');
    
    editDeadlineLinks.forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
            
            const deadlineID = link.getAttribute('data-deadline-id');
            const url = `/api/deadlines/loadDeadlineData/${deadlineID}`; // Replace with your API endpoint to fetch expense details
            
            try {
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
                
                const deadline = await response.json();
           
                // Populate the edit form fields with retrieved data
                document.getElementById('date').value = deadline.date;     
                document.getElementById('id').value = deadline.id;
                document.getElementById('title').value = deadline.title;
                document.getElementById('description').value = deadline.description;
                document.getElementById('amount').value = parseFloat(deadline.amount).toFixed(2);
                
                      
                // Show the edit form if hidden
                document.getElementById('edit-form-div').style.display = 'flex';
            } catch (error) {
                console.error('Error fetching deadline details:', error);
                // Handle error display or logging as needed
            }
        });
    });

    const deleteDeadlineLinks = document.querySelectorAll('.delete-deadline');

    deleteDeadlineLinks.forEach(link => {
        link.addEventListener('click', async (event) => {

            event.preventDefault();

            const userConfirmed = confirm('Sei sicuro di voler eliminare questa scadenza?');

            if (!userConfirmed) {
                return;
            }
            
            const deadlineID = link.getAttribute('data-deadline-id');
            const url = `/api/deadlines/deleteDeadline/${deadlineID}`;
            
            try {

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ id: deadlineID })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
            

                if (response.status === 200) {
                    toastr.success('Scadenza eliminata con successo!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000); // 1 second delay
                } else {
                    toastr.error('Errore durante l\'eliminazione della scadenza.');
                }                                 
               
            } catch (error) {
                console.error('Error fetching deadline details:', error);
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