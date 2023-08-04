@extends('layouts.app', ['pageTitle' => 'Upload Page'])

@section('page')
    <div class="d-flex flex-column justify-content-center w-100 align-items-center">
        <label id="drop-area" class="file-upload" for="file" data-url-upload="{{route('documents.files.store')}}">
            <div class="file-icon">
                <img src="{{Vite::asset('resources/images/file.svg')}}">
            </div>
            <div class="file-text">
                <span>Click to upload image</span>
            </div>
            <input type="file" id="file" accept="application/JSON">
        </label>
        <div id="result-area" class="d-none" style="margin-top: 1.5rem">
            <div>Verification Result : <span id="verification-result"></span></div>
            <div>Issuer : <span id="issuer"></span></div>
        </div>
    </div>
@endsection
