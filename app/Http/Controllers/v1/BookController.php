<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-14
 * Time: 下午4:18
 */

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Repositories\BookRepository;

class BookController extends Controller
{
    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function index()
    {
        $bookList = $this->bookRepository->getBookList();
        $data = [];
        if ($bookList) {
            $bookData = $bookList->toArray();
            $data['per_page'] = $bookData['per_page'];
            $data['current_page'] = $bookData['current_page'];
            $data['last_page']=$bookData['last_page'];
            $data['bookList'] = $bookData['data'];
        }
        return $this->success($data);
    }
}