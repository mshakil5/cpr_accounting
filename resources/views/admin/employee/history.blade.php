@extends('admin.layouts.admin')

@section('content')

<!-- Main content -->
<section class="content" id="newBtnSection">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2">
            <button type="button" class="btn btn-secondary my-3" id="newBtn">Add new</button>
        </div>
      </div>
    </div>
</section>
  <!-- /.content -->



    <!-- Main content -->
    <section class="content" id="addThisFormContainer">
      <div class="container-fluid">
        <div class="row justify-content-md-center">
          <!-- right column -->
          <div class="col-md-8">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Add new employee history</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form id="createThisForm">
                  @csrf
                  <input type="hidden" class="form-control" id="codeid" name="codeid">
                  

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Employee</label>
                        <select name="employee_id" id="employee_id" class="form-control">
                          <option value="">Select</option>
                          @foreach (\App\Models\Employee::where('status','1')->orderby('id', 'DESC')->get() as $employee)
                          <option value="{{$employee->id}}">{{$employee->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Salary</label>
                        <input type="number" class="form-control" id="salary" name="salary">
                      </div>
                    </div>


                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Start Date & Time</label>
                        <input type="date" class="form-control" id="start_datetime" name="start_datetime">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>End Date & Time</label>
                        <input type="date" class="form-control" id="end_datetime" name="end_datetime">
                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" id="history_desc" name="history_desc">
                      </div>
                    </div>
                  </div>


                  
                </form>
              </div>

              
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" id="addBtn" class="btn btn-secondary" value="Create">Create</button>
                <button type="submit" id="FormCloseBtn" class="btn btn-default">Cancel</button>
              </div>
              <!-- /.card-footer -->
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

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">All Data</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sl</th>
                  <th>Employee Name</th>
                  <th>Salary</th>
                  <th>Start Date</th>
                  <th>Start Date</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">{{$data->employee->name}}</td>
                    <td style="text-align: center">{{$data->salary}}</td>
                    <td style="text-align: center">{{$data->start_datetime}}</td>
                    <td style="text-align: center">{{$data->end_datetime}}</td>
                    <td style="text-align: center">{{$data->history_desc}}</td>
                    
                    <td style="text-align: center">
                      <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                      <a id="deleteBtn" rid="{{$data->id}}"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                      </a>
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
      $("#addThisFormContainer").hide();
      $("#newBtn").click(function(){
          clearform();
          $("#newBtn").hide(100);
          $("#addThisFormContainer").show(300);

      });
      $("#FormCloseBtn").click(function(){
          $("#addThisFormContainer").hide(200);
          $("#newBtn").show(100);
          clearform();
      });
      //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      //
      var url = "{{URL::to('/admin/employee-history')}}";
      var upurl = "{{URL::to('/admin/employee-history-update')}}";
      // console.log(url);
      $("#addBtn").click(function(){
      //   alert("#addBtn");
          if($(this).val() == 'Create') {


              var form_data = new FormData();
              form_data.append("employee_id", $("#employee_id").val());
              form_data.append("salary", $("#salary").val());
              form_data.append("start_datetime", $("#start_datetime").val());
              form_data.append("end_datetime", $("#end_datetime").val());
              form_data.append("history_desc", $("#history_desc").val());

              $.ajax({
                url: url,
                method: "POST",
                contentType: false,
                processData: false,
                data:form_data,
                success: function (d) {
                    if (d.status == 303) {
                        $(".ermsg").html(d.message);
                    }else if(d.status == 300){

                      $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'success',
                            title: 'Data create successfully.'
                          });
                        });
                      window.setTimeout(function(){location.reload()},2000)
                    }
                },
                error: function (d) {
                    console.log(d);
                }
            });
          }
          //create  end
          //Update
          if($(this).val() == 'Update'){
              var form_data = new FormData();
              form_data.append("employee_id", $("#employee_id").val());
              form_data.append("salary", $("#salary").val());
              form_data.append("start_datetime", $("#start_datetime").val());
              form_data.append("end_datetime", $("#end_datetime").val());
              form_data.append("history_desc", $("#history_desc").val());
              form_data.append("codeid", $("#codeid").val());
              
              $.ajax({
                  url:upurl,
                  type: "POST",
                  dataType: 'json',
                  contentType: false,
                  processData: false,
                  data:form_data,
                  success: function(d){
                      console.log(d);
                      if (d.status == 303) {
                          $(".ermsg").html(d.message);
                          pagetop();
                      }else if(d.status == 300){
                        $(function() {
                          var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                          });
                          Toast.fire({
                            icon: 'success',
                            title: 'Data updated successfully.'
                          });
                        });
                          window.setTimeout(function(){location.reload()},2000)
                      }
                  },
                  error:function(d){
                      console.log(d);
                  }
              });
          }
          //Update
      });
      //Edit
      $("#contentContainer").on('click','#EditBtn', function(){
          //alert("btn work");
          codeid = $(this).attr('rid');
          //console.log($codeid);
          info_url = url + '/'+codeid+'/edit';
          //console.log($info_url);
          $.get(info_url,{},function(d){
              populateForm(d);
              pagetop();
          });
      });
      //Edit  end
      //Delete
      $("#contentContainer").on('click','#deleteBtn', function(){
            if(!confirm('Sure?')) return;
            codeid = $(this).attr('rid');
            info_url = url + '/'+codeid;
            $.ajax({
                url:info_url,
                method: "GET",
                type: "DELETE",
                data:{
                },
                success: function(d){
                    if(d.success) {
                        alert(d.message);
                        location.reload();
                    }
                },
                error:function(d){
                    console.log(d);
                }
            });
        });
        //Delete 
      function populateForm(data){
          $("#employee_id").val(data.employee_id);
          $("#salary").val(data.salary);
          $("#start_datetime").val(data.start_datetime);
          $("#end_datetime").val(data.end_datetime);
          $("#history_desc").val(data.history_desc);
          $("#codeid").val(data.id);
          $("#addBtn").val('Update');
          $("#addBtn").html('Update');
          $("#addThisFormContainer").show(300);
          $("#newBtn").hide(100);
      }
      function clearform(){
          $('#createThisForm')[0].reset();
          $("#addBtn").val('Create');
      }
  });
</script>
@endsection