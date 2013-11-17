<?php

namespace Figeor\Models;

interface IModel {

    public static function create($initialValues);

    public static function exists($id);

    public function update();

    public function isDeletable();

    public function delete();

    public function getId();
}

