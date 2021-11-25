<?php
namespace app\models;

class ActionAssign extends AbstractAction
{
    private string $title = 'Подтвердить';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getInnerName(): string
    {
        return Task::ACTION_ASSIGN;
    }

    public function hasAccessRight($performerId, $customerId, $currentUserId): bool
    {
        return $currentUserId === $customerId;
    }
}
