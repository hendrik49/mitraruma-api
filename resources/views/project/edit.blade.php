@extends('layouts.global')

@section('title')Edit donasi
@endsection

@section('content')

<div class="row">
	<div class="container col-sm-12">
		<div class="col-md-10">
			@if(session('status'))
			<div class="alert alert-success">
				{{session('status')}}
			</div>
			@elseif(session('gagal'))
			<div class="alert alert-danger">
				{{session('gagal')}}
			</div>
			@endif
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Errors!</strong>
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<div class="box">
				<div class="box-body">
					<h2 align="center">Edit Donasi</h2>
					<form action="{{route('manage-donasi-user.update', ['id' => $donasi->id ])}}" method="POST" class="shadow-sm p-3 bg-white" enctype="multipart/form-data">
						@csrf
						<br>
						<label for="title">No Donasi</label> <br>
						<input type="text" class="form-control" name="invoice" placeholder="Masukkan no donasi" value="{{ $donasi->invoice }}" readonly>
						<br>
						<label for="title">Nama Donatur</label> <br>
						<input type="text" class="form-control" name="nama" placeholder="Masukkan nama donatur" value="{{ $donasi->nama }}" required>
						<br>
						<label for="title">Email Donatur</label> <br>
						<input type="email" class="form-control" name="email" placeholder="Masukkan email donatur" value="{{ $donasi->email }}" required>
						<br>
						<label for="title">No. Telepon</label> <br>
						<input type="text" class="form-control" name="nohp" placeholder="Masukkan no telepon" value="{{ $donasi->nohp }}" required>
						<br>
						<label for="title">Nama Campaign</label> <br>
						<select name="campaign" class="form-control" required>
							<option hidden>--Pilih campaign--</option>
							@foreach($campaigns as $campaign)
							<option value="{{$campaign->id}}" @if($donasi->campaign_id==$donasi->campaign_id) selected='selected' @endif>{{$campaign->nama_kegiatan}}</option>
							@endforeach
						</select>
						<br>
						<label for="title">Jumlah Donasi (Rp)</label> <br>
						<input type="number" min="1" class="form-control" name="jumlah" placeholder="Masukkan jumlah donasi"  onkeypress="return isNumberKey(event)" value="{{ $donasi->jumlah }}" required>
						<br>
						<label for="title">Tgl Donasi</label> <br>
						<input type="date" class="form-control" id="tgl_donasi" name="tgl_donasi" placeholder="Masukkan tanggal donasi" value="{{ $donasi->created_at }}" required>
						<br>
						<label for="cover">Bukti Bayar</label>
						<input type="file" class="form-control" name="bukti_bayar" value="{{ $donasi->foto }}" accept="image/*">
						@if($donasi->foto)
						<img src="{{asset('storage/' . $donasi->foto)}}" width="320px" />
						@endif
						<small class="text-muted">Format Image:png,jpg</small>
						<br>
						<label for="title">Status</label> <br>
						<select class="form-control" id="status" name="status" required>
							<option value="verified" @if($donasi->status=='verified') selected='selected' @endif>verified</option>
							<option value="pending" @if($donasi->status=='pending') selected='selected' @endif>pending</option>
							<option value="cancel" @if($donasi->status=='cancel') selected='selected' @endif>cancel</option>
							<option value="expire" @if($donasi->status=='expire') selected='selected' @endif>expire</option>
							<option value="success" @if($donasi->status=='success') selected='selected' @endif>paid</option>
						</select>
						<br>
						<input type="hidden" value="PUT" name="_method">
						<button class="btn btn-primary btn-flat" name="save_action" value="PUBLISH">Publish</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
 document.getElementById("tgl_donasi").valueAsDate = new Date();
</script>
@stop
