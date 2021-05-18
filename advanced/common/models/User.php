<?php

namespace common\models;

use common\widgets\OldDi;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "user".
 *
 * @property int $user_id
 * @property string $account
 * @property string|null $password
 * @property string|null $salt
 * @property string|null $totp_auth
 * @property int $register_time
 * @property string|null $phone
 * @property string|null $nick_name
 * @property float $balance
 * @property int|null $last_login
 * @property int $status
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = -1;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    public $remeberMe = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['account', 'register_time'], 'required'],
            [['register_time', 'last_login', 'status'], 'integer'],
            [['balance'], 'number'],
            [['account', 'nick_name'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 40],
            [['salt'], 'string', 'max' => 8],
            [['totp_auth', 'phone'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'account' => 'Account',
            'password' => 'Password',
            'salt' => 'Salt',
            'totp_auth' => 'Totp Auth',
            'register_time' => 'Register Time',
            'phone' => 'Phone',
            'nick_name' => 'Nick Name',
            'balance' => 'Balance',
            'last_login' => 'Last Login',
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $identity = UserIdentify::findOne(['identify' => $token]);
//        var_dump($identity);
//        exit();
        if ($identity) {
            return static::findOne(['user_id' => $identity->id]);
        }

    }

    public function getAccessToken($id)
    {
        $identity = UserIdentify::findOne(['user_id' => $id]);
        if ($identity) {
            if ($identity->expire_time && ($identity->expire_time > time())) {
                return $identity->identify;
            }
//            return 'User AccessToken expired';
        }
        return null;
    }

    public function refreshAccessToken($uId, $appId)
    {
        $identity = UserIdentify::findOne(['user_id' => $uId, 'app_id' => $appId]);
        if (!$identity) {
            $identity = new UserIdentify();
            $identity->user_id = $uId;
            $identity->append_time = time();
            $identity->app_id = $appId;
        }
        $identity->expire_time = time() + 30 * 3600;
        $identity->identify = Yii::$app->security->generateRandomString();
        if ($identity->save()) {
            return $identity->identify;
        }
        return null;
    }

    /**
     * Finds user by account
     *
     * @param string $account
     * @return static|null
     */
    public static function findByUsername($account)
    {
        return static::findOne(['account' => $account, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if (!is_string($password) || $password === '') {
            throw new InvalidArgumentException('Password must be a string and cannot be empty.');
        }

        if ($this->password === OldDi::generatePassword($password, $this->salt)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {

        $this->password = OldDi::setPassword($password, $this->getAuthKey());
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->salt = OldDi::GetString(8);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
