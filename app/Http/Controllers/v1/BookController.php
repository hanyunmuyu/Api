<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-14
 * Time: 下午4:18
 */

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private $bookDomain;
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
        $this->bookDomain = config('constants.book_domain');
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        return $this->success($this->bookService->getBookList($page));
    }

    public function getBookChapterList(Request $request)
    {
        $bookId = $request->get('bookId');
        $bookId = intval($bookId);
        if ($bookId > 0) {
            return $this->success($this->bookService->getBookChapterList($bookId));
        }
        return $this->error('书的id不可以为空');
    }
}