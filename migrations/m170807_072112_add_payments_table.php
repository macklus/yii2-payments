<?php

use macklus\payments\migrations\Migration;

/**
 * Class m170807_072112_add_payments_table
 */
class m170807_072112_add_payments_table extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable($this->payment_table, [
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'code' => 'VARCHAR(32) NOT NULL',
            'amount' => 'FLOAT(10,2) NOT NULL',
            'provider' => 'ENUM("paypal", "redsys", "transfer") NOT NULL',
            'date_received' => 'TIMESTAMP NOT NULL',
            'date_procesed' => 'TIMESTAMP NOT NULL',
            'date_add' => 'TIMESTAMP NOT NULL',
            'date_edit' => 'TIMESTAMP NOT NULL'
                ], $this->table_options);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable($this->payment_table);
    }

}
