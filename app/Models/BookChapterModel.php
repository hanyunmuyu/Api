<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-14
 * Time: 下午4:14
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BookChapterModel extends Model
{
    protected $table = 'book_chapter';
    public $timestamps = false;
}