<?php

namespace Figeor\Models;

use Figeor\Core\System;
use \PDO;

class Project implements IModel {

    private $id;
    private $user;
    private $name;
    private $description;
    private $dateCreated;
    private $dateCompleted;

    public function __construct($id) {
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('SELECT * FROM ' . System::TABLE_PROJECTS . ' WHERE id_p=:i LIMIT 1');
        $Q->bindValue(':i', $id, PDO::PARAM_INT);
        $Q->execute();
        if ($Q->rowCount()) {
            $R = $Q->fetch();
            $this->id = $R['id_p'];
            $this->user = $R['id_u'];
            $this->name = $R['name'];
            $this->description = $R['description'];
            $this->dateCreated = $R['dateCreated'];
            $this->dateCompleted = $R['dateCompleted'];
        }
    }

    public static function create($initialValues) {
        $user = $initialValues['user'];
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('INSET INTO ' . System::TABLE_PROJECTS . ' (id_u, dateCreated) VALUES (:iu, :dc)');
        $Q->bindValue(':iu', $user->getId(), PDO::PARAM_INT);
        $Q->bindValue(':dc', time());
        $Q->execute();
        return new self($DBH->lastInsertId());
    }

    public static function exists($id) {
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('SELECT 1 FROM ' . System::TABLE_PROJECTS . ' WHERE id_p=:i LIMIT 1');
        $Q->bindValue(':i', $id, PDO::PARAM_INT);
        $Q->execute();
        return $Q->rowCount() ? true : false;
    }

    public function update() {
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('UPDATE ' . System::TABLE_PROJECTS . ' SET name=:n, description=:d, dateCompleted=:dc WHERE id_p=:id');
        $Q->bindValue(':id', $this->id, PDO::PARAM_INT);
        $Q->bindValue(':n', $this->name, PDO::PARAM_STR);
        $Q->bindValue(':d', $this->description, PDO::PARAM_STR);
        $Q->bindValue(':dc', $this->dateCompleted, PDO::PARAM_INT);
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

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getDateCompleted() {
        return $this->dateCompleted;
    }

    public function setDateCompleted($dateCompleted) {
        $this->dateCompleted = $dateCompleted;
        return $this;
    }

}

