<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AuthAction
 *
 * @author Kamil Szwaradzki <kamil.szwaradzki at your.org>
 */
require_once 'Interfaces/AuthenticationInterface.php';
require_once 'DataBaseObject.php';

class AuthAction implements AuthenticationInterface {
    public DataBaseObject $pdo;
    public string $alg = 'sha3-256';

    public function __construct() {
        $this->pdo = new DataBaseObject();
    }

    public function register($formData) {
        $user_exist = $this->pdo->prepare('SELECT id FROM CBU_users WHERE email = ?');
        $user_exist->execute([$formData['email']]);
        $user_id = $user_exist ? $user_exist->fetchColumn() : 0;
        if ($user_id > 0) {
            echo '<p style="background:red;padding:10px;text-align: center;font-size: x-large;border-radius: 6px;width: auto;margin: auto;">Ten użytkownik już istnieje, proszę <a href="/login">zaloguj się</a>.</p>';
            return false;
        } else {
            $this->pdo->prepare('INSERT INTO CBU_users (email, password) VALUES (?, ?)')->execute([$formData['email'], hash($this->alg, $formData['password'])]);
            header('Location: /login'); // redirect to login page
            return true;
        }
    }

    public function login($credentials) {
        $session = session_start();
        $user = $this->pdo->prepare('SELECT id FROM CBU_users WHERE email = ? AND password = ?');
        $user->execute([$credentials['email'], hash($this->alg, $credentials['password'])]);
        $user_id = $user ? $user->fetchColumn() : 0;
        if ($user_id > 0) {
            $_SESSION['authenticated'] = true;
            $_SESSION['current_user'] = $user_id;
            header('Location: /chat'); 
            return true;
        } else {
            echo '<p style="background:red;padding:10px;text-align: center;font-size: x-large;border-radius: 6px;width: auto;margin: auto;">Nieprawidłowe dane uwierzytelniające.</p>';
            return false;
        }
    }

    public function changePassword($userEmail) {
        // 1. find user by Email
        // 2. generate link with form to password change
        // 3. send email with link to form
        $this->sendEmail();
    }
}
