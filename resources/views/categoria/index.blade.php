@extends('layouts.app')
@section('title','Cliente')
@section('mis_rutas')
<li class="breadcrumb-item active" aria-current="page">Categoria</li>
@endsection
@section('content')
 <tablacatego-component></tablacatego-component>
 <modalsave-component></modalsave-component>
 <modaldelete-component></modaldelete-component>
@endsection
