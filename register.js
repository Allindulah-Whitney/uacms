document.getElementById("registerForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let fullname = document.getElementById("fullname").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let confirmPassword = document.getElementById("confirmPassword").value.trim();

    if (fullname === "" || email === "" || password === "" || confirmPassword === "") {
        alert("Please fill in all fields.");
        return;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return;
    }

    alert("Front-end validation passed! Backend PHP will handle real registration later.");
});
fetch(githubRawURL)
    .then(response => response.text())
    .then(jsonString => {
        // Format JSON cleanly
        try {
            const parsed = JSON.parse(jsonString);
            jsonString = JSON.stringify(parsed, null, 4);
        } catch (e) {
            // If it's not valid JSON, show raw text
        }

        document.getElementById("code-block").textContent = jsonString;
        hljs.highlightAll();
    });

