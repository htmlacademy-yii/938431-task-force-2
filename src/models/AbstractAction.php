<?php
namespace app\models;

abstract class AbstractAction {
    abstract public function getTitle(): string;
    abstract public function getInnerName(): string;
    abstract public function hasAccessRight(?int $performerId, int $customerId, int $currentUserId): bool;
}
