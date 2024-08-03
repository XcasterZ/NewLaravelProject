$(document).ready(function() {
    $('form').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
        
        // Perform validation on the username field
        var username = $('textarea[name="username"]').val();
        if (!isValidUsername(username)) {
            alert('กรุณากรอกชื่อผู้ใช้ที่ถูกต้อง');
            return;
        }
        
        // If validation passes, proceed with AJAX submission
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                // Handle success response if needed
                console.log(response);
            },
            error: function(error) {
                // Handle error response if needed
                console.log(error);
            }
        });
    });
});

// Function to validate username
function isValidUsername(username) {
    // Regular expression to allow only alphanumeric characters and underscore
    var regex = /^[a-zA-Z0-9_]+$/;
    return regex.test(username);
}
