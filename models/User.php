<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property string $create_at
 * @property string|null $birthdate
 * @property string|null $info
 * @property string $phone
 * @property string|null $telegram
 * @property string $user_role
 * @property int|null $city_id Связь с полем id таблицы city
 *
 * @property Respond[] $responds
 * @property Review[] $reviews
 * @property Review[] $reviews0
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property UserCategory[] $userCategories
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'email', 'password', 'avatar', 'phone', 'user_role'], 'required'],
            [['create_at', 'birthdate'], 'safe'],
            [['info'], 'string'],
            [['city_id'], 'integer'],
            [['login', 'telegram'], 'string', 'max' => 50],
            [['email', 'password'], 'string', 'max' => 100],
            [['avatar'], 'string', 'max' => 255],
            [['phone', 'user_role'], 'string', 'max' => 20],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'email' => 'Email',
            'password' => 'Password',
            'avatar' => 'Avatar',
            'create_at' => 'Create At',
            'birthdate' => 'Birthdate',
            'info' => 'Info',
            'phone' => 'Phone',
            'telegram' => 'Telegram',
            'user_role' => 'User Role',
            'city_id' => 'City ID',
        ];
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Respond::className(), ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews0()
    {
        return $this->hasMany(Review::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::className(), ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategory::className(), ['performer_id' => 'id']);
    }
}
