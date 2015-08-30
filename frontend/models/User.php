<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \common\models\User
{
    public $password_confirm;
    public $password_set;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'password_set','password_confirm',"phone"], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 32],
            [["username"],'unique','message'=>'用户名{attribute}已存在'],
            [['password_set'],'match','pattern'=>'/^[\d\w*\$#^-_]{6,12}$/'],
            [['password_confirm'],'compare','compareAttribute'=>'password_set'],
            [["email"],'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', '用户名'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'password_set' =>  Yii::t('app', '密码'),
            'password_confirm' =>  Yii::t('app', '确认密码'),
            'name' =>  Yii::t('app', '姓名'),
            'phone' =>  Yii::t('app', '手机'),
        ];
    }

    public function attributeHints(){
        return [
            "username" => '登录使用的用户名',
            "password_set" => "登录密码,6-12个字符,支持0-9A-Za-z$#-_等字符^",
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function($event){
                        return date('Y-m-d H:i:s');
                    },
            ],
        ];
    }
}
