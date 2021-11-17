<?php
namespace app\models;

class ActionCancel extends  AbstractAction
{
    private string $title = 'Отменить';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getInnerName(): string
    {
        return Task::ACTION_CANCEL;
    }

    public function hasAccessRight($performerId, $customerId, $currentUserId): bool
    {
        return $currentUserId === $customerId;
    }
}
