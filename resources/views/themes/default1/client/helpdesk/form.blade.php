@extends('themes.default1.client.layout.client')

@section('title')
{!! Lang::get('lang.submit_a_ticket') !!} -
@stop

@section('submit')
class = "active"
@stop
<!-- breadcrumbs -->
@section('breadcrumb')
<div class="site-hero clearfix">
    <ol class="breadcrumb breadcrumb-custom">
        <li class="text">{!! Lang::get('lang.you_are_here') !!}: </li>
        <li><a href="{!! URL::route('form') !!}">{!! Lang::get('lang.submit_a_ticket') !!}</a></li>
    </ol>
</div>
@stop
<!-- /breadcrumbs -->
@section('check')
<div class="banner-wrapper  clearfix">
    <h3 class="banner-title text-center text-info h4">{!! Lang::get('lang.have_a_ticket') !!}?</h3>
    @if(Session::has('check'))
    @if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>{!! Lang::get('lang.alert') !!} !</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </div>
    @endif
    @endif
    <div class="banner-content text-center">
        {!! Form::open(['url' => 'checkmyticket' , 'method' => 'POST'] )!!}
        {!! Form::label('email',Lang::get('lang.email')) !!}<span class="text-red"> *</span>
        {!! Form::text('email_address',null,['class' => 'form-control']) !!}
        {!! Form::label('ticket_number',Lang::get('lang.ticket_number')) !!}<span class="text-red"> *</span>
        {!! Form::text('ticket_number',null,['class' => 'form-control']) !!}
        <br /><input type="submit" value="{!! Lang::get('lang.check_ticket_status') !!}" class="btn btn-info">
        {!! Form::close() !!}
    </div>
