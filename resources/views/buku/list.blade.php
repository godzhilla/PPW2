<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

    <h1>Daftar Buku Tersedia</h1>
    <h3>Bulaksumur, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</h3>

    <form action="{{route('buku.search')}}" method="get">@csrf
        <input type="text" name="kata" class="form-control" placeholder="Cari ..." style="width: 30%";
        display: inline; margin-top: 10px; margin-bottom: 10px; float: right;>
    </form>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <table class="table table-striped">
            <thead></thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col">Judul Buku</th>
                    <th scope="col">Penulis</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Tgl. Terbit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_buku as $buku)
                <tr>
                    <th scope="row">
                        @if ($buku->filepath)
                            <div class="relative h-10 w-10">
                                <img
                                class="h-full w-full rounded-full object-cover object-center"
                                src="{{ asset($buku->filepath) }}"
                                alt=""
                                />
                            </div>
                        @endif
                    </th>
                    
                    <th scope="row"> <a href="{{route('buku.detail', $buku->id)}}"> {{$buku->judul}} </a> </th>
                    
                    <th scope="row">{{$buku->penulis}}</th>
                    <th scope="row">{{"Rp ".number_format($buku->harga, 0, ',', '.')}}</th>
                    <td scope="row">{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d/m/Y')}}</td>
                
                    {{-- @if (Auth::user()->level=='admin') --}}
                        {{-- <th scope="row">
                            <form action="{{route('buku.edit', $buku->id)}}">
                                @csrf
                                <button> Edit</button>
                            </form>
                        </th>
                        <th scope="row">
                            <form action="{{route('buku.destroy', $buku->id)}}" method="post">
                                @csrf
                                <button onclick="return confirm('Yakin mau dihapus?')"> Hapus</button>
                            </form>
                        </th> --}}
                    {{-- @endif --}}
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>