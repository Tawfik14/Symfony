document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registration-form");

    if (!form) {
        console.error("❌ ERREUR : Le formulaire 'registration-form' n'a pas été trouvé !");
        return;
    }

    form.addEventListener("submit", async function (event) {
        event.preventDefault();

        let lastname = document.getElementById("lastname")?.value.trim();
        let firstname = document.getElementById("firstname")?.value.trim();
        let dob = document.getElementById("dob")?.value;
        let gender = document.getElementById("gender")?.value;
        let email = document.getElementById("email")?.value.trim();
        let pseudo = document.getElementById("pseudo")?.value.trim();
        let password = document.getElementById("password")?.value.trim();
        let confirmPassword = document.getElementById("confirm-password")?.value.trim();
        let errorMessage = document.getElementById("error-message");

        // Vérification si tous les champs sont remplis
        if (!lastname || !firstname || !dob || !email || !pseudo || !password || !confirmPassword) {
            alert("⚠️ Tous les champs doivent être remplis !");
            return;
        }

        // Vérification des mots de passe
        if (password !== confirmPassword) {
            errorMessage.style.display = "block";
            return;
        } else {
            errorMessage.style.display = "none";
        }

        try {
            let response = await fetch("http://127.0.0.1:8000/register", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ lastname, firstname, dob, gender, email, pseudo, password })
            });

            if (!response.ok) throw new Error("Erreur d'inscription");

            let data = await response.json();
            alert("✅ Inscription réussie !");
            window.location.href = "confirmation.html";
        } catch (error) {
            console.error("❌ Erreur:", error);
            alert("Une erreur est survenue.");
        }
    });
});

