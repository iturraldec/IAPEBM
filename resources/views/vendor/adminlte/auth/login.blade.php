@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('auth_body')
    @if(session('errorCredentials'))
        <h6>{{session('errorCredentials')}}</h6>
    @endif   

    <form action="{{ $login_url }}" method="post">
        @csrf

        {{-- Dcoument Number field --}}
        <div class="input-group mb-3">
            <input type="text" name="document" class="form-control @error('document') is-invalid @enderror"
                   value="{{ old('document') }}" placeholder="Documento de Identificacion" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-id-card {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('document')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ __('adminlte::adminlte.password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="row">
            {{-- recordar mi sesion --}}
            <div class="col-8">
                <div class="icheck-primary">
                <input type="checkbox" name="remember">
                <label for="remember">
                    Recuerda mi sesión
                </label>
                </div>
            </div>
            <!-- /.col -->
            
            {{-- enviar datos --}}
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
        </div>

    </form>
@stop

@section('auth_footer')
@stop
