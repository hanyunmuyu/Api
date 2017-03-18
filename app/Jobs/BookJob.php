<?php
/**
 * Created by PhpStorm.
 * User: hanyun
 * Date: 17-3-18
 * Time: 上午9:31
 */

namespace App\Jobs;


use App\Repositories\BookChapterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class BookJob extends Job
{
    private $bookHash;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bookHash)
    {
        //
        $this->bookHash = $bookHash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $book = Redis::hgetall($this->bookHash);
        if ($book) {
            $bookChapter = new BookChapterRepository();
            unset($book['url']);
            $res = $bookChapter->updateBookChapter($this->bookHash, $book);
            if ($res) {
                Redis::del($this->bookHash);
            }
        }
    }

}