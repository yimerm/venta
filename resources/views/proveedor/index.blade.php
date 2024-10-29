@extends('layouts.app')
@section('title','Proveedor')
@section('mis_rutas')
<li class="breadcrumb-item active" aria-current="page">Proveedor</li>
@endsection
@section('content')
<tablaproveedor-component></tablaproveedor-component>
<agregarproveedor-component></agregarproveedor-component>
<eliminarproveedor-component></eliminarproveedor-component>

@endsection