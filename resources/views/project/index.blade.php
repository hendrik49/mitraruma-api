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
                                    <th>no.</th>
                                    <th>order number</th>
                                    <th>room number</th>
                                    <th>customer name</th>
                                    <th>customer contact</th>
                                    <th>applicator name</th>
                                    <th>tipe proyek</th>
                                    <th>status</th>
                                    <th>date</th>
                                    {{-- <th>room ID</th>
                                    <th>consultation ID</th> --}}
                                    <th>description</th>
                                    {{-- @if (Auth::user()->user_type == 'customer' || Auth::user()->user_type == 'admin')

                                        <th> amount spk customer </th>
                                        <th> amount spk vendor </th>
                                        <th> amount spk vendor net </th>
                                        <th> mitraruma discount </th>
                                        <th> applicator discount </th>
                                        <th> commision </th>
                                        <th> other expanse </th>
                                        <th> total expanse </th>
                                        <th> expanse note </th>
                                        <th> project note </th>
                                        <th> material buy </th>
                                        <th> booking fee </th>
                                        <th> term payment vendor </th>
                                        <th> term payment customer </th>
                                        <th> termin customer 1 </th>
                                        <th> termin customer 2 </th>
                                        <th> termin customer 3 </th>
                                        <th> termin customer 4 </th>
                                        <th> termin customer 5 </th>
                                        <th> termin customer 1 date </th>
                                        <th> termin customer 2 date </th>
                                        <th> termin customer 3 date </th>
                                        <th> termin customer 4 date </th>
                                        <th> termin customer 5 date </th>
                                    @elseif(Auth::user()->user_type=="vendor"||Auth::user()->user_type=="admin")
                                        <th> termin vendor 1 </th>
                                        <th> termin vendor 2 </th>
                                        <th> termin vendor 3 </th>
                                        <th> termin vendor 4 </th>
                                        <th> termin vendor 5 </th>
                                        <th> termin vendor 1 date </th>
                                        <th> termin vendor 2 date </th>
                                        <th> termin vendor 3 date </th>
                                        <th> termin vendor 4 date </th>
                                        <th> termin vendor 5 date </th>
                                        <th> payment retention date </th>
                                    @endif --}}
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $key => $project)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $project->order_number }}</td>
                                        <td>{{ $project->room_number }}</td>
                                        <td>{{ $project->customer_name }}</td>
                                        <td>{{ $project->customer_contact }}</td>
                                        <td>{{ $project->vendor_name }}</td>
                                        <td width="10%">{{ $project->service_type }}</td>
                                        <td>{{ $project->status }}</td>
                                        <td>{{ $project->created_at->format('Y-m-d') }}</td>
                                        {{-- <td>{{ $project->room_id }}</td>
                                        <td>{{ $project->consultation_id }}</td> --}}
                                        <td>{{ $project->description }}</td>

                                        <td>{{ $project->amount_spk_customer }}</td>
                                        <td>{{ $project->amount_spk_vendor }}</td>
                                        <td>{{ $project->amount_spk_vendor_net }}</td>
                                        <td>{{ $project->mitraruma_discount }}</td>
                                        <td>{{ $project->applicator_discount }}</td>
                                        <td>{{ $project->commision }}</td>
                                        <td>{{ $project->other_expanse }}</td>
                                        <td>{{ $project->total_expanse }}</td>
                                        <td>{{ $project->expanse_note }}</td>
                                        <td>{{ $project->project_note }}</td>
                                        <td>{{ $project->material_buy }}</td>
                                        <td>{{ $project->booking_fee }}</td>
                                        <td>{{ $project->term_payment_vendor }}</td>
                                        <td>{{ $project->term_payment_customer }}</td>
                                        {{-- @if (Auth::user()->user_type == 'customer' || Auth::user()->user_type == 'admin')
                                            <td>{{ $project->termin_customer_1 }}</td>
                                            <td>{{ $project->termin_customer_2 }}</td>
                                            <td>{{ $project->termin_customer_3 }}</td>
                                            <td>{{ $project->termin_customer_4 }}</td>
                                            <td>{{ $project->termin_customer_5 }}</td>
                                            <td>{{ $project->termin_customer_1_date }}</td>
                                            <td>{{ $project->termin_customer_2_date }}</td>
                                            <td>{{ $project->termin_customer_3_date }}</td>
                                            <td>{{ $project->termin_customer_4_date }}</td>
                                            <td>{{ $project->termin_customer_5_date }}</td>
                                        @elseif(Auth::user()->user_type=="vendor"||Auth::user()->user_type=="admin")
                                            <td>{{ $project->termin_vendor_1 }}</td>
                                            <td>{{ $project->termin_vendor_2 }}</td>
                                            <td>{{ $project->termin_vendor_3 }}</td>
                                            <td>{{ $project->termin_vendor_4 }}</td>
                                            <td>{{ $project->termin_vendor_5 }}</td>
                                            <td>{{ $project->termin_vendor_1_date }}</td>
                                            <td>{{ $project->termin_vendor_2_date }}</td>
                                            <td>{{ $project->termin_vendor_3_date }}</td>
                                            <td>{{ $project->termin_vendor_4_date }}</td>
                                            <td>{{ $project->termin_vendor_5_date }}</td>
                                            <td>{{ $project->payment_retention_date }}</td>
                                        @endif --}}
                                        <td width="15%">
                                            <a href="{{ route('proyek.edit', ['proyek' => $project->id]) }}"
                                                class="btn btn-sm btn-primary"> <i class="glyphicon glyphicon-edit"></i>
                                                Edit </a>
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
