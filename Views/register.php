<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rejstracja</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <style>
            body {
                background: linear-gradient(0.75turn, #9aced9, #addbd1, #d9ccc4);
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
                $register = new AuthAction();
                $register->register($formData);
            }
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <form action="/register" method="post">
                        <fieldset class="p-2">
                            <legend class="fs-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                                Rejstracja:
                            </legend>
                            <label for="email-id" class="form-label fs-3">Email</label>
                            <input type="email" id="email-id" name="email" class="form-control form-control-lg" required/>
                            <label for="pass-id" class="form-label fs-3">Hasło</label>
                            <input type="password" id="pass-id" name="password" minlength="8" class="form-control form-control-lg" required/>
                            <input type="submit" name="send" class="form-control form-control-lg" value="Wyślij">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>