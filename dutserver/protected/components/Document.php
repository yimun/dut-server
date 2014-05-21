<?php
class Document
{
    /**
     * @var Hush_Document_Parser
     */
    protected $_parser = null;

    /**
     * Construct
     * @param Hush_Debug_Writer $writer
     */
    public function __construct($classFile)
    {
        /* if (!file_exists($classFile)) {
            require_once 'Hush/Document/Exception.php';
            throw new Hush_Document_Exception("Non-exists class file '$classFile'.");
        } */

        $this->_parser = new Parser();

        $this->_parser->parseCode($classFile);
    }

    /**
     * Get annotations
     * @param $classFile ClassName you want
     * @param $methodName MethodName you want
     * @return array
     */
    public function getAnnotation($className = '', $methodName = '')
    {
        return $this->_parser->getAnnotation($className, $methodName);
    }
}