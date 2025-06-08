<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tic Tac Toe</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
        }

        table {
            margin: auto;
            border-collapse: collapse;
        }

        td {
            width: 80px;
            height: 80px;
            font-size: 36px;
            text-align: center;
            border: 2px solid #333;
        }

        button {
            width: 100%;
            height: 100%;
            font-size: 30px;
            background: none;
            border: none;
            cursor: pointer;
        }

        .status {
            margin-top: 20px;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <h2>Tic Tac Toe - You vs Computer</h2>

    <form method="POST" action="{{ route('tic.play') }}">
        @csrf
        <table>
            @foreach(array_chunk($board, 3) as $row)
                <tr>
                    @foreach($row as $i => $cell)
                        @php $index = $loop->parent->index * 3 + $loop->index; @endphp
                        <td>
                            @if($cell === '' && !$gameOver)
                                <button name="move" value="{{ $index }}">-</button>
                            @else
                                {{ $cell }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </form>

    <div class="status">
        @if($winner)
            <p><strong>{{ $winner === 'X' ? '🎉 You win!' : '🤖 Computer wins!' }}</strong></p>
        @elseif($gameOver)
            <p><strong>🤝 It’s a draw!</strong></p>
        @endif
    </div>

    <form method="POST" action="{{ route('tic.reset') }}">
        @csrf
        <button style="margin-top: 20px;">🔄 Restart Game</button>
    </form>
</body>

</html>