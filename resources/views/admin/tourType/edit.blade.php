@extends('layout')

@section('title', 'Tour Types')

@section('pages')
    <li class="breadcrumb-item text-sm text-dark"><a class="opacity-5 text-dark"
            href="{{ route('tourType.index') }}">Tour Type</a></li>
    <li class="breadcrumb-item text-sm text-dark"><a href="{{ route('tourType.edit', @$main->id) }}">edit</a></li>
@endsection

@section('pages-title', 'Service Type')

@section('contents')
    <div class="container-fluid py-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">x</button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 text-white">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="card-body px-3 pb-2">
                    <form action="{{ route('tourType.update', @$main->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="d-flex">
                            <x-flag-contry></x-flag-contry>
                        </div>
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder"> Create Tour Type </h6>
                        <ul class="list-group">
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="form-label text-body ms-3 text-truncate w-80 mb-0">Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ @$main->name }}">
                                </div>
                            </li>
                        </ul>
                        <a class="btn bg-gradient-secondary" href="{{ route('tourType.index') }}">Back</a>
                        <button class="btn bg-gradient-dark" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function changeLange(e) {
            console.log(e.id);
            document.getElementById("lange").value = e.id;
            document.getElementById("imageFlagDrowdown").src = e.querySelector('img').src;
            updateLanguage(e.id);
        }
        var translations = @json(@$main->toArray());
        var fields = ['name'];
        function updateLanguage(language) {
            fields.forEach(function(field) {
                document.getElementById(field).value = translations[field][language] || '';
            });
        }
    </script>
@endsection
