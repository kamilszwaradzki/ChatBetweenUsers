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
        return $this->query("SELECT * FROM CBU_{$this->table} WHERE (sender_id = {$sender} AND receiver_id = {$recipient}) OR (sender_id = {$recipient} AND receiver_id = {$sender}) ORDER BY sent_at ASC")->fetchAll(self::FETCH_ASSOC);
    }

    public function addMessage($sender, $recipient, $message) {
        $this->prepare("INSERT INTO CBU_{$this->table} (sender_id, receiver_id, message, sent_at) VALUES (?, ?, ?, ?)")->execute([$sender, $recipient, $message, (new DateTime())->format('Y-m-d H:i:s')]);
    }
}
