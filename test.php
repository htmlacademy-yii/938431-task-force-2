<?php
require_once 'Task.php';

$task = new Task(999, 555);

var_dump($task->getAllActions());
echo "\n";
var_dump($task->getAllStatuses());
echo "\n";
echo "ClientID: " . $task->getClientId() . "\n";
echo "PerformerID: " . $task->getPerformerId() . "\n";

echo "Ожидается статус 'in_progress', получено: " . $task->getNextStatus(Task::ACTION_ASSIGN) . "\n";
echo "Ожидается статус 'completed', получено: " . $task->getNextStatus(Task::ACTION_ACCEPT) . "\n";
echo "Ожидается статус 'cancelled', получено: " . $task->getNextStatus(Task::ACTION_CANCEL) . "\n";
echo "Ожидается статус 'failed', получено: " . $task->getNextStatus(Task::ACTION_REJECT) . "\n";
echo "Ожидается статус 'new', получено: " . $task->getNextStatus(Task::ACTION_RESPOND) . "\n";
echo "Ожидается статус NULL, получено: " . $task->getNextStatus('unknown') . "\n";

echo "Ожидаются действия 'assign', 'cancel', получено: "
    . Task::getAvailableActions(Task::STATUS_NEW, 'client')[0] . ", "
    . Task::getAvailableActions(Task::STATUS_NEW, 'client')[1] . "\n";

echo "Ожидается действие 'respond' получено: "
    . Task::getAvailableActions(Task::STATUS_NEW, 'performer')[0] . "\n";

echo "Ожидается действие 'accept' получено: "
    . Task::getAvailableActions(Task::STATUS_IN_PROGRESS, 'client')[0] . "\n";

echo "Ожидается действие 'reject' получено: "
    . Task::getAvailableActions(Task::STATUS_IN_PROGRESS, 'performer')[0] . "\n";

echo "Не ожидается доступных действий, получено действий: "
    . count(Task::getAvailableActions(Task::STATUS_COMPLETED, 'client')) . "\n";

