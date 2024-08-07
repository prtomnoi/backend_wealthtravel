@extends('layout')

@section('title', 'Product')

@section('pages')
    <li class="breadcrumb-item text-sm text-dark"><a class="opacity-5 text-dark"
            href="{{ route('product.index') }}">Product</a></li>
    <li class="breadcrumb-item text-sm text-dark"><a href="{{ route('product.create') }}">create</a></li>
@endsection

@section('pages-title', 'Product')

@section('contents')
    <style>
        .rate {
            border-bottom-right-radius: 12px;
            border-bottom-left-radius: 12px
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center
        }

        .rating>input {
            display: none
        }

        .rating>label {
            position: relative;
            width: 1em;
            font-size: 30px;
            font-weight: 300;
            color: #FFD600;
            cursor: pointer
        }

        .rating>label::before {
            content: "\2605";
            position: absolute;
            opacity: 0
        }

        .rating>label:hover:before,
        .rating>label:hover~label:before {
            opacity: 1 !important
        }

        .rating>input:checked~label:before {
            opacity: 1
        }

        .rating:hover>input:checked~label:before {
            opacity: 0.4
        }

        .buttons {
            top: 36px;
            position: relative
        }

        .rating-submit {
            border-radius: 8px;
            color: #fff;
            height: auto
        }

        .rating-submit:hover {
            color: #fff
        }
    </style>
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
                    <form action="{{ route('product.update', @$main->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d-flex">
                            <x-flag-contry></x-flag-contry>
                        </div>

                        <h6 class="text-uppercase text-body text-xs font-weight-bolder"> Edit Product </h6>
                        <ul class="list-group">
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control">
                                        @foreach (@$productType as $item)
                                            <option value="{{ @$item->id }}"
                                                @if (@$item->id == @$main->type) selected @endif>{{ @$item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="name" name="name" value="{{ @$main->name }}">
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="price">Price</label>
                                    <input class="form-control" type="text" id="price" name="price" value="{{ @$main->price }}">
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="price_sale">Price Sale</label>
                                    <input class="form-control" type="text" id="price_sale" name="price_sale"
                                        value="{{ @$main->price_sale }}">
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <div class="d-flex">
                                        <label class="align-content-center">Star</label>
                                        <div class=" d-flex">
                                            <div class=" text-center">
                                                <div class="rating">
                                                    <input type="radio" name="star" value="5"
                                                        id="5" @if(@$main->star == 5) checked @endif ><label for="5">☆</label> <input type="radio"
                                                        name="star" value="4" id="4" @if(@$main->star == 4) checked @endif><label
                                                        for="4">☆</label> <input type="radio" name="star"
                                                        value="3" id="3" @if(@$main->star == 3) checked @endif><label for="3">☆</label> <input
                                                        type="radio" name="star" value="2" id="2" @if(@$main->star == 2) checked @endif><label
                                                        for="2">☆</label> <input type="radio" name="star"
                                                        value="1" id="1" @if(@$main->star == 1) checked @endif><label for="1">☆</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Image</label>
                                    <input type="file" accept="image/*" id="image" name="image"
                                        class="form-control" onchange="previewImage(this)">
                                    @if (@$main->image)
                                        <div class="div-preview-image">
                                            <img src="{{ asset('app/product/' . @$main->image) }}" alt="image"
                                                width="100" height="100" class="img-fluid" id="preview-image">
                                        </div>
                                    @else
                                        <div class="d-none div-preview-image">
                                            <img src="#" alt="image" width="100" height="100"
                                                class="img-fluid" id="preview-image">
                                        </div>
                                    @endif

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
            updateLanguage(e.id);
        }

        var translations = @json(@$main->toArray());
        var fields = ['name'];

        function updateLanguage(language) {
            fields.forEach(function(field) {
                document.getElementById(field).value = translations[field][language] || '';
            });
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
