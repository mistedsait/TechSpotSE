$(document).ready(function() {
    $("#register-form").validate({
        rules: {
            firstname: {
                required: true
            },
            lastname: {
                required: true
            },
            email: {
                required: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            firstname: {
                required: "You must fill this field"
            },
            email: {
                required: "You must fill this field"
            },
            password: {
                minlength: "Minimum length 6 characters"
            }
        },
        submitHandler: function(form, event) {
            apiFormHandler(form, event);
        }
    });

    function showSuccessMessage(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
        });
    }

    function showErrorMessage(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
        });
    }

    function blockUi(element) {
        $(element).block({
            message: '<div class="spinner-border text-primary" role="status"></div>',
            css: {
                backgroundColor: "transparent",
                border: "0",
            },
            overlayCSS: {
                backgroundColor: "#000",
                opacity: 0.25,
            },
        });
    }

    function unblockUi(element) {
        $(element).unblock({});
    }

    function serializeForm(form) {
        let jsonResult = {
            firstname: form.firstname.value,
            lastname: form.lastname.value,
            email: form.email.value,
            password: form.password.value
        };
        return jsonResult;
    }

    function apiFormHandler(form, event) {
        event.preventDefault();
        blockUi("#register-form");
        let data = serializeForm(form);

        $.ajax({
            url: Constants.get_api_base_url() + 'users/add',
            type: "POST",
            data: JSON.stringify(data),
            contentType: "application/json",
            dataType: "json",
            success: function(response) {
                $("#register-form")[0].reset();
                showSuccessMessage("Registration successful!");
                console.log("Form submitted successfully");

                setTimeout(function() {
                    window.location.href = '#home';
                }, 2000);
            },
            error: function(xhr, status, error) {
                showErrorMessage("Username or Email already exists");
            },
            complete: function() {
                unblockUi("#register-form");
            }
        });
    }
});
