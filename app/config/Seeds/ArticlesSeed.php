<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Articles seed.
 */
class ArticlesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'title'    => 'article 1',
                'body' => 'article 1',
                'user_id'     => 1,
                'created_at' => '2014-01-01 01:01:01',
                'updated_at' => '2014-01-01 01:01:01',
            ],
            [
                'title'    => 'article 2',
                'body' => 'article 2',
                'user_id'     => 2,
                'created_at' => '2014-01-01 01:01:01',
                'updated_at' => '2014-01-01 01:01:01',
            ],
            [
                'title'    => 'article 3',
                'body' => 'article 3',
                'user_id'     => 1,
                'created_at' => '2014-01-01 01:01:01',
                'updated_at' => '2014-01-01 01:01:01',
            ],
            [
                'title'    => 'article 4',
                'body' => 'article 4',
                'user_id'     => 2,
                'created_at' => '2014-01-01 01:01:01',
                'updated_at' => '2014-01-01 01:01:01',
            ]
        ];

        $table = $this->table('articles');
        $table->insert($data)->save();
    }
}
