<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login Логин пользователя
 * @property string|null $name ФИО пользователя
 * @property string $email Электронная почта пользователя
 * @property string|null $password Пароль пользователя
 * @property string|null $born_date Дата рождения пользователя
 * @property string|null $gender Пол
 * @property int|null $updated_at Дата обновления
 *
 * @property Attestat[] $attestats
 * @property Attestat[] $attestats0
 * @property ExamLog[] $examLogs
 * @property ExamLog[] $examLogs0
 * @property TeacherDisciplines[] $teacherDisciplines
 * @property Discipline[] $disciplines
 * @property TeacherGroups[] $teacherGroups
 * @property Groups[] $groups
 * @property UserGroups[] $userGroups
 * @property Groups[] $groups0
 * @property UsersRoles[] $usersRoles
 * @property Roles[] $roles
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'email'], 'required'],
            [['born_date'], 'safe'],
            [['updated_at'], 'integer'],
            [['login'], 'string', 'max' => 128],
            [['name', 'email'], 'string', 'max' => 250],
            [['password', 'gender'], 'string', 'max' => 255],
            [['login'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин пользователя',
            'name' => 'ФИО пользователя',
            'email' => 'Электронная почта пользователя',
            'password' => 'Пароль пользователя',
            'born_date' => 'Дата рождения пользователя',
            'gender' => 'Пол',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttestats()
    {
        return $this->hasMany(Attestat::className(), ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttestats0()
    {
        return $this->hasMany(Attestat::className(), ['teacher_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamLogs()
    {
        return $this->hasMany(ExamLog::className(), ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamLogs0()
    {
        return $this->hasMany(ExamLog::className(), ['teacher_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherDisciplines()
    {
        return $this->hasMany(TeacherDisciplines::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplines()
    {
        return $this->hasMany(Discipline::className(), ['id' => 'discipline_id'])->viaTable('teacher_disciplines', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherGroups()
    {
        return $this->hasMany(TeacherGroups::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Groups::className(), ['id' => 'group_id'])->viaTable('teacher_groups', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserGroups()
    {
        return $this->hasMany(UserGroups::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups0()
    {
        return $this->hasMany(Groups::className(), ['id' => 'group_id'])->viaTable('user_groups', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersRoles()
    {
        return $this->hasMany(UsersRoles::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Roles::className(), ['id' => 'role_id'])->viaTable('users_roles', ['user_id' => 'id']);
    }
}
