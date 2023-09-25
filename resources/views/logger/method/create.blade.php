@extends('layouts.default')

@section('content')
    <a class="mb-2" href="/">Go to list</a>

    <h1 class="h4 mb-4">{{ $title }}</h1>

    <div class="card card-body">
        <form class="" action="{{ route('method.store') }}" method="post" autocomplete="off">
            @csrf

            <div class="row mb-2">
                <label class="form-label col-2 fst-italic">Name</label>
                <div class="col-4">
                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" />
                    <div class="invalid-feedback">
                        @error('name'){{ $message }}@enderror
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <label class="form-label col-2 fst-italic">URI</label>
                <div class="col-4">
                    <input class="form-control @error('endpoint') is-invalid @enderror" name="endpoint" value="{{ old('endpoint') }}" />
                    <div class="invalid-feedback">
                        @error('endpoint'){{ $message }}@enderror
                    </div>
                </div>
            </div>

            <div class="row mb-2">
                <label class="form-label col-2"></label>
                <div class="col-4">
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>
            </div>
        </form>
    </div>
@stop