@extends('layouts.app')

@section('content')

<div class="container-fluid mt-2">
    <div class="row align-items-start flex-column">
        <div class="col-lg-5 ms-3 col-sm-8">
            <h3 class="mb-0 h4 font-weight-bolder">User Profile</h3>
            <p class="mb-4">
                Check your Profile detail's
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col d-flex justify-content-end">
        @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    </div>
</div>

<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-lg-3">
            <div class="card position-sticky top-1">
                <ul class="nav flex-column bg-white border-radius-lg p-3">
                    <li class="nav-item">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#profile">
                            <i class="material-symbols-rounded text-lg me-2">person</i>
                            <span class="text-sm">Profile</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#basic-info">
                            <i class="material-symbols-rounded text-lg me-2">receipt_long</i>
                            <span class="text-sm">Basic Info</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#password">
                            <i class="material-symbols-rounded text-lg me-2">lock</i>
                            <span class="text-sm">Change Password</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#logout-device">
                            <i class="material-symbols-rounded text-lg me-2">badge</i>
                            <span class="text-sm">Logout</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#logout-all-device">
                            <i class="material-symbols-rounded text-lg me-2">badge</i>
                            <span class="text-sm">Logout All Device's</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9 mt-lg-0 mt-4">
            <!-- Card Basic Info -->
            <div class="card" id="basic-info">
                <div class="card-header">
                    <h5>Basic Info</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="input-group input-group-static">
                                <label>User Name</label>
                                <input type="username" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" value="{{ Auth::user()->name }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="input-group input-group-static">
                                <label>Email</label>
                                <input type="email" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" value="{{ Auth::user()->email }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card Change Password -->
            <div class="card mt-4" id="password">
                <div class="card-header">
                    <h5>Change Password</h5>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('profile.change_password') }}" method="post">
                        @csrf

                        <div class="input-group input-group-outline">
                            <input type="password" class="form-control" name="current_password" onfocus="focused(this)" onfocusout="defocused(this)" placeholder="Current Password...">
                        </div>
                        @error('current_password')
                        {{ $message }}
                        @enderror


                        <div class="input-group input-group-outline my-4">
                            <input type="password" class="form-control" name="new_password" onfocus="focused(this)" onfocusout="defocused(this)" placeholder="New Password Here...">
                        </div>
                        @error('new_password')
                        {{ $message }}
                        @enderror



                        <div class="input-group input-group-outline">
                            <input type="password" class="form-control" name="new_password_confirmation" onfocus="focused(this)" onfocusout="defocused(this)" placeholder="New Repeat Password....">
                        </div>
                        <h5 class="mt-5">Password requirements</h5>
                        <p class="text-muted mb-2">
                            Please follow this guide for a strong password:
                        </p>
                        <ul class="text-muted ps-4 mb-0 float-start">
                            <li>
                                <span class="text-sm">One special characters</span>
                            </li>
                            <li>
                                <span class="text-sm">Min 6 characters</span>
                            </li>
                            <li>
                                <span class="text-sm">One number (2 are recommended)</span>
                            </li>
                            <li>
                                <span class="text-sm">Change it often</span>
                            </li>
                        </ul>
                        <button class="btn bg-gradient-dark btn-sm float-end mt-6 mb-0" type="submit">Update password</button>


                    </form>
                </div>
            </div>
            <!-- Session -->
            <div class="card mt-4" id="logout-device">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-sm-0 mb-4">
                        <div class="w-50">
                            <h5>Logout Current Device</h5>
                            <p class="text-sm mb-0">Once you logout this device, will need to log in again to access your account.</p>
                        </div>
                        <div class="w-50 text-end">
                            <div class="row">
                                <div class="col">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="btn bg-gradient-danger mb-0 ms-2" type="submit">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4" id="logout-all-device">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-sm-0 mb-4">
                        <div class="w-50">
                            <h5>Logout of all sessions except the Current one!</h5>
                            <p class="text-sm mb-0">Delete all session records except the current one!</p>
                        </div>
                        <div class="w-50 text-end">
                            <div class="row">
                                <div class="col">
                                    <form method="POST" action="{{ route('logout.alldevices') }}">
                                        @csrf
                                        <button type="submit" class="btn bg-gradient-danger mb-0 ms-2">Log out of other devices</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal id="exampleModal" title="Example Modal" buttonText="Save Changes">
    <p>This is the content of the modal.</p>
</x-modal>


<button type="button" class="btn btn-primary" id="openModalBtn">
    Open Modal Programmatically
</button>



@endsection