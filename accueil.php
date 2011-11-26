<span class="inscription-logo">
    <p class="inscripton-text">
        Nouveau sur Agenda ? 
    </p>
    <a class="bouton" href='inscription.php'> 
        <img class="logo-inscription" src="images/compte.jpg">
    </a>
</span>
</div>
</div>
<div class="main content">
    <div class="connexion">
        <div class="box-connexion">
            <h2> Connexion</h2>
            <form method="post" action='connexion.php'>
                <label>
                    <strong class="email-label"> Email </strong>
                    <input id="Email" type="email" value="" name="email" required>
                </label>
                <label>
                    <strong class="password-label"> Mot de passe</strong>
                    <input id="Password" type="password" name="passwd" required>
                    <?php
                    if (isset($_GET['id']) &&  $_GET['id'] == 'fail')
                    {
                        echo '<span class="erreurmsg" role="alert">';
                        echo 'Le nom d\'utilisateur ou le mot de passe saisi est erroné.';
                        echo '</span>';
                    }
                   ?>
                </label>
                <input id="Connexion" type="submit" value="Connexion" name="connexion">
            </form>
        </div>
    </div>
    <div class="production-info agenda">
        <div class="production-header">
            <h1> Agenda </h1>
            <h2> L'agenda pour tous </h2>
        </div>
        <p> tiré du cahier des charges </p>
        <ul class="liste">
            <li>
                <img alt="" src="images/contact.jpg">
                <p class="titre"> Contact </p>
                <p> Vous pourrez regarder les agendas, discuter, proposer des rendez-vous avec vos contacts où que vous soyez </p>
            </li>
            <li>
                <image alt="" src="images/recherche_agenda.jpg">
                <p class=titre"> Recherche <p>
                <p> Vous pourrez faire des recherches faciles sur vos tâches, celle de vos contacts, ect.
            </li>
        </ul>
    </div>
</div>
