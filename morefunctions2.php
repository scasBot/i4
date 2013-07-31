<?php
interface iSearch {
	public function get_type(); 
}

class SearchBinary implements iSearch {
	protected $left = null; 
	protected $right = null; 
	protected $type = null; 
	protected $of = null; 
	
	public function get_left() {
		return $this->left; 
	}
	public function get_right() {
		return $this->right; 
	}
	public function get_type() {
		return "Binary"; 
	}
	public function get_of() {
		return $this->of; 
	}

	public function __construct($clause1, $clause2, $type) {
		$types = array("SearchUnary", "SearchBinary");
		$class1 = get_class($clause1); 
		$class2 = get_class($clause2); 
		if( (!in_array($class1, $types)) || (!in_array($class2, $types))) {
			throw new Exception("Failed to construct SearchBinary, clauses must be in type."); 
		} else {
			$this->left = $clause1; 
			$this->right = $clause2; 
			$this->of = $type; 
		}
	}
}

class SearchUnary implements iSearch {
	protected $term = null; 
	public function get_type() {
		return "Unary"; 
	}
	public function get_term() {
		return $this->term; 
	}
	public function __construct($str) {
		$this->term = $str; 
	}
}
/*
class SearchClause {
	protected $type = null; 
	protected $element = null; 
	
	public function get_type() {
		return $this->type; 
	}

	public function __construct($searchElement) {
		$class = get_class($searchElement); 
		if(!in_array($class, array("SearchBinary", "SearchUnary", "SearchClause"))) {
			throw new Exception("Failed to construct SearchClause"); 
		} else {
			$this->type = $class;
			$this->element = $searchElement; 
		}
	}
}
*/
$term1 = (new SearchUnary("`YOG`>2012")); 
$term2 = (new SearchUnary("`Hidden`=1")); 
$or = new SearchBinary($term1, $term2, "OR"); 

$term3 = (new SearchUnary("Comper=1")); 
$and = new SearchBinary($or, $term3, "AND");

var_dump($and); 

?>