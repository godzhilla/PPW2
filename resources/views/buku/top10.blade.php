    <h1>Top 10 Books</h1>

    <div>
        @foreach ($topBooks as $buku)
            <div class="book">
                <h2>{{ $buku->judul }}</h2>
                <p>Author: {{ $buku->penulis }}</p>
                <p>Rating: {{ $buku->star_rating }}</p>
                <!-- Add other book details as needed -->
            </div>
        @endforeach
    </div>
    <h3>
        <a href="/dashboard"> Back</a>
    </h3>