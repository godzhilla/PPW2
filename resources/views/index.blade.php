@extends('themes.app')
@section('content')

    @if (Session::has('pesan'))
        <div class="alert alert-success">{{Session::get('pesan')}}</div> {{--ga muncul apa apa--}}
    @endif

    <h1>Daftar Buku Tersedia</h1>
    <h3>Bulaksumur, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</h3>


    <form action="{{route('buku.search')}}" method="get">@csrf
        <input type="text" name="kata" class="form-control" placeholder="Cari ..." style="width: 30%";
        display: inline; margin-top: 10px; margin-bottom: 10px; float: right;>
    </form>

    <table class="table table-striped">
        <thead></thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col"> </th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Penulis</th>
                <th scope="col">Harga</th>
                <th scope="col">Tgl. Terbit</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_buku as $buku)
            <tr>
                <th scope="row">{{++$no}}</th>
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
                <th scope="row"> {{$buku->judul}} </th>
                <th scope="row">{{$buku->penulis}}</th>
                <th scope="row">{{"Rp ".number_format($buku->harga, 0, ',', '.')}}</th>
                <td scope="row">{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d/m/Y')}}</td>
               
                {{-- @if (Auth::user()->level=='admin') --}}
                    <th scope="row">
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
                    </th>
                {{-- @endif --}}
                
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>{{ $data_buku->links() }}</div>
    <p>Jumlah Data: {{ $jumlahData }}</p>
    <p>Total Harga Buku: {{ "Rp ".number_format($totalHarga, 2, ', ','.')}}</p>

    {{-- @if (Auth::check()&& Auth::user()->level=='admin') --}}
        <button><a href="{{route('buku.create')}}"> Tambah Buku </a></button>
    {{-- @endif --}}

@endsection