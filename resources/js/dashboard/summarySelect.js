document.addEventListener('DOMContentLoaded', function() {

    const selectElement = document.getElementById('summaryYearSelect');
    
    if (selectElement) {
        selectElement.addEventListener('change', function() {
            this.form.submit();
        });

    }
});
