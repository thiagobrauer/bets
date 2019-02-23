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
            <div class="row p-5">
                <div class="col">
                    <form action="/generate" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="size">Tamanho do jogo (6 - 15)</label>
                            <input type="number" value="6" class="form-control" name="size" id="size" aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Quantidade de jogos</label>
                            <input type="number" value="84" class="form-control" name="amount" id="amount" aria-describedby="emailHelp" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Gerar</button>
                    </form>
                </div>
                <div class="col">
                    <form action="/hits" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="result">Resultado</label>
                            <input type="result" value="" class="form-control" name="result" id="result" aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label for="bets">Quantidade de jogos</label>
                            <input type="file" class="form-control" name="bets" id="bets" aria-describedby="emailHelp" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Resultado</button>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    @if (session('bets'))
                        <div class="row">
                            <div class="col-2">
                                <form action="/download" method="POST">
                                    @csrf
                                    <input type="hidden" name="bets" value={{ json_encode(session('bets')) }}>
                                    <input type="hidden" name="format" value="json">
                                    <button type="submit" class="btn btn-secondary mb-3">Salvar JSON</button>
                                </form>
                            </div>
                            <div class="col-2">
                                <form action="/download" method="POST">
                                    @csrf
                                    <input type="hidden" name="bets" value={{ json_encode(session('bets')) }}>
                                    <input type="hidden" name="format" value="csv">
                                    <button type="submit" class="btn btn-secondary mb-3">Salvar CSV</button>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                        @foreach (session('bets')[0] as $n)
                                            <th scope="col">{{ $loop->index + 1 }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (session('bets') as $bet)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            @foreach ($bet as $n)
                                                <td>{{ $n }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    @endif
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
