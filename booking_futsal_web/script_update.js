    function update_input() {
        // Use JavaScript to prompt the user for an integer input
        var userInput = prompt("Enter an integer:");

        // Validate that the input is an integer
        if (!isNaN(userInput) && parseInt(userInput) == userInput) {
            // Send the input to a PHP script using an AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "process.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response from the PHP script if needed
                    console.log(xhr.responseText);
                }
            };
            xhr.send("userInput=" + userInput);
        } else {
            alert("Please enter a valid integer.");
        }
    }