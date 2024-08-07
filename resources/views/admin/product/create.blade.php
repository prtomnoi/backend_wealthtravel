@extends('layout')

@section('title', 'Service')

@section('pages')
    <li class="breadcrumb-item text-sm text-dark"><a class="opacity-5 text-dark"
            href="{{ route('service.index') }}">Service</a></li>
    <li class="breadcrumb-item text-sm text-dark"><a href="{{ route('service.create') }}">create</a></li>
@endsection

@section('pages-title', 'Service')

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
                    <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <x-flag-contry></x-flag-contry>
                        </div>

                        <h6 class="text-uppercase text-body text-xs font-weight-bolder"> Create Service </h6>
                        <ul class="list-group">
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        @foreach (@$serviceType as $item)
                                            <option value="{{ @$item->id }}">{{ @$item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Title</label>
                                    <input class="form-control" type="text" id="title" name="title">
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Sub Description</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" id="sub_desc" name="sub_desc"></textarea>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Description</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" id="desc" name="desc"></textarea>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Image</label>
                                    <input type="file" accept="image/*" id="image" name="image" class="form-control"
                                        onchange="previewImage(this)">
                                    <div class="d-none div-preview-image">
                                        <img src="#" alt="image" width="100" height="100" class="img-fluid" id="preview-image">
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <a class="btn bg-gradient-secondary" href="{{ route('service.index') }}">Back</a>
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
            document.getElementById("lange").value = e.id;
            document.getElementById("imageFlagDrowdown").src = e.querySelector('img').src;
        }

        function previewImage(e) {
            const [file] = e.files
            if (file) {
                document.querySelector('.div-preview-image').classList.remove('d-none');
                document.getElementById('preview-image').src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
