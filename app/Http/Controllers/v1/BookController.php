<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-14
 * Time: 下午4:18
 */

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Repositories\BookChapterRepository;
use App\Repositories\BookRepository;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private $bookRepository;
    private $bookChapterRepository;
    private $bookDomain;
    private $bookService;
    public function __construct(BookRepository $bookRepository, BookChapterRepository $bookChapterRepository,BookService $bookService)
    {
        $this->bookRepository = $bookRepository;
        $this->bookChapterRepository = $bookChapterRepository;
        $this->bookService = $bookService;
        $this->bookDomain = config('constants.book_domain');
    }

    public function index()
    {
        $bookList = $this->bookRepository->getBookList();
        $data = [];
        if ($bookList) {
            $bookData = $bookList->toArray();
            $data['per_page'] = $bookData['per_page'];
            $data['current_page'] = $bookData['current_page'];
            $data['last_page'] = $bookData['last_page'];
            $data['bookList'] = $bookData['data'];
        }
        return $this->success($data);
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