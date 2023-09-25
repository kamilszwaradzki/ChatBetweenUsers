<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Message
 *
 * @author tom
 */
require_once 'DataBaseObject.php';
class Message extends DataBaseObject {
    protected string $table = 'messages';

    public function getAllMessagesByUsersId($sender, $recipient) {
        return $this->query("SELECT * FROM CBU_{$this->table} WHERE (sender = {$sender} AND recipient = {$recipient}) OR (sender = {$recipient} AND recipient = {$sender}) ORDER BY date_created ASC")->fetchAll(self::FETCH_ASSOC);
    }

    public function addMessage($sender, $recipient, $message) {
        $this->prepare("INSERT INTO CBU_{$this->table} (sender, recipient, message, date_created) VALUES (?, ?, ?, ?)")->execute([$sender, $recipient, $message, (new DateTime())->format('Y-m-d H:i:s')]);
    }
}
