$(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        
        const email = $('#email').val();
        const password = $('#password').val();
        
        $.ajax({
            url: Constants.get_api_base_url()+'auth/login',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ email: email, password: password }),
            success: function(response) {
                // Save the JWT token in local storage or cookie
                localStorage.setItem('user', response.token);
                
                // Show success message with SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Login Successful!',
                    text: 'You have been successfully logged in.',
                });

                // Optionally, redirect to a different page after a delay
                 setTimeout(function() {
                     window.location.href = '#home';
                     location.reload();
                 }, 2000);
                 
            },
            error: function(xhr, status, error) {
                // Show error message with SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: xhr.responseText,
                });
            }
        });
    });
});
