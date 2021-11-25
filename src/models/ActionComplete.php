<?php
namespace app\models;

class ActionComplete extends  AbstractAction
{
   private string $title = 'Завершить';

   public function getTitle(): string
   {
       return $this->title;
   }

   public function getInnerName(): string
   {
       return Task::ACTION_COMPLETE;
   }

   public function hasAccessRight($performerId, $customerId, $currentUserId): bool
   {
       return $currentUserId === $customerId;
   }
}
