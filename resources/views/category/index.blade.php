@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Manage Category</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('category.search') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="keyword" value="{{ request()->keyword }}" class="form-control" placeholder="Search category" aria-label="Recipient's categoryname" aria-describedby="button-addon2" />
                                        <div class="input-group-append">
                                            <input class="btn btn-success" type="submit" id="button-addon2" value="Search">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-4 col-md-3 col-lg-2">
                                <a href="{{ route('category.create') }}" class="btn btn-dark btn-block mb-2">Add Category</a>
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
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $key => $category)
                                    <tr>
                                        <td>{{ $categories->firstItem() + $key }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug_name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('category.edit', ['category' => $category->id]) }}" type="button" class="btn btn-primary">Edit</a>&nbsp;
                                            <form id="delete-form" action="{{ route('category.destroy', ['category' => $category->id]) }}" method="POST" class="d-inline-block mt-2 mt-lg-0">
                                                @csrf
                                                {{ method_field('delete') }}
                                                <input type="submit" class="btn btn-danger" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Category not found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-right">
                            {{ $categories->appends(request()->all())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
