<?php

use yii\db\Migration;

/**
 * Class m221104_125646_create_fulltext_index_on_video
 */
class m221104_125646_create_fulltext_index_on_video extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE {{%video}} ADD FULLTEXT(title, description, tags)");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221104_125646_create_fulltext_index_on_video cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221104_125646_create_fulltext_index_on_video cannot be reverted.\n";

        return false;
    }
    */
}
