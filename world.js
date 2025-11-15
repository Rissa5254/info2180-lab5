// Wait for the page to finish load
document.addEventListener("DOMContentLoaded", function(){
    const button = document.getElementById("lookup");
    const results = document.getElementById("result");

    // User clicks the Lookup Button
    button.addEventListener("click", function(){
          // prevent page from reloading
        
        // Santize user input
        const countryData = document.getElementById("country").value;
        const country = countryData.replace(/</g, "&lt;").replace(/>/g, "&gt;").trim();

        fetch("world.php?country=" + encodeURIComponent(country))  // AJAX request
            .then(response => response.text())
            .then(data => {
                results.innerHTML = data;
            })
            .catch(error => {
                console.error("Error:", error);
                results.innerHTML = "<p>Erorr in fetching country.</p>";  // Error alert message
            });
    });
});