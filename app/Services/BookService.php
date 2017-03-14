<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-14
 * Time: 下午5:51
 */

namespace App\Services;


use App\Repositories\BookChapterRepository;
use Illuminate\Support\Facades\Redis;

class BookService
{
    private $bookChapterRepository;

    public function __construct(BookChapterRepository $bookChapterRepository)
    {
        $this->bookChapterRepository = $bookChapterRepository;
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
                    $book[$key]['chapter_path'] = $bookId . '/book' . $value['chapter_path'];
                }
                Redis::set($key, serialize($book));
                return $book;
            }
            return [];
        }
    }
}