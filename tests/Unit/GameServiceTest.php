<?php

namespace Tests\Unit;

use App\Enums\GameStatuses;
use App\Models\Game;
use App\Services\GameService;
use App\Services\StorageKey;
use App\Services\Storages\GameStorage;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    public function test_create_success()
    {
        Redis::shouldReceive('set');
        $gameService = new GameService();
        $gameData = [
            'home_team' => 'HomeTeam',
            'away_team' => 'AwayTeam',
            'home_score' => 1,
        ];
        $game = $gameService->create($gameData);
        $this->assertTrue($game->getAwayScore() === 0);
        $this->assertTrue($game->getHomeScore() === 1);
        $this->assertTrue($game->getStatus() === GameStatuses::STATUS_NOT_STARTED);
    }

    public function test_finish_game_success()
    {
        $game = new Game();
        $game->setUuid(Str::uuid()->toString());
        $game->fill([
             'home_team' => 'team1',
             'away_team' => 'team2',
             'home_score' => 2,
             'away_score' => 1,
             'status' => GameStatuses::STATUS_FINISHED,
        ]);

        Redis::shouldReceive('set')
            ->twice()
            ->with(StorageKey::getGameKey($game->getUuid()), serialize($game))
            ->once()
            ->with(StorageKey::getGameIDTotalKey($game->getUuid()), $game->getTotalScore())
            ->once();

        $gameService = new GameService();
        $this->assertTrue($gameService->finishGame($game));
        $this->assertTrue($game->getStatus() === GameStatuses::STATUS_FINISHED);
    }

    public function test_get_stat_success()
    {
        $game1 = new Game();
        $game1->setUuid(Str::uuid()->toString());
        $game1->fill([
            'home_team' => 'team1',
            'away_team' => 'team2',
            'home_score' => 2,
            'away_score' => 1,
            'status' => GameStatuses::STATUS_FINISHED,
            'created_at' => 10,
        ]);
        $game2 = new Game();
        $game2->setUuid(Str::uuid()->toString());
        $game2->fill([
            'home_team' => 'team2',
            'away_team' => 'team1',
            'home_score' => 1,
            'away_score' => 2,
            'status' => GameStatuses::STATUS_FINISHED,
            'created_at' => 20
        ]);
        $game3 = new Game();
        $game3->setUuid(Str::uuid()->toString());
        $game3->fill([
            'home_team' => 'team3',
            'away_team' => 'team4',
            'home_score' => 0,
            'away_score' => 0,
            'status' => GameStatuses::STATUS_FINISHED,
        ]);

        Redis::shouldReceive('keys')
            ->once()
            ->with(GameStorage::GAME_ID_KEY_PREFIX.'*')
            ->andReturn(
                [
                    StorageKey::getGameIDTotalKey($game1->getUuid()),
                    StorageKey::getGameIDTotalKey($game2->getUuid()),
                    StorageKey::getGameIDTotalKey($game3->getUuid()),
                ]
            );

        Redis::shouldReceive('get')
            ->andReturn(serialize($game2), serialize($game1), serialize($game3));

        $gameService = new GameService();
        $games = $gameService->getStat();
        $this->assertTrue($games->first()->getUuid() === $game2->getUuid());
        $this->assertTrue($games->last()->getUuid() === $game3->getUuid());
    }
}
