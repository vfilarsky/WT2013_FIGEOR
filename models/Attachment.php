<?php

namespace Figeor\Models;

use Figeor\Core\System;
use \PDO;

class Attachment implements IModel {

    private $id;
    private $user;
    private $task;
    private $name;
    private $description;
    private $src;

    public function __construct($id) {
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('SELECT * FROM ' . System::TABLE_ATTACHMENTS . ' WHERE id_f=:i LIMIT 1');
        $Q->bindValue(':i', $id, PDO::PARAM_INT);
        $Q->execute();
        if ($Q->rowCount()) {
            $R = $Q->fetch();
            $this->id = $R['id_u'];
            $this->name = $R['name'];
            $this->task = new Task($R['id_t']);
            $this->user = new User($R['email']);
            $this->src = $R['src'];
            $this->description = $R['description'];
        }
    }

    public static function create($initialValues) {
        $task = $initialValues['task'];
        $user = $initialValues['user'];
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('INSET INTO ' . System::TABLE_ATTACHMENTS . ' (id_u, id_t) VALUES (:iu, :it)');
        $Q->bindValue(':it', $task->getId(), PDO::PARAM_STR);
        $Q->bindValue(':iu', $user->getId(), PDO::PARAM_STR);
        $Q->execute();
        return new self($DBH->lastInsertId());
    }

    public static function exists($id) {
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('SELECT 1 FROM ' . System::TABLE_ATTACHMENTS . ' WHERE id_f=:i LIMIT 1');
        $Q->bindValue(':i', $id, PDO::PARAM_INT);
        $Q->execute();
        return $Q->rowCount() ? true : false;
    }

    public function update() {
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('UPDATE ' . System::TABLE_ATTACHMENTS . ' SET name=:n, src=:src, description:ds WHERE id_f=:id');
        $Q->bindValue(':id', $this->id, PDO::PARAM_INT);
        $Q->bindValue(':n', $this->name, PDO::PARAM_STR);
        $Q->bindValue(':src', $this->src, PDO::PARAM_STR);
        $Q->bindValue(':ds', $this->description, PDO::PARAM_STR);
        $Q->execute();
    }

    public function isDeletable() {
        return true;
    }

    public function delete() {
        $DBH = System::getInstance()->getDBH();
        $DBH->exec('DELETE FROM ' . System::TABLE_PROJECTS . ' WHERE id_p=' . $this->id);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getUser() {
        return $this->user;
    }

    public function getTask() {
        return $this->task;
    }

    public function getSrc() {
        return $this->src;
    }

    public function setSrc($src) {
        $this->src = $src;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

}

