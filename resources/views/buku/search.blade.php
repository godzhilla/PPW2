@extends('themes.app')
@section('content')
    @if (count($data_buku) > 0)
    <div class="alert alert-seccess">Ditemukan <strong>{{count($data_buku)}}</strong> data dengan kata: <strong>{{$cari}}</strong></div>
    
    <table class="table table-striped">
        <thead></thead>
            <tr>
                <th scope="col">id</th>
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
                <th scope="row">{{$buku->judul}}</th>
                <th scope="row">{{$buku->penulis}}</th>
                <th scope="row">{{"Rp ".number_format($buku->harga, 0, ',', '.')}}</th>
                <td scope="row">{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d/m/Y')}}</td>
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
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="/buku" class="btn btn-warning">Kembali</a>

    @else
        <div class="alert alert-warning"><h4>Data {{$cari}} tidak ditemukan</h4>
        <a href="/buku" class="btn btn-warning">Kembali</a>
        </div>
        
    @endif
    
@endsection