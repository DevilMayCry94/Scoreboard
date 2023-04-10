<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Http\Requests\GameScoreUpdateRequest;
use App\Services\GameService;

class GamesController extends Controller
{
    private GameService $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {
        return view('index', ['games' => $this->gameService->getAll()]);
    }

    public function store(GameRequest $request)
    {
        $this->gameService->create($request->validated());
        return redirect('/');
    }

    public function start(string $uuid)
    {
        if (! $game = $this->gameService->get($uuid)) {
            abort(404);
        }

        if (! $this->gameService->startGame($game)) {
            return redirect()->back()->withErrors('Server Error');
        }

        return redirect()->back()->withSuccess('Game was started');
    }

    public function finish(string $uuid)
    {
        if (! $game = $this->gameService->get($uuid)) {
            abort(404);
        }

        if (! $this->gameService->finishGame($game)) {
            return redirect()->back()->withErrors('Server Error');
        }

        return redirect()->back()->withSuccess('Game was finished');
    }

    public function update(string $uuid, GameScoreUpdateRequest $request)
    {
        if (! $game = $this->gameService->get($uuid)) {
            abort(404);
        }

        if (! $this->gameService->updateScore($game, $request->input('home_score'), $request->input('away_score'))) {
            return redirect()->back()->withErrors('Server Error');
        }

        return redirect()->back()->withSuccess('Score updated successfully');
    }

    public function stats()
    {
        return view('games', ['games' => $this->gameService->getStat()]);
    }
}
