@extends('themes.default1.agent.layout.agent')

@section('sidebar')
<li class="header">{!! Lang::get('lang.Report') !!}</li>
<li>
    <a href="">
        <i class="fa fa-area-chart"></i> <span>{!! Lang::get('lang.help_topic') !!}</span> <small
            class="label pull-right bg-green"></small>
    </a>
</li>
<li>

</li>
@stop

@section('Report')
class="active"
@stop

@section('dashboard-bar')
active
@stop
@section('report-bar')
active
@stop
@section('PageHeader')
<h1>{!! Lang::get('lang.report') !!}</h1>
@stop

@section('dashboard')
class="active"
@stop

@section('content')
<!-- check whether success or not -->
{{-- Success message --}}
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
{{-- failure message --}}
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
<link type="text/css" href="{{asset("lb-faveo/css/bootstrap-datetimepicker4.7.14.min.css")}}" rel="stylesheet">
{{-- <script src="{{asset("lb-faveo/dist/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
--}}

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.help_topic') !!}</h3>
    </div>
    <div class="box-body">
        <form id="reportForm" style="display: flex;">
            <input type="hidden" name="duration" value="" id="duration">
            <input type="hidden" name="default" value="false" id="default">
            <div class="form-group">
                <div class="row" style="    display: flex;direction: rtl;">

                    <div class='col-sm-2 form-group' id="start_date">
                        {!! Form::label('date', Lang::get('lang.start_date')) !!}
                        {!! Form::text('start_date',null,['class'=>'form-control','id'=>'datepickerStartDate'])!!}
                    </div>
                    <?php
                    $start_date = App\Model\helpdesk\Ticket\Tickets::where('id', '=', '1')->first();
                    if ($start_date != null) {
                        $created_date = $start_date->created_at;
                        $created_date = explode(' ', $created_date);
                        $created_date = $created_date[0];
                        $start_date = date("m/d/Y", strtotime($created_date . ' -1 months'));
                    } else {
                        $start_date = date("m/d/Y", strtotime(date("m/d/Y") . ' -1 months'));
                    }
                    ?>
                    <script type="text/javascript">
                        $(function() {
                            var timestring1 = "{!! $start_date !!}";
                            var timestring2 = "{!! date('m/d/Y') !!}";
                            $('#datepickerStartDate').datetimepicker({
                                format: 'DD/MM/YYYY',
                                minDate: moment(timestring1).startOf('day'),
                                maxDate: moment(timestring2).startOf('day')
                            });
                        });
                    </script>
                    <div class='col-sm-2 form-group' id="end_date">
                        {!! Form::label('start_time', Lang::get('lang.end_date')) !!}
                        {!! Form::text('end_date',null,['class'=>'form-control','id'=>'datetimepickerEndDate'])!!}
                    </div>
                    <script type="text/javascript">
                        $(function() {
                            var timestring1 = "{!! $start_date !!}";
                            var timestring2 = "{!! date('m/d/Y') !!}";
                            $('#datetimepickerEndDate').datetimepicker({
                                format: 'DD/MM/YYYY',
                                minDate: moment(timestring1).startOf('day'),
                                maxDate: moment(timestring2).startOf('day')
                            });
                        });
                    </script>
                    <div class='col-sm-1' style="padding-right:0px;padding-left:0px">
                        <label>{!! Lang::get('lang.status') !!}</label>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">{!! Lang::get('lang.select') !!}</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" id="stop"><input type="checkbox" name="open" id="open"> {!!
                                        lang::get('lang.created') !!} {!! lang::get('lang.tickets') !!}</a></li>
                                <li><a href="#" id="stop"><input type="checkbox" name="closed" id="closed"> {!!
                                        lang::get('lang.closed') !!} {!! lang::get('lang.tickets') !!}</a></li>
                                <li><a href="#" id="stop"><input type="checkbox" name="reopened" id="reopened"> {!!
                                        lang::get('lang.reopened') !!} {!! lang::get('lang.tickets') !!}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class='col-sm-1'>
                        {!! Form::label('filter', Lang::get('lang.filter')) !!}<br>
                        <input type="submit" class="btn btn-primary" value={{Lang::get('lang.submit')}} id="submit">
                    </div>
                    <br />
                    <div class="col-md-4">
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="click_day">{!! Lang::get('lang.day')
                                    !!}</button>
                                <button type="button" class="btn btn-default" id="click_week">{!! Lang::get('lang.week')
                                    !!}</button>
                                <button type="button" class="btn btn-default" id="click_month">{!!
                                    Lang::get('lang.month') !!}</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <!--<div id="legendDiv"></div>-->

    </div><!-- /.box-body -->
