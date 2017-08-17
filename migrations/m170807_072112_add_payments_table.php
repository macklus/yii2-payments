<?php

use macklus\payments\helpers\Migration;

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
            'item' => 'VARCHAR(255) NOT NULL',
            'amount' => 'FLOAT(10,2) NOT NULL',
            'provider' => 'ENUM("paypal", "redsys", "transfer") NOT NULL',
            'date_received' => 'TIMESTAMP DEFAULT 0',
            'date_procesed' => 'TIMESTAMP DEFAULT 0',
            'date_add' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'date_edit' => 'TIMESTAMP DEFAULT 0'
                ], $this->table_options);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable($this->payment_table);
    }

}
