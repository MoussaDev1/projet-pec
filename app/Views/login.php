<section class="login-container">
    <h2 class="login-title">Login</h2>
    <form method="POST" class="login-form">
        <label for="email" class="form-label">Email :</label>
        <input type="email" name="email" id="email" class="form-input">
        <?php if (!empty($errorLogin['email'])): ?>
            <?php foreach ($errorLogin['email'] as $error): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <label for="password" class="form-label">Mot de passe :</label>
        <input type="password" name="password" id="password" class="form-input">
        <?php if (!empty($errorLogin['password'])): ?>
            <?php foreach ($errorLogin['password'] as $error): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($errorLogin['general'])): ?>
            <?php foreach ($errorLogin['general'] as $error): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <button type="submit" class="submit-button">Se connecter</button>
    </form>

    <p class="register-link">Vous n'avez pas encore de compte client <a href="/ProjetPec/public/registerClient" class="link">Incrivez-vous ici</a></p>
    <p class="technician-link">Vous voulez devenir un technicien chez Doc 2 Wheels <a href="/ProjetPec/public/registerTechnicien" class="link">Postuler ici</a></p>
</section>