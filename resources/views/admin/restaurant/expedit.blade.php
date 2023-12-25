@extends('admin.layouts.admin')

@section('content')




    <!-- Main content -->
    <section class="content" id="addThisFormContainer">
      <div class="container-fluid">
        <div class="row">
          <!-- right column -->
          <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Expense Edit</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="ermsg"></div>
                <form id="createThisForm">
                  @csrf
                  <input type="hidden" class="form-control" id="codeid" name="codeid">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{$data->date}}">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{$data->description}}">
                      </div>
                    </div>
                  </div>
                  

                  <div class="row">
                    <div class="col-sm-12">

                      <table class="table">
                        <thead>
                          <tr>
                            <th>Product Name</th>
                            <th>Price per unit</th>
                            <th>Quantity</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody id="inner">
                          <tr>
                            <td>
                              <input type="text" id="productname" name="productname" class="form-control" value="{{$data->productname}}">
                            </td>
                            <td>
                              <input type="number" id="price_per_unit" name="price_per_unit" class="form-control price_per_unit" value="{{$data->price_per_unit}}">
                            </td>
                            <td>
                              <input type="number" id="qty" name="qty" value="{{$data->qty}}" class="form-control qty">
                            </td>
                            <td>
                              <input type="number" step="any" id="price" name="price" class="form-control total" value="{{$data->price}}" readonly>
                            </td>
                          </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>
                      </table>
                      


                    </div>
                  </div>

                  
                </form>
              </div>

              
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" id="addBtn" class="btn btn-secondary" value="Update">Update</button>
                <a href="{{route('admin.restaurantExpense')}}" class="btn btn-default">Cancel</a>
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

 

      // change quantity start  
      $("body").delegate(".price_per_unit,.total,.qty","keyup",function(event){
            event.preventDefault();
            var row = $(this).parent().parent();
            var price = row.find('.price_per_unit').val();
            
            var qty = row.find('.qty').val();
                if (isNaN(qty)) {
                    qty = 1;
                }
                if (qty < 1) {
                    qty = 1;
                }
            var total = price * qty;
            
            row.find('.total').val(total.toFixed(2));

            var grand_total=0;
            var vat_total=0;
            $('.total').each(function(){
                grand_total += ($(this).val()-0);
            })
            
            $('#discount').val('');
            $('#grand_total').val(grand_total.toFixed(2));
            net_total();          
      });
        //Change Quantity end here

      

      

      function net_total(){
        var discount = Number($("#discount").val());
        var total_amount=0;
        $('.total').each(function(){
          total_amount += ($(this).val()-0);
        })
        var grand_total = total_amount - discount;
        $('#grand_total').val(grand_total.toFixed(2));
      }


      //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
      //
      var url = "{{URL::to('/admin/restaurant-expense-update')}}";
      // console.log(url);
      $("body").delegate("#addBtn","click",function(event){
                event.preventDefault();

            var price = $("#price").val();
            var qty = $("#qty").val();
            var price_per_unit = $("#price_per_unit").val();
            var date = $("#date").val();
            var description = $("#description").val();
            var productname = $("#productname").val();



              
            // console.log(product_id, paymentmethod, comment);

                $.ajax({
                    url: url,
                    method: "POST",
                    data: {productname,price_per_unit,qty,date,description,price},

                    success: function (d) {
                        if (d.status == 303) {
                            console.log(d);
                            $(".ermsg").html(d.message);
                            pagetop();
                        }else if(d.status == 300){
                            console.log(d);
                            $(".ermsg").html(d.message);
                            pagetop();
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
                });
        });
      
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

      function clearform(){
          $('#createThisForm')[0].reset();
          $("#addBtn").val('Create');
      }
  });
</script>
@endsection