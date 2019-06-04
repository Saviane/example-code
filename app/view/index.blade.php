@extends('layouts.dashboard')

@section('pageTitle', $pageTitle)

@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col">
                    <h4 class="page-title">{{ $pageTitle }}</h4>
                    @component('components.breadcrumbs', ['items' => [
                         ['link' => false, 'name' => 'Endereços'],
                         ['link' => false, 'name' => $pageTitle]
                     ]])
                    @endcomponent
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Estado</th>
                                    <th>Sigla</th>
                                    <th>Código IBGE</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($resources as $row)
                                    <tr>
                                        <td>{{ $row->state_id }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->initials }}</td>
                                        <td>{{ $row->ibge_code }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
