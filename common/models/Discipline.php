<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discipline".
 *
 * @property int $id
 * @property string $discipline_name Наименование предмета
 *
 * @property Attestat[] $attestats
 * @property ExamLog[] $examLogs
 * @property TeacherDisciplines[] $teacherDisciplines
 * @property Users[] $users
 */
class Discipline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discipline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discipline_name'], 'required'],
            [['discipline_name'], 'string', 'max' => 128],
            [['discipline_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'discipline_name' => 'Наименование предмета',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttestats()
    {
        return $this->hasMany(Attestat::className(), ['discipline_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamLogs()
    {
        return $this->hasMany(ExamLog::className(), ['discipline_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherDisciplines()
    {
        return $this->hasMany(TeacherDisciplines::className(), ['discipline_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('teacher_disciplines', ['discipline_id' => 'id']);
    }
}
