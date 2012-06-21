<?php
/*
	txton is a new REST format that is extremely lightweight and extremely fast!
	http://github.com/bilawal360/txton
	
	Developed as a side project by @bilawalhameed
*/

class Txton {

	/* @note: This version helps us know whether our code is compatible. */
	public $version = '1.0.0';
	
	/*
		@note: This converts a data set into a structure set.
		@param: (array) $array	[This is the array you wish to convert to txton]
	*/
	public function structure( $array ) {
	
		/* @note: Loop through the array. */
		foreach( $array as $i => $val ) {
			if( is_array($val) ) {
				/* @note: Does it have a child? Loop through structure again under the child. */
				$new_array[] = self::structure( $val );
			} else {
				/* @note: It doesn't have a child. Let's proceed. */
				$new_array[] = $i;
			}
		}
		
		/* @note: Return the output.*/
		return $new_array;
	}
	
	/*
		@note: We can use loop to help encode our array data into JSON
		@param: (array) $array		[This is the array you wish to encode]
		@param: (array) $parents 	[Ignore this. It is used internally to process sub-arrays]
	*/
	public function encode( $array, $parents = array() ) {
		
		/* @note: If we are more than one level deep in our array, we can't do it right now. Minimalism applies. */
		if(count($parents) > 1) {
			return trigger_error("Sorry, STML does not support multiple level encoding.", E_USER_NOTICE);
		}
		
		/* @note: Our zero-indexed $index is used as a routing mechanism through our data */
		$index = 0;
		
		/* @note: Let's actually do the loop. */
		foreach($array as $i => $val) {
			
			if( is_array( $val ) ) {
				/* @note: We need to loop this function again with this sub-array. Also add new parent. */
				$loop = $this->encode( $val, array_merge( $parents, array( $index ) ) );
			} else {
				/* @note: Let's note that this value belongs to a parent array. */
				$loop = ( count($parents) > 0 ? implode(':', $parents) . ':' : '' ) . $val;
			}
			
			/* @note: Increment the $index */
			$index ++;
			
			/* @note: Add final value to $loops */
			$loops[] = $loop;
		}
		
		/* @note: Loop over. Let's glue everything together using the | character. */
		return implode('|', $loops);
	}
	
	/*
		@note: Decode does something awkwardly weird… it decodes? 
		@param: (string) $string	[This is the string that txton_encode provides]
		@param: (array) $structure	[This is the array structure that txton_structure provides]
	*/
	public function decode( $string, $structure ) {
		
		/* @note: Let's declare $output */
		$output = array();
		
		/* @note: Let's validate the structure. */
		$structure = self::structure($structure);
		
		/* @note: Let's loop through the structure and convert it. */
		foreach( $structure as $index => $data ) {
			
			/* @note: If there is a sub-array, let's deal with it. */
			if( is_array($data) ) {
				$keys[] = $index;
				foreach($data as $data_index => $data_data) {
					$keys[] = $data_data;
				}
			} else {
				/* @note: There isn't. Let's proceed. */
				$keys[] = $data;
			}
		}
		
		/* @note: Hack a little way that makes sure txton works for single value arrays. */
		$string = substr_count($string, '|') == 0 ? '|' . $string : $string;
		
		/* @note: Split the $string into $children so we can deal with it individually. */
		$children = explode('|', $string);
		
		/* @note: Reset the $index. We have a new use for it. */
		$index = 0;
		
		/* @note: Loop through the $children. $i is the $children index. $str is each children's value. */
		foreach( $children as $i => $str ) {
			
			/* @note: If there's a colon found in the string, it's definitely has a parent. */
			if( substr_count($str, ':') > 0 ) {
			
				/* @note: Let's find its parents. */
				$parents = substr_count($str, ':');
				
				/* @note: Obtain the indexes of the parents. */
				$parent_ids = explode(':', $str);
				
				/* @note: Self explanatory. $first_parent is the first parent of this item. */
				$first_parent = $parent_ids[0];
				
				/* @note: We don't want it anymore. It is stored under $first_parent. */
				unset($parent_ids[0]);
				
				/* @note: We don't officially support multi level support yet. */
				if($parents > 1) {
					return trigger_error("Sorry, we cannot decode on multiple array levels", E_USER_ERROR);
				}
				
				/* @note: $first_keys is the first key. Simples. */
				$first_keys = $keys[ $first_parent ];
				
				/* @note: Without a first key, we have nothing. The End. Kapish. */
				if(! $first_keys) {
					continue;
				}
				
				/* @note: Let's loop through the remaining parents. */
				foreach($parent_ids as $itm) {
					/* @note: Put each item under the correct parent. It is this code that limits the code to one sub-array. */
					$child_index = ($child_indexes[ $parents ] > 0 ? $child_indexes[ $parents ] : 0);
					if( strlen($output[$keys[$first]][ $first_keys[$child_index] ] ) > 0) {
						continue;
					}
					
					$output[$keys[$first]][ $keys[$first + $child_index + 1] ] = $itm;
					$child_indexes[ $parents ]++;
				}
				
			}
			
			
			else {
				
				/* @note: The easy bit. Let's proceed. */
				if( ! empty( $keys[ $id ] )) {
					$output[ $keys[ $id ] ] = $str;
				}
			}
			
			/* @note: Increment $id. */
			$id++;
		}
		
		/* @note: Return output. Done.  */
		return $output;
	
	}

}

function txton_encode( $array ) {
	if(! class_exists('Txton')) {
		return trigger_error("We could not find the .txton library.", E_USER_NOTICE);
	}
	
	return Txton::encode( $array );
}

function txton_structure( $array ) {
	if(! class_exists('Txton')) {
		return trigger_error("We could not find the .txton library.", E_USER_NOTICE);
	}
	
	return Txton::structure( $array );
}

function txton_decode( $string, $structure ) {
	if(! class_exists('Txton')) {
		return trigger_error("We could not find the .txton library.", E_USER_NOTICE);
	}
	
	return Txton::decode( $string, $structure );
}