<?php
class Task
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    const ACTION_RESPOND = 'respond';
    const ACTION_ACCEPT = 'accept';
    const ACTION_CANCEL = 'cancel';
    const ACTION_ASSIGN = 'assign';
    const ACTION_REJECT = 'reject';

    private $statuses = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELLED => 'Отменено',
        self::STATUS_COMPLETED => 'Выполнено',
        self::STATUS_IN_PROGRESS => 'На исполнении',
        self::STATUS_FAILED => 'Провалено',
    ];

    private $actions = [
        self::ACTION_ASSIGN => 'Подтвердить',
        self::ACTION_ACCEPT => 'Завершить',
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_RESPOND => 'Откликнуться на задание',
        self::ACTION_REJECT => 'Отказаться от задания',
    ];

    private $clientId;
    private $performerId;
    private $currentStatus;

    public function __construct($clientId, $performerId = null, $status = self::STATUS_NEW)
    {
        $this->clientId = $clientId;
        $this->performerId = $performerId;
        $this->currentStatus = $status;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getPerformerId(): int
    {
        return $this->performerId;
    }

    public function getAllStatuses(): array
    {
        return $this->statuses;
    }

    public function getAllActions(): array
    {
        return $this->actions;
    }

    public function getNextStatus($action)
    {
        return match ($action) {
            self::ACTION_ASSIGN => self::STATUS_IN_PROGRESS,
            self::ACTION_ACCEPT => self::STATUS_COMPLETED,
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_REJECT => self::STATUS_FAILED,
            self::ACTION_RESPOND => self::STATUS_NEW,
            default => null,
        };
    }

    public function getAvailableActions($userRole): array
    {
        $isClient = $userRole === 'client';
        return match ($this->currentStatus) {
            self::STATUS_NEW => $isClient ? [self::ACTION_ASSIGN, self::ACTION_CANCEL] : [self::ACTION_RESPOND],
            self::STATUS_IN_PROGRESS => $isClient ? [self::ACTION_ACCEPT] : [self::ACTION_REJECT],
            default => [],
        };
    }
}
