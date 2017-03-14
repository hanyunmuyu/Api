<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-14
 * Time: 下午4:12
 */

namespace App\Repositories;


use App\Models\BookModel;

class BookRepository
{
    public function getBookList()
    {
        return BookModel::paginate(15);
    }
}