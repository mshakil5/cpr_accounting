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
    <section class="content mt-3" id="addThisFormContainer">
      <div class="container-fluid">
        <div class="row justify-content-md-center">
          <!-- right column -->
          <div class="col-md-8">
            <!-- general form elements disabled -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Add new food sales</h3>
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
                        <input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d')}}">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" id="description" name="description">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Select Item Name</label>
                        <select name="product" id="product" class="form-control">
                          <option value="">Select</option>
                          @foreach ($foods as $item)
                          <option value="{{$item->id}}">{{$item->name}}-{{$item->code}}</option>
                          @endforeach
                        </select>
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
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="inner">

                        </tbody>
                        <tfoot>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Discount</td>
                            <td><input type="number" id="discount" name="discount" class="form-control"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Total Amount</td>
                            <td><input type="number" id="grand_total" name="grand_total" class="form-control" readonly></td>
                            <td></td>
                          </tr>
                        </tfoot>
                      </table>
                      


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
                  <th>Date</th>
                  <th>Invoice No</th>
                  <th>Description</th>
                  <th>Discount</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $data)
                  <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">{{$data->date}}</td>
                    <td style="text-align: center">{{$data->invoiceno}}</td>
                    <td style="text-align: center">{{$data->description}}</td>
                    <td style="text-align: center">{{$data->discount}}</td>
                    <td style="text-align: center">{{$data->net_amount}}</td>
                    
                    <td style="text-align: center">

                      <a data-toggle="modal" data-target="#modal{{$data->id}}"><i class="fa fa-eye" style="color: #1ea948;font-size:16px;"></i></a>

                      <a href="{{route('admin.salesEdit', $data->id)}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                      
                    <div class="modal fade" id="modal{{$data->id}}">
                      <div class="modal-dialog modal{{$data->id}}">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Product Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="container">
  
                              <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th>Product Name</th>
                                    <th>Price per unit</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($data->saledetail as $item)
                                  <tr>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->price_per_unit}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{$item->price}}</td>
                                  </tr>
                                  @endforeach
                                  
                                </tbody>
                              </table>
  
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>

                      
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

      function removeRow(event) {
          event.target.parentElement.parentElement.remove();
          net_total();   
      }

      function net_total(){
        var discount = Number($("#discount").val());
        var total_amount=0;
        $('.total').each(function(){
          total_amount += ($(this).val()-0);
        })
        var grand_total = total_amount - discount;
        $('#grand_total').val(grand_total.toFixed(2));
      }


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

      //calculation end
      $("#discount").keyup(function(){
          var discount = Number($("#discount").val());
          var total_amount=0;
              $('.total').each(function(){
                total_amount += ($(this).val()-0);
              })
          var tamount = total_amount - discount;
          $('#grand_total').val(tamount.toFixed(2));
      });
      //calculation end  

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

      

      var urlbr = "{{URL::to('/admin/getproduct')}}";
      $("#product").change(function(){
          event.preventDefault();
              var accname = $(this).val();

              var product_id = $("input[name='product_id[]']")
                        .map(function(){return $(this).val();}).get();

                        product_id.push(accname);
                  seen = product_id.filter((s => v => s.has(v) || !s.add(v))(new Set));

                  if (Array.isArray(seen) && seen.length) {
                      return;
                  }
                  
              $.ajax({
              url: urlbr,
              method: "POST",
              data: {accname:accname},

              success: function (d) {
                
                  if (d.status == 303) {

                  }else if(d.status == 300){
                          
                      var markup = '<tr><td><input type="text" id="productname" name="productname[]" class="form-control" value="'+d.name+'"><input type="hidden" id="product_id" name="product_id[]" class="form-control" value="'+d.product_id+'"></td><td><input type="number" id="price_per_unit" name="price_per_unit[]" class="form-control price_per_unit" value="'+d.price+'"></td><td><input type="number" id="qty" name="qty[]" value="1" class="form-control qty"></td><td><input type="number" step="any" id="price" name="price[]" class="form-control total" value="'+d.price+'.00" readonly></td><td><div style="color: white;  user-select:none;  padding: 2px;    background: red;    width: 25px;    display: flex;    align-items: center; margin-right:5px;   justify-content: center;    border-radius: 4px;   left: 4px;    top: 81px;" onclick="removeRow(event)" >X</div></td></tr>';

                      $("table #inner ").append(markup);
                      net_total();
                  }
              },
              error: function (d) {
                  console.log(d);
              }
          });

      });

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
      var url = "{{URL::to('/admin/sales')}}";
      // console.log(url);
      $("body").delegate("#addBtn","click",function(event){
                event.preventDefault();

            var grand_total = $("#grand_total").val();
            var discount = $("#discount").val();
            var date = $("#date").val();
            var description = $("#description").val();

            var product_id = $("input[name='product_id[]']")
              .map(function(){return $(this).val();}).get();

            var price_per_unit = $("input[name='price_per_unit[]']")
            .map(function(){return $(this).val();}).get();

            var qty = $("input[name='qty[]']")
              .map(function(){return $(this).val();}).get();
              
            // console.log(product_id, paymentmethod, comment);

                $.ajax({
                    url: url,
                    method: "POST",
                    data: {product_id,price_per_unit,qty,grand_total,discount,date,description},

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