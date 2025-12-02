document.getElementById("adminLoginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();

    if (username === "" || password === "") {
        alert("Please fill in all fields.");
        return;
    }

    alert("Front-end validation passed! (PHP backend will handle real login later)");
});
