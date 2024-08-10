@extends('layout')

@section('title', 'Product Types')

@section('pages')
    <li class="breadcrumb-item text-sm text-dark"><a href="{{ route('productType.index') }}">Product Types</a></li>
@endsection

@section('pages-title', 'Product Type')

@section('contents')
    <div class="container-fluid py-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
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
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('productType.create') }}"
                            class="btn btn-sm btn-info font-weight-bold text-xs" data-toggle="tooltip"
                            data-original-title="Create user">
                            Create +
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Type</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (@$data as $key => $item)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex px-2 py-1">
                                                {{ @$item->name }}
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex px-2 py-1">
                                                <a href="{{ route('productType.edit', @$item->id) }}"
                                                    class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                    data-original-title="Edit user">
                                                    Edit
                                                </a>
                                                <div onclick="deleteItem({{ @$item->id }})"
                                                    class="text-danger font-weight-bold text-xs px-3 cursor-pointer" data-toggle="tooltip"
                                                    data-original-title="Delete user">
                                                    Delete
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="2">No data found</td>
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
<script>
    function deleteItem(id) {
            Swal.fire({
                title: 'Delete?',
                text: "You want delete value ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5e72e4',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    var is_url = "{{ route('productType.destroy', ':id') }}";
                    $.ajax({
                        url: is_url.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: "Delete value success.",
                                icon: 'success',
                            }).then((result) => {
                                if(result.isConfirmed){
                                    location.reload();
                                }
                            });
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Swal.fire({
                                title: 'Error!!!',
                                text: "Cannot delete value.",
                                icon: 'error',
                            });
                        }
                    });
                }
            })
        }
</script>
@endsection
