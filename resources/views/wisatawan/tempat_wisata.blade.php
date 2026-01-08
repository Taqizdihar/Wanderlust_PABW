@extends('layout')

@section('title', 'Kelola Tempat Wisata')

@section('content')
 <h1>Daftar Tempat Wisata</h1>

  <table>
    <thead>
      <tr>
         <th>No</th>
        <th>Nama Tempat</th>
        <th>Lokasi</th>
        <th>Harga Tiket</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data_wisata as $index => $wisata)
        <tr>
         <td>{{ $index + 1 }}</td>
          <td>{{ $wisata['nama'] }}</td>
          <td>{{ $wisata['lokasi'] }}</td>

         <td>Rp{{ number_format($wisata['harga'], 0, ',', '.') }}</td>
          <td>
                <span class="badge {{ $wisata['status'] == 'Selesai' ? 'success' : 'warning' }}">
                    {{ $wisata['status'] }}
                </span>
            </td>
         <td>
             <a href="{{ route('verifikasi.detail', $wisata['id']) }}" class="btn" style="background: #17a2b8;">
                Verifikasi
            </a>
         </td>
         </tr>
         @endforeach
    </tbody>
  </table>
@endsection