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

    private array $statuses = [
        self::STATUS_NEW => 'Новое',
        self::STATUS_CANCELLED => 'Отменено',
        self::STATUS_COMPLETED => 'Выполнено',
        self::STATUS_IN_PROGRESS => 'На исполнении',
        self::STATUS_FAILED => 'Провалено',
    ];

    private array $actions = [
        self::ACTION_ASSIGN => 'Подтвердить',
        self::ACTION_ACCEPT => 'Завершить',
        self::ACTION_CANCEL => 'Отменить',
        self::ACTION_RESPOND => 'Откликнуться на задание',
        self::ACTION_REJECT => 'Отказаться от задания',
    ];

    private int $clientId;
    private int $performerId;
    private string $currentStatus = self::STATUS_NEW;

    public function __construct($clientId, $performerId = null)
    {
        $this->clientId = $clientId;
        $this->performerId = $performerId;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getPerformerId()
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

    public function getNextStatus($action): string
    {
        switch ($action) {
            case self::ACTION_ASSIGN:
                $result = self::STATUS_IN_PROGRESS;
                break;
            case self::ACTION_ACCEPT:
                $result = self::STATUS_COMPLETED;
                break;
            case self::ACTION_CANCEL:
                $result = self::STATUS_CANCELLED;
                break;
            case self::ACTION_REJECT:
                $result = self::STATUS_FAILED;
                break;
            default:
                $result = $this->currentStatus;
        };
        return $result;
    }

    public function getAvailableActions($userRole)
    {
        $isClient = $userRole === 'client';
        $result = [];
        switch ($this->currentStatus) {
            case self::STATUS_NEW:
                $result = $isClient ? [self::ACTION_ASSIGN, self::ACTION_CANCEL] : [self::ACTION_RESPOND];
                break;
            case self::STATUS_IN_PROGRESS:
                $result = $isClient ? [self::ACTION_ACCEPT] : [self::ACTION_REJECT];
                break;
            default: break;
        }
        return $result;
    }
}
