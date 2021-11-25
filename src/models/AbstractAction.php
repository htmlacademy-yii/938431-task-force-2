<?php
namespace app\models;

abstract class AbstractAction {
    abstract public function getTitle();
    abstract public function getInnerName();
    abstract public function hasAccessRight($performerId, $customerId, $currentUserId);
}
