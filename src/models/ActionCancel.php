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

    public function hasAccessRight(?int $performerId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId === $customerId;
    }
}