</div><!-- /.box -->

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.tabular') !!}</h3>
    </div>
    <div class="box-body">
        <table class="table table-bordered" id="tabular">
        </table>
    </div>
</div>

@section('dataTable')
<script type="text/javascript">
    var result1a;
//    var help_topic_global;
                        $(document).ready(function() {
                            $('#reportForm').submit(function(event){
                                var start_date = $('#datepickerStartDate').val();
                                var end_date = $('#datetimepickerEndDate').val();
                                var data = $('#reportForm').serialize();
                                var startDate= start_date.split("/").join('-');
                                    var endDate = end_date.split("/").join('-');
                                $.ajax({
                                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                                    url: 'tickets-status-report/'+startDate+'/'+endDate, // the url where we want to POST
                                    dataType: 'json', // what type of data do we expect back from the server
                                    data: data, // our data object
                                    success: function(result2) {
                                        var tableRef = document.getElementById('tabular');
                                      
                                        while (tableRef.rows.length > 0)
                                        {
                                            tableRef.deleteRow(0);
                                        }
                                        var tbodyrow = document.getElementsByTagName('tbody')[0];
                                        tbodyrow.parentNode.removeChild(tbodyrow);
                                        var labels = [], open = [], closed = [], reopened = [], open_total = 0, closed_total = 0, reopened_total = 0;
                                        var header = tableRef.createTHead();
                                        var row = header.insertRow(0);
                                        var cllTitles=Object.keys(result2[0]);
                                        var theaderTicketNumber = document.createElement("th");
                                        theaderTicketNumber.innerText=cllTitles[1];
                                        row.appendChild(theaderTicketNumber);
                                        //var headerTicketNumber=row.insertCell(0);
                                        //headerTicketNumber.innerHTML=cllTitles[1];
                                        var headerTicketTitle=document.createElement("th");
                                        headerTicketTitle.innerText=cllTitles[38];
                                        row.appendChild(headerTicketTitle);
                                        var headeruser=document.createElement("th");
                                        headeruser.innerText=cllTitles[39];
                                        row.appendChild(headeruser);
                                        var headerDueDate=document.createElement("th");
                                        headerDueDate.innerText=cllTitles[26];
                                        row.appendChild(headerDueDate);

                                        var body = tableRef.createTBody();

                                        for (var i = 0; i < result2.length; i++) {
                                            labels.push(result2[i].date);
                                            var date123 = result2[i].date;
                                            var row1 = body.insertRow(0);
                                            var cellTicketNumber=row1.insertCell(0);
                                             cellTicketNumber.innerHTML= '<a href="'+window.location.origin+'/thread/'+result2[i].thread[0]['ticket_id']+'">'+result2[i].ticket_number+'</a>';
                                            var cellTitle=row1.insertCell(1);
                                             cellTitle.innerHTML=result2[i].thread[0]['title'];
                                             var celluser=row1.insertCell(2);
                                             celluser.innerHTML=result2[i].user['first_name'];
                                             var cellDueDate=row1.insertCell(3);
                                                 cellDueDate.innerHTML=result2[i].duedate;
  
                                        }
                                    },
                                    error:function(result){
                                        console.log(result);
                                    }
                            });
                           
                            event.preventDefault();
                            $('#tabular').DataTable({
                              dom:'Bfrtip',
                              bSort: false,
                             aoColumns: [ 
                                         { sWidth: "25%", bSearchable: false, bSortable: false }, 
                                        { sWidth: "45%", bSearchable: false, bSortable: false }, 
                                        { sWidth: "10%", bSearchable: false, bSortable: false },
                                        { sWidth: "10%", bSearchable: false, bSortable: false } 
                                        ],
                                        buttons: ['csvhtml5', 'excelhtml5', 'pdfhtml5'],

                        });
                        });

                            $("#pdf").on('click', function(){
                                document.getElementById("pdf_form").value = JSON.stringify(result1a);
                                document.getElementById("pdf_form_help_topic").value = $('#help_topic :selected').val();
                                document.getElementById("form_pdf").submit();
//                                $("#form_pdf").submit(function(){
//                                    alert('saasdas');
//                                });
                            });
                       
                    });
</script>
@stop
@stop