<?php

class Parser
{

    /**
     *
     * @var array
     */
    protected $_annotation = array(
            '_annotation' => array(),
            '_methodlist' => array(
                    '_annotation' => array()
            )
    );

    /**
     * Get annotations from a class file
     * 
     * @param
     *            $classFile
     * @return array
     */
    public function getAnnotation ($className = '', $methodName = '')
    {
        if ($className && $methodName) {
            if(isset($this->_annotation[$className]['_methodlist'][$methodName]['_annotation']))
			return $this->_annotation[$className]['_methodlist'][$methodName]['_annotation'];
		} elseif ($className) {
			return $this->_annotation[$className]['_annotation'];
		} else {
			return false;
		}
    }

    /**
     *
     * @var mixed
     */
    private $_register = array();

    /**
     * Store data into register
     * 
     * @param string $name            
     * @param string $key   title/action/method/params         
     * @param mixed $val            
     */
    protected function _setRegister ($name, $key, $val = null)
    {
        if ($val) {
            $vName = isset($val[0]) ? trim($val[0]) : '';
            $vDval = isset($val[1]) ? trim($val[1]) : '';
            $vDesc = isset($val[2]) ? trim($val[2]) : '';
            switch ($key) {
                case 'params':
                    $this->_register[$name][$key][$vName] = array(
                            'dval' => $vDval,
                            'desc' => $vDesc
                    );
                    break;
                default:
                    $this->_register[$name][$key] = $vName;
                    break;
            }
        } else {
            $this->_register[$name] = $key;
        }
    }

    /**
     * Get register by name
     * 
     * @param string $name            
     */
    protected function _getRegister ($name)
    {
        return isset($this->_register[$name])?($this->_register[$name]):null;
    }

    /**
     * Clean register by name
     * 
     * @param string $name            
     */
    protected function _delRegister ($name)
    {
        $this->_register[$name] = array();
    }

    /**
     * Parse annotations for a class file
     * 
     * @param
     *            $classFile
     * @return void
     */
    public function parseCode ($classFile)
    {
        $fp = fopen($classFile, 'r');
        while (! feof($fp)) {
            $codeLine = fgets($fp);
            $this->_parseLine($codeLine);
        }
        fclose($fp);
    }

    /**
     * Parse each line annotation
     * 
     * @param string $codeLine            
     * @return void
     */
    protected function _parseLine ($codeLine)
    {
    // 
		if (preg_match('/@(\w+)\s+(.*?)\s+(.*?)\s+(.*)/i', $codeLine, $annotationRes)
		  ||preg_match('/@(\w+)\s+(.*?)\s+()()/', $codeLine, $annotationRes)) {
		    
			//var_dump($annotationRes);
			$annotationName = isset($annotationRes[1]) ? trim($annotationRes[1]) : '';
			if ($annotationName) {
				array_shift($annotationRes);
				array_shift($annotationRes);
				$this->_setRegister('annotation', $annotationName, $annotationRes);
			}
		}
		// 
		if (preg_match('/class\s+(\w+)\s+/i', $codeLine, $classRes)) {
			$className = isset($classRes[1]) ? trim($classRes[1]) : '';
			//var_dump($className);
			if ($className) {
				$this->_setRegister('class', $className);
				$classAnnotation = $this->_getRegister('annotation');
				if ($classAnnotation) {
					$this->_annotation[$className]['_annotation'] = $classAnnotation;
					$this->_delRegister('annotation');
				}
			}
		}
		// 
		if (preg_match('/function\s+(\S+)\s+/i', $codeLine, $functionRes)) {
			$functionName = isset($functionRes[1]) ? trim($functionRes[1]) : '';
			//var_dump($functionName);
			if ($functionName) {
				$className = $this->_getRegister('class');
				$functionAnnotation = $this->_getRegister('annotation');
				if ($functionAnnotation) {
					$this->_annotation[$className]['_methodlist'][$functionName]['_annotation'] = $functionAnnotation;
					$this->_delRegister('annotation');
				}
			}
		}
	}
   
}

