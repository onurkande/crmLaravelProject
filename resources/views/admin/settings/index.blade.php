@extends('admin.layouts.master')

@section('title', 'Site Ayarları')

@section('styles')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }
</style>
@endsection

@section('content')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Site Ayarları
                <small class="text-muted">Site Ayarlarını Düzenle</small>
            </h2>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <ul class="breadcrumb float-md-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item active">Site Ayarları</li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Site</strong> Ayarları</h2>
                </div>
                <div class="body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Uygulama Adı -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Uygulama Adı</label>
                                    <input type="text" name="app_name" class="form-control" value="{{ old('app_name', $settings->app_name) }}" required>
                                    <small class="text-muted">Bu isim, uygulamanızın başlık çubuğunda ve e-postalarda görünecektir.</small>
                                    @error('app_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Logo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Site Logo</label>
                                    @if($settings->logo)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" style="max-height: 100px;">
                                        </div>
                                    @endif
                                    <input type="file" name="logo" class="form-control-file">
                                    @error('logo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Favicon -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Site Favicon</label>
                                    @if($settings->favicon)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $settings->favicon) }}" alt="Favicon" style="max-height: 32px;">
                                        </div>
                                    @endif
                                    <input type="file" name="favicon" class="form-control-file">
                                    @error('favicon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <!-- Mail Ayarları -->
                            <div class="col-md-12">
                                <h4 class="mb-4">Mail Ayarları</h4>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mail Kullanıcı Adı</label>
                                    <input type="email" name="mail_username" class="form-control" value="{{ old('mail_username', $settings->mail_username) }}" required>
                                    @error('mail_username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mail SMTP Şifresi</label>
                                    <input type="password" name="mail_password" class="form-control" value="{{ old('mail_password', $settings->mail_password) }}" required>
                                    <small class="text-muted">Bu şifre, mail sunucunuzun SMTP kimlik doğrulama şifresidir. Normal e-posta şifrenizden farklı olabilir.</small>
                                    @error('mail_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mail Şifreleme</label>
                                    <select name="mail_encryption" class="form-control show-tick" required>
                                        <option value="ssl" {{ old('mail_encryption', $settings->mail_encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                                        <option value="tls" {{ old('mail_encryption', $settings->mail_encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                                    </select>
                                    @error('mail_encryption')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gönderen Mail Adresi</label>
                                    <input type="email" name="mail_from_address" class="form-control" value="{{ old('mail_from_address', $settings->mail_from_address) }}" required>
                                    @error('mail_from_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gönderen Adı</label>
                                    <input type="text" name="mail_from_name" class="form-control" value="{{ old('mail_from_name', $settings->mail_from_name) }}" required>
                                    @error('mail_from_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="footer_content">Footer İçeriği</label>
                            <textarea name="footer_content" id="footer_content" class="form-control">{{ $settings->footer_content }}</textarea>
                            <small class="form-text text-muted">HTML etiketleri kullanabilirsiniz. Örnek: sosyal medya linkleri, iletişim bilgileri vb.</small>
                        </div>

                        <div class="form-group">
                            <label for="terms_of_use">Kullanım Sözleşmesi</label>
                            <textarea name="terms_of_use" id="terms_of_use" class="form-control">{{ $settings->terms_of_use }}</textarea>
                            <small class="form-text text-muted">Kullanım sözleşmesi içeriği. HTML etiketleri kullanabilirsiniz.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h2><strong>Bakım</strong> Modu</h2>
                                    </div>
                                    <div class="body">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group">
                                                    <label class="switch">
                                                        <input type="checkbox" name="maintenance_mode" value="1" {{ $settings->maintenance_mode ? 'checked' : '' }}>
                                                        <span class="slider"></span>
                                                    </label>
                                                    <span class="ml-3">Bakım modunu {{ $settings->maintenance_mode ? 'kapatmak' : 'açmak' }} için tıklayın</span>
                                                    <small class="form-text text-muted d-block mt-2">Bakım modu açıkken sadece admin kullanıcıları siteye erişebilir.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">
                            <i class="zmdi zmdi-save"></i> Ayarları Kaydet
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#footer_content'), {
            toolbar: {
                items: [
                    'undo', 'redo',
                    '|', 'heading',
                    '|', 'bold', 'italic', 'strikethrough', 'underline',
                    '|', 'bulletedList', 'numberedList',
                    '|', 'alignment',
                    '|', 'link', 'blockQuote',
                    '|', 'removeFormat'
                ]
            },
            language: 'tr',
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
        })
        .then(editor => {
            // Editor başarıyla yüklendi
            console.log('Editor yüklendi:', editor);
        })
        .catch(error => {
            console.error('Editor yüklenirken hata oluştu:', error);
        });

    ClassicEditor
        .create(document.querySelector('#terms_of_use'), {
            toolbar: {
                items: [
                    'undo', 'redo',
                    '|', 'heading',
                    '|', 'bold', 'italic', 'strikethrough', 'underline',
                    '|', 'bulletedList', 'numberedList',
                    '|', 'alignment',
                    '|', 'link', 'blockQuote',
                    '|', 'removeFormat'
                ]
            },
            language: 'tr',
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
        })
        .then(editor => {
            console.log('Editor yüklendi:', editor);
        })
        .catch(error => {
            console.error('Editor yüklenirken hata oluştu:', error);
        });
</script>
@endsection 