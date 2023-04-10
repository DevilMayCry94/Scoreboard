<?php

namespace Tests\Unit;

use App\Services\StorageKey;
use App\Services\Storages\GameStorage;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class StorageKeyTest extends TestCase
{
    public function test_get_uuid_from_redis_key_success()
    {
        $expectedUuid = Str::uuid()->toString();
        $redisKey = 'laravel_database_'.GameStorage::GAME_KEY_PREFIX.$expectedUuid;
        $uuid = StorageKey::getUuidFromRedisKey($redisKey, GameStorage::GAME_KEY_PREFIX);
        $this->assertTrue($uuid == $expectedUuid);
    }

    public function test_get_uuid_from_redis_key_failed()
    {
        $invalidUuid = Str::random(16);
        $redisKey = 'laravel_database_'.GameStorage::GAME_KEY_PREFIX.$invalidUuid;
        $this->expectException(\Exception::class);
        StorageKey::getUuidFromRedisKey($redisKey, GameStorage::GAME_KEY_PREFIX);
    }

    public function test_get_game_key_success()
    {
        $uuid = Str::uuid()->toString();
        $expectedResult = GameStorage::GAME_KEY_PREFIX.$uuid;
        $this->assertTrue($expectedResult === StorageKey::getGameKey($uuid));
    }

    public function test_get_game_id_key_success()
    {
        $uuid = Str::uuid()->toString();
        $expectedResult = GameStorage::GAME_ID_KEY_PREFIX.$uuid;
        $this->assertTrue($expectedResult === StorageKey::getGameIDTotalKey($uuid));
    }
}
