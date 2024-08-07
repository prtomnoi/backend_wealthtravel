@extends('superAdmin.layout_super')

@section('title', 'permission')

@section('pages')
    <li class="breadcrumb-item text-sm text-dark"><a href="{{ route('permission.index') }}">permission</a></li>
@endsection

@section('contents')
    <div class="container-fluid py-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
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
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                        Role
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (@$data as $key => $item)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex px-2 py-1">
                                                <p>{{ @$item->name }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('permission.edit', @$item->id) }}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Edit user">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td>No data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-end pb-0">
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
