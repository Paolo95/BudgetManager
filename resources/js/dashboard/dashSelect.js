document.addEventListener('DOMContentLoaded', function() {

    const dashSubmitButton = document.getElementById('dashSubmitButton');
    if (dashSubmitButton) {
        dashSubmitButton.addEventListener('click', function() {
            this.form.submit();
        });

    }
    
});
