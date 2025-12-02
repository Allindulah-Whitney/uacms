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
