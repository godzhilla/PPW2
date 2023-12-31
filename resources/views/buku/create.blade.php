<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h2>Tambah Buku</h2>

        @if (count($errors) > 0)
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul> 
        @endif

        <form action="{{route('buku.store')}}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="judul" class="col-sm-2 col-form-label">Judul :</label>
                <div class="col-sm-10">
                    <input type="text" name="judul" id="judul" class="form-control">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="penulis" class="col-sm-2 col-form-label">Penulis :</label>
                <div class="col-sm-10">
                    <input type="text" name="penulis" id="penulis" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="harga" class="col-sm-2 col-form-label">Harga :</label>
                <div class="col-sm-10">
                    <input type="text" name="harga" id="harga" class="form-control">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="tgl_terbit" class="col-sm-2 col-form-label">Tgl. Terbit :</label>
                <div class="col-sm-10">
                    <input type="text" name="tgl_terbit" id="tgl_terbit" class="date form-control" placeholder="yyyy/mm/dd">
                </div>
            </div>

            <div>
                <input type="file" name="thumbnail" id="thumbnail" alt="thumbnail">
            </div>

            <div><button type="submit" class="simpan">Simpan</button></div>
            <a href="/buku"> Batal</a>
            
            </form>
        </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>