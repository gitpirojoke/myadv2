<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exam_log".
 *
 * @property int $id
 * @property int $student_id ID студента
 * @property int $teacher_id ID преподавателя
 * @property int $discipline_id ID предмета
 * @property string $exam_theme Тема оцениваемой работы
 * @property int $valuation Оценка работы
 * @property int $signed_at Дата получения оценки
 *
 * @property Discipline $discipline
 * @property Users $student
 * @property Users $teacher
 */
class ExamLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exam_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'teacher_id', 'discipline_id', 'exam_theme', 'valuation', 'signed_at'], 'required'],
            [['student_id', 'teacher_id', 'discipline_id', 'valuation', 'signed_at'], 'integer'],
            [['exam_theme'], 'string', 'max' => 250],
            [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discipline::className(), 'targetAttribute' => ['discipline_id' => 'id']],
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
            'exam_theme' => 'Тема оцениваемой работы',
            'valuation' => 'Оценка работы',
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
