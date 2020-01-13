<?php

use yii\db\Migration;

/**
 * Миграция добавляет структуру таблиц College.
 */
class m191207_111757_create_college_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(11)->unsigned(),
            'login' => $this->string(128)->unique()->notNull()->comment('Логин пользователя'),
            'name' => $this->string(250)->comment('ФИО пользователя'),
            'email' => $this->string(250)->unique()->notNull()->comment('Электронная почта пользователя'),
            'password' => $this->string()->comment('Пароль пользователя'),
            'born_date' => $this->dateTime()->comment('Дата рождения пользователя'),
            'gender' => $this->string()->comment('Пол'),
            'updated_at' => $this->integer()->unsigned()->null()->comment('Дата обновления')
        ]);
        $this->addCommentOnTable('{{%users}}', 'Пользователи');

        $this->createIndex('UX_users', '{{%users}}', ['login', 'email']);


        $this->createTable('{{%roles}}', [
            'id' => $this->primaryKey(11)->unsigned(),
            'role_name' => $this->string(128)->notNull()->comment('Наименование роли'),
            'comment' => $this->string(250)->null()->comment('Краткое описание роли')
        ]);
        $this->addCommentOnTable('{{%roles}}', 'Справочник ролей');

        $this->createTable('{{%users_roles}}', [
            'user_id' => $this->integer(11)->unsigned()->comment('ID пользователя'),
            'role_id' => $this->integer(11)->unsigned()->comment('ID роли пользователя'),
            'updated_at' => $this->integer()->unsigned()->notnull()->comment('Дата обновления'),
            'comment' => $this->string(250)->null()->comment('Примечание')
        ]);
        $this->addCommentOnTable('{{%users_roles}}', 'Связи пользователей с ролями');

        $this->createIndex('UX_users_roles_id', '{{%users_roles}}', ['user_id', 'role_id'], true);
        $this->createIndex('IX_users_roles_id', '{{%users_roles}}', 'role_id');
        $this->addPrimaryKey('PK_users_roles', '{{%users_roles}}', ['user_id', 'role_id']);

        $this->addForeignKey(
            'FK_users_roles_user_id',
            '{{%users_roles}}', 'user_id',
            '{{%users}}', 'id'
        );

        $this->addForeignKey(
            'FK_users_roles_role_id',
            '{{%users_roles}}', 'role_id',
            '{{%roles}}', 'id'
        );

        $this->createTable('{{%groups}}', [
            'id' => $this->primaryKey(11)->unsigned(),
            'group_name' => $this->string(128)->unique()->notNull()->comment('Группы пользователей')
        ]);
        $this->addCommentOnTable('{{%groups}}', 'Справочник групп пользователей');

        $this->createTable('{{%user_groups}}', [
            'user_id' => $this->integer(11)->unsigned()->notNull()->comment('ID пользователя'),
            'group_id' => $this->integer(11)->unsigned()->notNull()->comment('ID группы'),
            'updated_at' => $this->integer()->unsigned()->null()->comment('Дата обновления'),
            'comment' => $this->string(250)->null()->comment('Примечание')
        ]);
        $this->addCommentOnTable('{{%user_groups}}', 'Связи пользователей с группами');

        $this->createIndex('UX_users_groups_id', '{{%user_groups}}', ['user_id', 'group_id'], true);
        $this->createIndex('IX_users_groups_group_id', '{{%user_groups}}', 'group_id');
        $this->addPrimaryKey('PK_users_groups', '{{%user_groups}}', ['user_id', 'group_id']);

        $this->addForeignKey(
            'FK_user_groups_user_id',
            '{{%user_groups}}', 'user_id',
            '{{%users}}', 'id'
        );

        $this->addForeignKey(
            'FK_user_groups_group_id',
            '{{%user_groups}}', 'group_id',
            '{{%groups}}', 'id'
        );

        $this->createTable('{{%discipline}}', [
            'id' => $this->primaryKey(11)->unsigned(),
            'discipline_name' => $this->string(128)->unique()->notNull()->comment('Наименование предмета')
        ]);
        $this->addCommentOnTable('{{%discipline}}', 'Справочник предметов обучения');

        $this->createTable('{{%exam_log}}', [
            'id' => $this->primaryKey(11)->unsigned(),
            'student_id' => $this->integer(11)->unsigned()->notNull()->comment('ID студента'),
            'teacher_id' => $this->integer(11)->unsigned()->notNull()->comment('ID преподавателя'),
            'discipline_id' => $this->integer(11)->unsigned()->notNull()->comment('ID предмета'),
            'exam_theme' => $this->string(250)->notnull()->comment('Тема оцениваемой работы'),
            'valuation' => $this->integer()->notNull()->comment('Оценка работы'),
            'signed_at' => $this->integer()->unsigned()->notNull()->comment('Дата получения оценки')
        ]);
        $this->addCommentOnTable('{{%exam_log}}', 'Лог учебного процесса');

        $this->createIndex('IX_exam_log_id', '{{%exam_log}}', ['student_id', 'teacher_id', 'discipline_id']);

        $this->addForeignKey(
            'FK_exam_log_student_id',
            '{{%exam_log}}', 'student_id',
            '{{%users}}', 'id'
        );

        $this->addForeignKey(
            'FK_exam_log_teacher_id',
            '{{%exam_log}}', 'teacher_id',
            '{{%users}}', 'id'
        );

        $this->addForeignKey(
            'FK_exam_log_discipline_id',
            '{{%exam_log}}', 'discipline_id',
            '{{%discipline}}', 'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191207_111757_create_college_tables cannot be reverted.\n";

        $this->dropForeignKey('FK_users_roles_user_id', '{{%users_roles}}');
        $this->dropForeignKey('FK_users_roles_role_id', '{{%users_roles}}');

        $this->dropForeignKey('FK_user_groups_user_id', '{{%user_groups}}');
        $this->dropForeignKey('FK_user_groups_group_id', '{{%user_groups}}');

        $this->dropForeignKey('FK_exam_log_student_id', '{{%exam_log}}');
        $this->dropForeignKey('FK_exam_log_teacher_id', '{{%exam_log}}');
        $this->dropForeignKey('FK_exam_log_discipline_id', '{{%exam_log}}');

        $this->dropIndex('UX_users', '{{%users}}');

        $this->dropIndex('UX_users_roles_id', '{{%users_roles}}');
        $this->dropIndex('IX_users_roles_id', '{{%users_roles}}');

        $this->dropIndex('UX_users_groups_id', '{{%user_groups}}');
        $this->dropIndex('IX_users_groups_group_id', '{{%user_groups}}');

        $this->dropIndex('IX_exam_log_id', '{{%exam_log}}');

        $this->dropPrimaryKey('PK_users_roles', '{{%users_roles}}');
        $this->dropPrimaryKey('PK_users_groups', '{{%user_groups}}');

        $this->dropTable('{{%users}}');
        $this->dropTable('{{%roles}}');
        $this->dropTable('{{%users_roles}}');
        $this->dropTable('{{%groups}}');
        $this->dropTable('{{%user_groups}}');
        $this->dropTable('{{%discipline}}');
        $this->dropTable('{{%exam_log}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191207_111757_create_college_tables cannot be reverted.\n";

        return false;
    }
    */
}
