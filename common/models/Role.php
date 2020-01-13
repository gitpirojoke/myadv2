<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string $role_name Наименование роли
 * @property string|null $comment Краткое описание роли
 *
 * @property UsersRoles[] $usersRoles
 * @property Users[] $users
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name'], 'required'],
            [['role_name'], 'string', 'max' => 128],
            [['comment'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Наименование роли',
            'comment' => 'Краткое описание роли',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersRoles()
    {
        return $this->hasMany(UsersRoles::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('users_roles', ['role_id' => 'id']);
    }
}
