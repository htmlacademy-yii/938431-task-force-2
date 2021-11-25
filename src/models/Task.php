<?php
namespace app\models;
use app\ex\ActionTypeException;
use app\ex\TaskStatusException;
use app\ex\UserRoleException;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    const ACTION_RESPOND = 'respond';
    const ACTION_COMPLETE = 'complete';
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

    private $actions;
    private $clientId;
    private $performerId;
    private $currentStatus;

    public function __construct(int $clientId, ?int $performerId = null, ?string $status = self::STATUS_NEW)
    {
        if ($clientId === $performerId) {
            throw new UserRoleException("Получены идентичные id Заказчика и Исполнителя. Заказчик не может быть Исполнителем");
            die;
        }
        if (!array_key_exists($status, $this->statuses)) {
            throw new TaskStatusException("Переданный статус задания не существует.");
            die;
        }
        $this->clientId = $clientId;
        $this->performerId = $performerId;
        $this->currentStatus = $status;
        $this->actions = [
            self::ACTION_ASSIGN => new ActionAssign(),
            self::ACTION_COMPLETE => new ActionComplete(),
            self::ACTION_CANCEL => new ActionCancel(),
            self::ACTION_RESPOND => new ActionRespond(),
            self::ACTION_REJECT => new ActionReject(),
        ];
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getPerformerId(): ?int
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

    public function getNextStatus(string $action): ?string
    {
        if (!array_key_exists($action, $this->actions)) {
            throw new ActionTypeException("Переданный тип действия не существует");
            die;
        }
        return match ($action) {
            self::ACTION_ASSIGN => self::STATUS_IN_PROGRESS,
            self::ACTION_COMPLETE => self::STATUS_COMPLETED,
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_REJECT => self::STATUS_FAILED,
            self::ACTION_RESPOND => self::STATUS_NEW,
        };
    }

    public function getAvailableActions(int $userId): array
    {
        $availableActions = match ($this->currentStatus) {
            self::STATUS_NEW => [self::ACTION_ASSIGN, self::ACTION_CANCEL, self::ACTION_RESPOND],
            self::STATUS_IN_PROGRESS => [self::ACTION_COMPLETE, self::ACTION_REJECT],
            default => [],
        };

        $cb = function (object $action, string $key) use ($availableActions, $userId) {
            return in_array($key, $availableActions) && $action->hasAccessRight($this->performerId, $this->clientId, $userId);
        };
        return array_filter($this->actions, $cb, ARRAY_FILTER_USE_BOTH);
    }
}
