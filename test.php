<?php
require_once 'Task.php';

$task = new Task(999, 555);

var_dump($task->getAllActions());
echo "\n";
var_dump($task->getAllStatuses());
echo "\n";
echo "ClientID: " . $task->getClientId() . "\n";
echo "PerformerID: " . $task->getPerformerId() . "\n";

echo "Ожидается статус 'in_progress', получено: " . $task->getNextStatus($task::ACTION_ASSIGN) . "\n";
echo "Ожидается статус 'completed', получено: " . $task->getNextStatus($task::ACTION_ACCEPT) . "\n";
echo "Ожидается статус 'cancelled', получено: " . $task->getNextStatus($task::ACTION_CANCEL) . "\n";
echo "Ожидается статус 'failed', получено: " . $task->getNextStatus($task::ACTION_REJECT) . "\n";
echo "Ожидается статус 'new', получено: " . $task->getNextStatus($task::ACTION_RESPOND) . "\n";
echo "Ожидается статус 'new', получено: " . $task->getNextStatus('unknown') . "\n";

echo "Ожидаются действия 'assign', 'cancel', получено: "
    . Task::getAvailableActions($task::STATUS_NEW, 'client')[0] . ", "
    . Task::getAvailableActions($task::STATUS_NEW, 'client')[1] . "\n";

echo "Ожидается действие 'respond' получено: "
    . Task::getAvailableActions($task::STATUS_NEW, 'performer')[0] . "\n";

echo "Ожидается действие 'accept' получено: "
    . Task::getAvailableActions($task::STATUS_IN_PROGRESS, 'client')[0] . "\n";

echo "Ожидается действие 'reject' получено: "
    . Task::getAvailableActions($task::STATUS_IN_PROGRESS, 'performer')[0] . "\n";

echo "Не ожидается доступных действий, получено действий: "
    . count(Task::getAvailableActions($task::STATUS_COMPLETED, 'client')) . "\n";

