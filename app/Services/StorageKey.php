<?php

namespace App\Services;

use App\Services\Storages\GameStorage;
use Illuminate\Support\Str;

class StorageKey
{
    public static function getUuidFromRedisKey(string $redisKey, string $prefix): string
    {
        $uuid = explode($prefix, $redisKey)[1] ?? '';
        if (! $uuid || !Str::isUuid($uuid)) {
            throw new \Exception('Uuid not found. Redis Key:'.$redisKey);
        }

        return $uuid;
    }

    public static function getGameKey(string $uuid): string
    {
        return GameStorage::GAME_KEY_PREFIX.$uuid;
    }

    public static function getGameIDTotalKey(string $uuid): string
    {
        return GameStorage::GAME_ID_KEY_PREFIX.$uuid;
    }
}
