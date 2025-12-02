// Display current date
document.getElementById("dateDisplay").innerText = new Date().toDateString();

// Logout handler
document.getElementById("logoutBtn").onclick = function () {
    alert("Logging out...");
    window.location.href = "user_login.html"; // redirect to your login page
     window.location.href = "backend/logout.php";
}  
console.log("Dashboard loaded successfully.");
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("hidden");
}
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


