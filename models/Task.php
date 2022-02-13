<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string|null $create_at
 * @property string $title
 * @property int $customer_id Связь с полем id таблицы user
 * @property int|null $performer_id Связь с полем id таблицы user
 * @property string $status
 * @property string $deadline_at
 * @property string $description
 * @property float $budget
 * @property string|null $location
 * @property int|null $city_id Связь с полем id таблицы city
 *
 * @property Attachment[] $attachments
 * @property City $city
 * @property User $customer
 * @property User $performer
 * @property Respond[] $responds
 * @property Review[] $reviews
 * @property TaskCategory[] $taskCategories
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_at', 'deadline_at'], 'safe'],
            [['title', 'customer_id', 'status', 'description'], 'required'],
            [['customer_id', 'performer_id', 'city_id'], 'integer'],
            [['description'], 'string'],
            [['budget'], 'number'],
            [['title', 'location'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['performer_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_at' => 'Create At',
            'title' => 'Title',
            'customer_id' => 'Customer ID',
            'performer_id' => 'Performer ID',
            'status' => 'Status',
            'deadline_at' => 'Deadline At',
            'description' => 'Description',
            'budget' => 'Budget',
            'location' => 'Location',
            'city_id' => 'City ID',
        ];
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachment::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
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
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Respond::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskCategories()
    {
        return $this->hasMany(TaskCategory::className(), ['task_id' => 'id']);
    }
}
