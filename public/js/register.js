document.getElementById("registerForm").addEventListener("submit", async function (event) {
    event.preventDefault();
    
    const formData = new FormData(this);
    const jsonData = Object.fromEntries(formData.entries());

    // Sélection de la div des messages
    const messageDiv = document.getElementById("message");
    messageDiv.innerHTML = ""; // Réinitialise les messages

    try {
        const response = await fetch(this.action, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(jsonData)
        });

        const result = await response.json();

        if (response.ok) {
            if (result.redirect) {
                window.location.href = result.redirect; // Redirection après succès
            }
        } else {
            // Afficher les erreurs sous le formulaire
            if (result.errors) {
                result.errors.forEach(error => {
                    let errorElem = document.createElement("p");
                    errorElem.style.color = "red";
                    errorElem.textContent = error;
                    messageDiv.appendChild(errorElem);
                });
            }
        }
    } catch (error) {
        let errorElem = document.createElement("p");
        errorElem.style.color = "red";
        errorElem.textContent = "Une erreur est survenue. Veuillez réessayer.";
        messageDiv.appendChild(errorElem);
    }
});

