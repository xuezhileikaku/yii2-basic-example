<?php


namespace common\services;

use yii\helpers\ArrayHelper;

/**
 * gmat_paper_types  gmat考试的所有试卷类型
 *
 * gmat_ques_types  gmat考试的所有试题类型、
 * gmat_ques_{quesid} 该试题的所有信息
 *
 * gmat_paper_num_{paperid} 该试卷的试题总数
 * gmat_paper_ques_{paperid}  该试卷的所有试题数据
 * gmat_paper_test_{paperid}  该试卷的组卷后的模块数据
 *
 * gmat_userTest_{userid}   该用户所有的记录id
 *
 * gmat_userPaperTest_{userid}_{paperid}   用户id下在各套试卷下的记录
 *
 * gmat_test_{test_id}  该记录下的用户做题总数据
 * gmat_test_details_{test_id} 该记录下的所有做题记录
 *
 */
class Service
{
    private static $data;
    public static $cache;

    public function __construct(array $config = [])
    {
        self::setCache();
//        return parent::__construct($config);
    }

    protected static function setCache()
    {
        self::$cache = \Yii::$app->redis;
    }

    public static function success($data)
    {
        self::$data = ['status' => true, 'data' => $data];
        return self::$data;
    }

    public static function error($error, $action = null, $uid = null)
    {

        LogService::errInfo(json_encode($error), $action, $uid);
        self::$data = ['status' => false, 'data' => $error];

        return self::$data;
    }

    public static function inRedis($key)
    {
        self::setCache();
        return (bool)self::$cache->exists($key);
    }

    public static function redisSave($k, $v)
    {
        self::setCache();
        if (self::inRedis($k)) {
            self::$cache->del($k);
        }
        self::$cache->set($k, $v);
    }

    public static function redisGetByKey($k)
    {
        self::setCache();
        return self::$cache->get($k);
    }

    public static function getListAll($k, $s = 0, $e = -1)
    {
        self::setCache();
        return self::$cache->lrange($k, $s, $e);
    }

    public static function addList($k, $va)
    {
        self::setCache();
        return self::$cache->rpush($k, $va);
    }

    public static function redisListLen($k)
    {
        self::setCache();
        return self::$cache->llen($k);
    }

    public static function getListVal($k, $n)
    {
        self::setCache();
        return self::$cache->lrange($k, $n, $n);
    }

    public static function ToArray($arr)
    {
        return ArrayHelper::toArray($arr);
    }
}