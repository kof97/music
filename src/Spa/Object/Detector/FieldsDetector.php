<?php 

namespace Spa\Object\Detector;

use Spa\Exceptions\ParamsException;

/**
 * Class FieldsDetector
 *
 * @category PHP
 * @package  Spa
 * @author   Arno <arnoliu@tencent.com>
 */
class FieldsDetector {

    private function __construct() {
        // It would never be used.
    }

    public static function validateField($params, $data) {
        if (empty($params)) {
            return;
        }

        // validate the required field
        self::validateRequireField($data, $params);

        foreach ($params as $key => $value) {
            if (!isset($data[$key])) {
                continue;
            }

            $type = $data[$key]['type'];
            switch ($type) {
                case 'string':
                    self::validateString($data[$key], $key, $value);
                    break;

                case 'integer':
                    
                    break;

                case 'id':

                case 'number':
                    
                    break;

                case 'struct':
                    
                    break;

                case 'array':
                    
                    break;

                default: break;
            }
        }
    }

    protected static function validateString($data, $key, $value) {
        $len = strlen($value);
        if (isset($data['max_length'])) {
            if ($len > ($max_length = $data['max_length'])) {
                throw new ParamsException("The length of field '$key' is too long, it expects the length can't more than '$max_length'");
            }
        }

        if (isset($data['min_length'])) {
            if ($len < ($min_length = $data['min_length'])) {
                throw new ParamsException("The length of field '$key' is too short, it expects the length at least '$min_length'");
            }
        }

        if (isset($data['list'])) {
            $list = explode(',', $data['list']);
            if (!in_array($value, $list)) {
                $list = implode($list, ',');
                throw new ParamsException("The value of field '$key' is limited in '$list'");
            }
        }

        if (isset($data['pattern'])) {
            self::validatePattern($data['pattern'], $key, $value);
        }
    }

    protected static function validatePattern($pattern, $key, $value) {
        switch ($pattern) {
            case '{url_pattern}':
                //$regex = '/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i';
                $regex = '/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i';
                break;
            
            case '{age_pattern}':
                if ($value !== intval($value) . '') {
                    throw new ParamsException("The value of field '$key' needs the type int");
                }
                return;

            case '{memo_pattern}':
                
                break;

            case '{date_pattern}':
                
                break;

            default:
                $regex = $pattern;
                break;
        }

        $res = preg_match($regex, $value);

        if (!$res) {
            throw new ParamsException("The value of field '$key', '$value' is not a validate value");
        }
    }

    protected static function validateRequireField($data, $params) {
        foreach ($data as $key => $value) {
            if ($value['require'] === 'no') {
                continue;
            }

            if (!isset($params[$key])) {
                throw new ParamsException("Expect the required params '$key' that you didn't provide");
            }
        }
    }

}

//end of script
