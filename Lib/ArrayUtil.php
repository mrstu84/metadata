<?php
/**
 * Array Utility.
 *
 * Methods to manipulate arrays.
 *
 * Copyright 2016, Stewart Doxey (http://www.stewartdoxey.co.uk)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2016, Stewart Doxey (http://www.stewartdoxey.co.uk)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class ArrayUtil {

/**
 * Inserts the supplied array elements into the supplied existing array at the requested position
 *
 * @param array $existingArray containing the existing array
 * @param string $keyIndex containing the index value of the key we are inserting after
 * @param array $newElements containing the new array elements to insert
 * @return array which include the supplied existing array with extra elements inserted
 */
	private static function __insertArrayElements($existingArray = array(), $keyIndex = null, $newElements = array()) {
		$afterNewElements = array_splice($existingArray, $keyIndex);
		return $existingArray + $newElements + $afterNewElements;
	}

/**
 * Prepend the supplied array elements to the existing array
 *
 * @param array $existingArray containing the existing array
 * @param string $existingFieldKey containing the array key to prepend new elements to
 * @param array $newElements containing the new array elements to insert
 * @return array which include the supplied existing array with extra elements prepended where requested
 */
	public static function prependElements($existingArray = array(), $existingFieldKey = '', $newElements = array()) {
		$keyIndex = array_search($existingFieldKey, array_keys($existingArray));
		return self::__insertArrayElements($existingArray,  $keyIndex, $newElements);
	}

/**
 * Append the supplied array elements to the existing array
 *
 * @param array $existingArray containing the existing array
 * @param string $existingFieldKey containing the array key to append new elements to
 * @param array $newElements containing the new array elements to insert
 * @return array which include the supplied existing array with extra elements appended where requested
 */
	public static function appendElements($existingArray = array(), $existingFieldKey = '', $newElements = array()) {
		$keyIndex = array_search($existingFieldKey, array_keys($existingArray)) + 1;
		return self::__insertArrayElements($existingArray, $keyIndex, $newElements);
	}

}
