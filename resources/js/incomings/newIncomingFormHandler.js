document.getElementById('type').addEventListener('change', function(event) {

    event.preventDefault();

    var categoria = this.value;
    var sottoCategoriaSelect = document.getElementById('subtype');
    sottoCategoriaSelect.innerHTML = '<option value="" disabled selected>Seleziona Sotto-categoria</option>';

    if (categoria) {
        fetch(`/api/incomings/getSubCategories/${categoria}`)
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