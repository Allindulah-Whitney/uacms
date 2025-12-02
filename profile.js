function enableEdit() {
    document.getElementById("fullname").disabled = false;
    document.getElementById("email").disabled = false;

    document.querySelector(".edit-btn").style.display = "none";
    document.querySelector(".save-btn").style.display = "block";
}

function saveProfile() {
    alert("This will be connected to PHP backend to update profile.");

    document.getElementById("fullname").disabled = true;
    document.getElementById("email").disabled = true;

    document.querySelector(".edit-btn").style.display = "block";
    document.querySelector(".save-btn").style.display = "none";
}

// Logout
document.getElementById("logoutBtn").onclick = function () {
    window.location.href = "backend/logout.php";
};
