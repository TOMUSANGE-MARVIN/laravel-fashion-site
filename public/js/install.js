function checkComplete() {
    $.ajax({
        url: checkUrl,
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            if (response.success) {
                // Handle success case
                nextStep();
            } else {
                // Handle validation errors
                handleErrors(response.errors || {});
            }
        },
        error: function(xhr, status, error) {
            // Safely handle error response
            let errorMessage = 'An error occurred during installation.';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
            }
            // Display error message to user
            alert(errorMessage);
        }
    });
}