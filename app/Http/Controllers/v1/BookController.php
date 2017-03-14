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
use Illuminate\Http\Request;

class BookController extends Controller
{
    private $bookRepository;
    private $bookChapterRepository;
    private $bookDomain;

    public function __construct(BookRepository $bookRepository, BookChapterRepository $bookChapterRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->bookChapterRepository = $bookChapterRepository;
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

    public function getBookDetail(Request $request)
    {
        $bookId = $request->get('bookId');
        $bookId = intval($bookId);
        if ($bookId > 0) {
            $book = $this->bookChapterRepository->getBookDetail($bookId);
            if ($book) {
                foreach ($book as $key => $value) {
                    $book[$key]['chapter_path'] = $this->bookDomain . '/book'.$value['chapter_path'];
                }
                return $this->success($book);
            }
            return $this->success([]);
        }
        return $this->error('书的id不可以为空');
    }
}