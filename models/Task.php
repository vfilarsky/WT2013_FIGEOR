<?php

namespace Figeor\Models;

use Figeor\Core\System;
use \PDO;

class Task implements IModel {

    private $id;
    private $project;
    private $parentTask;
    private $user;
    private $name;
    private $description;
    private $dateCreated;
    private $dateCompleted;
    private $deadline;
    private $points;
    private $priority;

    public function __construct($id) {
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('SELECT * FROM ' . System::TABLE_TASKS . ' WHERE id_t=:i LIMIT 1');
        $Q->bindValue(':i', $id, PDO::PARAM_INT);
        $Q->execute();
        if ($Q->rowCount()) {
            $R = $Q->fetch();
            $this->id = $R['id_t'];
            $this->project = new Project($R['id_p']);
            $this->parentTask = $R['parentTask'];
            $this->user = $R['id_u'];
            $this->name = $R['name'];
            $this->description = $R['description'];
            $this->dateCreated = $R['dateCreated'];
            $this->dateCompleted = $R['dateCompleted'];
            $this->deadline = $R['deadline'];
            $this->points = $R['points'];
            $this->priority = $R['priority'];
        }
    }

    public static function create($initialValues) {
        $user = $initialValues['user'];
        $project = $initialValues['project'];
        $parentTask = is_numeric($initialValues['parentTask']) ? $initialValues['parentTask'] : null;
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('INSET INTO ' . System::TABLE_TASKS . ' (id_u, id_p, parentTask, dateCreated) VALUES (:iu, :ip, :pt, :dc)');
        $Q->bindValue(':iu', $user->getId(), PDO::PARAM_INT);
        $Q->bindValue(':ip', $project->getId(), PDO::PARAM_INT);
        $Q->bindValue(':pt', $parentTask);
        $Q->bindValue(':dc', time());
        $Q->execute();
        return new self($DBH->lastInsertId());
    }

    public static function exists($id) {
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('SELECT 1 FROM ' . System::TABLE_TASKS . ' WHERE id_t=:i LIMIT 1');
        $Q->bindValue(':i', $id, PDO::PARAM_INT);
        $Q->execute();
        return $Q->rowCount() ? true : false;
    }

    public function update() {
        $DBH = System::getInstance()->getDBH();
        $Q = $DBH->prepare('UPDATE ' . System::TABLE_TASKS . ' SET name=:n, description=:d, dateCompleted=:dc, deadline=:dl, points=:pts, priority=:prio WHERE id_t=:id');
        $Q->bindValue(':id', $this->id, PDO::PARAM_INT);
        $Q->bindValue(':n', $this->name, PDO::PARAM_STR);
        $Q->bindValue(':d', $this->description, PDO::PARAM_STR);
        $Q->bindValue(':dc', $this->dateCompleted, PDO::PARAM_INT);
        $Q->bindValue(':dl', $this->deadline, PDO::PARAM_INT);
        $Q->bindValue(':pts', $this->points, PDO::PARAM_INT);
        $Q->bindValue(':prio', $this->priority, PDO::PARAM_INT);
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

    public function getDeadline() {
        return $this->deadline;
    }

    public function setDeadline($deadline) {
        $this->deadline = $deadline;
        return $this;
    }

    public function getPoints() {
        return $this->points;
    }

    public function setPoints($points) {
        $this->points = $points;
        return $this;
    }

    public function getPriority() {
        return $this->priority;
    }

    public function setPriority($priority) {
        $this->priority = $priority;
        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function getProject() {
        return $this->project;
    }

    public function getParentTask() {
        return $this->parentTask;
    }

}

