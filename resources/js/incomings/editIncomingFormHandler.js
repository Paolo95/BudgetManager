document.addEventListener('DOMContentLoaded', () => {
    const editIncomingLinks = document.querySelectorAll('.edit-incoming');
    
    editIncomingLinks.forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
            
            const incomingID = link.getAttribute('data-incoming-id');
            const url = `/api/incomings/loadIncomingData/${incomingID}`;
            try {
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
                
                const incoming = await response.json();
           
                // Populate the edit form fields with retrieved data
                document.getElementById('date').value = incoming.date;

                // Populate the 'type' select options
                const typeSelect = document.getElementById('type');
                typeSelect.innerHTML = ''; // Clear existing options
                
                // Create and append new options based on fetched data
                ['Primaria', 'Secondaria'].forEach(type => {
                    const option = document.createElement('option');
                    option.value = type; // Adjust this based on your data structure
                    option.textContent = type; // Adjust this based on your data structure
                    
                    // Optionally select the current type
                    if (type === incoming.type) {
                        option.selected = true;
                    }
                    typeSelect.appendChild(option);
                });

                const sottoCategoriaSelect = document.getElementById('subtype');

                sottoCategoriaSelect.innerHTML = '';

                await fetch(`/api/incomings/getSubCategories/${incoming.type}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(item => {
                            var option = document.createElement('option');
                            option.value = item.subtype;
                            option.text = item.subtype;
                            sottoCategoriaSelect.appendChild(option);

                            if (item.subtype === incoming.subtype) {
                                option.selected = true;
                            }
                        });
                        sottoCategoriaSelect.disabled = false;
                    })
                    .catch(error => console.error('Errore nel recuperare le sotto-categorie. Errore: ', error)); 
                
                
     
                document.getElementById('id').value = incoming.id;
                document.getElementById('title').value = incoming.title;
                document.getElementById('description').value = incoming.description;
                document.getElementById('amount').value = parseFloat(incoming.amount).toFixed(2);
                
                      
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

        await fetch(`/api/incomings/getSubCategories/${typeSelect.value}`)
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

    const deleteIncomingsLinks = document.querySelectorAll('.delete-incoming');

    deleteIncomingsLinks.forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
            
            const incomingID = link.getAttribute('data-incoming-id');
            const url = `/api/incomings/deleteIncomingData/${incomingID}`;
            
            try {

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ id: incomingID })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                

                if (response.status === 200) {
                    toastr.success('Entrata eliminata con successo!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000); // 1 second delay
                } else {
                    toastr.error('Errore durante l\'eliminazione dell\'entrata.');
                }                                 
               
            } catch (error) {
                console.error('Error fetching incoming details:', error);
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