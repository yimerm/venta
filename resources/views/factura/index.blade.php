@extends('layouts.app')
@section('title','Factura')
@section('mis_rutas') 
<li class="breadcrumb-item active" aria-current="page">Factura</li>
@endsection
@section('content')
<tablafactura-component></tablafactura-component>
<modalfactura-component></modalfactura-component>
@endsection