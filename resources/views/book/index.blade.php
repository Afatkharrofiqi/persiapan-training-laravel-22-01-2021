@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Manage Book</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('book.search') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="keyword" value="{{ request()->keyword }}" class="form-control" placeholder="Search book" aria-label="Recipient's username" aria-describedby="button-addon2" />
                                        <div class="input-group-append">
                                            <input class="btn btn-success" type="submit" id="button-addon2" value="Search">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-4 col-md-3 col-lg-2">
                                <a href="{{ route('book.create') }}" class="btn btn-dark btn-block mb-2">Add Book</a>
                            </div>
                        </div>
                        <div class="input"></div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-striped table-responsive-lg">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Created By</th>
                                    <th scope="col">Updated By</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($books as $key => $book)
                                    <tr>
                                        <td>{{ $books->firstItem() + $key }}</td>
                                        <td>{{ $book->name }}</td>
                                        <td>{{ $book->slug }}</td>
                                        <td>
                                            @if($book->image)
                                                <img src="{{ asset('storage/'.$book->image) }}" width="100px" alt="Book Cover">
                                            @else
                                                <p>Cover not set</p>
                                            @endif
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach($book->categories as $category)
                                                    <li>{{ $category->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $book->createdBy->name }}</td>
                                        <td>{{ $book->updatedBy->name ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('book.edit', ['book' => $book->id]) }}" type="button" class="btn btn-primary">Edit</a>&nbsp;
                                            <form id="delete-form" action="{{ route('book.destroy', ['book' => $book->id]) }}" method="POST" class="d-inline-block mt-2">
                                                @csrf
                                                {{ method_field('delete') }}
                                                <input type="submit" class="btn btn-danger" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Book not found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-right">
                            {{ $books->appends(request()->all())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
