@extends('components.layout')

@section('content')
    <div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Home Team</th>
                <th>Score</th>
                <th>Away Team</th>
            </tr>
            </thead>
            <tbody>
            @foreach($games as $game)
                <tr>
                    <td>{{ $game->getHomeTeam() }}</td>
                    <td>
                        {{ $game->getHomeScore() . ' : ' . $game->getAwayScore() }}
                    </td>
                    <td>{{ $game->getAwayTeam() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
