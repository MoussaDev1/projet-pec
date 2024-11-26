<!-- app/views/register.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
    <h1>Créer un compte</h1>

    <form method="POST" action="">
        <div>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" id="username" required>
        </div>

        <div>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà un compte ? <a href="/ProjetPec/public/index.php?action=login">Connectez-vous ici</a></p>
</body>

</html>