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
 

