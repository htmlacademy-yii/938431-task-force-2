<?php
use app\models\Task;
use app\exceptions\ActionTypeException;
use app\exceptions\TaskStatusException;
use app\exceptions\UserRoleException;

require_once "vendor/autoload.php";

echo "1. Ожидается исключение типа UserRoleException, получено: ";
try {
    $task = new Task(999, 999);
} catch (UserRoleException $ex) {
    echo $ex->getMessage() . PHP_EOL;
}

$task = new Task(999);

$actions = $task->getAllActions();
echo "2. Доступные действия: \n";
foreach ($actions as $action) {
    echo $action->getInnerName() . ": " . $action-> getTitle();
    echo "\n";
}

echo "\n";
echo "3. ClientID: " . $task->getClientId() . "\n";
echo "4. PerformerID: " . $task->getPerformerId() . "\n";

echo "5. Ожидается статус 'in_progress', получено: " . $task->getNextStatus(Task::ACTION_ASSIGN) . "\n";
echo "6. Ожидается статус 'completed', получено: " . $task->getNextStatus(Task::ACTION_COMPLETE) . "\n";
echo "7. Ожидается статус 'cancelled', получено: " . $task->getNextStatus(Task::ACTION_CANCEL) . "\n";
echo "8. Ожидается статус 'failed', получено: " . $task->getNextStatus(Task::ACTION_REJECT) . "\n";
echo "9. Ожидается статус 'new', получено: " . $task->getNextStatus(Task::ACTION_RESPOND) . "\n";

echo "10. Ожидается исключение типа ActionTypeException, получено: ";
try {
    echo $task->getNextStatus('unknown');
} catch (ActionTypeException $ex) {
    echo $ex->getMessage() .PHP_EOL;
}

echo "\n";
echo "11. Текущий статус: 'new'.\n";
echo "12. Для Заказчика ожидаются действия 'assign', 'cancel', получено: ";
$actions = $task->getAvailableActions(999);
foreach ($actions as $action) {
    echo $action->getInnerName() . " ";
};
echo "\n";
var_dump($actions);

echo "13. Для пользователя ожидается действие 'respond' получено: ";
$actions = $task->getAvailableActions(555);
foreach ($actions as $action) {
    echo $action->getInnerName() . " ";
};
echo "\n";
var_dump($actions);

echo "\n";
echo "14. Ожидается исключение типа TaskStatusException, получено: ";
try {
    $task = new Task(1,2,'unknown');
} catch (TaskStatusException $ex) {
    echo $ex->getMessage() .PHP_EOL;
}

$task = new Task(111, 222, Task::STATUS_IN_PROGRESS);
echo "\n";
echo "15. Текущий статус: 'in_progress'.\n";
echo "Для Заказчика ожидается действие 'complete' получено: ";
$actions = $task->getAvailableActions(111);
foreach ($actions as $action) {
    echo $action->getInnerName() . " ";
}
echo "\n";
var_dump($actions);

echo "\n";
echo "16. Для Исполнителя ожидается действие 'reject' получено: ";
$actions = $task->getAvailableActions(222);
foreach ($actions as $action) {
    echo $action->getInnerName() . " ";
}
echo "\n";
var_dump($actions);

$task = new Task(111, 222, Task::STATUS_COMPLETED);
echo "\n";
echo "17. Текущий статус: 'completed'.\n";
echo "Не ожидается доступных действий для Заказчика, получено действий: "
    . count($task->getAvailableActions(111)) . "\n";

echo "Не ожидается доступных действий для Исполнителя, получено действий: "
    . count($task->getAvailableActions(222)) . "\n";

