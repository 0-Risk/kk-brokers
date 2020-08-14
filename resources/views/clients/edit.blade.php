@extends('layouts.body', ['title' => 'KK Blokers Clients'])

@section('content')
    @include('inc.navbar', ['user' => $user])
    <!-- Content Wrapper. Contains page content -->
    <br>
    <br>
    <br>
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <div class="card">
                    <div class="card-header custom-header">
                        @include('inc.contentheader', ['title' => 'Edit '. $user->firstname .' '. $user->lastname ])
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body assets_container_disburse">
                        @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                           <strong>{{ session()->get('message') }}</strong>
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                           </button>
                         </div>
                         @endif
                         @if(session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ session()->get('error') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                         @endif
                      <br><br><br>
                       <div class="row">
                           <div class="col-md-4"></div>
                           <div class="col-md-4">
                            <form action="{{ action('Users\UserController@updateClient') }}" role="form" method="POST">
                                @csrf
                                <div class="form-group {{ $errors->has('firstname') ? 'has-error' : ''}}">
                                    <label for="role_name">First Name</label>
                                    <input type="text" class="form-control" value="{{ $user->firstname }}" name="firstname"
                                    placeholder="Enter First Name">
                                    {!! $errors->first('firstname', '<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group {{ $errors->has('lastname') ? 'has-error' : ''}}">
                                    <label for="role_name">Last Name</label>
                                    <input type="text" class="form-control" value="{{ $user->lastname }}" name="lastname"
                                    placeholder="Enter Last Name">
                                    {!! $errors->first('lastname', '<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group {{ $errors->has('mobileno') ? 'has-error' : ''}}">
                                    <label for="role_name">Mobile Contact</label>
                                    <input type="number" class="form-control" value="{{ $user->mobileno }}" name="mobileno"
                                    placeholder="Enter Mobile Contact">
                                    {!! $errors->first('mobileno', '<p class="text-danger">:message</p>') !!}
                                </div>
                                <br>
                                <br>
                                <div>
                                    <input type="hidden" value="{{ $user->id }}" name="user_id"/>
                                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                                </div>
                            </form>
                           </div>
                           <div class="col-md-4"></div>

                       </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
            </section>
            <!-- /.Left col -->
          </div>
      <!-- /.content -->
    @include('inc.copyright')
@endsection
