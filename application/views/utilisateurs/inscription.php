<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>

<div id="main">
    <div id="login">
        <h2>Formulaire d'inscription</h2>
        <?php
        echo "<div class='error_msg'>";
        echo validation_errors();
        echo "</div>";


        echo form_open('users/validation_inscription');

        echo form_label('Email : ');
        $data = array(
            'type' => 'email',
            'name' => 'email_value'
        );
        echo form_input($data);

        echo "</br>";

        echo form_label('Mot de Passe : ');
        echo form_password('password');

        echo "</br>";

        echo form_label('Nom : ');
        echo form_input('nom');
        echo form_label('Prénom : ');
        echo form_input('prenom');

        echo "</br>";

        echo form_label('Date de naissance : ');
        echo "<input type='date' name='datenaissance' placeholder='jj/mm/aaaa'>";

        echo "<div class='error_msg'>";
        if (isset($message_display)) {
            echo $message_display;
        }
        echo "</div>";

        echo form_label('Organisation : ');
        echo form_input('organisation');

        echo "</br>";

        echo form_label('Pays : ');
        echo form_input('pays');

        echo "</br>";

        echo form_label('Ville : ');
        echo form_input('ville');

        echo "</br></br>";
        echo form_submit('submit', 'Validation');
        echo form_close();
        ?>
    </div>
</div>