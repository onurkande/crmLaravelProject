@extends('admin.layouts.master')

@section('title', 'Komisyon Hesaplama')

@section('styles')
<style>
    .commission-form .form-group {
        margin-bottom: 1.5rem;
    }
    .commission-table th {
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('content')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Komisyon Hesaplama
                <small class="text-muted">Danışman Komisyon Hesaplama Aracı</small>
            </h2>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <ul class="breadcrumb float-md-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item active">Komisyon Hesaplama</li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Komisyon</strong> Hesaplama Formu</h2>
                </div>
                <div class="body">
                    @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                        </div>
                        <script>
                            setTimeout(function() {
                                $('.alert').fadeOut();
                            }, 5000);
                        </script>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <script>
                            setTimeout(function() {
                                $('.alert').fadeOut();
                            }, 5000);
                        </script>
                    @endif

                    <form action="{{ route('admin.commissions.calculate') }}" method="POST" class="commission-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fiyat (£)</label>
                                    <input type="number" name="price" class="form-control" step="0.01" min="0" required value="{{ old('price') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Danışman</label>
                                    <select name="consultant_id" class="form-control show-tick" required>
                                        <option value="">Seçiniz</option>
                                        @foreach($consultants as $consultant)
                                            <option value="{{ $consultant->id }}" {{ old('consultant_id') == $consultant->id ? 'selected' : '' }}>
                                                {{ $consultant->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Komisyon Yüzdesi (%)</label>
                                    <input type="number" name="percentage" class="form-control" step="0.01" min="0" max="100" required value="{{ old('percentage') }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary mr-2">Hesapla</button>
                            @if($commissions->count() > 0)
                                <a href="{{ route('admin.commissions.clear') }}" 
                                   onclick="return confirmClear(event)" 
                                   class="btn btn-danger">
                                    <i class="zmdi zmdi-delete"></i> Tümünü Temizle
                                </a>
                            @endif
                        </div>
                    </form>

                    <div class="table-responsive mt-4">
                        @if($commissions->count() > 0)
                            <div class="mb-3">
                                <a href="{{ route('admin.commissions.export') }}" class="btn btn-success">
                                    <i class="zmdi zmdi-file-text"></i> Excel'e Aktar
                                </a>
                            </div>
                        @endif
                        <table class="table table-hover commission-table">
                            <thead>
                                <tr>
                                    <th>Danışman</th>
                                    <th>Fiyat</th>
                                    <th>Yüzde</th>
                                    <th>Komisyon Tutarı</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commissions as $commission)
                                    <tr>
                                        <td>{{ $commission->consultant->name }}</td>
                                        <td>{{$commission->formatted_price}}</td>
                                        <td>%{{ number_format($commission->percentage, 2, ',', '.') }}</td>
                                        <td>{{$commission->formatted_commission_amount}}</td>
                                        <td>{{ $commission->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.commissions.edit', $commission) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Düzenle
                                            </a>
                                            <form action="{{ route('admin.commissions.destroy', $commission) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu komisyonu silmek istediğinizden emin misiniz?')">
                                                    <i class="fas fa-trash"></i> Sil
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination-wrapper">
                        {{ $commissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection 