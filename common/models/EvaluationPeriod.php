<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evaluation_periods".
 *
 * @property int $id
 * @property string $period_name Название периода аттестации
 * @property int $start_at Дата начала периода
 * @property int $end_at Дата окончания периода
 *
 * @property Attestat[] $attestats
 */
class EvaluationPeriod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluation_periods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['period_name', 'start_at', 'end_at'], 'required'],
            [['start_at', 'end_at'], 'integer'],
            [['period_name'], 'string', 'max' => 128],
            [['period_name'], 'unique'],
            [['period_name', 'start_at', 'end_at'], 'unique', 'targetAttribute' => ['period_name', 'start_at', 'end_at']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'period_name' => 'Название периода аттестации',
            'start_at' => 'Дата начала периода',
            'end_at' => 'Дата окончания периода',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttestats()
    {
        return $this->hasMany(Attestat::className(), ['evaluation_period' => 'id']);
    }
}
