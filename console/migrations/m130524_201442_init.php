<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // CREATE TABLE
        // Tabel User
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Tabel Material
        $this->createTable('{{%material}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull()->unique(),
            'safety_stock' => $this->integer()->notNull(),
        ], $tableOptions);

        // Tabel Stok
        $this->createTable('{{%stock}}', [
            'material_id' => $this->primaryKey(),
            'qty' => $this->integer()->notNull(),
        ], $tableOptions);

        // Tabel Penerimaan Material
        $this->createTable('{{%material_accepted}}', [
            'id' => $this->primaryKey(),
            'reserved_material_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Tabel Detil Penerimaan Material
        $this->createTable('{{%material_accepted_detail}}', [
            'material_accepted_id' => $this->integer()->notNull(),
            'material_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
            'price' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey(
          'pk_material_accepted_detail',
          'material_accepted_detail', [
            'material_accepted_id',
            'material_id'
        ]);

        // Tabel Barang
        $this->createTable('{{%product}}', [
            'order_id' => $this->integer()->notNull(),
            'material_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'qty' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey(
          'pk_product',
          'product', [
            'order_id',
            'material_id',
            'name'
          ]
        );

        // Tabel Order
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'customer' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Tabel Pengeluaran Material
        $this->createTable('{{%material_expenditure}}', [
            'id' => $this->primaryKey(),
            'requested_material_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Tabel Detil Pengeluaran Material
        $this->createTable('{{%material_expenditure_detail}}', [
            'material_expenditure_id' => $this->integer()->notNull(),
            'material_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey(
          'pk_material_expenditure_detail',
          'material_expenditure_detail', [
            'material_expenditure_id',
            'material_id',
          ]
        );

        // Tabel Sisa Material
        $this->createTable('{{%wasted_material}}', [
            'id' => $this->primaryKey(),
            'material_expenditure_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Tabel Detil Sisa Material
        $this->createTable('{{%wasted_material_detail}}', [
            'wasted_material_id' => $this->integer()->notNull(),
            'material_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey(
          'pk_wasted_material_detail',
          'wasted_material_detail', [
            'wasted_material_id',
            'material_id',
          ]
        );

        // Tabel Pemesanan Material
        $this->createTable('{{%reserved_material}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Tabel Detil Pemesanan Material
        $this->createTable('{{%reserved_material_detail}}', [
            'reserved_material_id' => $this->integer()->notNull(),
            'material_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey(
          'pk_reserved_material_detail',
          'reserved_material_detail', [
            'reserved_material_id',
            'material_id',
          ]
        );

        // Tabel Permintaan Material
        $this->createTable('{{%requested_material}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Tabel Detil Permintaan Material
        $this->createTable('{{%requested_material_detail}}', [
            'requested_material_id' => $this->integer()->notNull(),
            'material_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey(
          'pk_requested_material_detail',
          'requested_material_detail', [
            'requested_material_id',
            'material_id',
          ]
        );

        // CREATE RELATION
        // Tabel Stok ke Material
        $this->addForeignKey(
            'material_have_stock',
            '{{%stock}}',
            'material_id',
            '{{%material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Detil Penerimaan Material ke Material
        $this->addForeignKey(
            'material_have_accept',
            '{{%material_accepted_detail}}',
            'material_id',
            '{{%material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Detil Penerimaan Material ke Penerimaan Material
        $this->addForeignKey(
            'accept_have_material',
            '{{%material_accepted_detail}}',
            'material_accepted_id',
            '{{%material_accepted}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Penerimaan Material ke Pemesanan Material
        $this->addForeignKey(
            'accept_have_reserved',
            '{{%material_accepted}}',
            'reserved_material_id',
            '{{%reserved_material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Detil Pemesanan Material ke Pemesanan Material
        $this->addForeignKey(
            'reserved_detail_have_reserved_material',
            '{{%reserved_material_detail}}',
            'reserved_material_id',
            '{{%reserved_material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Detil Pemesanan Material ke Material
        $this->addForeignKey(
            'reserved_detail_have_material',
            '{{%reserved_material_detail}}',
            'material_id',
            '{{%material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Detil Pengeluaran Material ke Pengeluaran Material
        $this->addForeignKey(
            'expenditure_detail_have_expenditure_material',
            '{{%material_expenditure_detail}}',
            'material_expenditure_id',
            '{{%material_expenditure}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Detil Pengeluaran Material ke Material
        $this->addForeignKey(
            'expenditure_detail_have_material',
            '{{%material_expenditure_detail}}',
            'material_id',
            '{{%material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Detil Sisa Material ke Sisa Material
        $this->addForeignKey(
            'waste_detail_have_waste_material',
            '{{%wasted_material_detail}}',
            'wasted_material_id',
            '{{%wasted_material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Detil Sisa Material ke Material
        $this->addForeignKey(
            'waste_detail_have_material',
            '{{%wasted_material_detail}}',
            'material_id',
            '{{%material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Sisa Material ke Pengeluaran Material
        $this->addForeignKey(
            'wasted_have_expenditure',
            '{{%wasted_material}}',
            'material_expenditure_id',
            '{{%material_expenditure}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Pengeluaran Material ke Permintaan Material
        $this->addForeignKey(
            'expenditure_have_requested',
            '{{%material_expenditure}}',
            'requested_material_id',
            '{{%requested_material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Barang ke Material
        $this->addForeignKey(
            'product_have_material',
            '{{%product}}',
            'material_id',
            '{{%material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Barang ke Order
        $this->addForeignKey(
            'product_have_order',
            '{{%product}}',
            'order_id',
            '{{%order}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Permintaan Material ke Order
        $this->addForeignKey(
            'requested_have_order',
            '{{%requested_material}}',
            'order_id',
            '{{%order}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Detil Permintaan Material ke Material
        $this->addForeignKey(
            'requested_detail_have_material',
            '{{%requested_material_detail}}',
            'material_id',
            '{{%material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        // Tabel Detil Permintaan Material ke Permintaan Material
        $this->addForeignKey(
            'requested_detail_have_requested_material',
            '{{%requested_material_detail}}',
            'requested_material_id',
            '{{%requested_material}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function down()
    {


        $this->dropForeignKey(
            'accept_have_reserved',
            '{{%material_accepted}}'
        );

        $this->dropForeignKey(
            'material_have_stock',
            '{{%stock}}'
        );

        $this->dropForeignKey(
            'material_have_accept',
            '{{%material_accepted_detail}}'
        );

        $this->dropForeignKey(
            'accept_have_material',
            '{{%material_accepted_detail}}'
        );

        // Tabel Detil Pemesanan Material ke Pemesanan Material
        $this->dropForeignKey(
            'reserved_detail_have_reserved_material',
            '{{%reserved_material_detail}}'
        );

        // Tabel Detil Pemesanan Material ke Material
        $this->dropForeignKey(
            'reserved_detail_have_material',
            '{{%reserved_material_detail}}'
        );

        // Tabel Detil Pengeluaran Material ke Pengeluaran Material
        $this->dropForeignKey(
            'expenditure_detail_have_expenditure_material',
            '{{%material_expenditure_detail}}'
        );

        // Tabel Detil Pengeluaran Material ke Material
        $this->dropForeignKey(
            'expenditure_detail_have_material',
            '{{%material_expenditure_detail}}'
        );

        // Tabel Detil Sisa Material ke Sisa Material
        $this->dropForeignKey(
            'waste_detail_have_waste_material',
            '{{%wasted_material_detail}}'
        );

        // Tabel Detil Sisa Material ke Material
        $this->dropForeignKey(
            'waste_detail_have_material',
            '{{%wasted_material_detail}}'
        );

        // Tabel Sisa Material ke Pengeluaran Material
        $this->dropForeignKey(
            'wasted_have_expenditure',
            '{{%wasted_material}}'
        );

        // Tabel Pengeluaran Material ke Permintaan
        $this->dropForeignKey(
            'expenditure_have_requested',
            '{{%material_expenditure}}'
        );

        // Tabel Barang ke Material
        $this->dropForeignKey(
            'product_have_material',
            '{{%product}}'
        );

        // Tabel Barang ke Order
        $this->dropForeignKey(
            'product_have_order',
            '{{%product}}'
        );

        // Tabel Permintaan Material ke Order
        $this->dropForeignKey(
            'requested_have_order',
            '{{%requested_material}}'
        );

        // Tabel Detil Permintaan Material ke Material
        $this->dropForeignKey(
            'requested_detail_have_material',
            '{{%requested_material_detail}}'
        );

        // Tabel Detil Permintaan Material ke Permintaan Material
        $this->dropForeignKey(
            'requested_detail_have_requested_material',
            '{{%requested_material_detail}}'
        );

        $this->dropTable('{{%user}}');
        $this->dropTable('{{%stock}}');
        $this->dropTable('{{%material_accepted_detail}}');
        $this->dropTable('{{%material_accepted}}');
        $this->dropTable('{{%material}}');
        $this->dropTable('{{%product}}');
        $this->dropTable('{{%order}}');
        $this->dropTable('{{%material_expenditure}}');
        $this->dropTable('{{%material_expenditure_detail}}');
        $this->dropTable('{{%wasted_material}}');
        $this->dropTable('{{%wasted_material_detail}}');
        $this->dropTable('{{%reserved_material}}');
        $this->dropTable('{{%reserved_material_detail}}');
        $this->dropTable('{{%requested_material}}');
        $this->dropTable('{{%requested_material_detail}}');
    }
}
