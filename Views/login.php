<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Logowanie</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
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
            <fieldset class="p-2">
                <legend>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-fill-lock" viewBox="0 0 16 16">
                        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5v-1a2 2 0 0 1 .01-.2 4.49 4.49 0 0 1 1.534-3.693Q8.844 9.002 8 9c-5 0-6 3-6 4m7 0a1 1 0 0 1 1-1v-1a2 2 0 1 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1"/>
                    </svg>
                    Logowanie:
                </legend>
                <label for="email-id" class="form-label">Email</label>
                <input type="email" id="email-id" name="email" class="form-control" required/>
                <label for="pass-id" class="form-label">Hasło</label>
                <input type="password" id="pass-id" name="password" minlength="8" class="form-control" required/>
                <input type="submit" name="send" class="form-control" value="Wyślij">
            </fieldset>
        </form>
    </body>
</html>