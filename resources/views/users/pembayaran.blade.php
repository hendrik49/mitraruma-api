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
                <div class="box">
                    <div class="box-body">
                        <table class="table table-bordered table-striped" id="projectrange">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Order Number</th>
                                    @if (Auth::user()->user_type == 'customer')
                                        <th>Customer Name</th>
                                    @else
                                        <th>Applicator Name</th>
                                    @endif
                                    <th>SPK Amount</th>
                                    <th>Termin 1 </th>
                                    <th>Termin 2 </th>
                                    <th>Termin 3 </th>
                                    <th>Termin 4 </th>
                                    <th>Termin 5 </th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $key => $project)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $project->order_number }}</td>
                                        @if (Auth::user()->user_type == 'customer')
                                            <td>{{ $project->customer_name }}</td>
                                            <td>{{ $project->amount_spk_customer }}</td>
                                            <td>{{ $project->termin_customer_1 }}</td>
                                            <td>{{ $project->termin_customer_2 }}</td>
                                            <td>{{ $project->termin_customer_3 }}</td>
                                            <td>{{ $project->termin_customer_4 }}</td>
                                            <td>{{ $project->termin_customer_5 }}</td>
                                        @else
                                            <td>{{ $project->vendor_name }}</td>
                                            <td>{{ $project->amount_spk_vendor }}</td>
                                            <td>{{ $project->termin_customer_1 }}</td>
                                            <td>{{ $project->termin_customer_2 }}</td>
                                            <td>{{ $project->termin_customer_3 }}</td>
                                            <td>{{ $project->termin_customer_4 }}</td>
                                            <td>{{ $project->termin_customer_5 }}</td>
                                        @endif
                                        <td>{{ $project->status }}</td>
                                        <td>{{ $project->created_at->format('Y-m-d') }}</td>
                                        <td width="15%">
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
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }, ]
            });
        });
    </script>
@endsection
