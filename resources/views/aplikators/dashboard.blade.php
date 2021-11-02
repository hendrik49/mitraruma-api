@extends('layouts.app')
@section('title') Overview Data @endsection
@section('content')
    <section class="content">
        <!-- Small boxes (Stat box) -->
        {{-- @if (Auth::user()->user_type == 'admin')
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
                            <table class="table dt-dashboard" id="userrange">
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
                                            <td>{{ $review->ID }}</td>
                                            <td>{{ $review->display_name }}</td>
                                            <td>{{ $review->capacity }} </td>
                                            <td>{{ $review->projects->where('status', '<>', 'project ended')->count() }}
                                            </td>
                                            <td>{{ ($review->projects->where('status', '<>', 'project ended')->count() / $review->capacity) * 100 }}
                                            </td>
                                            <td>{{ round($review->review['overall_score'], 2) ?? '' }} </td>
                                            <td>{{ $review->review['quality'] ?? '' }}
                                                {{ $review->review['responsiveness_to_customer'] ?? '' }}
                                                {{ $review->review['responsiveness_to_mitraruma'] ?? '' }}
                                                {{ $review->review['helpful'] ?? '' }}
                                                {{ $review->review['behaviour'] ?? '' }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif --}}
        <div class="row mt-2">
            <!-- ./col -->
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-user mr-1"></i>
                            Profil
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-xs-6">
                                <div class="col-xs-5">
                                    <div class="form-group @if ($errors->has('user_picture_url')) has-error @endif">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <div class="img">
                                            <img class="img img-responsive" style="margin-bottom:5px;" width="100"
                                                height="75" id="avatar" @if ($user->user_picture_url) src="{{ $user->user_picture_url }}" @else src="http://nanoup.net/assets/userdata/avatar/thumbs/default-avatar.png" @endif>
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
                                        <select class="form-control" id="coverage-area-field" name="area-coverage">
                                            @if ($user->extension->where('name', 'Coverage')->first())
                                                @foreach ($user->extension->where('name', 'Coverage')->first()->value as $p)
                                                    <option value="{{ $p }}">{{ $p }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="name-field">Skill Type</label>
                                        <select multiple class="form-control select2" id="skill_set-field"
                                            name="skill_set[]" disabled>
                                            @if ($user->extension->where('name', 'SKILLSET')->first())
                                                @foreach ($masters->where('name', 'skill-set')->first()->value as $p)
                                                    <option @if (in_array($p['name'], $user->extension->where('name', 'SKILLSET')->first()->value)) selected @endif value="{{ $p['name'] }}">
                                                        {{ $p['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="name-field">Segmentation</label>
                                        <select class="form-control select2" multiple id="coverage-area-field"
                                            name="skill_set" disabled>
                                            @if ($user->extension->where('name', 'segment')->first())
                                                @foreach ($masters->where('name', 'segment')->first()->value as $p)
                                                    <option @if (in_array($p['name'], $user->extension->where('name', 'segment')->first()->value)) selected @endif value="{{ $p['code'] }}">
                                                        {{ $p['name'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
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
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Konsultasi By Tipe Status
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChartStatus" style="height: 375px; width: 340px;" height="375" width="500"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Konsultasi By Tipe Service
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart" style="height: 375px; width: 340px;" height="375" width="500"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Portfolio
                        </h3>
                    </div>
                    <div class="card-body">
                        @if ($user->portfolio)
                            @if (true)
                                <div class="img mt-2">
                                    <embed src="{{ $user->portfolio }}" width="450" height="375">
                                </div>
                            @else
                                <div class="img mt-2">
                                    <img class="img img-responsive" style="margin-bottom:5px;" width="100" height="100"
                                        id="avatar" @if ($user->portfolio) src="{{ $user->portfolio }}" @endif>
                                </div>
                            @endif
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Kapasitas
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" style="height: 375px; width: 340px;" height="375" width="500"></canvas>
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
                            Progres Konsultasi
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach ($progres as $val)
                            @if ($val->status == 'Project Ended' || $val->status == 'project ended')
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
                            @if ($val->status == 'Project Started' || $val->status == 'project started')
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
                            @if ($val->status == 'Construction Phase' || $val->status == 'construction phase')
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
                            @if ($val->status == 'Design Phase' || $val->status == 'design phase')
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
                            @if ($val->status == 'pre purchase' || $val->status == 'Pre-Purchase')
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
                            Konsultasi Berakhir
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-table mr-1"></i>
                            Daftar Proyek
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped dt-dashboard" id="projectrange">
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
                                    <th>date</th>
                                    <th>sub status</th>
                                    <th>description</th>
                                    <th>location</th>
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
                                        <td>{{ $project->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $project->project_note }}</td>
                                        <td>{{ $project->description }}</td>
                                        <td>{{ $project->street }}</td>
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
    @php
        // charting
        $pieStatusLabel = $pieStatus->pluck('label');
        $pieStatusValue = $pieStatus->pluck('value');
        
        $pieLabel = $pie->pluck('label');
        $pieValue = $pie->pluck('value');
        
        $stackBarData = [];
        foreach ($pie as $p) {
            $el = [];
            $el['label'] = $p->label;
            $el['data'] = [0, $p->value];
            $el['backgroundColor'] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $stackBarData[] = $el;
        }
        if($pf){
            $per = json_encode([$pf->quality ?? 0, $pf->responsiveness_to_customer ?? 0, $pf->responsiveness_to_mitraruma ?? 0, $pf->behaviour ?? 0, $pf->helpful ?? 0, $pf->commitment ?? 0, $pf->activeness ?? 0]);
            $overall = round(($pf->quality + $pf->responsiveness_to_customer + $pf->responsiveness_to_mitraruma + $pf->behaviour + $pf->helpful + $pf->commitment + $pf->activeness) / 7);
        }else{
            $per = json_encode(0, 0, 0, 0, 0, 0, 0]);
            $overall = 0;
        }
    @endphp
    @section('scripts')
        @parent
        <script type="text/javascript">
            $(function() {
                $('.select2').select2();

                var dTable = $('.dt-dashboard').dataTable({
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
                            data: <?php echo $pieStatusValue; ?>,
                            backgroundColor: [
                                "#F7464A",
                                "#46BFBD"
                            ],
                        }],
                        labels: <?php echo $pieStatusLabel; ?>

                    },
                    options: {
                        responsive: true
                    }
                };

                var configStatus = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: <?php echo $pieValue; ?>,
                            backgroundColor: [
                                "#12464A",
                                "#4600BD",
                                "#07424A",
                                "#123655",
                                "#F73300"
                            ],
                        }],
                        labels: <?php echo $pieLabel; ?>
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
                            label: 'Overall Score: {{ $overall }}',
                            data: <?php echo $per; ?>,
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

                var data = <?php echo json_encode($stackBarData); ?>;
                var configBar = {
                    type: 'bar',
                    data: {
                        labels: ['',
                            'Capacity'
                        ],
                        datasets: data
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'right' // place legend on the right side of chart
                        },
                        scales: {
                            xAxes: [{
                                stacked: true // this should be set to make the bars stacked
                            }],
                            yAxes: [{
                                stacked: true // this also..
                            }]
                        }
                    }
                };

                window.onload = function() {

                    var ctxRadar = document.getElementById("radar").getContext("2d");
                    window.ctxRadar = new Chart(ctxRadar, configRadar);

                    var ctx = document.getElementById("pieChart").getContext("2d");
                    window.myPie = new Chart(ctx, config);

                    var ctxStatus = document.getElementById("pieChartStatus").getContext("2d");
                    window.myPieStatus = new Chart(ctxStatus, configStatus);

                    var ctxBar = document.getElementById("barChart").getContext("2d");
                    window.myBar = new Chart(ctxBar, configBar);


                };
            });
        </script>
    @endsection
