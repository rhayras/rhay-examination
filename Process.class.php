<?php


class Process {
	public $processed = [];

	public function processsJson($json){
		$decoded = json_decode($json,true);

		$this->processed['objectCount'] = count($decoded);

		foreach($decoded as $key => $val){

			//rearrange key
			$letters = str_split($key);
			usort($letters, function($a, $b) {
			    return $this->arrangeLetter($a) > $this->arrangeLetter($b);
			});
			rsort($letters);
			$newKey = implode("",$letters);

			if (!is_scalar($val)) {
			 	$this->processed[$newKey] = $this->nestedArray($val);
			 	// $this->processed[$newKey] = json_encode($val);
			}else{
				if(!is_bool($val)){
					$valueLetters = str_split($val);
					usort($valueLetters, function($a, $b) {
					    return $this->arrangeLetter($a) > $this->arrangeLetter($b);
					});
					rsort($valueLetters);
					$val = implode("", $valueLetters);
				}
				$this->processed[$newKey] = $val;
			}

		}
		return json_encode($this->processed,JSON_PRETTY_PRINT);
	}

	public function nestedArray($decoded){
		$result = [];
		$process = [];
		foreach($decoded as $val){
			$process['objectCount'] = 0;
			if (!is_scalar($val)) {
				foreach($val as $key => $value){
					$process['objectCount']++;
					//rearrange key
					$letters = str_split($key);
					usort($letters, function($a, $b) {
					    return $this->arrangeLetter($a) > $this->arrangeLetter($b);
					});
					rsort($letters);
					$newKey = implode("", $letters);
					
					if (!is_scalar($value)) {

					}else{
						if(!is_bool($value)){
							$valueLetters = str_split($value);
							usort($valueLetters, function($a, $b) {
							    return $this->arrangeLetter($a) > $this->arrangeLetter($b);
							});
							rsort($valueLetters);
							$value = implode("", $valueLetters);
						}
					}

					$process[$newKey] = $value;
				}
			}
			$result[] = $process;
		}
		return $result;
	}

	public function arrangeLetter($char){
		if (ctype_lower($char)) {
	        return 1;
	    }
	    else if (ctype_upper($char)) {
	        return 2;
	    }
	    else if (is_numeric($char)) {
	        return 3;    
	    }
	    else {
	        return 4;
	    }
	}
}