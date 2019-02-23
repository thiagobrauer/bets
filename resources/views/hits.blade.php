<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Styles -->
        <style>
        </style>
    </head>
    <body style="padding-bottom: 1000px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                    @foreach ($bets[0] as $n)
                                        <th scope="col">{{ $loop->index + 1 }}</th>
                                    @endforeach
                                    <th scope="col">Acertos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bets as $bet)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        @foreach ($bet as $n)
                                            <td>{{ $n }}</td>
                                        @endforeach
                                        <th scope="row">
                                            @if ($hits[$loop->index] == 0)
                                                <span class="text-danger">
                                                    {{ $hits[$loop->index] }}
                                                </span>
                                            @elseif($hits[$loop->index] <= 3)
                                                <span class="text-secondary">
                                                    {{ $hits[$loop->index] }}
                                                </span>
                                            @elseif($hits[$loop->index] == 4)
                                                <span class="text-success">
                                                    **** {{ $hits[$loop->index] }} ****
                                                </span>
                                            @elseif($hits[$loop->index] == 5)
                                                <span class="text-success">
                                                    ***** {{ $hits[$loop->index] }} *****
                                                </span>
                                            @elseif($hits[$loop->index] == 6)
                                                <span class="text-success">
                                                    ****** {{ $hits[$loop->index] }} ******
                                                </span>
                                            @endif
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
