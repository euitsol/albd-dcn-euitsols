
  @extends('layout.master')
  <!-- Page wrapper  -->
  <!-- ============================================================== -->
  @section('content')

  <div class="page-wrapper">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <div class="page-breadcrumb">
          <div class="row">
              <div class="col-5 align-self-center">
                  <h4 class="title_page">থানার দায়িত্বভার ব্যক্তির তথ্য দেখুন</h4>
              </div>
        
              <div class="col-7 align-self-center">
                  <div class="d-flex align-items-center justify-content-end">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                              <li class="breadcrumb-item">
                                  <a href="#">হোম</a>
                              </li>
                              <li class="breadcrumb-item active" aria-current="page">থানার দায়িত্বভার ব্যক্তির তথ্য</li>
                          </ol>
                      </nav>
                  </div>
              </div>
          </div>
      </div>
      <!-- ============================================================== -->
      <!-- End Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Container fluid  -->
      <!-- ============================================================== -->
      <div class="container-fluid">

          <!-- ============================================================== -->
          <!-- Add Police Station -->
          <div class="col-12  w-75 m-auto">
              
          </div>

          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Add Police Station -->
          <!-- ============================================================== -->



          <div class="row">
              <!-- column -->
              <div class="col-12  m-auto">
                  <div class="card">
                      <div class="table-responsive">
                        
                            <div class="row">
                                @foreach($data_thana as $data) 
                                <div class="col-sm-6">
                                      <div class="box">
                                          <div class="img">
                                          <img src="{{asset("storage/image/$data->rp_img")}}" alt="Image">
                                          </div>
                                          <div class="details">
                                            {{-- <strong>Name: </strong>
                                            <strong>Email :</strong>
                                            <strong>Phone:</strong>  --}}
                                            
                                             
                                            <label for="name"><strong class="make_hi">Name: </strong> {{ $data->rp_name}}</label><br>
                                            <label for="email"><strong class="make_hi">Email: </strong> {{ $data->rp_email}}</label><br>
                                            <label for="Phone" ><strong id="phone" class=" phone make_hi">Phone: </strong> <a id="phone_number" class="phone_num" href="tel:{{ $data->rp_phone}}">{{ $data->rp_phone}}</a> </label><br>
                                            
                                          </div>
                                      </div>
                                     
                                </div>
                                @endforeach
                               
                                </div>
                                
                            </div>
                           
                
                      </div>
                  </div>
              </div>
          </div>




      </div>
      <!-- ============================================================== -->
      <!-- End Container fluid  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- footer -->
      <!-- ============================================================== -->
      <footer class="footer text-center">
        All Rights Reserved by
        <a href="#">ঢাকা মহানগর উত্তর আওয়ামী লীগ</a>.
    </footer>
      <!-- ============================================================== -->
      <!-- End footer -->
      <!-- ============================================================== -->
  </div>
 
      
  @endsection

  @section('javaScript')
  <script>
      $(document).ready(function(){
          $('#phone').on('click',function(){
            //   alert('ok');
            $('#phone_number').show();
          });
            
      });
  </script>
      
  @endsection


  

