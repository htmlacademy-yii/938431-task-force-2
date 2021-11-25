<?php
use app\models\Task;
require_once "vendor/autoload.php";

$task = new Task(999, 555);

$actions = $task->getAllActions();
echo "Доступные действия: \n";
foreach ($actions as $action) {
    echo $action->getInnerName() . ": " . $action-> getTitle();
echo "\n";
}

echo "\n";
echo "ClientID: " . $task->getClientId() . "\n";
echo "PerformerID: " . $task->getPerformerId() . "\n";

echo "Ожидается статус 'in_progress', получено: " . $task->getNextStatus(Task::ACTION_ASSIGN) . "\n";
echo "Ожидается статус 'completed', получено: " . $task->getNextStatus(Task::ACTION_COMPLETE) . "\n";
echo "Ожидается статус 'cancelled', получено: " . $task->getNextStatus(Task::ACTION_CANCEL) . "\n";
echo "Ожидается статус 'failed', получено: " . $task->getNextStatus(Task::ACTION_REJECT) . "\n";
echo "Ожидается статус 'new', получено: " . $task->getNextStatus(Task::ACTION_RESPOND) . "\n";
echo "Ожидается статус NULL, получено: " . $task->getNextStatus('unknown') . "\n";

echo "\n";
echo "Текущий статус: 'new'.\n";
echo "Для Заказчика ожидаются действия 'assign', 'cancel', получено: ";
$actions = $task->getAvailableActions(999);
foreach ($actions as $action) {
    echo $action->getInnerName() . " ";
};
echo "\n";
var_dump($actions);

echo "Для Исполнителя ожидается действие 'respond' получено: ";
$actions = $task->getAvailableActions(555);
foreach ($actions as $action) {
    echo $action->getInnerName() . " ";
};
echo "\n";
var_dump($actions);

$task = new Task(111, 222, Task::STATUS_IN_PROGRESS);
echo "\n";
echo "Текущий статус: 'in_progress'.\n";
echo "Для Заказчика ожидается действие 'complete' получено: ";
$actions = $task->getAvailableActions(111);
foreach ($actions as $action) {
    echo $action->getInnerName() . " ";
}
echo "\n";
var_dump($actions);

echo "\n";
echo "Для Исполнителя ожидается действие 'reject' получено: ";
$actions = $task->getAvailableActions(222);
foreach ($actions as $action) {
    echo $action->getInnerName() . " ";
}
echo "\n";
var_dump($actions);

$task = new Task(111, 222, Task::STATUS_COMPLETED);
echo "\n";
echo "Текущий статус: 'completed'.\n";
echo "Не ожидается доступных действий для Заказчика, получено действий: "
    . count($task->getAvailableActions(111)) . "\n";

echo "Не ожидается доступных действий для Исполнителя, получено действий: "
    . count($task->getAvailableActions(222)) . "\n";

