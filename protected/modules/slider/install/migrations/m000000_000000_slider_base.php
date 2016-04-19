<?php

/**
 * Класс миграций для модуля Slider
 **/
class m000000_000000_slider_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{slide_slide}}',
            [
                'id'            => 'pk',
                'name'          => 'varchar(250) NOT NULL',
                'description'   => 'text',
                'file'          => 'varchar(250) NOT NULL',
            	'url'           => 'varchar(250) NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'user_id'       => 'integer DEFAULT NULL',
                'status'        => "integer NOT NULL DEFAULT '1'",
            	'sort'			=> 	"integer NOT NULL DEFAULT '1'",
                'slider_id'     => 'int(11) NOT NULL',
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ix_{{slide_slide}}_status", '{{slide_slide}}', "status", false);
        $this->createIndex("ix_{{slide_slide}}_user", '{{slide_slide}}', "user_id", false);


        //fk

        $this->addForeignKey(
            "fk_{{slide_slide}}_user_id",
            '{{slide_slide}}',
            'user_id',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );

        $this->createTable(
            '{{slide_slider}}',
            [
                'id'            => 'pk',
                'name'          => 'varchar(250) NOT NULL',
                'code'          => 'varchar(250) NOT NULL',
                'description'   => 'text',
                'creation_date' => 'datetime NOT NULL',
                'user_id'       => 'integer DEFAULT NULL',
                'status'        => "integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{slide_slide}}');
        $this->dropTableWithForeignKeys('{{slide_slider}}');
    }
}
