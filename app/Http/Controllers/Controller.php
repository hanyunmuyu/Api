<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    public function success($data, $msg = 'success', $code = 1)
    {
        return $this->returnData([
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    public function error($msg = 'error', $code = 0)
    {
        return $this->returnData([
            'code' => $code,
            'msg' => $msg
        ]);
    }

    private function returnData($data)
    {
        header('Content-type: application/json');
        return json_encode($this->parseData($data),JSON_FORCE_OBJECT);
    }

    private function parseData($data)
    {
        $tmp = [];
        if (is_array($data)) {
            foreach ($data as $key => $v) {
                $tmp[$this->parseKey($key)] = $this->parseData($v);
            }
            return $tmp;
        } elseif(is_null($data)) {
            return '';
        } else {
            return $data;
        }
    }

    private function parseKey($key)
    {
        if (strpos($key, '_', 1)) {
            $keyArr = explode('_', $key);
            $str = '';
            foreach ($keyArr as $key => $value) {
                if ($key > 0) {
                    $str .= ucfirst($value);
                } else {
                    $str .= $value;
                }
            }
            return $str;
        }
        return $key;
    }
}
