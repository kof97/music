<?php 

namespace Spa\Object\Interfaces\Media;

use Spa\Object\Detector\FieldsDetector;

/**
 * Class Info
 *
 * @category PHP
 * @package  Spa
 * @author   Arno <arnoliu@tencent.com>
 */
class Info {

    /**
     * Instance of Spa.
     */
    protected $spa;

    /**
     * HTTP method.
     */
    protected $method;

    /**
     * The request endpoint.
     */
    protected $endpoint;

    /**
     * Init .
     */
    public function __construct($spa, $mod, $act) {

        $this->spa = $spa;

        $this->method = 'GET';

        $this->endpoint = $mod . '/' . $act;

    }

    public function send($params = array(), $headers = array()) {

        $data = $this->fieldInfo();

        FieldsDetector::validateField($params, $data);

        $response = $this->spa->sendRequest($this->method, $this->endpoint, $params, $headers);

        return $response;
    }

    public function fieldInfo() {
        return array(

            'advertiser_id' => array(
                'name' => 'advertiser_id',
                'extendType' => 'advertiser_id',
                'require' => 'yes',
                'type' => 'integer',
                'description' => '广告主ID',
                'restraint' => '详见附录',
                'errormsg' => '广告主ID不正确',
                'max' => '4294967296',
                'min' => '0',
            ),

            'media_id' => array(
                'name' => 'media_id',
                'extendType' => 'media_id',
                'require' => 'yes',
                'type' => 'id',
                'description' => '媒体Id',
                'restraint' => '小于2^63',
                'errormsg' => '媒体Id不正确',
                'max' => '9223372036854775807',
                'min' => '1',
            ),

        );
    }

}

//end of script
