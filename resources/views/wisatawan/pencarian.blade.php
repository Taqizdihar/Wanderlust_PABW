<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian</title>
    <link rel="stylesheet" href="{{ asset('css/Home.css') }}">
</head>
<body>
    <main class="main-content">
        <div class="section-title">
            <h2>Hasil Pencarian: "{{ $kataKunci }}"</h2>
            <p class="subtitle">Menampilkan destinasi wisata berdasarkan pencarianmu</p>
        </div>

        @if(count($hasilPencarian) > 0)
            <div class="card-gallery">
                @foreach ($hasilPencarian as $hasil)
                    <div class="cards-destination">
                        <div class="card-images" style="background-image: url('{{ asset('/images/Images/' . $hasil['link_foto']) }}');">
                            <h4>{{ $hasil['nama_lokasi'] }}</h4>
                        </div>
                        <div class="destination-content">
                            <p>{{ $hasil['sumir'] }}</p>
                            <div class="stars">
                                ★★★★☆
                            </div>
                            <a class="card-button" href="{{ url('detailDestinasiWisata?tempatwisata_id=' . $hasil['tempatwisata_id']) }}">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-results">
                <p>Tidak ada hasil ditemukan untuk "<strong>{{ $kataKunci }}</strong>".</p>
                <a href="{{ url('/') }}" class="back-home">Kembali ke Beranda</a>
            </div>
        @endif
    </main>
</body>
</html>