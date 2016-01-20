<?php
/**
 * Copyright 2016, Stewart Doxey (http://www.stewartdoxey.co.uk)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2016, Stewart Doxey (http://www.stewartdoxey.co.uk)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('MetaData', 'MetaData.Model');

/**
 * CakePHP MetaData Plugin
 *
 * Meta behavior
 *
 * @package 	metadata
 * @subpackage 	metadata.models.behaviors
 */
class MetaBehavior extends ModelBehavior {

/**
 * Settings array
 *
 * @var array
 */
	public $settings = array();

/**
 * Default settings
 *
 * @var array
 */
	protected $_defaults = array();

/**
 * Setup
 *
 * @param Model $Model
 * @param array $settings
 * @return void
 */
	public function setup(Model $Model, $settings = array()) {
		if (! isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = $this->_defaults;
		}

		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);

		return;
	}

/**
 * Prepare the meta data for saving
 */
	public function beforeSave(Model $Model, $options = array()) {
		if (isset($Model->data[$Model->alias]['MetaData'])) {
			$Model->data['MetaData'] = $Model->data[$Model->alias]['MetaData'];
			unset($Model->data[$Model->alias]['MetaData']);
		}
		return parent::beforeSave($Model, $options);
	}

/**
 * Save the meta data
 */
	public function afterSave(Model $Model, $created, $options = array()) {
		parent::afterSave($Model, $created, $options);

		$Model->data['MetaData']['model'] = $Model->alias;
		$Model->data['MetaData']['model_id'] = $Model->id;

		$MetaData = ClassRegistry::init('MetaData.MetaData');
		$MetaData->create();
		$MetaData->save($Model->data);

		return;
	}

/**
 * Insert meta data into parent model find results
 */
	public function afterFind(Model $Model, $data, $primary = false) {
		// we are only ever concerned about retreiving meta data
		// for individul records and not for listing, allowing us
		// to check for the $primary boolean of true
		if ($primary === true) {
			$modelAlias = $Model->alias;

			if (! empty($data)) {
				$MetaData = ClassRegistry::init('MetaData.MetaData');

				// get first key from the model array
				$tmpData = $data;
				reset($tmpData);
				$dataKey = key($tmpData);

				// extract the model alias id from the data array
				$modelAliasId = Hash::get($data, "$dataKey.$modelAlias.id");

				if (! empty($modelAliasId)) {
					$meta = $MetaData->find('first', array(
							'conditions' => array(
								'model' => $modelAlias,
								'model_id' => $modelAliasId
							)
						)
					);

					// assign the meta data to the model array
					$data[$dataKey] += $meta;
				}
			}
		}

		return $data;
	}

}
