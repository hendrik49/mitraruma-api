@extends('layouts.app')
@section('title') Daftar project @endsection
@section('content')
    <div class="row">
        <div class="container mt-2">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @elseif(session('gagal'))
                    <div class="alert alert-danger">
                        {{ session('gagal') }}
                    </div>
                @endif
                <h2>List Konsultasi
                    <div style="float: right!important;">
                        <a
                        href="{{route('proyek.create')}}"
                        class="btn btn-success"
                        ><i class="fa fa-plus" aria-hidden="true"></i> Tambah Konsultasi</a>
                    </div>
                </h2>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="projectrange">
                            <thead>
                                <tr>
                                    <th>no.</th>
                                    <th>order number</th>
                                    <th>customer ID</th>
                                    <th>customer name</th>
                                    <th>customer contact</th>
                                    <th>applicator name</th>
                                    <th>tipe proyek</th>
                                    <th>status</th>
                                    <th>sub status</th>
                                    <th>date</th>
                                    <th>consultation ID</th>
                                    <th>description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $key => $project)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $project->order_number }}</td>
                                        <td>{{ $project->user_id }}</td>
                                        <td>{{ $project->customer_name }}</td>
                                        <td>{{ $project->customer_contact }}</td>
                                        <td>{{ $project->vendor_name }}</td>
                                        <td width="10%">{{ $project->service_type }}</td>
                                        <td>{{ $project->status }}</td>
                                        <td>{{ $project->project_note }}</td>
                                        <td>{{ $project->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $project->consultation_id }}</td>
                                        <td>{{ $project->description }}</td>                      
                                        <td width="15%">
                                            @if (Auth::user()->user_type == 'admin')
                                            <a href="{{ route('proyek.edit', ['proyek' => $project->id]) }}"
                                                class="btn btn-sm btn-primary"> <i class="glyphicon glyphicon-edit"></i>
                                                Edit </a>
                                            @endif
                                            <a href="{{ route('proyek.show', ['proyek' => $project->id]) }}"
                                                class="btn btn-sm btn-warning"> <i class="glyphicon glyphicon-eye-open"></i>
                                                View </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
        $(function() {
            var dTable = $('#projectrange').dataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'responsive': true,
                'info': true,
                'scrollX': true,
                'dom': 'Bfrtip',
                'buttons': [{
                    extend: 'excel',
                    // exportOptions: {
                    //     columns: [0, 1, 2, 3, 4, 5]
                    // }
                }, ]
            });
        });
    </script>
@endsection
