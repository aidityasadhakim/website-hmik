<<<<<<< HEAD
<h1>Welcome, Sandhika Galih</h1>
=======
@extends('dashboard.layout.main')


@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Welcome, {{ auth()->user()->name }}</h1>
</div>
@endsection

>>>>>>> af84dcf178f764985ea2117e7f623d334ac25438
