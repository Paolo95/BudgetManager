document.addEventListener('DOMContentLoaded', () => {
    const editCreditDebitLinks = document.querySelectorAll('.edit-creditDebit');
    
    editCreditDebitLinks.forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
            
            const creditDebitID = link.getAttribute('data-creditDebit-id');
            const url = `/api/creditDebits/loadCreditDebitData/${creditDebitID}`; // Replace with your API endpoint to fetch expense details
            
            try {
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
                
                const creditDebit = await response.json();
           
                // Populate the edit form fields with retrieved data
                document.getElementById('date').value = creditDebit.date;     
                document.getElementById('id').value = creditDebit.id;
                document.getElementById('type').value = creditDebit.type;
                document.getElementById('description').value = creditDebit.description;
                document.getElementById('amount').value = parseFloat(creditDebit.amount).toFixed(2);
                
                      
                // Show the edit form if hidden
                document.getElementById('edit-form-div').style.display = 'flex';
            } catch (error) {
                console.error('Error fetching creditDebit details:', error);
                // Handle error display or logging as needed
            }
        });
    });

    const deleteCreditDebitLinks = document.querySelectorAll('.delete-creditDebit');

    deleteCreditDebitLinks.forEach(link => {
        link.addEventListener('click', async (event) => {

        event.preventDefault();

        const userConfirmed = confirm('Sei sicuro di voler eliminare questo credito/debito?');

        if (!userConfirmed) {
            return;
        }
            
            const creditDebitID = link.getAttribute('data-creditDebit-id');
            const url = `/api/creditDebits/deleteCreditDebit/${creditDebitID}`;
            
            try {

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ id: creditDebitID })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
            

                if (response.status === 200) {
                    toastr.success('Credito/debito eliminato con successo!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000); // 1 second delay
                } else {
                    toastr.error('Errore durante l\'eliminazione del credito/debito.');
                }                                 
               
            } catch (error) {
                console.error('Error fetching credit/debit details:', error);
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