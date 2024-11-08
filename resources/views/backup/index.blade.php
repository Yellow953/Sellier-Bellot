@extends('layouts.app')

@section('title', 'backup')

@section('content')
<div class="container px-4">
    <h2 class="mb-3 text-info text-center">Backup</h2>
    <div class="row">
        <div class="col-md-5 my-auto">
            <div>
                <img src="{{ asset('assets/images/backup.png') }}" alt="Backup" class="backup-img">
            </div>
        </div>
        <div class="col-md-7">
            <div class="card p-2 mb-1">
                <div class="import">
                    <h3 class="mb-1">Import Database</h3>
                    <form action="{{ route('backup.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 px-2">
                                <input type="file" name="file" required class="form-control" id="inputGroupFile">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="text-center btn btn-info">
                                    Import
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card p-2 mb-1">
                <div class="export">
                    <h3 class="mb-2">Export Database</h3>
                    <a href="{{ route('backup.export') }}" class="btn btn-info">
                        Export Backup
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
