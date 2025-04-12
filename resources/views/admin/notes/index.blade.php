@extends('admin.layouts.master')

@section('title', 'Notlar')

@section('styles')
<style>
    .content nav {
        background: #fff;
        padding: 10px;
        border-radius: 50px;
        box-shadow: 0 0 20px 0 rgba(0,0,0,0.1);
        display: inline-block;
    }

    .content .pagination {
        margin: 0;
        display: flex;
        gap: 5px;
    }

    .content .page-item {
        margin: 0 2px;
    }

    .content .page-item .page-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-weight: 600;
        font-size: 14px;
        color: #666;
        background: transparent;
        border: none;
        transition: all 0.3s ease;
    }

    .content .page-item .page-link:hover {
        background: #f0f0f0;
        color: #2196F3;
    }

    .content .page-item.active .page-link {
        background: #2196F3;
        color: white;
    }

    .content .page-item.disabled .page-link {
        background: transparent;
        color: #ccc;
        cursor: not-allowed;
    }

    .content .page-item:first-child .page-link,
    .content .page-item:last-child .page-link {
        background: #f8f9fa;
    }

    .content .page-item:first-child .page-link:hover,
    .content .page-item:last-child .page-link:hover {
        background: #e9ecef;
    }

    .content .zmdi {
        font-size: 18px;
    }

    /* Mobil cihazlar için responsive tasarım */
    @media (max-width: 576px) {
        .content nav {
            padding: 5px;
            border-radius: 25px;
        }

        .content .page-item .page-link {
            width: 35px;
            height: 35px;
            font-size: 12px;
        }

        .content .zmdi {
            font-size: 16px;
        }
    }
</style>
@endsection 

@section('content')
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
    @if(session()->has('deleted'))
        <div class="alert alert-danger" role="alert">
            {{ session('deleted') }}
        </div>
        <script>
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        </script>
    @endif
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Notlar
                <small class="text-muted">Tüm Notlar</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <a href="{{ route('admin.notes.create') }}" class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10 d-flex align-items-center justify-content-center" type="button">
                    <i class="zmdi zmdi-plus"></i>
                </a>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                    <li class="breadcrumb-item active">Notlar</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            @if($notes->isEmpty())
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <h4>Henüz not eklenmemiş.</h4>
                        </div>
                    </div>
                </div>
            @else
                @foreach($notes as $note)
                    <div class="col-lg-2 col-md-12">
                        <div class="card">
                            @if($note->image_path)
                                <div class="body">
                                    <img src="{{ asset('storage/' . $note->image_path) }}" alt="Not Resmi" class="img-fluid mb-3" style="height: 200px; width: 100%; object-fit: cover;">
                                </div>
                            @endif
                            <div class="body">
                                <h4 class="title">{{ $note->title }}</h4>
                                <p class="m-t-10">{!! Str::limit($note->description, 100) !!}</p>
                                <p class="text-muted"><i class="zmdi zmdi-calendar"></i> {{ $note->date ? $note->date->format('d.m.Y') : 'Tarih Belirtilmemiş' }}</p>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('admin.notes.edit', $note) }}" class="btn btn-info btn-sm">
                                        <i class="zmdi zmdi-edit"></i> Düzenle
                                    </a>
                                    <form action="{{ route('admin.notes.destroy', $note) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu notu silmek istediğinizden emin misiniz?')">
                                            <i class="zmdi zmdi-delete"></i> Sil
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        <!-- Pagination -->
        @if($notes->total() > 12)
            <div class="mt-4" style="display: flex; justify-content: center;">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mb-0">
                        {{-- Önceki sayfa linki --}}
                        @if ($notes->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="zmdi zmdi-arrow-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $notes->previousPageUrl() }}" rel="prev">
                                    <i class="zmdi zmdi-arrow-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Sayfa numaraları --}}
                        @foreach ($notes->getUrlRange(1, $notes->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $notes->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Sonraki sayfa linki --}}
                        @if ($notes->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $notes->nextPageUrl() }}" rel="next">
                                    <i class="zmdi zmdi-arrow-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="zmdi zmdi-arrow-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>
@endsection

