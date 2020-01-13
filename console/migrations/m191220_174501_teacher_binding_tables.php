<?php

use yii\db\Migration;

/**
 * Миграция добавляет таблицы связей преподавателей с группами и предметами обучения
 * для базы данных College.
 */
class m191220_174501_teacher_binding_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%teacher_groups}}', [
            'user_id' => $this->integer(11)->unsigned()->notNull()->comment('ID пользователя-преподавателя'),
            'group_id' => $this->integer(11)->unsigned()->notNull()->comment('ID группы студентов')
        ]);
        $this->addCommentOnTable('{{%teacher_groups}}', 'Таблица связей преподователей и групп');

        $this->createIndex('UX_teacher_groups_id', '{{%teacher_groups}}', ['user_id', 'group_id'], true);
        $this->createIndex('IX_teacher_groups_group_id', '{{%teacher_groups}}', 'group_id');
        $this->addPrimaryKey('PK_teacher_groups', '{{%teacher_groups}}', ['user_id', 'group_id']);

        $this->addForeignKey(
            'FK_teacher_groups_user_id',
            '{{%teacher_groups}}', 'user_id',
            '{{%users}}', 'id'
        );

        $this->addForeignKey(
            'FK_teacher_groups_group_id',
            '{{%teacher_groups}}', 'group_id',
            '{{%groups}}', 'id'
        );

        $this->createTable('{{%teacher_disciplines}}', [
            'user_id' => $this->integer(11)->unsigned()->notNull()->comment('ID пользователя-преподавателя'),
            'discipline_id' => $this->integer(11)->unsigned()->notNull()->comment('ID предмета обучения')
        ]);
        $this->addCommentOnTable('{{%teacher_disciplines}}', 'Таблица связей преподователей и предметов обучения');

        $this->createIndex('UX_teacher_disciplines_id', '{{%teacher_disciplines}}', ['user_id', 'discipline_id'], true);
        $this->createIndex('IX_teacher_disciplines_discipline_id', '{{%teacher_disciplines}}', 'discipline_id');
        $this->addPrimaryKey('PK_teacher_disciplines', '{{%teacher_disciplines}}', ['user_id', 'discipline_id']);

        $this->addForeignKey(
            'FK_teacher_discipline_user_id',
            '{{%teacher_disciplines}}', 'user_id',
            '{{%users}}', 'id'
        );

        $this->addForeignKey(
            'FK_teacher_disciplines_discipline_id',
            '{{%teacher_disciplines}}', 'discipline_id',
            '{{%discipline}}', 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191220_174501_teacher_binding_tables cannot be reverted.\n";

        $this->dropForeignKey('FK_teacher_groups_user_id', '{{%teacher_groups}}');
        $this->dropForeignKey('FK_teacher_groups_group_id', '{{%teacher_groups}}');
        $this->dropForeignKey('FK_teacher_discipline_user_id', '{{%teacher_disciplines}}');
        $this->dropForeignKey('FK_teacher_disciplines_discipline_id', '{{%teacher_disciplines}}');

        $this->dropIndex('UX_teacher_groups_id', '{{%teacher_groups}}');
        $this->dropIndex('IX_teacher_groups_group_id', '{{%teacher_groups}}');
        $this->dropIndex('UX_teacher_disciplines_id', '{{%teacher_disciplines}}');
        $this->dropIndex('IX_teacher_disciplines_discipline_id', '{{%teacher_disciplines}}');

        $this->dropPrimaryKey('PK_teacher_groups', '{{%teacher_groups}}');
        $this->dropPrimaryKey('PK_teacher_disciplines', '{{%teacher_disciplines}}');

        $this->dropTable('{{%teacher_groups}}');
        $this->dropTable('{{%teacher_disciplines}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191220_174501_teacher_binding_tables cannot be reverted.\n";

        return false;
    }
    */
}
