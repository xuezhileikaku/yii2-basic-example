<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "curriculum".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $content
 * @property string|null $show_time
 * @property string|null $show_teachers
 * @property string|null $show_address
 * @property int|null $cat_id
 * @property int|null $show_year
 * @property int|null $show_day
 * @property int|null $show_month
 * @property int $show_order
 * @property int|null $status
 * @property int|null $create_at
 * @property int|null $update_at
 * @property int|null $user_id
 */
class Curriculum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'curriculum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'content', 'show_time', 'show_teachers'], 'string'],
            [['cat_id', 'show_year', 'show_day', 'show_month', 'show_order', 'status', 'create_at', 'update_at', 'user_id'], 'integer'],
            [['show_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'content' => 'Content',
            'show_time' => 'Show Time',
            'show_teachers' => 'Show Teachers',
            'show_address' => 'Show Address',
            'cat_id' => 'Cat ID',
            'show_year' => 'Show Year',
            'show_day' => 'Show Day',
            'show_month' => 'Show Month',
            'show_order' => 'Show Order',
            'status' => 'Status',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'user_id' => 'User ID',
        ];
    }
}
