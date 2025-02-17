@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Edit Category</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('category.update', ['category' => $category->id]) }}" method="POST">
                            @csrf
                            {{ method_field('put') }}
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name Category</label>
                                <div class="col-sm-10">
                                    <input name="name" type="text" class="form-control" id="name" value="{{ $category->name }}" placeholder="Name category" />
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-dark mb-2" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
