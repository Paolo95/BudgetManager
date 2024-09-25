document.addEventListener('DOMContentLoaded', function() {
    var selectElement = document.getElementById("type");
    var form = document.getElementById("category-form");

    form.addEventListener('submit', function(event) {
        var selectedValue = selectElement.value;

        // Check the selected value and update the form action accordingly
        if (selectedValue === "Necessità" || selectedValue === "Desideri" || selectedValue === "Risparmio") {
            form.action = "/api/categories/newExpenseSubCategory";
        } else if (selectedValue === "Primaria" || selectedValue === "Secondaria") {
            form.action = "/api/categories/newIncomingSubCategory";
        } else {
            // Prevent form submission if no valid option is selected
            form.action = "";
            event.preventDefault();
            alert('Please select a valid category.');
        }

    });
});
