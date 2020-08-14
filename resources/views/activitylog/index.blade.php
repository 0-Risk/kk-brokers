@extends('layouts.body', ['title' => 'Activity Logs'])

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
                        @include('inc.contentheader', ['title' => 'Activity Logs' ])
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
                      <div class="table-responsive">
                        <table id="ActivityLogs" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th>No</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>URL</th>
                                <th>Method</th>
                                <th>Ip</th>
                                <th>Performed By</th>
                                <th>Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activity_logs as  $log)
                                <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $log->subject }}</td>
                                <td>{{ $log->details }}</td>
                                <td class="text-danger">{{ $log->url }}</td>
                                <td><label class="label label-info">{{ $log->method }}</label></td>
                                <td class="text-danger">{{ $log->ip }}</td>
                                <td>{{ $log->firstname }} - {{ $log->lastname }}</td>
                                <td>{{ $log->created_at }}</td>
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
