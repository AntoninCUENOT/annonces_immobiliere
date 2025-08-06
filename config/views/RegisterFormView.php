<?php
namespace Views;

class RegisterFormView
{
    public function render(): void
    {
        ?>
        <div style="width: 300px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 6px; background: white;">
            <h2 style="text-align: center;">Créer un compte sur Find My Dream Home</h2>
            <form method="POST" action="">
                <div>
                    <label>Email</label><br>
                    <input type="email" name="email" required style="width:100%; padding: 8px;">
                </div>
                <div style="margin-top:10px;">
                    <label>Mot de passe</label><br>
                    <input type="password" name="password" required style="width:100%; padding: 8px;">
                </div>
                <div style="margin-top:10px;">
                    <label>Confirmer le mot de passe</label><br>
                    <input type="password" name="confirm_password" required style="width:100%; padding: 8px;">
                </div>
                <button type="submit" style="width: 100%; margin-top:15px;">S'inscrire</button>
            </form>
            <p style="text-align:center; margin-top:10px;">
                <a href="login.php">Déjà inscrit ? Connectez-vous</a>
            </p>
        </div>
        <?php
    }
}
