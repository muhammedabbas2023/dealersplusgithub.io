document.getElementById("login-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    // Get the entered username and password
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Send a request to the server for authentication
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "authenticate.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.authenticated) {
                // Redirect to post.html if authentication is successful
                window.location.href = "post.html";
            } else {
                // Display error message if authentication fails
                alert(response.message);
            }
        }
    };
    xhr.send("username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password));
});
