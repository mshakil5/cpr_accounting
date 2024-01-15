@extends('admin.layouts.admin')

@section('content')




    <!-- Main content -->
    <section class="content mt-3" id="addThisFormContainer">
      <div class="container-fluid">
        <div class="row justify-content-md-center">
          <!-- right column -->
          <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card">
                
              <!-- /.card-header -->
              <div class="card-body">
                <div class="ermsg"></div>
                <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Account Name</label>
                        <select name="account_id" id="account_id" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\Account::all() as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Branch</label>
                            <select name="branch" id="branch" class="form-control">
                              <option value="">All</option>
                              <option value="Restaurant">Restaurant</option>
                              <option value="Resort">Resort</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="col-sm-2">
                      <div class="form-group">
                          <label>From Date</label>
                          <input type="date" name="fromdate" id="fromdate" class="form-control">
                      </div>
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <label>To Date</label>
                        <input type="date" name="todate" id="todate" class="form-control">
                      </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group" style="margin-top: 33px;">
                            
                            <button type="submit" id="addBtn" class="btn btn-secondary" value="Create">Search</button>
                        </div>
                    </div>
                </div>




              </div>

              
              <!-- /.card-body -->
            </div>
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


<!-- Main content -->
<section class="content" id="contentContainer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- /.card -->

          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">All Data</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl</th>
                  <th>Name</th>
                  <th>Balance</th>
                  <th>Branch</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">{{$data->name}}</td>
                    <td style="text-align: center">{{$data->balance}}</td>
                    <td style="text-align: center">{{$data->branch}}</td>
                    <td style="text-align: center">{{$data->description}}</td>
                    
                    <td style="text-align: center">
                      <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                      <a id="deleteBtn" rid="{{$data->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a>
                    </td>
                  </tr>
                  @endforeach
                
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->


@endsection
@section('script')
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

<script>
  $(document).ready(function () {
    
      //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      //
      
      
      
      
      
      
  });
</script>
@endsection