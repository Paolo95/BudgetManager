document.addEventListener('DOMContentLoaded', function(event) {

    event.preventDefault();

    var selectElement = document.getElementById("search-type");
    var searchForm = document.getElementById("search-form");

    searchForm.addEventListener('submit', function(event) {
      
        var selectedValue = selectElement.value;

        // Check the selected value and update the form action accordingly
        if (selectedValue === "Spese") {
            searchForm.action = "/api/categories/expenseCategoryList";
        } else if (selectedValue === "Entrate") {
            searchForm.action = "/api/categories/incomingCategoryList";
        } else {
            // Prevent form submission if no valid option is selected
            searchForm.action = "";
            event.preventDefault();
            alert('Please select a valid field.');
        }

    });

    const editSubCategoryLinks = document.querySelectorAll('.edit-category');
    
    editSubCategoryLinks.forEach(link => {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
 
            const categoryID = link.getAttribute('data-category-id');
            
            var url = '';

            if(selectElement.value === 'Entrate'){
                var url = `/api/categories/incomingCategoryDetails/${categoryID}`;
            }else{
                var url = `/api/categories/expenseCategoryDetails/${categoryID}`;
            }        
                        
            try {
                const response = await fetch(url);
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
                
                const categoryData = await response.json();

                // Show the edit form if hidden
                document.getElementById('edit-form-div').style.display = 'flex';

                // Populate the edit form fields with retrieved data   
                document.getElementById('id').value = categoryData.id;
                document.getElementById('type').value = categoryData.type;
                document.getElementById('subtype').value = categoryData.subtype;
                document.getElementById('description').value = categoryData.description;
                                      
                
            } catch (error) {
                console.error('Error fetching category details:', error);
                // Handle error display or logging as needed
            }
        });
    });

    var editForm = document.getElementById("edit-form");


    editForm.addEventListener('submit', function(event) {
 
        // Check the selected value and update the form action accordingly
        if (selectElement.value === "Spese") {
            editForm.action = "/api/categories/editExpenseCategory";
        } else if (selectElement.value === "Entrate") {
            editForm.action = "/api/categories/editIncomingCategory";
        } else {
            // Prevent form submission if no valid option is selected
            editForm.action = "";
            event.preventDefault();
            alert('Please select a valid field.');
        }

    });

    const deleteCategoryLinks = document.querySelectorAll('.delete-category');

    deleteCategoryLinks.forEach(link => {
        link.addEventListener('click', async (event) => {

        event.preventDefault();

        const userConfirmed = confirm('Sei sicuro di voler eliminare questa categoria?');

        if (!userConfirmed) {
            return;
        }
            var url='';
            const categoryID = link.getAttribute('data-category-id');

            // Check the selected value and update the form action accordingly
            if (selectElement.value === "Spese") {
                url = `/api/categories/deleteExpenseCategory/${categoryID}`;
            } else if (selectElement.value === "Entrate") {
                url = `/api/categories/deleteIncomingCategory/${categoryID}`;
            } else {
                // Prevent form submission if no valid option is selected
                editForm.action = "";
                event.preventDefault();
                alert('Please select a valid field.');
            }
            
            
            try {

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ id: categoryID })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }                
            

                if (response.status === 200) {
                    toastr.success('Categoria eliminata con successo!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000); // 1 second delay
                } else {
                    toastr.error('Errore durante l\'eliminazione della categoria.');
                }                                 
               
            } catch (error) {
                console.error('Error fetching category details:', error);
            }
        });
    });

});
