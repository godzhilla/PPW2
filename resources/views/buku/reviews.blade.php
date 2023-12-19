@extends('layouts.app')

@section('content')
    <h1>Reviews for {{ $buku->title }}</h1>

    <div>
        @foreach ($reviews as $review)
            <div class="review">
                <p><strong>{{ $review->name }}</strong></p>
                <p>{{ $review->comment }}</p>
            </div>
        @endforeach
    </div>

    <hr>

    <h2>Add a Review</h2>

    <form action="{{ route('buku.storeReview', $buku->id) }}" method="post">
        @csrf
        <label for="name">Your Name:</label>
        <input type="text" name="name" required>
        <label for="comment">Your Comment:</label>
        <textarea name="comment" rows="4" required></textarea>
        <button type="submit">Submit Review</button>
    </form>
@endsection
