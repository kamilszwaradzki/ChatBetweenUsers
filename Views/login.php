<html>
    <head>
        <meta charset="UTF-8">
        <title>Logowanie</title>
        <style>
            body {
                background: linear-gradient(to bottom, #9aced9, #addbd1, #d9ccc4);
            }
            fieldset, #email-id, #pass-id {
                border-radius: 10px;
            }
            fieldset {
                display: flex;
                flex-direction: column;
                background: rgba(255,255,255,0.5);
                font-size: large;
                width: max-content;
                margin-top: 10%;
                margin-left: auto;
                margin-right: auto;
                font-size: large;
            }
            #email-id, #pass-id {
                width: 20em;
            }
            input[type='submit'] {
                width: fit-content;
                margin-top:1em;
            }
        </style>
    </head>
    <body>
        <?php
            require_once 'Classes/AuthAction.php';
            if (isset($_POST['send'])) {
                $formData = $_POST;
                $auth = new AuthAction();
                $auth->login($formData);
            }
        ?>
        <form action="/login" method="post">
            <fieldset>
                <legend>Logowanie:</legend>
                <label for="email-id">Email</label>
                <input type="email" id="email-id" name="email"required/>
                <label for="pass-id">Hasło</label>
                <input type="password" id="pass-id" name="password" minlength="8" required/>
                <input type="submit" name="send" value="Wyślij">
            </fieldset>
        </form>
    </body>
</html>