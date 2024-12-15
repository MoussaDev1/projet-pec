<section class="home-container">
    <h2 class="welcome-message">
        Bienvenue sur notre site Doc 2 Wheels !
        <?php if ($userLogged['role'] === 'admin') : ?>
            <p class="role admin"> admin
                <?= htmlspecialchars($userLogged['email']); ?>
            </p>
        <?php elseif ($userLogged['role'] === 'technicien') : ?>
            <p class="role technicien"> technicien
                <?= htmlspecialchars($userLogged['email']); ?>
            </p>
        <?php else : ?>
            <p class="role client"> client
                <?= htmlspecialchars($userLogged['email']); ?>
            </p>
        <?php endif; ?>
        <form action="/ProjetPec/public/index.php?action=home&method=logout" method="post" class="logout-form">
            <button type="submit" class="logout-button">Se déconnecter</button>
        </form>
    </h2>
</section>