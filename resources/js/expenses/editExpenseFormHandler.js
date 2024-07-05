document.addEventListener('DOMContentLoaded', () => {
    const editExpenseLinks = document.querySelectorAll('.edit-expense');
    
    editExpenseLinks.forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
            
            const expenseID = link.getAttribute('data-expense-id');
            const url = `/api/expenses/loadExpenseData/${expenseID}`; // Replace with your API endpoint to fetch expense details
            
            try {
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
                
                const expense = await response.json();
           
                // Populate the edit form fields with retrieved data
                document.getElementById('date').value = expense.date;

                // Populate the 'type' select options
                const typeSelect = document.getElementById('type');
                typeSelect.innerHTML = ''; // Clear existing options
                
                // Create and append new options based on fetched data
                ['Necessità', 'Desideri', 'Risparmio'].forEach(type => {
                    const option = document.createElement('option');
                    option.value = type; // Adjust this based on your data structure
                    option.textContent = type; // Adjust this based on your data structure
                    
                    // Optionally select the current type
                    if (type === expense.type) {
                        option.selected = true;
                    }
                    typeSelect.appendChild(option);
                });

                const sottoCategoriaSelect = document.getElementById('subtype');

                sottoCategoriaSelect.innerHTML = '';

                await fetch(`/api/expenses/getSubCategories/${expense.type}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(item => {
                            var option = document.createElement('option');
                            option.value = item.subtype;
                            option.text = item.subtype;
                            sottoCategoriaSelect.appendChild(option);

                            if (item.subtype === expense.subtype) {
                                option.selected = true;
                            }
                        });
                        sottoCategoriaSelect.disabled = false;
                    })
                    .catch(error => console.error('Errore nel recuperare le sotto-categorie. Errore: ', error)); 
                
                let deadlineSelect = document.getElementById('deadline_id');
                deadlineSelect.innerHTML = '<option value="" disabled selected>Seleziona Scadenza</option>';
                
                try {
                    
                    let response = await fetch(`/api/deadlines/userDeadlines`);
            
                    if (!response.ok) {
                        throw new Error(`Errore: ${response.status}`);
                    }
            
                    let data = await response.json();
                    
                    if(data.message){
            
                        deadlineSelect.innerHTML = '';
                        var option = document.createElement('option');
                        option.value = "";
                        option.text = "Nessuna Scadenza per l'utente";
                        deadlineSelect.appendChild(option);
                        deadlineSelect.disabled = true;
            
                    }else{
            
                        data.forEach(item => {
                            var option = document.createElement('option');
                            option.value = item.id;
                            option.text = `${item.title} - ${item.amount}€ - Scadenza: ${formatDate(item.date)}`;
                            deadlineSelect.appendChild(option);
                        });
                        deadlineSelect.disabled = false;
                    }
                    
                } catch (error) {
                    console.error('Errore nel recuperare le scadenze. Errore: ', error);
                }    
     
                document.getElementById('id').value = expense.id;
                document.getElementById('title').value = expense.title;
                document.getElementById('description').value = expense.description;
                document.getElementById('amount').value = parseFloat(expense.amount).toFixed(2);
                
                      
                // Show the edit form if hidden
                document.getElementById('edit-form-div').style.display = 'block';
            } catch (error) {
                console.error('Error fetching expense details:', error);
                // Handle error display or logging as needed
            }
        });
    });

    const typeSelect = document.getElementById('type');

    typeSelect.addEventListener('change', async (event) => {
 
        event.preventDefault();

        const sottoCategoriaSelect = document.getElementById('subtype');

        sottoCategoriaSelect.innerHTML = '';

        await fetch(`/api/expenses/getSubCategories/${typeSelect.value}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(item => {
                    var option = document.createElement('option');
                    option.value = item.subtype;
                    option.text = item.subtype;
                    sottoCategoriaSelect.appendChild(option);

                   
                });
                sottoCategoriaSelect.disabled = false;
            })
            .catch(error => console.error('Errore nel recuperare le sotto-categorie. Errore: ', error)); 

            
    });

    const deleteExpenseLinks = document.querySelectorAll('.delete-expense');

    deleteExpenseLinks.forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
            
            const expenseID = link.getAttribute('data-expense-id');
            const url = `/api/expenses/deleteExpense/${expenseID}`;
            
            try {

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ id: expenseID })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
            

                if (response.status === 200) {
                    toastr.success('Spesa eliminata con successo!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000); // 1 second delay
                } else {
                    toastr.error('Errore durante l\'eliminazione della spesa.');
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