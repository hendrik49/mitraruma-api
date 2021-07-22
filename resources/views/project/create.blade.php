@extends('layouts.global')

@section('title')Tambah Donasi 
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
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<div class="box">
				<div class="box-body">

					<h2 align="center">Tambahkan Donasi</h2>
					<form action="{{route('manage-donasi-user.store')}}" method="POST" class="shadow-sm p-3 bg-white" enctype="multipart/form-data">
						@csrf
						<br>
						<label for="title">No Donasi</label> <br>
						<input type="text" class="form-control" name="invoice" placeholder="Masukkan no donasi" value="{{ $invoice }}" readonly>
						<br>
						<label for="title">Nama Donatur</label> <br>
						<input type="text" class="form-control" name="nama" placeholder="Masukkan nama donatur" value="{{ old('nama') }}" required>
						<br>
						<label for="title">Email Donatur</label> <br>
						<input type="email" class="form-control" name="email" placeholder="Masukkan email donatur" value="{{ old('email') }}" required>
						<br>
						<label for="title">No. Telepon</label> <br>
						<input type="text" class="form-control" name="nohp" placeholder="Masukkan no telepon" value="{{ old('nohp') }}" required>
						<br>
						<label for="title">Nama Campaign</label> <br>
						<select name="campaign" class="form-control" required>
							<option hidden>--Pilih campaign--</option>
							@foreach($campaigns as $campaign)
							<option value="{{$campaign->id}}">{{$campaign->nama_kegiatan}}</option>
							@endforeach
						</select>
						<br>
						<label for="title">Jumlah Donasi (Rp)</label> <br>
						<input type="number" min="1" class="form-control" name="jumlah" placeholder="Masukkan jumlah donasi" onkeypress="return isNumberKey(event)" value="{{ old('jumlah') }}" required>
						<br>
						<label for="title">Tgl Donasi</label> <br>
						<input type="date" class="form-control" id="tgl_donasi" name="tgl_donasi" placeholder="Masukkan tanggal donasi" value="{{ old('tgl_donasi') }}" required>
						<br>
						<label for="cover">Bukti Bayar</label>
						<input type="file" class="form-control" name="bukti_bayar" value="{{ old('bukti_bayar') }}" accept="image/*">
						<small class="text-muted">Format Image:png,jpg</small>
						<br>
						<label for="title">Status</label> <br>
						<select class="form-control" id="status" name="status" required>
							<option value="verified">verified</option>
							<option value="pending">pending</option>
							<option value="cancel">cancel</option>
							<option value="expire">expire</option>
							<option value="success">paid</option>
						</select>
						<br>
						<button class="btn btn-primary btn-flat" name="save_action" value="PUBLISH">Publish</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script>
 document.getElementById("tgl_donasi").valueAsDate = new Date();
 function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

      return true;
    }

    function isDecimalKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 46 || charCode > 57))
        return false;

      return true;
    } 
</script>
@endsection
