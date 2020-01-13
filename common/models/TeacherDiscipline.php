<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "teacher_disciplines".
 *
 * @property int $user_id ID пользователя-преподавателя
 * @property int $discipline_id ID предмета обучения
 *
 * @property Users $user
 * @property Discipline $discipline
 */
class TeacherDiscipline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher_disciplines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'discipline_id'], 'required'],
            [['user_id', 'discipline_id'], 'integer'],
            [['user_id', 'discipline_id'], 'unique', 'targetAttribute' => ['user_id', 'discipline_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discipline::className(), 'targetAttribute' => ['discipline_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID пользователя-преподавателя',
            'discipline_id' => 'ID предмета обучения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscipline()
    {
        return $this->hasOne(Discipline::className(), ['id' => 'discipline_id']);
    }
}
