<?php

use yii\db\Migration;

/**
 * Handles the creation of table `banner`.
 * Has foreign keys to the tables:
 *
 * - `image`
 * - `user`
 * - `user`
 */
class m170730_003014_create_banner_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('banner', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'link' => $this->string(),
            'caption' => $this->string(),
            'active' => $this->smallInteger(1),
            'type' => $this->integer(),
            'sort_order' => $this->integer(),
            'create_time' => $this->integer()->notNull(),
            'update_time' => $this->integer(),
            'image_id' => $this->integer(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `image_id`
        $this->createIndex(
            'idx-banner-image_id',
            'banner',
            'image_id'
        );

        // add foreign key for table `image`
        $this->addForeignKey(
            'fk-banner-image_id',
            'banner',
            'image_id',
            'image',
            'id',
            'SET NULL'
        );

        // creates index for column `creator_id`
        $this->createIndex(
            'idx-banner-creator_id',
            'banner',
            'creator_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-banner-creator_id',
            'banner',
            'creator_id',
            'user',
            'id',
            'RESTRICT'
        );

        // creates index for column `updater_id`
        $this->createIndex(
            'idx-banner-updater_id',
            'banner',
            'updater_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-banner-updater_id',
            'banner',
            'updater_id',
            'user',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `image`
        $this->dropForeignKey(
            'fk-banner-image_id',
            'banner'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            'idx-banner-image_id',
            'banner'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-banner-creator_id',
            'banner'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            'idx-banner-creator_id',
            'banner'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-banner-updater_id',
            'banner'
        );

        // drops index for column `updater_id`
        $this->dropIndex(
            'idx-banner-updater_id',
            'banner'
        );

        $this->dropTable('banner');
    }
}
