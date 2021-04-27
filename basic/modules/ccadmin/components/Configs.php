<?php


namespace app\modules\ccadmin\components;


use Yii;
use yii\caching\Cache;
use yii\db\Connection;
use yii\di\Instance;
use yii\rbac\ManagerInterface;

class Configs extends \hscstudio\mimin\components\Configs
{
    const CACHE_TAG = 'cc.admin';
    /**
     * @var Connection Database connection.
     */
    public $db = 'db';

    public $authManager = 'authManager';
    /**
     * @var Connection Database connection.
     */
    public $userDb = 'db';
    public $cacheDuration = 10;
    /**
     * @var Cache Cache component.
     */
    public $cache = 'cache';
    /**
     * @var ManagerInterface .
     */

    private static $_classes = [
        'db' => 'yii\db\Connection',
        'userDb' => 'yii\db\Connection',
        'cache' => 'yii\caching\Cache',
        'authManager' => 'yii\rbac\ManagerInterface',
    ];

    public function init()
    {
        foreach (self::$_classes as $key => $class) {
            try {
                $this->{$key} = empty($this->{$key}) ? null : Instance::ensure($this->{$key}, $class);
            } catch (\Exception $exc) {
                $this->{$key} = null;
                Yii::error($exc->getMessage());
            }
        }
    }

    /**
     * @return Connection
     */
    public static function db()
    {
        return static::instance()->db;
    }

    /**
     * @return Connection
     */
    public static function userDb()
    {
        return static::instance()->userDb;
    }

    /**
     * @return Cache
     */
    public static function cache()
    {
        return static::instance()->cache;
    }

    /**
     * @return ManagerInterface
     */
    public static function authManager()
    {
        return static::instance()->authManager;
    }

    /**
     * @return string
     */
    public static function menuTable()
    {
        return static::instance()->menuTable;
    }
}
