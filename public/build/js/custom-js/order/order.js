



    $(document).on('submit', '#OrderPlaceForm', function(e) {
        alert('yes');
        e.preventDefault(); // Prevent default form submission

        // Get the form data
        var form = $(this);
        var formData = form.serialize(); // Serialize all form inputs

        $.ajax({
            url: form.attr('action'), // Use form action as the URL
            type: 'POST', // Or change this depending on your form method
            dataType: 'json',
            data: formData, // Send the form data
            success: function(response) {
                console.log(response);
                if(response.status === true) {

                    toastr.success(response.message); // Show success message
                } else {
                    toastr.error(response.message); // Show error message
                }
            },
            error: function(xhr, status, error) {
                console.log('error', error);
            }
        });
    });




