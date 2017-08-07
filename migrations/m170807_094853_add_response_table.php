<?php

use macklus\payments\migrations\Migration;

/**
 * Class m170807_094853_add_response_table
 */
class m170807_094853_add_response_table extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $this->createTable($this->response_table, [
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'payment_id' => 'INT(11) UNSIGNED',
            'status' => 'ENUM("ok", "error", "unknow") NOT NULL DEFAULT "unknow"',
            'amount' => 'FLOAT(10, 2) NOT NULL',
            'provider' => 'ENUM("paypal", "redsys", "transfer") NOT NULL',
            'data' => 'TEXT NOT NULL',
            'error_code' => 'VARCHAR(255)',
            'date_received' => 'TIMESTAMP',
            'date_processed' => 'TIMESTAMP'
                ], $this->table_options);
        $this->addForeignKey('FK_payment_response', $this->response_table, 'payment_id', $this->payment_table, 'id', $this->cascade, $this->cascade);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropTable($this->response_table);
    }

}
