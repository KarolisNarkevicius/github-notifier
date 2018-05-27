@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Repositories</div>

                    <div class="card-body">

                        <table class="table table-bordered table-stripped">
                            <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <td>Description</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($repositories as $repository)
                                <tr>
                                    <td>{{ $repository->id }}</td>
                                    <td>
                                        <a href="{{ $repository->html_url }}" target="_blank">{{ $repository->name }}</a>
                                    </td>
                                    <td>{{ $repository->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No repositories found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
