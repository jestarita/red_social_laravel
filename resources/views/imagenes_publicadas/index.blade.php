@extends('layouts.app')
@section('content')

@include('includes.mensaje')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
            <div class="card-header">Agregar imagen</div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ route('agregar_imagen') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                        <div class="col-md-7">
                            <input type="file" class="form-control" id="image_path" name="image_path" required />
                            @error('image_path')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-3 col-form-label text-md-right">Descripci&oacute;n</label>
                        <div class="col-md-7">
                            <textarea type="text" class="form-control" id="description" name="description" required>
                            </textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>

                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-success">
                               Guardar
                            </button>
                        </div>
                    </div>
                </form>
          

            </div>

        </div>
        </div>
    </div>
</div>
@endsection