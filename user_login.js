document.getElementById("userLoginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    if (email === "" || password === "") {
        alert("Please fill in all fields.");
        return;
    }

    alert("Front-end validation passed! (PHP backend coming next)");
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

