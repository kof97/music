<?php 

namespace Spa\Object\Interfaces\Report;

use Spa\Object\Detector\FieldsDetector;

/**
 * Class SelectGender
 *
 * @category PHP
 * @package  Spa
 * @author   Arno <arnoliu@tencent.com>
 */
class SelectGender {

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

    protected $name;

    protected $title;


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

            'date_range' => array(
                'name' => 'date_range',
                'extendType' => 'date_range',
                'require' => 'yes',
                'type' => 'struct',
                'description' => '时间范围',
                'restraint' => '日期格式，{"start_date":"2014-03-01","end_date":"2014-04-02"}',
                'errormsg' => '时间范围不正确',
                'element' => array(
                    'start_date' => array(
                        'name' => 'start_date',
                        'extendType' => 'start_date',
                        'require' => 'yes',
                        'type' => 'string',
                        'description' => '开始投放时间点对应的时间戳',
                        'restraint' => '大于等于0，且小于end_time',
                        'errormsg' => '开始投放时间不正确',
                        'max_length' => '10',
                        'min_length' => '10',
                        'pattern' => '{date_pattern}',
                    ),

                    'end_date' => array(
                        'name' => 'end_date',
                        'extendType' => 'end_date',
                        'require' => 'yes',
                        'type' => 'string',
                        'description' => '结束投放时间点对应的时间戳点对应的时间戳',
                        'restraint' => '大于等于今天，且大于begin_time',
                        'errormsg' => '结束投放时间点对应的时间戳不正确',
                        'max_length' => '10',
                        'min_length' => '10',
                        'pattern' => '{date_pattern}',
                    ),

                ),
            ),

            'campaign_id_list' => array(
                'name' => 'campaign_id_list',
                'extendType' => 'campaign_id_list',
                'require' => 'no',
                'type' => 'array',
                'description' => '如[2001,2002,2003,2004]，可不填',
                'restraint' => '数量不能不超过200个',
                'errormsg' => '推广计划ID列表不正确',
                'item_max_length' => '255',
                'repeated' => array(
                    'type' => 'integer',
                    'max' => '9200000000000000000',
                    'min' => '0',
                )
            ),

            'adgroup_id_list' => array(
                'name' => 'adgroup_id_list',
                'extendType' => 'adgroup_id_list',
                'require' => 'no',
                'type' => 'array',
                'description' => '如[2001,2002,2003,2004]，可不填',
                'restraint' => '数量不能不超过200个',
                'errormsg' => '广告组ID列表不正确',
                'item_max_length' => '255',
                'repeated' => array(
                    'type' => 'integer',
                    'max' => '9200000000000000000',
                    'min' => '0',
                )
            ),

            'group_by' => array(
                'name' => 'group_by',
                'extendType' => 'group_by',
                'require' => 'no',
                'type' => 'array',
                'description' => '聚合参数，例：["date"]',
                'restraint' => '见 [link href="group_by"]聚合规则定义[/link]',
                'errormsg' => '聚合字段不正确',
                'item_max_length' => '255',
                'repeated' => array(
                    'type' => 'string',
                    'item_max_length' => '255',
                )
            ),

            'page' => array(
                'name' => 'page',
                'extendType' => 'page',
                'require' => 'no',
                'type' => 'integer',
                'description' => '搜索页码',
                'restraint' => '大于等于1，若不传则视为1',
                'errormsg' => '页码不正确',
                'max' => '99999',
                'min' => '1',
            ),

            'page_size' => array(
                'name' => 'page_size',
                'extendType' => 'page_size',
                'require' => 'no',
                'type' => 'integer',
                'description' => '一页显示的数据条数',
                'restraint' => '大于等于1，且小于100，若不传则视为10',
                'errormsg' => '每页显示条数不正确',
                'max' => '100',
                'min' => '1',
            ),

        );
    }

}

//end of script
