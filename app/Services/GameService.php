<?php

namespace App\Services;

use App\Enums\GameStatuses;
use App\Models\Game;
use App\Services\Storages\GameStorage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class GameService
{
    public function create(array $data): ?Game
    {
        $game = new Game();
        $game->setUuid(Str::uuid()->toString());
        $game->fill($data);
        $game->setCreatedAt(time());

        return $game->save();
    }

    public function getAll(): Collection
    {
        $games = collect();
        $keys = Redis::keys(GameStorage::GAME_KEY_PREFIX.'*');
        foreach ($keys as $key) {
            $games->add($this->get(StorageKey::getUuidFromRedisKey($key, GameStorage::GAME_KEY_PREFIX)));
        }

        return $games->sort(function (Game $game1, Game $game2) {
            return $game1->getCreatedAt() < $game2->getCreatedAt() ? 1 : -1;
        });
    }

    public function get(string $uuid): bool|Game
    {
        return unserialize(Redis::get(StorageKey::getGameKey($uuid)));
    }

    public function startGame(Game $game): bool
    {
        $game->setStatus(GameStatuses::STATUS_IN_PROGRESS);
        return $this->update($game);
    }

    public function finishGame(Game $game): bool
    {
        $game->setStatus(GameStatuses::STATUS_FINISHED);
        if ($this->update($game)) {
            GameStorage::setGameIdTotalScore($game->getUuid(), $game->getTotalScore());
            return true;
        }

        return false;
    }

    public function updateScore(Game $game, int $homeScore, int $awayScore): bool
    {
        $game->setHomeScore($homeScore);
        $game->setAwayScore($awayScore);
        return $this->update($game);
    }

    public function update(Game $game): bool
    {
        GameStorage::setGame($game->getUuid(), $game);
        return true;
    }

    public function getStat(): Collection
    {
        $keys = Redis::keys(GameStorage::GAME_ID_KEY_PREFIX.'*');
        $games = collect();
        foreach ($keys as $key) {
            $uuid = StorageKey::getUuidFromRedisKey($key, GameStorage::GAME_ID_KEY_PREFIX);
            $games->add($this->get($uuid));
        }

        return $games->sort(function (Game $game1, Game $game2) {
            if ($game1->getTotalScore() === $game2->getTotalScore()) {
                return $game1->getCreatedAt() < $game2->getCreatedAt() ? 1 : -1;
            }

            return $game1->getTotalScore() < $game2->getTotalScore() ? 1 : -1;
        });
    }
}
