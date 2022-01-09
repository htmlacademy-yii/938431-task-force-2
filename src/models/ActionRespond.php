<?php
namespace app\models;

class ActionRespond extends  AbstractAction
{
    private string $title = 'Откликнуться на задание';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getInnerName(): string
    {
        return Task::ACTION_RESPOND;
    }

    public function hasAccessRight(?int $performerId, int $customerId, int $currentUserId): bool
    {
        return $currentUserId !== $customerId && $performerId !== $currentUserId;
    }
}
