<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property int $seo_id
 * @property string $seo_url
 * @property string|null $seo_name
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_host
 * @property string|null $seo_file
 * @property string|null $seo_description
 * @property int|null $seo_user
 * @property int|null $create_at
 * @property int|null $update_at
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seo_url'], 'required'],
            [['seo_title', 'seo_keywords', 'seo_file', 'seo_description'], 'string'],
            [['seo_user', 'create_at', 'update_at'], 'integer'],
            [['seo_url', 'seo_name', 'seo_host'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'seo_id' => 'Seo ID',
            'seo_url' => 'Seo Url',
            'seo_name' => 'Seo Name',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_host' => 'Seo Host',
            'seo_file' => 'Seo File',
            'seo_description' => 'Seo Description',
            'seo_user' => 'Seo User',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
