@extends('admin.layouts.master')

@section('title', 'Not Ekle')

@section('styles')
<style>
    /* CKEditor için stil düzenlemeleri */
    .ck-editor__editable {
        min-height: 200px;
        max-height: 400px;
    }
    .ck-editor__editable:focus {
        border-color: #2196F3 !important;
    }
</style>
@endsection

@section('content')
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Not Ekle
                    <small class="text-muted">Yeni Not Ekle</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.notes.index') }}"><i class="zmdi zmdi-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.notes.index') }}">Notlar</a></li>
                    <li class="breadcrumb-item active">Not Ekle</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2 style="color: #2196F3; font-weight: 600;">Yeni Not Ekle</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('admin.notes.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>Not Başlığı</label>
                                <input type="text" name="title" class="form-control" required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Not Açıklaması</label>
                                <textarea name="description" id="editor" class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Not Resmi</label>
                                <input type="file" name="image" class="form-control">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Durum</label>
                                <select name="status" class="form-control show-tick">
                                    <option value="1">Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tarih</label>
                                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}">
                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Kaydet</button>
                            <a href="{{ route('admin.notes.index') }}" class="btn btn-secondary">İptal</a>
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
        .create(document.querySelector('#editor'), {
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
</script>
@endsection 
