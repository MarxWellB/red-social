@extends('layouts.app')

@section('titulo')
    Enlaces
@endsection

@section('contenido')
<div class="container">
    <form method="POST" id="fcreate" style="display: block;" action="{{ route('store.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de la tienda') }}</label>
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
            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo de la tienda') }}</label>
            <div class="col-md-6">
                <input id="logo" type="text" class="form-control @error('logo') is-invalid @enderror" name="logo" required>
                @error('logo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="fdo" class="col-md-4 col-form-label text-md-right">{{ __('Fondo') }}</label>
            <div class="col-md-6">
                <input id="fdo" type="text" class="form-control @error('fdo') is-invalid @enderror" name="fdo" value="{{ old('fdo') }}" required autocomplete="fdo">
                @error('fdo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary" id="btn-create">
                    {{ __('Crear') }}
                </button>
            </div>
        </div>
    </form>
    <form method="POST" id="fupdate" style="display: none;" action="{{ route('store.update')}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" id="tag_idi" name="tag_idi" value="">
        <div class="form-group row">
            <label for="namei" class="col-md-4 col-form-label text-md-right">{{ __('Nombre de la tienda') }}</label>
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
            <label for="logoi" class="col-md-4 col-form-label text-md-right">{{ __('Logo de la tienda') }}</label>
            <div class="col-md-6">
                <input id="logoi" type="text" class="form-control @error('logoi') is-invalid @enderror" name="logoi" accept="image/*">
                @error('logoi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="fdoi" class="col-md-4 col-form-label text-md-right">{{ __('Fondo') }}</label>
            <div class="col-md-6">
                <input id="fdoi" type="text" class="form-control @error('fdoi') is-invalid @enderror" name="fdoi" value="{{ old('fdoi') }}" required autocomplete="fdoi">
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
                <button type="button" class="btn btn-secondary ml-2" id="btn-cancel" style="display: none;">{{ __('Cancelar') }}</button>
            </div>
        </div>
    </form>

    <div class="container tag-container">
        @foreach ($stores->sortBy('name') as $store)
            <a href="#" class="tag edit-form" data-tag-id="{{ $store->id }}" data-tag-name="{{ $store->nombre }}" data-tag-fdo="{{ $store->fdo }}">{{ $store->nombre }}</a>
        @endforeach
    </div>
</div>

   
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tags = document.querySelectorAll('.tag');
        const tagIdInput = document.getElementById('tag_idi');
        const nameInput = document.getElementById('namei');
        const fdoInput = document.getElementById('fdoi');
        const btnSave = document.getElementById('btn-save');
        const btnCancel = document.getElementById('btn-cancel');
        const btnCreate = document.getElementById('btn-create');
        const formCreate = document.getElementById('fcreate');
        const formUpdate = document.getElementById('fupdate');

        tags.forEach((tag) => {
            tag.addEventListener('click', function (event) {
                event.preventDefault();
                const tagId = this.dataset.tagId;
                const tagName = this.dataset.tagName;
                const tagFdo = this.dataset.tagFdo;

                tagIdInput.value = tagId;
                nameInput.value = tagName;
                fdoInput.value = tagFdo;

                formUpdate.style.display = 'block';
                formCreate.style.display = 'none';
                btnSave.style.display = 'block';
                btnCancel.style.display = 'block';
                btnCreate.style.display = 'none';
            });
        });

        btnCancel.addEventListener('click', function (event) {
            event.preventDefault();

            formCreate.style.display = 'block';
            formUpdate.style.display = 'none';
            tagIdInput.value = '';
            nameInput.value = '';
            fdoInput.value = '';
            btnSave.style.display = 'none';
            btnCancel.style.display = 'none';
            btnCreate.style.display = 'block';
        });
    });
</script>

<style>
    .form-group {
        margin-bottom: 1rem;
    }
    label {
        font-weight: bold;
        color: #ccc;
    }
    input[type="text"], input[type="file"] {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 0.5rem;
        width: 100%;
    }
    button[type="submit"] {
        background-color: #007bff;
        border: none;
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

@endsection