</div>
@stop
<!-- content -->
@section('content')
<div id="content" class="site-content col-md-9">
    @if(Session::has('message'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('message') !!}
    </div>
    @endif
    @if (count($errors) > 0)
    @if(Session::has('check'))
    <?php goto a; ?>
    @endif
    @if(!Session::has('error'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>{!! Lang::get('lang.alert') !!} !</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <?php a: ?>
    @endif
    <!-- open a form -->
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> --}}
    <script src="{{asset("lb-faveo/js/jquery2.0.2.min.js")}}" type="text/javascript"></script>
    <!--
    |====================================================
    | SELECT FROM
    |====================================================
    -->
    <?php
    $encrypter = app('Illuminate\Encryption\Encrypter');
    $encrypted_token = $encrypter->encrypt(csrf_token());
    ?>
    <input id="token" type="hidden" value="{{$encrypted_token}}">
    {!! Form::open(['action'=>'Client\helpdesk\FormController@postedForm','method'=>'post',
    'enctype'=>'multipart/form-data']) !!}
    <div>
        <div class="content-header">
            <h4>{!! Lang::get('lang.ticket') !!} </h4>
        </div>
        <div class="row col-md-12">

            @if(Auth::user())

            {!! Form::hidden('Name',Auth::user()->user_name,['class' => 'form-control']) !!}

            @else
            <div class="col-md-12 form-group {{ $errors->has('Name') ? 'has-error' : '' }}">
                {!! Form::label('Name',Lang::get('lang.name')) !!}<span class="text-red"> *</span>
                {!! Form::text('Name',null,['class' => 'form-control']) !!}
            </div>
            @endif



            @if(Auth::user())

            {!! Form::hidden('Email',Auth::user()->email,['class' => 'form-control']) !!}

            @else
            <div class="col-md-12 form-group {{ $errors->has('Email') ? 'has-error' : '' }}">
                {!! Form::label('Email',Lang::get('lang.email')) !!}
                @if($email_mandatory->status == 1 || $email_mandatory->status == '1')
                <span class="text-red"> *</span>
                @endif
                {!! Form::email('Email',null,['class' => 'form-control']) !!}
            </div>
            @endif




            @if(!Auth::user())
            <div class="col-md-4 form-group">
                {!! Form::hidden('Code','972',['class' => 'form-control']) !!}
            </div>
            <div class="col-md-4 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                {!! Form::label('mobile',Lang::get('lang.mobile_number')) !!}
                @if($email_mandatory->status == 0 || $email_mandatory->status == '0')
                <span class="text-red"> *</span>
                @endif
                {!! Form::text('mobile',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-md-4 form-group {{ $errors->has('Phone') ? 'has-error' : '' }}">
                {!! Form::label('Phone',Lang::get('lang.phone')) !!}
                {!! Form::text('Phone',null,['class' => 'form-control']) !!}
            </div>
            @else
            {!! Form::hidden('mobile',Auth::user()->mobile,['class' => 'form-control']) !!}
            {!! Form::hidden('Code',Auth::user()->country_code,['class' => 'form-control']) !!}
            {!! Form::hidden('Phone',Auth::user()->phone_number,['class' => 'form-control']) !!}

            @endif
            <div class="col-md-12 form-group {{ $errors->has('help_topic') ? 'has-error' : '' }}">
                {!! Form::label('help_topic', Lang::get('lang.choose_a_help_topic')) !!}
                {!! $errors->first('help_topic', '<spam class="help-block">:message</spam>') !!}
                <?php
                $forms = App\Model\helpdesk\Form\Forms::get();
                $helptopic = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get();
                ?>
                <select name="helptopic" class="form-control" id="selectid">

                    @foreach($helptopic as $topic)
                    <option value="{!! $topic->id !!}">{!! $topic->topic !!}</option>
                    @endforeach
                </select>
            </div>
            <!-- priority -->
            <?php 
             $Priority = App\Model\helpdesk\Settings\CommonSettings::select('status')->where('option_name','=', 'user_priority')->first(); 
             $user_Priority=$Priority->status;
            ?>

            @if(Auth::user())

            @if(Auth::user()->active == 1)
            @if($user_Priority == 1)


            <div class="col-md-12 form-group">
                <div class="row">
                    <div class="col-md-1">
                        <label>{!! Lang::get('lang.priority') !!}:</label>
                    </div>
                    <div class="col-md-12">
                        <?php $Priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('status','=',1)->get(); ?>
                        {!! Form::select('priority',
                        ['Priority'=>$Priority->pluck('priority_desc','priority_id')->toArray()],null,['class' =>
                        'form-control select']) !!}
                    </div>
                </div>
            </div>
            @endif
            @endif
            @endif
            <div class="col-md-12 form-group {{ $errors->has('Subject') ? 'has-error' : '' }}">
                {!! Form::label('Subject',Lang::get('lang.subject')) !!}<span class="text-red"> *</span>
                {!! Form::text('Subject',null,['class' => 'form-control']) !!}
            </div>
            <div class="col-md-12 form-group {{ $errors->has('Details') ? 'has-error' : '' }}">
                {!! Form::label('Details',Lang::get('lang.message')) !!}<span class="text-red"> *</span>
                {!! Form::textarea('Details',null,['class' => 'form-control']) !!}
            </div>
            {!! Form::hidden('longitude','', ['id' => 'longitude','class' => 'form-control']) !!}
            {!! Form::hidden('latitude','',['id' => 'latitude','class' => 'form-control']) !!}
            <div id="mapdiv" class="col-md-12 form-group">
                <div id="mapid" style="width: 600px; height: 400px;display: none;"></div>
            </div>
            <div class="col-md-12 form-group">
                <div class="btn btn-default btn-file"><i class="fa fa-paperclip"> </i> {!! Lang::get('lang.attachment')
                    !!}<input type="file" name="attachment[]" multiple /></div><br />
                {!! Lang::get('lang.max') !!}. 10MB
            </div>
            {{-- Event fire --}}
            <?php Event::fire(new App\Events\ClientTicketForm()); ?>
            <div class="col-md-12" id="response"> </div>
            <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}"> </div>
            <div class="col-md-12 form-group">{!! Form::submit(Lang::get('lang.Send'),['class'=>'form-group btn btn-info
                pull-left', 'onclick' => 'this.disabled=true;this.value="Sending, please
                wait...";this.form.submit();'])!!}</div>
        </div>
        <div class="col-md-12" id="response"> </div>
        <div id="ss" class="xs-md-6 form-group {{ $errors->has('') ? 'has-error' : '' }}"> </div>
    </div>
    {!! Form::close() !!}
</div>
<!--
|====================================================
| SELECTED FORM STORED IN SCRIPT
|====================================================
-->

<script type="text/javascript">
    var mymap
    var homeIcon = L.icon({
  iconUrl:      '/img/house_marker.png',
  iconSize:     [24, 24],
  iconAnchor:   [12, 24],
  popupAnchor:  [0, -24]
  });
var mymarkers = L.layerGroup([
  L.marker([ 43.669128, -79.343001 ], {icon: homeIcon}).bindPopup("Get Gas Here")
  ]);
var chosenmarker = L.layerGroup([
  ]);

function foundLocation(pos) {
  myLat = pos.coords.latitude;
  myLon = pos.coords.longitude;
  myAcc = pos.coords.accuracy;

 L.marker([ myLat, myLon ]).addTo(mymarkers);
   mymap = L.map('mapid', {    center:       [ myLat, myLon ],    minZoom:      2,    maxZoom:      18,    zoom:         15,    layers: [mymarkers, chosenmarker]    });
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org" target="_blank">OpenStreetMap</a> Imagery © <a href="http://mapbox.com" target="_blank">Mapbox</a>',
        maxZoom:19,
      }).addTo(mymap);
  mymap.on('click', function(e) {
    console.log(myLat);
    console.log( myLon);
    $("#latitude").val(e.latlng.lat);
    $("#longitude").val(e.latlng.lng);
    chosenmarker.clearLayers();
    L.marker([e.latlng.lat,e.latlng.lng]).bindPopup("Chosen Location").addTo(chosenmarker);
    $('#warning').html("Values updated");
    });

  L.control.layers(mymarkers, chosenmarker).addTo(mymap);
  };

function noLocation() {
  document.getElementById("warning").innerHTML = "Could not find your location";
  };

options = {
  enableHighAccuracy:     true,
  timeout:                5000,
  maximumAge:             0
  };

navigator.geolocation.getCurrentPosition(foundLocation, noLocation, options);
</script>
<script type="text/javascript">
    $(document).ready(function(){
   var helpTopic = $("#selectid").val();
   send(helpTopic);
   $("#selectid").on("change",function(){
       helpTopic = $("#selectid").val();
       send(helpTopic);
       usingGeo(helpTopic);
   });
   function send(helpTopic){
       $.ajax({
           url:"{{url('/get-helptopic-form')}}",
           data:{'helptopic':helpTopic},
           type:"GET",
           dataType:"html",
           success:function(response){
                $("#response").html(response);
           },
           error:function(response){

              $("#response").html(response); 
           }
       });
   }
   function usingGeo(helpTopic){
     $.ajax({
           url:"{{url('/get-helptopic-usingeo')}}",
           data:{'helptopic':helpTopic},
           type:"GET",
           success:function(response){
               if(response==1){
                   $("#mapid").show();
                       mymap.invalidateSize();
                      }else
                      {
                        $("#mapid").hide();
                      }   
                              },
           error:function(response){
              $("#response").html(response); 
           }
       });

   }
});

$(function() {
//Add text editor
    $("textarea").wysihtml5();
});
</script>
@stop