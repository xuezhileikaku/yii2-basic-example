<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "di_user_identify".
 *
 * @property int $user_id
 * @property int $app_id
 * @property string $identify
 * @property int $append_time
 * @property int|null $expire_time
 * @property string|null $remark
 */
class UserIdentify extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_identify';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'app_id', 'identify', 'append_time'], 'required'],
            [['user_id', 'app_id', 'append_time', 'expire_time'], 'integer'],
            [['identify', 'remark'], 'string', 'max' => 255],
            [['user_id', 'app_id'], 'unique', 'targetAttribute' => ['user_id', 'app_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'app_id' => 'App ID',
            'identify' => 'Identify',
            'append_time' => 'Append Time',
            'expire_time' => 'Expire Time',
            'remark' => 'Remark',
        ];
    }
}
