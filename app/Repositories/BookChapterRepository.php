<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-14
 * Time: 下午4:55
 */

namespace App\Repositories;


use App\Models\BookChapterModel;

class BookChapterRepository
{
    public function getBookDetail($bookId)
    {
        return BookChapterModel::where('book_id', '=', $bookId)->get()->toArray();
    }

    public function updateBookChapter($url, $data)
    {
        $data['update_at'] = time();
        $data['is_crawled'] = 1;
        return BookChapterModel::where('chapter_href', '=', $url)
            ->update($data);
    }
}