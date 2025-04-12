@extends('admin.layouts.master')

@section('title', 'Not Düzenle')

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
            {{ session()->get('deleted') }}
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
                <h2>Not Düzenle
                    <small class="text-muted">Not Düzenle</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.notes.index') }}"><i class="zmdi zmdi-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.notes.index') }}">Notlar</a></li>
                    <li class="breadcrumb-item active">Not Düzenle</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2 style="color: #2196F3; font-weight: 600;">Not Düzenle</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('admin.notes.update', $note) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Not Başlığı</label>
                                <input type="text" name="title" class="form-control" value="{{ $note->title }}" required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Not Açıklaması</label>
                                <textarea name="description" id="editor" class="form-control">{{ old('description', $note->description) }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            @if($note->image_path)
                                <div class="form-group">
                                    <label>Mevcut Resim</label>
                                    <div>
                                        <img src="{{ asset('storage/' . $note->image_path) }}" alt="Not Resmi" style="max-width: 200px;" class="img-thumbnail">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Not Resmi {{ $note->image_path ? '(Değiştirmek için seçin)' : '' }}</label>
                                <input type="file" name="image" class="form-control">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Durum</label>
                                <select name="status" class="form-control show-tick">
                                    <option value="1" {{ $note->status ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ !$note->status ? 'selected' : '' }}>Pasif</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tarih</label>
                                <input type="date" name="date" class="form-control" value="{{ old('date', $note->date ? $note->date->format('Y-m-d') : date('Y-m-d')) }}">
                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Güncelle</button>
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