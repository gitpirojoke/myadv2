<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "groups".
 *
 * @property int $id
 * @property string $group_name Группы пользователей
 *
 * @property Attestat[] $attestats
 * @property TeacherGroups[] $teacherGroups
 * @property Users[] $users
 * @property UserGroups[] $userGroups
 * @property Users[] $users0
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_name'], 'required'],
            [['group_name'], 'string', 'max' => 128],
            [['group_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_name' => 'Группы пользователей',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttestats()
    {
        return $this->hasMany(Attestat::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherGroups()
    {
        return $this->hasMany(TeacherGroups::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('teacher_groups', ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserGroups()
    {
        return $this->hasMany(UserGroups::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('user_groups', ['group_id' => 'id']);
    }
}
