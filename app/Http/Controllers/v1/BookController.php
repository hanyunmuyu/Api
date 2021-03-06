<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-14
 * Time: 下午4:18
 */

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Jobs\BookJob;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
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

    public function bookQueue(Request $request)
    {
        $bookHash = $request->get('bookhash');
        return $this->dispatch(new BookJob($bookHash));
    }
}