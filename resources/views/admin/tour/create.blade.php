@extends('layout')

@section('title', 'Tour')

@section('pages')
    <li class="breadcrumb-item text-sm text-dark"><a class="opacity-5 text-dark" href="{{ route('tour.index') }}">Tour</a></li>
    <li class="breadcrumb-item text-sm text-dark"><a href="{{ route('tour.create') }}">create</a></li>
@endsection

@section('pages-title', 'Tour')

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
                    <form action="{{ route('tour.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <x-flag-contry></x-flag-contry>
                        </div>

                        <h6 class="text-uppercase text-body text-xs font-weight-bolder"> Create Tour </h6>
                        <ul class="list-group">
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        @foreach (@$tourType as $item)
                                            <option value="{{ @$item->id }}">{{ @$item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            @foreach (@$config_lang ?? [] as $key => $item)
                            <li class="list-group-item border-0 px-0 datalange datalange_{{$item}} @if($key != 0) d-none @endif">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Title [{{$item}}]</label>
                                    <input class="form-control" type="text" id="datalange[{{ $item }}][title]" name="datalange[{{ $item }}][title]">
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0 datalange datalange_{{$item}} @if($key != 0) d-none @endif">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Sub Description [{{$item}}]</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" id="datalange[{{ $item }}][sub_desc]" name="datalange[{{ $item }}][sub_desc]"></textarea>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0 datalange datalange_{{$item}} @if($key != 0) d-none @endif">
                                <div class="form-group form-switch ps-0">
                                    <label for="title">Description [{{$item}}]</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" id="datalange[{{ $item }}][desc]" name="datalange[{{ $item }}][desc]"></textarea>
                                </div>
                            </li>
                            @endforeach
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="Contry">Contry</label>
                                    <select name="Contry" id="Contry" class="form-control"
                                        onchange="getCityByContry(this)">
                                        <option value="">--- Select contry ---</option>
                                        @foreach (@$contry as $item)
                                            <option value="{{ @$item->alpha_3 }}">{{ @$item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="city_id">City</label>
                                    <select name="city_id" id="city_id" class="form-control" disabled>
                                    </select>
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="start_date">Start date tour</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date"
                                        value="{{ now()->format('Y-m-d') }}" />
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="end_date">End date tour</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date"
                                        value="{{ now()->format('Y-m-d') }}" />
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="duration">Duration</label>
                                    <input type="text" class="form-control" name="duration" id="duration"
                                        value="1" />
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="price">Price</label>
                                    <input type="text" class="form-control" name="price" id="price"
                                        value="0" />
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <label class="form__container" id="upload-container">Select Image or Drag
                                    <input class="form__file" id="upload-files" type="file" accept="image/*"
                                        multiple="multiple" name="uploadImage[]" />
                                </label>
                                <div class="form__files-container" id="files-list-container">
                                </div>
                            </li>
                            <li class="list-group-item border-0 px-0">
                                <div class="form-group form-switch ps-0">
                                    <label for="duration">Upload Pdf</label>
                                    <input type="file" class="form-control" name="uploadPdf" id="uploadPdf" accept="application/pdf"  />
                                </div>
                            </li>
                        </ul>
                        <a class="btn bg-gradient-secondary" href="{{ route('tour.index') }}">Back</a>
                        <button class="btn bg-gradient-dark" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ asset('assets/css/uploadFile.css') }}">
    <script src="{{ asset('assets/js/uploadFile.js') }}"></script>
    {{-- editor --}}
    <link rel="stylesheet" href="{{ asset('assets/libs/summernote/summernote-lite.min.css') }}">
    <script src="{{ asset('assets/libs/summernote/summernote-lite.min.js') }}"></script>
    <script>
        function changeLange(e) {
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

        function setInputFilter(textbox, inputFilter, errMsg) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop", "focusout"].forEach(
                function(event) {
                    textbox.addEventListener(event, function(e) {
                        if (inputFilter(this.value)) {
                            // Accepted value.
                            if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
                                this.classList.remove("input-error");
                                this.setCustomValidity("");
                            }

                            this.oldValue = this.value;
                            this.oldSelectionStart = this.selectionStart;
                            this.oldSelectionEnd = this.selectionEnd;
                        } else if (this.hasOwnProperty("oldValue")) {
                            // Rejected value: restore the previous one.
                            this.classList.add("input-error");
                            this.setCustomValidity(errMsg);
                            this.reportValidity();
                            this.value = this.oldValue;
                            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                        } else {
                            // Rejected value: nothing to restore.
                            this.value = "";
                        }
                    });
                });
        }
        setInputFilter(document.getElementById("price"), function(value) {
            return /^-?\d*[.,]?\d{0,2}$/.test(value);
        }, "Must be a currency value");
        // Install input filters.
        setInputFilter(document.getElementById("duration"), function(value) {
            return /^-?\d*$/.test(value);
        }, "Must be an integer");
    </script>
    <script>
        function getCityByContry(e) {
            if (e.value) {
                $('#city_id').attr('disabled', false);
                console.log(e.value)
                $.ajax({
                    type: "GET",
                    url: `/cityByContry/${e.value}`,
                    success: function(response) {
                        var html = '';
                        response.data.forEach(e => {
                            html += `<option value="${e.id}">${e.city}</option>`
                        });
                        console.log(html)
                        $('#city_id').html(html);

                    }
                });
            } else {
                $('#city_id').attr('disabled', true);
                $('#city_id').html('');
            }
        }
        $('#desc').summernote({
            height: 200
        });
    </script>
@endsection
