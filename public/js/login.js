function login() {
    let identifier = document.getElementById("identifier").value;
    let password = document.getElementById("password").value;

    if (identifier === "" || password === "") {
        alert("Veuillez remplir tous les champs !");
        return;
    }

    // Simule une connexion (remplace ceci par une requête API avec Symfony)
    alert("Connexion réussie !");
    window.location.href = "dashboard.html"; // Redirection après connexion
}

function forgotPassword() {
    let email = prompt("Entrez votre email pour réinitialiser votre mot de passe :");
    if (email) {
        alert("Un email de réinitialisation a été envoyé à " + email);
    }
}

