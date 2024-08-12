@extends('layout')

@section('title', 'Service Types')

@section('pages')
    <li class="breadcrumb-item text-sm text-dark"><a class="opacity-5 text-dark"
            href="{{ route('serviceType.index') }}">Service Type</a></li>
    <li class="breadcrumb-item text-sm text-dark"><a href="{{ route('serviceType.edit', @$main->id) }}">edit</a></li>
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
                    <form action="{{ route('serviceType.update', @$main->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="d-flex">
                            <x-flag-contry></x-flag-contry>
                        </div>
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder"> Create Service Type </h6>
                        <ul class="list-group">
                            @foreach (@$config_lang ?? [] as $key => $item)
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0 datalange datalange_{{$item}} @if($key != 0) d-none @endif">
                                    <label for="form-label text-body ms-3 text-truncate w-80 mb-0">Name [{{ $item }}]</label>
                                    <input class="form-control" type="text" id="datalange[{{ $item }}][name]" name="datalange[{{ $item }}][name]" value="{{ @$main->getTranslation('name', $item) ?? null }}">
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <a class="btn bg-gradient-secondary" href="{{ route('serviceType.index') }}">Back</a>
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
            lange = document.querySelectorAll(`.datalange`);
            lange.forEach(element => {
                if(element.classList.contains(`datalange_${e.id}`)){
                    element.classList.remove("d-none");
                } else {
                    element.classList.add("d-none");
                }
            });
        }
    </script>
@endsection
