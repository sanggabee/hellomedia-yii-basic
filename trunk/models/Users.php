<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $levelid
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $fullname
 * @property string $birthday
 * @property string $sex
 * @property string $phonenumber
 * @property string $city
 * @property string $avatar
 * @property double $vang
 * @property double $xu
 * @property integer $statu
 * @property string $code
 * @property string $datecreated
 * @property string $openID
 * @property string $openType
 * @property string $displayname
 * @property string $codemail
 * @property double $exp
 * @property string $friends
 * @property string $lastLogin
 * @property integer $ticket
 * @property integer $onlineDay
 * @property integer $constrainMoney
 * @property integer $eventPoint
 * @property integer $eventTime
 * @property integer $published
 * @property integer $party_id
 * @property integer $stt_check
 * @property string $link_user_create
 * @property string $hash_code
 * @property string $new_encryption_method
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['levelid', 'email', 'username', 'password', 'statu', 'code', 'datecreated', 'openID', 'openType', 'displayname', 'codemail', 'exp', 'constrainMoney', 'published', 'party_id', 'link_user_create', 'hash_code'], 'required'],
            [['levelid', 'statu', 'ticket', 'onlineDay', 'constrainMoney', 'eventPoint', 'eventTime', 'published', 'party_id', 'stt_check'], 'integer'],
            [['vang', 'xu', 'exp'], 'number'],
            [['datecreated'], 'safe'],
            [['friends'], 'string'],
            [['email', 'username', 'password', 'fullname', 'sex', 'phonenumber', 'city', 'avatar', 'openID', 'openType', 'displayname', 'codemail', 'lastLogin'], 'string', 'max' => 255],
            [['birthday', 'new_encryption_method'], 'string', 'max' => 10],
            [['code'], 'string', 'max' => 65],
            [['link_user_create'], 'string', 'max' => 100],
            [['hash_code'], 'string', 'max' => 50],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'levelid' => 'Levelid',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'fullname' => 'Fullname',
            'birthday' => 'Birthday',
            'sex' => 'Sex',
            'phonenumber' => 'Phonenumber',
            'city' => 'City',
            'avatar' => 'Avatar',
            'vang' => 'Vang',
            'xu' => 'Xu',
            'statu' => 'Statu',
            'code' => 'Code',
            'datecreated' => 'Datecreated',
            'openID' => 'Open ID',
            'openType' => 'Open Type',
            'displayname' => 'Displayname',
            'codemail' => 'Codemail',
            'exp' => 'Exp',
            'friends' => 'Friends',
            'lastLogin' => 'Last Login',
            'ticket' => 'Ticket',
            'onlineDay' => 'Online Day',
            'constrainMoney' => 'Constrain Money',
            'eventPoint' => 'Event Point',
            'eventTime' => 'Event Time',
            'published' => 'Published',
            'party_id' => 'Party ID',
            'stt_check' => 'Stt Check',
            'link_user_create' => 'Link User Create',
            'hash_code' => 'Hash Code',
            'new_encryption_method' => 'New Encryption Method',
        ];
    }
}
