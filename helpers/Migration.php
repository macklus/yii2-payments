<?php

namespace macklus\payments\migrations;

use yii\db\Migration as YiiMigration;

/**
 * Class Migration
 */
class Migration extends YiiMigration {

    protected $table_options;
    protected $payment_table;
    protected $response_table;
    protected $cascade = 'CASCADE';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        $this->payment_table = \Yii::$app->getModule('payments')->tables['payment'];
        $this->response_table = \Yii::$app->getModule('payments')->tables['response'];

        switch ($this->db->driverName) {
            case 'mysql':
                $this->table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                break;
            case 'pgsql':
                $this->table_options = null;
                break;
            case 'dblib':
            case 'mssql':
            case 'sqlsrv':
                $this->table_options = null;
                break;
            default:
                throw new \RuntimeException('Your database is not supported!');
        }

        return true;
    }

}
