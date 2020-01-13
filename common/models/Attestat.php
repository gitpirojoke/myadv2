<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "attestat".
 *
 * @property int $id
 * @property int $student_id ID студента
 * @property int $teacher_id ID преподавателя
 * @property int $discipline_id ID предмета
 * @property int $group_id ID группы студента
 * @property int $evaluation_period ID периода аттестации
 * @property int $valuation Аттестационная оценка
 * @property int $signed_at Дата получения оценки
 *
 * @property Discipline $discipline
 * @property EvaluationPeriods $evaluationPeriod
 * @property Groups $group
 * @property Users $student
 * @property Users $teacher
 */
class Attestat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attestat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'teacher_id', 'discipline_id', 'group_id', 'evaluation_period', 'valuation', 'signed_at'], 'required'],
            [['student_id', 'teacher_id', 'discipline_id', 'group_id', 'evaluation_period', 'valuation', 'signed_at'], 'integer'],
            [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discipline::className(), 'targetAttribute' => ['discipline_id' => 'id']],
            [['evaluation_period'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluationPeriods::className(), 'targetAttribute' => ['evaluation_period' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'ID студента',
            'teacher_id' => 'ID преподавателя',
            'discipline_id' => 'ID предмета',
            'group_id' => 'ID группы студента',
            'evaluation_period' => 'ID периода аттестации',
            'valuation' => 'Аттестационная оценка',
            'signed_at' => 'Дата получения оценки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscipline()
    {
        return $this->hasOne(Discipline::className(), ['id' => 'discipline_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluationPeriod()
    {
        return $this->hasOne(EvaluationPeriods::className(), ['id' => 'evaluation_period']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Users::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Users::className(), ['id' => 'teacher_id']);
    }
}
