<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LikesFixture
 */
class LikesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'article_id' => 1,
                'user_id' => 1,
                'created_at' => '2024-02-02 15:25:21',
                'updated_at' => '2024-02-02 15:25:21',
            ],
        ];
        parent::init();
    }
}
