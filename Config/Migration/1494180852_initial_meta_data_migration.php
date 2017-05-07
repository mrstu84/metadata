<?php
class InitialMetaDataMigration extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'initial_meta_data_migration';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'meta_data' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary')
					'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 254, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'description' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 254, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'model' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 254, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'model_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1)
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'meta_data'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
