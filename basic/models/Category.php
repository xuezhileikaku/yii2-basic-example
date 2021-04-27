<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $cat_id
 * @property int|null $cat_parent
 * @property string|null $cat_name
 * @property int|null $status
 * @property int|null $create_at
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_parent', 'status', 'create_at'], 'integer'],
            [['cat_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cat_id' => 'Cat ID',
            'cat_parent' => 'Cat Parent',
            'cat_name' => 'Cat Name',
            'status' => 'Status',
            'create_at' => 'Create At',
        ];
    }
}
