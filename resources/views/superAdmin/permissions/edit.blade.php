@extends('superAdmin.layout_super')

@section('title', 'permission')

@section('pages')
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('permission.index') }}">permission</a></li>
    <li class="breadcrumb-item text-sm text-dark"><a href="{{ route('permission.edit', $role->id) }}">edit</a></li>
@endsection

@section('contents')
    <div class="container-fluid py-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    Permission Settings
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row">

                        <div class="col-12 col-xl-12">
                            <div class="card h-100">
                                <div class="card-header p-3">
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
                                <div class="card-body p-3">
                                    <form action="{{ route('permission.update', $role->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        @forelse (@$permission as $key => $item)
                                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">
                                                {{ @$item->table_name }}</h6>
                                            <input type="text" class="d-none" name="id[]" value="{{ @$item->id }}">
                                            <ul class="list-group">
                                                <li class="list-group-item border-0 px-0">
                                                    <div class="form-check form-switch ps-0">
                                                        <input class="form-check-input ms-auto view" type="checkbox"
                                                            value="1"
                                                            @if (@$item->view == 1) checked @endif onchange="onchangeCheckboxView(this)">
                                                        <label
                                                            class="form-check-label text-body ms-3 text-truncate w-80 mb-0">view</label>
                                                        <input type="number" class="d-none view-input" maxlength="1" minlength="0" name="view[]" value="{{ @$item->view }}">
                                                    </div>
                                                </li>
                                                <li class="list-group-item border-0 px-0">
                                                    <div class="form-check form-switch ps-0">
                                                        <input class="form-check-input ms-auto" type="checkbox"
                                                            value="1"
                                                            @if (@$item->create == 1) checked @endif onchange="onchangeCheckboxCreate(this)">
                                                        <label
                                                            class="form-check-label text-body ms-3 text-truncate w-80 mb-0">create</label>
                                                            <input type="number" class="d-none create-input" maxlength="1" minlength="0" name="create[]" value="{{ @$item->create }}">
                                                    </div>
                                                </li>
                                                <li class="list-group-item border-0 px-0">
                                                    <div class="form-check form-switch ps-0">
                                                        <input class="form-check-input ms-auto" type="checkbox"
                                                            value="1"
                                                            @if (@$item->update == 1) checked @endif onchange="onchangeCheckboxUpdate(this)">
                                                        <label
                                                            class="form-check-label text-body ms-3 text-truncate w-80 mb-0">update</label>
                                                            <input type="number" class="d-none update-input" maxlength="1" minlength="0" name="update[]" value="{{ @$item->update }}">
                                                    </div>
                                                </li>
                                                <li class="list-group-item border-0 px-0">
                                                    <div class="form-check form-switch ps-0">
                                                        <input class="form-check-input ms-auto" type="checkbox"
                                                            value="1"
                                                            @if (@$item->delete == 1) checked @endif onchange="onchangeCheckboxDelete(this)">
                                                        <label
                                                            class="form-check-label text-body ms-3 text-truncate w-80 mb-0" >delete</label>
                                                            <input type="number" class="d-none delete-input" maxlength="1" minlength="0" name="delete[]" value="{{ @$item->delete }}">
                                                    </div>
                                                </li>
                                            </ul>
                                        @empty
                                            <h6 class="text-uppercase text-body text-xs font-weight-bolder text-center">No
                                                data
                                                found</h6>
                                        @endforelse
                                        <a class="btn bg-gradient-secondary" href="{{ route('permission.index') }}" >Back</a>
                                        <button class="btn bg-gradient-dark" type="submit">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function onchangeCheckboxView(e){
        if(e.checked){
            e.closest('.form-check').querySelector('.view-input').value = 1
        } else {
            e.closest('.form-check').querySelector('.view-input').value = 0
        }
    }
    function onchangeCheckboxCreate(e){
        if(e.checked){
            e.closest('.form-check').querySelector('.create-input').value = 1
        } else {
            e.closest('.form-check').querySelector('.create-input').value = 0
        }
    }
    function onchangeCheckboxUpdate(e){
        if(e.checked){
            e.closest('.form-check').querySelector('.update-input').value = 1
        } else {
            e.closest('.form-check').querySelector('.update-input').value = 0
        }
    }
    function onchangeCheckboxDelete(e){
        if(e.checked){
            e.closest('.form-check').querySelector('.delete-input').value = 1
        } else {
            e.closest('.form-check').querySelector('.delete-input').value = 0
        }
    }
</script>
@endsection
