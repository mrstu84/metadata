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

App::uses('Component', 'Controller');

/**
 * CakePHP MetaData Plugin
 *
 * Meta component
 *
 * @package 	metadata
 * @subpackage 	metadata.controllers.components
 */

App::uses('ArrayUtil', 'MetaData.Lib');

App::uses('CakeText', 'Utility');

class MetaComponent extends Component {

	public $metaDataFields = array(
		'MetaData.id' => array(
			'type' => 'hidden'
		),
		'MetaData.title' => array(
			'label' => 'Meta Title',
			'length' => 60,
			'type' => 'string'
		),
		'MetaData.description' => array(
			'label' => 'Meta Description',
			'length' => 160,
			'type' => 'string'
		)
	);

/**
 * Callback
 *
 * @param Controller $Controller
 * @return void
 */
	public function initialize(Controller $controller) {
		parent::initialize($controller);

		$this->Controller = $controller;
	}

/**
 * Sets the views meta data, if available
 *
 * @param array $data
 * @return void
 */
	public function set($data = array()) {
		$Model = $this->__controller->{$this->__controller->modelClass};

		// assign the meta title variable, starting with data assigned
		// directly to MetaData, falling back next to the Model displayField
		// variable before falling again to the Model displayName variable
		if (! empty($data['MetaData']['title'])) {
			$metaTitle = $data['MetaData']['title'];
		} elseif (! empty($data[$Model->alias][$Model->displayField])) {
			$metaTitle = $data[$Model->alias][$Model->displayField];
		} else {
			$metaTitle = Inflector::pluralize($data[$Model->alias][$Model->displayName]);
		}

		if (! empty($metaTitle)) {
			$this->Controller->set(compact('metaTitle'));
		}

		// assign the meta description variable, starting with data
		// assigned directly to MetaData, falling back to content
		// and then body fields from within the supplied data
		if (! empty($data['MetaData']['description'])) {
			$metaDescription = $data['MetaData']['description'];
		} elseif (! empty($data[$Model->alias]['body'])) {
			// truncate the content variable to a max of 160 characters
			// ref: https://moz.com/learn/seo/meta-description
			$metaDescription = CakeText::truncate($data['MetaData']['description'], 160, array('html' => false));
		} elseif (! empty($data[$Model->alias]['content'])) {
			// truncate the content variable to a max of 160 characters
			// ref: https://moz.com/learn/seo/meta-description
			$metaDescription = CakeText::truncate($data[$Model->alias]['content'], 160, array('html' => false));
		}

		if (! empty($metaDescription)) {
			$this->Controller->set(compact('metaDescription'));
		}

		return;
	}

/**
 * Prepend the meta title and description fields to the supplied array at the requested point
 *
 * @param array $existingArray containing the array we're inserting elements into
 * @param string $arrayKey containing the key to prepend the meta data fields to
 * @return updated array with the meta fields prepended where requested
 */
	public function prependFormFields($existingArray = array(), $arrayKey = '') {
		return ArrayUtil::prependElements($existingArray, $arrayKey, $this->metaDataFields);
	}

/**
 * Append the meta title and description fields to the supplied array at the requested point
 *
 * @param array $existingArray containing the array we're inserting elements into
 * @param string $arrayKey containing the key to append the meta data fields to
 * @return updated array with the meta fields prepended where requested
 */
	public function appendFormFields($existingArray = array(), $arrayKey = '') {
		return ArrayUtil::appendElements($existingArray, $arrayKey, $this->metaDataFields);
	}

}