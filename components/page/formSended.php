<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devis envoyée</title>
    <script>
        const fermer = () => {
            window.location.href = "https://www.acportail.fr";
        }
    </script>

    <style>
        .formAlert-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .formAlert {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 2em;
            width: 100%;
        }

        .formAlert-success h2 {
            color: #4CAF50;
        }

        .formAlert-error h2 {
            color: #F44336;
        }

        .formAlert-Header {
            border-bottom: 2px solid #4CAF50;
            margin-bottom: 15px;
        }

        .formAlert-Header h2 {
            font-size: 2.5em;
            margin: 0;
        }

        .formAlert-Body h3 {
            margin-top: 0;
            font-size: 1.5em;
        }

        .formAlert-Body p {
            font-size: 1.1em;
            line-height: 1.5;
        }

        .formAlert-Footer {
            text-align: right;
            margin-top: 15px;
        }

        .btn-formAlert {
            padding: 0.5em 1em;
            font-size: 1em;
            border: solid black 2px;
            cursor: pointer;
            background-color: white;
            text-transform: uppercase;
            font-weight: bold;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);

        }
        .btn-formAlert:hover {
            background-color: #f0f0f0;
            box-shadow: 3px 3px 7px rgba(0, 0, 0, 0.3);
            transition: all 0.2s ease-in-out;

        }
        .btn-formAlert:active {
            transform: scale(0.98);
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            background-color: black;
            color: white;
        }

    </style>
</head>

<body>

    <?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['formError'])) {
        ob_start();
        ?>
        <div class="formAlert-container">
            <div class="formAlert formAlert-error">
                <div class="formAlert-Header">
                    <h2>Erreur lors de l'envoi du formulaire</h2>
                </div>
                <div class="formAlert-Body">
                    <h3>Une erreur est survenue lors de l'envoie de vôtre demande de devis</h3>
                    <p><?php echo $_SESSION['formError']; ?></p>
                    <p>Si le problème persiste, veuillez contacter nôtre agence au : <a href="tel:0558555314">05 58 55 53 14</a> ou par mail : <a href="mailto:contact@acportail.fr">contact@acportail.fr</a></p>
                </div>
                <div class="formAlert-Footer">
                    <button class="btn btn-formAlert" onclick="fermer();">Fermer</button>
                </div>
            </div>
        </div>
        <?php
        echo ob_get_clean();
    } else if (isset($_SESSION['formSuccess'])) {
        ob_start();
        ?>
            <div class="formAlert-container">
                <div class="formAlert formAlert-success">
                    <div class="formAlert-Header">
                        <h2>Demande de devis envoyée</h2>
                    </div>
                    <div class="formAlert-Body">
                        <h3>Votre demande de devis a bien été envoyée !</h3>
                        <p>Nous vous remercions pour l'intérêt que vous nous portez. Un conseiller
                            prendra contact avec vous dans les plus brefs délais afin de discuter de votre projet et
                            de vous fournir un devis personnalisé.</p>
                        <p>Si vous avez des questions en attendant, n'hésitez pas à nous contacter au : <a href="tel:0558555314">05 58 55 53 14</a>
                            ou par mail : <a href="mailto:contact@acportail.fr">contact@acportail.fr</a></p>
                    </div>
                    <div class="formAlert-Footer">
                        <button class="btn btn-formAlert" onclick="fermer();">Fermer</button>
                    </div>
                </div>
            </div>
        <?php
        echo ob_get_clean();
    } else {
        session_destroy();
        header('Location: https://www.acportail.fr');
        exit;
    }

    session_destroy();
    ?>



</body>

</html>