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
                <div class="card card-primary">
                    <div class="card-header custom-header">
                        @include('inc.contentheader', ['title' => 'KK Blokers Clients' ])
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
                      <div>
                          <a role="button" href="{{ url('/create/new/client') }}" class="btn btn-primary float-right">Add Client</a>
                      </div>
                      <br>
                      <br>
                      <br>
                      <div class="table-responsive">
                        <table id="ActivityLogs" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>No</th>
                                <th>First Name</th>
                                <th>LastName</th>
                                <th>Mobile No</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->firstname }}</td>
                                    <td>{{ $user->lastname }}</td>
                                    <td>{{ $user->mobileno }}</td>
                                    <td>{{ date('d-M-Y', strtotime($user->created_at))}}</td>
                                    <td>
                                        @if ($user->account_activated == 1)
                                           <span class="badge-danger">Active</span>
                                        @else
                                          <span class="badge-warning">Deactivated</span>
                                        @endif
                                    </td>
                                    <td>
                                       <?php

                                           $user_id = Crypt::encrypt($user->id);

                                        ?>
                                        <a class="btn btn-success btn-sm" href="{{ url('/edit/client/'.$user_id) }}">Edit</a>

                                    |

                                    @if ($user->account_activated == 1)
                                        <a class="btn btn-danger btn-sm" href="{{ url('/client/deactivate/'.$user_id) }}">Deactivate</a>
                                    @else
                                       <a class="btn btn-info btn-sm" href="{{ url('/client/activate/'.$user_id) }}">Activate</a>
                                    @endif

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

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
