<?php
namespace app\models;

class ActionReject extends  AbstractAction
{
    private string $title = 'Отказаться от задания';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getInnerName(): string
    {
        return Task::ACTION_REJECT;
    }

    public function hasAccessRight($performerId, $customerId, $currentUserId): bool
    {
        return $currentUserId === $performerId;
    }
}
