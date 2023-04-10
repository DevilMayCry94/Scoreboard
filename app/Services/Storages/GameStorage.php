<?php

namespace App\Services\Storages;

use App\Models\Game;
use App\Services\StorageKey;
use Illuminate\Support\Facades\Redis;

class GameStorage
{
    public const GAME_KEY_PREFIX = 'games:';
    public const GAME_ID_KEY_PREFIX = 'game_ids:';

    public static function setGame(string $uuid, Game $game)
    {
        Redis::set(StorageKey::getGameKey($uuid), serialize($game));
    }

    public static function setGameIdTotalScore(string $uuid, int $totalScore)
    {
        Redis::set(StorageKey::getGameIDTotalKey($uuid), $totalScore);
    }
}
