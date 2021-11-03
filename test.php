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


