@extends('layouts.app')
@section('title','Cliente')
@section('mis_rutas')
<li class="breadcrumb-item active" aria-current="page">Clientes</li>
@endsection
@section('content')

<tablacliente-component></tablacliente-component>
<agregarcliente-component></agregarcliente-component>
<eliminarcliente-component></eliminarcliente-component>

@endsection