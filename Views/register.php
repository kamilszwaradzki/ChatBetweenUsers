<html>
    <head>
        <meta charset="UTF-8">
        <title>Rejstracja</title>
    </head>
    <body>
        <?php
            require_once 'Classes/AuthAction.php';
            if (isset($_POST['send'])) {
                $formData = $_POST;
                $register = new AuthAction();
                $register->register($formData);
            }
        ?>
        <form action="/register" method="post">
            <fieldset>
                <legend>Rejstracja:</legend>
                <label for="email-id">Email</label>
                <input type="email" id="email-id" name="email" required/>
                <label for="pass-id">Hasło</label>
                <input type="password" id="pass-id" name="password" minlength="8" required/>
                <input type="submit" name="send" value="Wyślij">
            </fieldset>
        </form>
    </body>
</html>