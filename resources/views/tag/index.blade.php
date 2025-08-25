@extends('layouts.app')

@section('titulo')
    Crear Tag
@endsection

@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Tag</div>
                <div class="card-body">
                    <form method="POST" id="fcreate" style="display: block;" action="{{ route('tag.store') }}">
                        @csrf
                        <input type="hidden" id="tag_id" name="tag_id" value="">
                        <input type="hidden" name="_method" value="POST"> 
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fdo" class="col-md-4 col-form-label text-md-right">Fondo</label>
                            <div class="col-md-6">
                                <input id="fdo" type="text" class="form-control @error('fdo') is-invalid @enderror" name="fdo" value="{{ old('fdo') }}" required autocomplete="fdo" autofocus>
                                @error('fdo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4" style="display: flex;">
    <button type="submit" class="btn btn-primary" id="btn-create">
        {{ __('Crear') }}
    </button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" id="fupdate" style="display: none;"  action="{{ route('tag.update') }}">   
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="tag_idi" name="tag_idi" value="">
                        <div class="form-group row">
                            <label for="namei" class="col-md-4 col-form-label text-md-right">{{ __('Namei') }}</label>
                            <div class="col-md-6">
                                <input id="namei" type="text" class="form-control @error('namei') is-invalid @enderror" name="namei" value="{{ old('namei') }}" required autocomplete="namei" autofocus>
                                @error('namei')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fdoi" class="col-md-4 col-form-label text-md-right">Fondo</label>
                            <div class="col-md-6">
                                <input id="fdoi" type="text" class="form-control @error('fdoi') is-invalid @enderror" name="fdoi" value="{{ old('fdoi') }}" required autocomplete="fdoi" autofocus>
                                @error('fdoi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4" style="display: flex;">
                                <button type="submit" class="btn btn-primary" id="btn-save" style="display: none;">
        {{ __('Guardar cambios') }}
    </button>
    <button type="button" class="btn btn-secondary" id="btn-cancel" style="display: none;">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container tag-container">
    @foreach ($tags->sortBy('name') as $tag)
        <a href="#" class="tag edit-form" data-tag-id="{{ $tag->id }}" data-tag-name="{{ $tag->name }}" data-tag-fdo="{{ $tag->fdo }}">{{ $tag->name }}</a>
    @endforeach
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tags = document.querySelectorAll('.tag');
        const editForms = document.querySelectorAll('.edit-form');
        const tagIdInput = document.getElementById('tag_idi');
        const nameInput = document.getElementById('namei');
        const fdoInput = document.getElementById('fdoi');
        const btnSave = document.getElementById('btn-save');
        const btnCancel = document.getElementById('btn-cancel');
        const btnCreate = document.getElementById('btn-create');
        const form = document.getElementById('fcreate');
        const formu = document.getElementById('fupdate');

        tags.forEach((tag) => {
            tag.addEventListener('click', function (event) {
                event.preventDefault();
                const tagId = this.dataset.tagId;
                const tagName = this.dataset.tagName;
                const tagFdo = this.dataset.tagFdo;

                tagIdInput.value = tagId;
                nameInput.value = tagName;
                fdoInput.value = tagFdo;

                formu.style.display='block'
                
                btnSave.style.display = 'block';
                btnCancel.style.display = 'block';
                form.style.display='none';
            });
        });

        btnSave.addEventListener('click', function (event) {
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
        });

        btnCancel.addEventListener('click', function (event) {
            event.preventDefault();

            form.dataset.mode = 'fcreate';
            form.action = '{{ route('tag.store') }}';
            tagIdInput.value = '';
            nameInput.value = '';
            fdoInput.value = '';

            form.style.display='block';
            btnCreate.style.display = 'block';
            btnSave.style.display = 'none';
            btnCancel.style.display = 'none';
            formu.style.display='none'
        });
    });
</script>

@endsection
