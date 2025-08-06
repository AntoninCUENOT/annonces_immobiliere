<?php
namespace Views;

class LoginFormView
{
    public function render(): void
    {
        ?>
        <div style="width: 300px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 6px; background: white;">
            <h2 style="text-align: center;">Connexion à Find My Dream Home</h2>
            <form method="POST" action="">
                <div>
                    <label>Email</label><br>
                    <input type="email" name="email" required style="width:100%; padding: 8px;">
                </div>
                <div style="margin-top:10px;">
                    <label>Mot de passe</label><br>
                    <input type="password" name="password" required style="width:100%; padding: 8px;">
                </div>
                <button type="submit" style="width: 100%; margin-top:15px;">Se connecter</button>
            </form>
            <p style="text-align:center; margin-top:10px;">
                <a href="?page=register">Pas encore de compte ? Inscrivez-vous</a>
            </p>
        </div>
        <?php
    }
}
