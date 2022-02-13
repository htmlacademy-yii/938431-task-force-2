<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respond".
 *
 * @property int $id
 * @property int $task_id Связь с полем id таблицы task
 * @property string|null $text
 * @property float $budget
 * @property int $performer_id Связь с полем id таблицы user
 *
 * @property User $performer
 * @property Task $task
 */
class Respond extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respond';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'performer_id'], 'required'],
            [['task_id', 'performer_id'], 'integer'],
            [['text'], 'string'],
            [['budget'], 'number'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['performer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'text' => 'Text',
            'budget' => 'Budget',
            'performer_id' => 'Performer ID',
        ];
    }

    /**
     * Gets query for [[Performer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformer()
    {
        return $this->hasOne(User::className(), ['id' => 'performer_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}
