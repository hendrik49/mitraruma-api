@extends('layouts.app')
@section('title') Overview Data @endsection
@section('content')
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-3 mt-4">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Filter
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group{{ $errors->has('service-type') ? ' has-error' : '' }}">
                            <label for="service-type">Service Type</label>
                            <select class="form-control" id="service-type-field" name="skill_set">
                                <option value="service">Home Service</option>
                                <option value="renovation">Home Renovation</option>
                            </select>
                            @if ($errors->has('service-type'))
                                <span class="help-block">{{ $errors->first('service-type') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('coverage-area') ? ' has-error' : '' }}">
                            <label for="coverage-area">Service Area</label>
                            <select class="form-control select2" id="coverage-area-field" name="skill_set">
                                @foreach ($masters->where('name', 'area-coverage')->first()->value as $p)
                                    @foreach ($p['child'] as $v)
                                        <option value="{{ $v }}">{{ $v }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                            @if ($errors->has('coverage-area'))
                                <span class="help-block">{{ $errors->first('coverage-area') }}</span>
                            @endif
                        </div>
                        <div class="form-group @if ($errors->has('skill_set')) has-error @endif">
                            <label for="triwulan-field">Skill Set</label>
                            <select class="form-control" id="skill_set-field" name="skill_set">
                                @foreach ($masters->where('name', 'skill-set')->first()->value as $p)
                                    <option value="{{ $p['code'] }}">{{ $p['name'] }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('skill_set'))
                                <span class="help-block">{{ $errors->first('skill_set') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('customer_segmentation') ? ' has-error' : '' }}">
                            <label for="customer_segmentation">Segmentation</label>
                            <select class="form-control" id="coverage-area-field" name="skill_set">
                                @foreach ($masters->where('name', 'segment')->first()->value as $p)
                                    <option value="{{ $p['code'] }}">{{ $p['name'] }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('customer_segmentation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('customer_segmentation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="well well-sm mb-2">
                            <button type="submit" value="filter" class="btn btn-primary pull-right right"> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 mt-4">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-table mr-1"></i>
                            Data
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table" id="userrange">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Capacity</th>
                                    <th>On Going</th>
                                    <th>% Capacity</th>
                                    <th>Overall Score</th>
                                    <th>Compitency</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aplikators as $key => $review)
                                    <tr>
                                        <td>{{ $review->vendor_user_id }}</td>
                                        <td>{{ $review->vendor_name }}</td>
                                        <td>{{ $review->review['quality']??'' }} </td>
                                        <td>{{ $review->review['responsiveness_to_customer']??'' }} </td>
                                        <td>{{ $review->review['responsiveness_to_mitraruma']??'' }} </td>
                                        <td>{{ $review->review['behaviour']??'' }} </td>
                                        <td>{{ $review->review['helpful']??'' }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- ./col -->
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Profil
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-xs-6">
                                <div class="col-xs-5">
                                    <div class="form-group @if ($errors->has('user_picture_url')) has-error @endif">
                                        <div class="img">
                                            <img class="img img-responsive" style="margin-bottom:5px;" width="100"
                                                height="65" id="avatar" @if ($user->user_picture_url) src="{{ $user->user_picture_url }}" @else src="http://nanoup.net/assets/userdata/avatar/thumbs/default-avatar.png" @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="name-field">Service</label>
                                        <span class="form-control">Home Service</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="name-field">Service Area</label>
                                        <span class="form-control">Kota Bogor</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="name-field">Skill Type</label>
                                        <span class="form-control">Interior, Civil, Specialty</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="name-field">Segmentation</label>
                                        <span class="form-control">Low</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-xs-6 ml-2">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="name-field">Nama</label>
                                        <span class="form-control">{{ $user->display_name }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="name-field">Kontak</label>
                                        <span class="form-control">{{ $user->user_phone_number }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="name-field">NIK</label>
                                        <span class="form-control">{{ $user->nik }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="name-field">NPWP</label>
                                        <span class="form-control">{{ $user->npwp }}</span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label for="name-field">No. Rekening</label>
                                        <span class="form-control">{{ $user->bank_account }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Performance
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="radar" style="height: 475px; width: 340px;" height="475" width="500"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <!-- ./col -->

            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Progres Konsulltasi
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach ($progres as $val)
                            @if ($val->status == 'Project Ended')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->order_number }} - {{ $val->description }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>10</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                            @if ($val->status == 'Project Started')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->order_number }} - {{ $val->description }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>8</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: 80%"></div>
                                    </div>
                                </div>
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'Construction Phase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->order_number }} - {{ $val->description }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>6</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: 60%"></div>
                                    </div>
                                </div>
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'Design Phase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->order_number }} - {{ $val->description }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>4</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 40%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'pre-purchase' || $val->status == 'Pre-Purchase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->order_number }} - {{ $val->description }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>2</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 20%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                        @endforeach
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Progres Aplikator
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach ($progresVendor as $val)
                            @if ($val->status == 'Project Ended')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->vendor_name }} - {{ $val->order_number }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>10</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                            @if ($val->status == 'Project Started')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->vendor_name }} - {{ $val->order_number }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>8</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: 80%"></div>
                                    </div>
                                </div>
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'Construction Phase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->vendor_name }} - {{ $val->order_number }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>6</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: 60%"></div>
                                    </div>
                                </div>
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'Design Phase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->vendor_name }} - {{ $val->order_number }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>4</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 40%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'pre-purchase' || $val->status == 'Pre-Purchase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->vendor_name }} - {{ $val->order_number }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>2</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 20%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                        @endforeach
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>

        <div class="row">
            <!-- ./col -->
            {{-- <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Pembayaran Bulanan
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" style="height: 150px; width: 228px;" height="250" width="456"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div> --}}
        </div>

        <div class="row">
            <!-- ./col -->
            {{-- <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Pembayaran Bulanan (IDR)
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="barChartAmount" style="height: 150px; width: 228px;" height="250" width="456"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div> --}}

        </div>
    @endsection
    @section('scripts')
        @parent
        <script type="text/javascript">
            $(function() {
                // $('.select2').select2();

                var dTable = $('#userrange').dataTable({
                    'paging': true,
                    "pageLength": 4,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'responsive': true,
                    'info': true,
                    'scrollX': true
                });

                var config = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [
                                4,
                                6
                            ],
                            backgroundColor: [
                                "#F7464A",
                                "#46BFBD"
                            ],
                        }],
                        labels: [
                            "Home Service",
                            "Home Renovation"
                        ]
                    },
                    options: {
                        responsive: true
                    }
                };

                var configStatus = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [
                                1,
                                2,
                                1,
                                3,
                                5
                            ],
                            backgroundColor: [
                                "#12464A",
                                "#4600BD",
                                "#07424A",
                                "#123655",
                                "#F73300"
                            ],
                        }],
                        labels: [
                            "Pre-Project",
                            "Design",
                            "Construction",
                            "Project Started",
                            "Project Ended"
                        ]
                    },
                    options: {
                        responsive: true
                    }
                };

                const configRadar = {
                    type: 'radar',
                    data: {
                        labels: [
                            'Quality',
                            'Responsiveness to customer',
                            'Responsiveness to mitraruma',
                            'Behavior',
                            'Helpful',
                            'Commitment',
                            'Activeness'
                        ],
                        datasets: [{
                            label: 'Key Performance',
                            data: [5, 4, 3, 3, 2, 4, 4],
                            fill: true,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgb(255, 99, 132)',
                            pointBackgroundColor: 'rgb(255, 99, 132)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgb(255, 99, 132)'
                        }]
                    },
                    options: {
                        elements: {
                            line: {
                                borderWidth: 3
                            }
                        }
                    },
                };

                window.onload = function() {

                    var ctxRadar = document.getElementById("radar").getContext("2d");
                    window.ctxRadar = new Chart(ctxRadar, configRadar);

                    var ctx = document.getElementById("pieChart").getContext("2d");
                    window.myPie = new Chart(ctx, config);

                    var ctxStatus = document.getElementById("pieChartStatus").getContext("2d");
                    window.myPieStatus = new Chart(ctxStatus, configStatus);

                };
            });
        </script>
    @endsection
