@extends('components.layout')

@section('content')
    <div class="pull-right">

        <form action="{{ route('game.store') }}" method="post">
            {{ csrf_field() }}

            <div class="form-row align-items-center">
                <div class="col-auto">
                    <label class="sr-only" for="home_team">Home Team</label>
                    <input type="text" name="home_team" class="form-control mb-2" id="home_team" placeholder="Home Team">
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Away Team</label>
                    <input type="text" class="form-control" id="away_team" placeholder="Away Team" name="away_team">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2">Add</button>
                </div>
            </div>
        </form>
    </div>

    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Home Team</th>
                    <th>Score</th>
                    <th>Away Team</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($games as $game)
                    <tr>
                        <td>{{ $game->getHomeTeam() }}</td>
                        <td>
                            @if ($game->getStatus() === \App\Enums\GameStatuses::STATUS_IN_PROGRESS)
                                <form action="{{ route('game.update', ['uuid' => $game->getUuid()]) }}" method="post">
                                    {{csrf_field()}}
                                    {{ method_field('PUT') }}
                                    <input type="number" name="home_score" value="{{$game->getHomeScore()}}"> : <input type="number" name="away_score" value="{{$game->getAwayScore()}}">
                                    <button type="submit">save</button>
                                </form>
                            @else
                                {{ $game->getHomeScore() . ' : ' . $game->getAwayScore() }}
                            @endif
                        </td>
                        <td>{{ $game->getAwayTeam() }}</td>
                        <td>{{ $game->getStatus() }}</td>
                        <td>
                            @if ($game->getStatus() === \App\Enums\GameStatuses::STATUS_NOT_STARTED)
                                <form action="{{ route('game.start', ['uuid' => $game->getUuid()]) }}" method="post">
                                    {{csrf_field()}}
                                    {{ method_field('PUT') }}
                                    <button type="submit">Start</button>
                                </form>
                            @elseif($game->getStatus() === \App\Enums\GameStatuses::STATUS_IN_PROGRESS)
                                <form action="{{ route('game.finish', ['uuid' => $game->getUuid()]) }}" method="post">
                                    {{csrf_field()}}
                                    {{ method_field('PUT') }}
                                    <button type="submit">Finish</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
