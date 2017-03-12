<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-12
 * Time: 上午9:32
 */

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return $this->success($_SERVER);
    }
}