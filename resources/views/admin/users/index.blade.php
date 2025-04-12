@extends('admin.layouts.master')

@section('title', 'Kullanıcılar')

@section('styles')
    <style>
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .badge-user-type {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
        }
        .badge-admin { background: #dc3545; color: white; }
        .badge-sales_consultant { background: #28a745; color: white; }
        .badge-agency { background: #17a2b8; color: white; }
        .badge-user { background: #6c757d; color: white; }

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
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Kullanıcılar
                    <small class="text-muted">Kullanıcı Listesi</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                    <li class="breadcrumb-item active">Kullanıcılar</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Kullanıcı</strong> Listesi</h2>
                        <ul class="header-dropdown">
                            <li>
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Yeni Kullanıcı</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                            <script>
                                setTimeout(function() {
                                    $('.alert').fadeOut();
                                }, 5000);
                            </script>
                        @endif

                        @if(session()->has('deleted'))
                            <div class="alert alert-warning">
                                {{ session()->get('deleted') }}
                            </div>
                            <script>
                                setTimeout(function() {
                                    $('.alert').fadeOut();
                                }, 5000);
                            </script>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Profil</th>
                                        <th>Ad Soyad</th>
                                        <th>E-posta</th>
                                        <th>Kullanıcı Tipi</th>
                                        <th>Kayıt Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('assets/images/default-avatar.png') }}" 
                                                     alt="Profil" class="user-avatar">
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge badge-user-type badge-{{ $user->user_type }}">
                                                    @switch($user->user_type)
                                                        @case('admin')
                                                            Admin
                                                            @break
                                                        @case('user')
                                                            Yeni Kullanıcı
                                                            @break
                                                        @case('sales_consultant')
                                                            Satış Danışmanı
                                                            @break
                                                        @case('agency')
                                                            Acenta
                                                            @break
                                                        @default
                                                            {{ ucfirst($user->user_type) }}
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Kullanıcıyı silmek istediğinize emin misiniz?')">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($users->total() > 10)
                            <div class="mt-4" style="display: flex; justify-content: center;">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center mb-0">
                                        {{-- Önceki sayfa linki --}}
                                        @if ($users->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link"><i class="zmdi zmdi-arrow-left"></i></span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">
                                                    <i class="zmdi zmdi-arrow-left"></i>
                                                </a>
                                            </li>
                                        @endif
                
                                        {{-- Sayfa numaraları --}}
                                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                            <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach
                
                                        {{-- Sonraki sayfa linki --}}
                                        @if ($users->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">
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
                </div>
            </div>
        </div>
    </div>
@endsection 