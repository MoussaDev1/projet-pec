<section class="form-container">
    <h2>Créer un compte client</h2>
    <form method="POST" class="form">

        <div class="na">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email">
            <?php if (!empty($errorRegister['email'])): ?>
                <?php foreach ($errorRegister['email'] as $error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="em">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password">
            <?php if (!empty($errorRegister['password'])): ?>
                <?php foreach ($errorRegister['password'] as $error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="me">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom">
            <?php if (!empty($errorRegister['nom'])): ?>
                <?php foreach ($errorRegister['nom'] as $error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="pe">
            <label for="prenom">Prenom :</label>
            <input type="text" name="prenom" id="prenom">
            <?php if (!empty($errorRegister['prenom'])): ?>
                <?php foreach ($errorRegister['prenom'] as $error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="ad">
            <label for="adresse">Adresse :</label>
            <input type="text" name="adresse" id="adresse">
            <?php if (!empty($errorRegister['adresse'])): ?>
                <?php foreach ($errorRegister['adresse'] as $error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="te">
            <label for="telephone">Numéro de téléphone :</label>
            <input type="text" name="telephone" id="telephone">
            <?php if (!empty($errorRegister['telephone'])): ?>
                <?php foreach ($errorRegister['telephone'] as $error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="submit" class="button bu">S'inscrire</button>
    </form>
    <p>Déjà un compte ? <a href="/ProjetPec/public/login">Connectez-vous ici</a></p>
</section>