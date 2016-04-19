<?php

class m160419_094111_add_fields extends yupe\components\DbMigration
{
	public function safeUp()
	{
		$this->addColumn('{{slide_slider}}', 'title1', 'varchar(250) DEFAULT NULL');
		$this->addColumn('{{slide_slider}}', 'title2', 'varchar(250) DEFAULT NULL');
		$this->addColumn('{{slide_slider}}', 'file', 'varchar(250) NOT NULL');
		$this->addColumn('{{slide_slider}}', 'lang', 'char(2) DEFAULT NULL');
	}

	public function safeDown()
	{
		$this->dropColumn('{{slide_slider}}', 'title1');
		$this->dropColumn('{{slide_slider}}', 'title2');
		$this->dropColumn('{{slide_slider}}', 'file');
		$this->dropColumn('{{slide_slider}}', 'lang');
	}
}