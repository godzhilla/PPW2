<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku Favorit</title>
</head>
<body>

    <h2>Daftar Buku Favorit</h2>

    @if(count($favorit) > 0)
        <ul>
            @foreach($favorit as $buku)
                <li>{{ $buku->judul }}</li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada buku favorit.</p>
    @endif

</body>
</html>
