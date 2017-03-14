<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-14
 * Time: 下午5:51
 */

namespace App\Services;


use App\Repositories\BookChapterRepository;
use App\Repositories\BookRepository;
use Illuminate\Support\Facades\Redis;

class BookService
{
    private $bookChapterRepository;
    private $bookRepository;
    private $bookDomain;
    public function __construct(BookChapterRepository $bookChapterRepository,BookRepository $bookRepository)
    {
        $this->bookChapterRepository = $bookChapterRepository;
        $this->bookRepository = $bookRepository;
        $this->bookDomain = config('constants.book_domain');
    }

    public function getBookChapterList($bookId)
    {
        $key = BOOK_CHAPTER_LIST . $bookId;
        $book = Redis::get($key);
        if ($book) {
            return unserialize($book);
        } else {
            $book = $this->bookChapterRepository->getBookDetail($bookId);
            if ($book) {
                foreach ($book as $key => $value) {
                    $book[$key]['chapter_path'] = $this->bookDomain . '/book' . $value['chapter_path'];
                }
                Redis::set($key, serialize($book));
                return $book;
            }
            return [];
        }
    }

    public function getBookList($page=1)
    {
        $key = BOOK_PAGE . $page;
        $bookList = Redis::get($key);
        if ($bookList) {
            return unserialize($bookList);
        } else {
            $bookList = $this->bookRepository->getBookList();
            $data = [];
            if ($bookList) {
                $bookData = $bookList->toArray();
                $data['per_page'] = $bookData['per_page'];
                $data['current_page'] = $bookData['current_page'];
                $data['last_page'] = $bookData['last_page'];
                $data['bookList'] = $bookData['data'];
            }
            return $data;
        }
    }
}