const SUPABASE_URL = "https://cxcnqtnefhfivqrqxgya.supabase.co/rest/v1";
const SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImN4Y25xdG5lZmhmaXZxcnF4Z3lhIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzY3NDAzNTYsImV4cCI6MjA5MjMxNjM1Nn0.SN89oa0-PdqPA6bsaxqFGzO7uP2Gsb1XfhqvCrrDRr8";

const headers = {
  "apikey": SUPABASE_KEY,
  "Authorization": "Bearer " + SUPABASE_KEY,
  "Content-Type": "application/json",
  "Prefer": "return=representation"
};

window.onload = function() {
    var dateInput = document.getElementById("date");
    if(dateInput) {
        var today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
    }
    
    // Dynamic Navbar
    const navMenu = document.getElementById("navMenu");
    if(navMenu) {
        const user = JSON.parse(localStorage.getItem("bus_user"));
        let navHtml = `<a href="index.html">Home</a>`;
        if (user) {
            if(user.role === 'admin') {
                navHtml += `<a href="admin.html">Admin</a>`;
            } else {
                navHtml += `<a href="my_bookings.html">My Bookings</a>`;
            }
            navHtml += `<a href="#" onclick="logout()">Logout (${user.name})</a>`;
        } else {
            navHtml += `<a href="login.html">Login</a>`;
        }
        navMenu.innerHTML = navHtml;
    }
};

function logout() {
    localStorage.removeItem("bus_user");
    window.location.href = "login.html";
}
