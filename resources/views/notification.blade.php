@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">

    @if($unread->isEmpty())
    <h4 class="d-flex justify-content-center text-danger">No Unread Notification Found!</h4>
    @else
    <h4 class="d-flex justify-content-center text-danger">Unread Notifications</h4>
    @foreach ($unread as $notification)
    <div>
        <p>{{ $notification->data['message'] }}</p>
        <form action="{{ route('notification.markAsRead', $notification->id) }}" method="POST">
            @csrf
            @method('POST')
            <button class="btn btn-primary btn-sm text-dark" type="submit">Mark as Read</button>
        </form>
    </div>
    @endforeach

    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
        @csrf
        @method('POST')
        <button class="btn btn-primary btn-sm text-dark" type="submit">Mark All as Read</button>
    </form>
    @endif



    <h4>All Notifications</h4>

    @foreach ($notifications as $notification)
    <ul>
        <li>
            {{ $notification->data['message'] }} at {{ $notification->data['notification_time'] }}
        </li>
    </ul>

    @endforeach

</div>

@endsection