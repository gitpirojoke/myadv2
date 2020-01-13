<?php

use yii\db\Migration;

/**
 * Миграция добавляет таблицы аттестата и справочник периодов аттестации.
 */
class m191220_220011_attestat_and_evaluation_periods extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evaluation_periods}}', [
            'id' => $this->primaryKey(11)->unsigned(),
            'period_name' => $this->string(128)->unique()->notNull()->comment('Название периода аттестации'),
            'start_at' => $this->integer()->unsigned()->notNull()->comment('Дата начала периода'),
            'end_at' => $this->integer()->unsigned()->notNull()->comment('Дата окончания периода')
        ]);
        $this->addCommentOnTable('{{%evaluation_periods}}', 'Справочник периодов аттестации');

        $this->createIndex('UX_evaluation_periods', '{{%evaluation_periods}}', ['period_name', 'start_at',
            'end_at'], true);

        $this->createTable('{{%attestat}}', [
            'id' => $this->primaryKey(11)->unsigned(),
            'student_id' => $this->integer(11)->unsigned()->notNull()->comment('ID студента'),
            'teacher_id' => $this->integer(11)->unsigned()->notNull()->comment('ID преподавателя'),
            'discipline_id' => $this->integer(11)->unsigned()->notNull()->comment('ID предмета'),
            'group_id' => $this->integer(11)->unsigned()->notNull()->comment('ID группы студента'),
            'evaluation_period' => $this->integer(11)->unsigned()->notNull()->comment('ID периода аттестации'),
            'valuation' => $this->integer()->notNull()->comment('Аттестационная оценка'),
            'signed_at' => $this->integer()->unsigned()->notNull()->comment('Дата получения оценки')
        ]);
        $this->addCommentOnTable('{{%attestat}}', 'Таблица аттестации студентов');

        $this->createIndex('IX_attestat', '{{%attestat}}', ['student_id', 'teacher_id', 'discipline_id',
            'group_id']);

        $this->addForeignKey(
            'FK_attestat_student_id',
            '{{%attestat}}', 'student_id',
            '{{%users}}', 'id'
        );

        $this->addForeignKey(
            'FK_attestat_teacher_id',
            '{{%attestat}}', 'teacher_id',
            '{{%users}}', 'id'
        );

        $this->addForeignKey(
            'FK_attestat_discipline_id',
            '{{%attestat}}', 'discipline_id',
            '{{%discipline}}', 'id'
        );

        $this->addForeignKey(
            'FK_attestat_group_id',
            '{{%attestat}}', 'group_id',
            '{{%groups}}', 'id'
        );

        $this->addForeignKey(
            'FK_attestat_evaluation_period',
            '{{%attestat}}', 'evaluation_period',
            '{{%evaluation_periods}}', 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191220_220011_attestat_and_evaluation_periods cannot be reverted.\n";

        $this->dropForeignKey('FK_attestat_student_id', '{{%attestat}}');
        $this->dropForeignKey('FK_attestat_teacher_id', '{{%attestat}}');
        $this->dropForeignKey('FK_attestat_discipline_id', '{{%attestat}}');
        $this->dropForeignKey('FK_attestat_group_id', '{{%attestat}}');
        $this->dropForeignKey('FK_attestat_evaluation_period', '{{%attestat}}');

        $this->dropIndex('UX_evaluation_periods', '{{%evaluation_periods}}');
        $this->dropIndex('IX_attestat', '{{%attestat}}');

        $this->dropTable('{{%evaluation_periods}}');
        $this->dropTable('{{%attestat}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191220_220011_attestat_and_evaluation_periods cannot be reverted.\n";

        return false;
    }
    */
}
