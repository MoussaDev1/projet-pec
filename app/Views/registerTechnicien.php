<section class="form-container">
    <h2>Devenir un nouveau technicien</h2>
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

        <div class="sp">
            <label for="specialite">Sélectionnez vos spécialités :</label><br>
            <select name="specialite[]" id="specialite" multiple required>
                <option value="mécanique">Mécanique</option>
                <option value="électronique">Électronique</option>
                <option value="réparation de carrosserie">Réparation de carrosserie</option>
                <option value="entretien">Entretien</option>
            </select><br>
        </div>

        <div class="lo">
            <label for="localisation">Localisation :</label>
            <input type="text" name="localisation" id="localisation">
            <?php if (!empty($errorRegister['localisation'])): ?>
                <?php foreach ($errorRegister['localisation'] as $error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="submit" class="button bu">S'inscrire</button>
    </form>
    <p>Déjà un compte ? <a href="/ProjetPec/public/login">Connectez-vous ici</a></p>
</section>