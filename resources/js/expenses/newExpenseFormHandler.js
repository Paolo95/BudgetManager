document.getElementById('type').addEventListener('change', function(event) {

    event.preventDefault();

    var categoria = this.value;
    var sottoCategoriaSelect = document.getElementById('subtype');
    sottoCategoriaSelect.innerHTML = '<option value="" disabled selected>Seleziona Sotto-categoria</option>';

    if (categoria) {
        fetch(`/api/expenses/getSubCategories/${categoria}`)
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
    } else {
        sottoCategoriaSelect.disabled = true;
    }
});


document.addEventListener('DOMContentLoaded', async (event) => {

    event.preventDefault();

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
    
        
});

function formatDate(dateString) {

    let date = new Date(dateString);

    let day = date.getDate().toString().padStart(2, '0');
    let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
    let year = date.getFullYear();

    return `${day}/${month}/${year}`;
}