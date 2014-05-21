<?php


/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    /**
     *
     * @var string the default layout for the controller view. Defaults to
     *      '//layouts/column1',
     *      meaning using a single column layout. See
     *      'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     *
     * @var array context menu items. This property will be assigned to {@link
     *      CMenu::items}.
     */
    public $menu = array();

    /**
     *
     * @var array the breadcrumbs of the current page. The value of this
     *      property will
     *      be assigned to {@link CBreadcrumbs::links}. Please refer to {@link
     *      CBreadcrumbs::links}
     *      for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    
    
    /**
     * 
     * @var unknown
     */
    public $user = array();
    
    public $session;
    
    
    public function init ()
    {
        // 手动启动session   过滤sid设置session_id
        $this->session=new CHttpSession;
        //$this->session->autoStart = false;
        if($this->param('sid'))
        {
            //echo 'HAS_SID ';
            $this->session->setSessionID($this->param('sid'));
        }
        $this->session->open();

        //var_dump($_SESSION);
    }

    /**
     * return to client
     * @param string $code
     * @param string $message
     * @param string $result
     */
    public function mrender ($code, $message, $result = '')
    {
        // filter by datamap
        if (is_array($result)) {
            foreach ((array) $result as $name => $data) {
                // Object list
                if (strpos($name, '.list')) {
                    $model = trim(str_replace('.list', '', $name));
                    foreach ((array) $data as $k => $v) {
                        $result[$name][$k] = $this->M($model, $v);
                    }
                    // Object
                } else {
                    $model = trim($name);
                    $result[$name] = $this->M($model, $data);
                }
            }
        }
        // print json code
        echo json_encode(
                array(
                        'code' => $code,
                        'message' => $message,
                        'result' => $result
                ));
        exit();
    }
    
    /**
     * user auth
     */
    public function doAuth ()
    {
        if (!isset($this->session['user'])) {
            $this->mrender('10001', 'Please login firstly.');
        } else {
            $this->user = $this->session['user'];
        }
    }
    
    /**
     * Get all http request
     * @param string $pname request name
     * @param mixed $value
     * @return mixed
     */
    public function param ($pname)
    {
        return Yii::app()->request->getParam($pname);
    }
    
    /**
     * Strip all slashed string
     * @param string $str
     * @return string
     */
    public function str_strip ($str)
    {
        $str = trim($str);
        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return $str;
    }
    

    /**
     * render message filter
     * @param array $model
     * @param array $data
     * @return multitype:unknown |unknown
     */
    public function M ($model, $data)
    {
        $_DataMap = Yii::app()->params['datamap'];
        $dataMap = isset($_DataMap[$model]) ? $_DataMap[$model] : null;
        if ($dataMap) {
            $dataRes = array();
            foreach ((array) $data as $k => $v) {
                if (array_key_exists($k, $dataMap)) {
                    $mapKey = $dataMap[$k];
                    $dataRes[$mapKey] = $v;
                }
            }
            return $dataRes;
        }
    
        return $data;
    }
}