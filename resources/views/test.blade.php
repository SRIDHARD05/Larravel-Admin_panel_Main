@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">
    <div class="row ms-3 me-3">
        <div class="card">
            <div class="card-body">
                @foreach ($data as $ds)
                <ul>
                    <li>
                        {{ $ds }}
                    </li>
                </ul>
                @endforeach
            </div>
            <div class="card-footer">
                {{ $data->links() }}
            </div>
        </div>
    </div>

</div>


@endsection