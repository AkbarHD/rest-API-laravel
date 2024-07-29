<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Genre</th>
            <th>Author</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($books as $book)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->genre }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->price }}</td>
            </tr>

        @empty
        @endforelse
    </tbody>
</table>
