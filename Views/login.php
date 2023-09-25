<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
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
                <label for="pass-id">Password</label>
                <input type="password" id="pass-id" name="password" minlength="8" required/>
                <input type="submit" name="send" value="Submit">
            </fieldset>
        </form>
    </body>
</html>