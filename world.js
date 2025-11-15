// Wait for the page to finish load
document.addEventListener("DOMContentLoaded", function(){
    const button = document.getElementById("lookup");
    const results = document.getElementById("result");
    const btn = document.getElementById("lookup-cities");

    // User clicks the Lookup Country Button
    button.addEventListener("click", function(){
        
        // Santize user input
        const countryData = document.getElementById("country").value;
        const country = countryData.replace(/</g, "&lt;").replace(/>/g, "&gt;").trim();

        // Look up Country information
        fetch("world.php?country=" + encodeURIComponent(country))  // AJAX request
            .then(response => response.text())
            .then(data => {
                results.innerHTML = data;
            })
            .catch(error => {
                console.error("Error:", error);
                results.innerHTML = "<p>Erorr in fetching country.</p>";  // Error message
            });
    });

    // User clicks the Lookup Cities Button
    btn.addEventListener("click", function(){
        // Santize user input
        const countryData = document.getElementById("country").value;
        const country = countryData.replace(/</g, "&lt;").replace(/>/g, "&gt;").trim();

        // Look up Ciites information
        fetch("world.php?country=" + encodeURIComponent(country) + "&lookup=cities")  // AJAX request
            .then(response => response.text())
            .then(data => {
                results.innerHTML = data;
            })
            .catch(error => {
                console.error("Error:", error);
                results.innerHTML = "<p>Erorr in fetching country.</p>";  // Error message
            });
    });
});