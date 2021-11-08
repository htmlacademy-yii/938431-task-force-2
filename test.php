<?php
use app\models\Task;
require_once "vendor/autoload.php";

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

echo "\n";
echo "Текущий статус: 'new'.\n";
echo "Ожидаются действия 'assign', 'cancel', получено: "
    . $task->getAvailableActions('client')[0] . ", "
    . $task->getAvailableActions('client')[1] . "\n";

echo "Ожидается действие 'respond' получено: "
    . $task->getAvailableActions('performer')[0] . "\n";

$task = new Task(111, 222, Task::STATUS_IN_PROGRESS);
echo "\n";
echo "Текущий статус: 'in_progress'.\n";
echo "Ожидается действие 'accept' получено: "
    . $task->getAvailableActions('client')[0] . "\n";

echo "Ожидается действие 'reject' получено: "
    . $task->getAvailableActions('performer')[0] . "\n";

$task = new Task(111, 222, Task::STATUS_COMPLETED);
echo "\n";
echo "Текущий статус: 'completed'.\n";
echo "Не ожидается доступных действий, получено действий: "
    . count($task->getAvailableActions('client')) . "\n";

