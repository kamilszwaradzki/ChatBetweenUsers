<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of User
 *
 * @author tom
 */
require_once 'DataBaseObject.php';
class User extends DataBaseObject {
    protected string $table = 'users';

    public function getAllUsers() {
        return $this->query('SELECT id, email FROM CBU_' . $this->table)->fetchAll(self::FETCH_ASSOC);
    }
}
