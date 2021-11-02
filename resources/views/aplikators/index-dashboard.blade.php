@extends('layouts.app')
@section('title') Overview Data @endsection
@section('content')
    <section class="content">
        <!-- Small boxes (Stat box) -->
        @if (Auth::user()->user_type == 'admin')
            <div class="row">
                <div class="col-md-3 mt-3">
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
                <div class="col-md-9 mt-3">
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aplikators as $key => $review)
                                        <tr>
                                            <td>{{ $review->ID }}</td>
                                            <td>{{ $review->display_name }}</td>
                                            <td>{{ $review->capacity }} </td>
                                            <td>{{ $review->projects->where('status', '<>', 'Project Ended')->count() }}
                                            </td>
                                            <td>{{ ($review->projects->where('status', '<>', 'Project Ended')->count() / $review->capacity) * 100 }}
                                            </td>
                                            <td>{{ round($review->review['overall_score'], 2) ?? '' }} </td>
                                            <td>{{ $review->review['quality'] ?? '' }}
                                                {{ $review->review['responsiveness_to_customer'] ?? '' }}
                                                {{ $review->review['responsiveness_to_mitraruma'] ?? '' }}
                                                {{ $review->review['helpful'] ?? '' }}
                                                {{ $review->review['behaviour'] ?? '' }} </td>
                                            <td>
                                                <a href="{{ url('admin/aplikator-dashboard', ['id' => $review->ID]) }}"
                                                    class="btn btn-sm btn-warning"> <i
                                                        class="glyphicon glyphicon-eye-open"></i>
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
        @endif
    @endsection
    @section('scripts')
        @parent
        <script type="text/javascript">
            $(function() {

                var dTable = $('.dt-dashboard').dataTable({
                    'paging': true,
                    "pageLength": 4,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'responsive': true,
                    'info': true,
                    'scrollX': true,
                    'dom': 'Bfrtip',
                    'buttons': [{
                        extend: 'excel'
                    }]
                });
            });
        </script>
    @endsection
