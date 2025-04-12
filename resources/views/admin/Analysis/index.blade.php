@extends('admin.layouts.master')

@section('title', 'Analiz Paneli')

@section('content')

<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Analiz Paneli
                <small class="text-muted">{{ $isAdmin ? 'Genel İstatistikler ve Raporlar' : 'Kişisel İstatistikler ve Raporlar' }}</small>
            </h2>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <ul class="breadcrumb float-md-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item active">Analiz</li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Sayısal İstatistikler -->
    <div class="row clearfix">
        <div class="col-lg-{{ $isAdmin ? '3' : '6' }} col-md-6">
            <div class="card">
                <div class="body">
                    <h3 class="mt-0 mb-0">{{ $totalAdvertisements ?? 0 }}</h3>
                    <p class="text-muted">{{ $isAdmin ? 'Toplam İlan Sayısı' : 'Toplam Eklediğiniz İlan Sayısı' }}</p>
                    <div class="progress">
                        <div class="progress-bar l-amber" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        @if($isAdmin)
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <h3 class="mt-0 mb-0">{{ $totalAgencies ?? 0 }}</h3>
                    <p class="text-muted">Toplam Acenta Sayısı</p>
                    <div class="progress">
                        <div class="progress-bar l-blue" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <h3 class="mt-0 mb-0">{{ $totalAdmins ?? 0 }}</h3>
                    <p class="text-muted">Toplam Admin Sayısı</p>
                    <div class="progress">
                        <div class="progress-bar l-purple" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="body">
                    <h3 class="mt-0 mb-0">{{ $totalConsultants ?? 0 }}</h3>
                    <p class="text-muted">Toplam Danışman Sayısı</p>
                    <div class="progress">
                        <div class="progress-bar l-green" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="body">
                    <h3 class="mt-0 mb-0">{{ $totalSoldAdvertisements ?? 0 }}</h3>
                    <p class="text-muted">Toplam Sattığınız İlan Sayısı</p>
                    <div class="progress">
                        <div class="progress-bar l-green" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Satış İstatistikleri -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Satış</strong> İstatistikleri</h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <h3 class="mt-0 mb-0">{{ $totalEarnings ?? 0 }} £</h3>
                                    <p class="text-muted">{{$isAdmin ? 'Toplam Kazanç' : 'Toplam Sattığınız İlanlardan Elde Ettiğiniz Kazanç'}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <h3 class="mt-0 mb-0">{{ $totalSoldAdvertisements }}</h3>
                                    <p class="text-muted">{{ $isAdmin ? 'Toplam Satılan İlanlar' : 'Toplam Sattığınız İlanlar' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <h3 class="mt-0 mb-0">{{ $soldByRoomType['1+0'] ?? 0 }}</h3>
                                    <p class="text-muted">{{ $isAdmin ? 'Satılan 1+0 Evler' : 'Sattığınız 1+0 Evler' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <h3 class="mt-0 mb-0">{{ $soldByRoomType['1+1'] ?? 0 }}</h3>
                                    <p class="text-muted">{{ $isAdmin ? 'Satılan 1+1 Evler' : 'Sattığınız 1+1 Evler' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <h3 class="mt-0 mb-0">{{ $soldByRoomType['2+1'] ?? 0 }}</h3>
                                    <p class="text-muted">{{ $isAdmin ? 'Satılan 2+1 Evler' : 'Sattığınız 2+1 Evler' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <h3 class="mt-0 mb-0">{{ $soldByRoomType['3+1'] ?? 0 }}</h3>
                                    <p class="text-muted">{{ $isAdmin ? 'Satılan 3+1 Evler' : 'Sattığınız 3+1 Evler' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <h3 class="mt-0 mb-0">{{ $soldByRoomType['villa'] ?? 0 }}</h3>
                                    <p class="text-muted">{{ $isAdmin ? 'Satılan Villalar' : 'Sattığınız Villalar' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablolar -->
    <div class="row clearfix">
        <!-- Son Eklenen İlanlar -->
        <div class="col-lg-{{ $isAdmin ? '4' : '6' }} col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Son Eklenen</strong> {{ $isAdmin ? 'İlanlar' : 'İlanlarınız' }}</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>İlan Adı</th>
                                    <th>Fiyat</th>
                                    <th>Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAdvertisements as $ad)
                                <tr>
                                    <td>{{ $ad ? Str::limit($ad->name, 20) : 'İlan Silinmiş' }}</td>
                                    <td>{{ $ad ? number_format($ad->price, 2) : '0.00' }} £</td>
                                    <td>{{ $ad && $ad->created_at ? $ad->created_at->format('d.m.Y') : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Son Satılan İlanlar -->
        <div class="col-lg-{{ $isAdmin ? '4' : '6' }} col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Son Satılan</strong> {{ $isAdmin ? 'İlanlar' : 'İlanlarınız' }}</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>İlan Adı</th>
                                    <th>Fiyat</th>
                                    <th>Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentlySoldAdvertisements as $ad)
                                <tr>
                                    <td>{{ $ad ? Str::limit($ad->name, 20) : 'İlan Silinmiş' }}</td>
                                    <td>{{ $ad ? number_format($ad->price, 2) : '0.00' }} £</td>
                                    <td>{{ $ad && $ad->updated_at ? $ad->updated_at->format('d.m.Y') : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if($isAdmin)
        <!-- Son Eklenen Notlar -->
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Son Eklenen</strong> Notlar</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Not</th>
                                    <th>Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentNotes as $note)
                                <tr>
                                    <td>{!! $note ? Str::limit($note->description, 20) : 'Not Silinmiş' !!}</td>
                                    <td>{{ $note && $note->created_at ? $note->created_at->format('d.m.Y') : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
