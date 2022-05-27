@extends('layout.master')
<!-- Page wrapper  -->
<!-- ============================================================== -->
@section('content')
<style>
    /* The container */
    .check_box_container {
      display: block;
      position: relative;
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    /* Hide the browser's default checkbox */
    .check_box_container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 30px;
      width: 30px;
      background-color: #eee;
      margin-left: 43%;
      margin-top: -4%;
    }

    /* On mouse-over, add a grey background color */
    .check_box_container:hover input ~ .checkmark {
      background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .check_box_container input:checked ~ .checkmark {
      background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the checkmark when checked */
    .check_box_container input:checked ~ .checkmark:after {
      display: block;
    }

    /* Style the checkmark/indicator */
    .check_box_container .checkmark:after {
        left: 10px;
        top: 1px;
        width: 11px;
        height: 20px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
<div class="page-wrapper">

    @php
        $key = 1;
    @endphp
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="title_page"> স্বতন্ত্র বার্তা পাঠান </h4>
            </div>

            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">হোম</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">স্বতন্ত্র বার্তা পাঠান</li>
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


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="row mb-5">
            <label class="col-sm-12" style="">ব্যক্তি নির্বাচন করুন</label>
            <div class="col-sm-12" style="">
                <select id='ind_person' class="form-select shadow-none form-control-line">
                        <option hiden selected>অনুগ্রহ করে নির্বাচন করুন</option>
                    @foreach ($data as $dt)
                        <option  value="{{ $dt['phone'] }}" data-name="{{ $dt['name'] }}" data-phone="{{ $dt['phone'] }}" data-description="{{ $dt['designation'] }}">{{ $dt['name'] }} --- {{ $dt['phone'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
{{-- =======================================================================================================
==============================       Show show table        ===========================================
==================================================================================================== --}}
        <div class="row">
            <!-- column -->
            <form method="POST" id="mp_send_sms" action="{{ route('sms.send') }}">
            @csrf
            <div class="col-12  m-auto">
                <div class="card">
                    <div class="table-responsive">
                        <table id="add_table" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="border-top-0 text-center">সি. নং</th>
                                    <th class="border-top-0 text-center">নাম</th>
                                    <th class="border-top-0 text-center">মোবাইল নম্বর</th>
                                    <th class="border-top-0 text-center">বিবরণ</th>
                                    <th class="border-top-0 text-center">অপারেশন</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4 mb-4 row message_box">

                <div class="col-md-12 m-auto">

                    <div class="form-group pt-3">
                        <label for="message">Message</label>
                        <textarea name="message" class="form-control" required rows="4"></textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-5 m-auto">
                    <input type="submit" id="submit_btn" style="width:100%" class="btn btn-success text-white" value="Send Message">
                </div>
                {{-- <div class="form-group">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>
                </div> --}}

            </div>
            </form>
        </div>

        {{-- =======================================================================================================
==============================     End Show show table        ===========================================
==================================================================================================== --}}



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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $('#add_table').hide();
    $('#add_table tbody').html('');
    if( $('#add_table').children('tbody').children('tr').length == 0 ){
        $('.message_box').hide();
    }
    $('#ind_person').change( function (){
        let name = $(this).children("option:selected").data('name');
        let phone = $(this).children("option:selected").data('phone');
        let description = $(this).children("option:selected").data('description');
        let sl =  $('#add_table').children('tbody').children('tr').length;
        sl++;

        $('#add_table tbody').append(`
            <tr>
                <td>${sl}</td>
                <td>${name}</td>
                <td>${phone}</td>
                <td>${description}</td>
                <td>
                    <label class="check_box_container">
                        <input type="checkbox" name="number[]" value="${ phone }" checked="checked">
                        <span class="checkmark"></span>
                    </label>
                </td>
            </tr>

        `);

    $('#add_table').show();
    if( $('#add_table').children('tbody').children('tr').length == 0 ){
        $('.message_box').hide();
    }else{
        $('.message_box').show();
    }
    });
</script>
@endsection
