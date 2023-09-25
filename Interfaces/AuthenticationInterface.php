<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

/**
 *
 * @author Kamil Szwaradzki <kamil.szwaradzki at your.org>
 */
interface AuthenticationInterface {
    function register($formData);
    function login($credentials);
    function changePassword($userEmail);
}
