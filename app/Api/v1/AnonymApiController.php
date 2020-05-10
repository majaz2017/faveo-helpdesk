<?php

namespace App\Api\V1;

use App\Http\Controllers\Agent\helpdesk\TicketController as CoreTicketController;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Request as Value;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Utility\CountryCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnonymApiController extends Controller
{

 /**
  * Get help topics.
  *
  * @return json
  */
 public function getHelpTopics()
 {
  try {
   $result = Help_topic::where('status', '=', 1)->get();
   $result = Help_topic::all();

   return response()->json($result);
  } catch (\Exception $e) {
   $error = $e->getMessage();
   $line  = $e->getLine();
   $file  = $e->getFile();
   return response()->json(compact('error', 'file', 'line'));
  }
 }

 /**
  * Create Tickets.
  *
  * @method POST
  *
  * @param name,email,phone,cell_phone,subject,message,helptopic
  *
  * @return json
  */
 public function createTicket(\App\Http\Requests\helpdesk\CreateTicketRequest $request)
 {
  try {
   $user_id         = 1;
   $code            = new CountryCode();
   $code->id        = 104;
   $code->phonecode = 972;
   $code->numcode   = 376;
   $subject         = $request->input('subject');
   $body            = $request->input('body');
   $helptopic       = $request->input('helptopic');
   $sla             = 1;
   $priority        = 2;
   $header          = $request->input('cc');
   $dept            = $request->input('dept');
   $assignto        = $request->input('assignto');
   $form_data       = $request->input('form_data');
   $source          = $request->input('source');
   $attach          = $request->input('attachments');
   $headers         = [];
   if ($header) {
    $headers = explode(',', $header);
   }
   if ($request->hasFile('file')) {

   }

   //return $headers;
   /*
    * return s ticket number
    */
   $PhpMailController      = new \App\Http\Controllers\Common\PhpMailController();
   $NotificationController = new \App\Http\Controllers\Common\NotificationController();
   $core                   = new CoreTicketController($PhpMailController, $NotificationController);
   $request->merge(['body' => preg_replace('/[ ](?=[^>]*(?:<|$))/', '&nbsp;', nl2br($request->get('body')))]);
   $request->replace($request->except('token', 'api_key'));
   $response = $core->post_newticket($request, $code, true);
   //$response = $this->ticket->createTicket($user_id, $subject, $body, $helptopic, $sla, $priority, $source, $headers, $dept, $assignto, $form_data, $attach);
   //return $response;
   /*
    * return ticket details
    */
   //dd($response);
   //$result = $this->thread->where('id', $response)->first();
   //$result = $this->attach($result->id,$file);
   return response()->json(compact('response'));
  } catch (\Exception $e) {
   $error = $e->getMessage();
   $line  = $e->getLine();
   $file  = $e->getFile();
   log::emergency("in catch :" . $error . " " . $line);
   return response()->json(compact('error', 'file', 'line'));
  } catch (\TokenExpiredException $e) {
   $error = $e->getMessage();
   log::emergency("in TokenExpiredException :", $e);
   return response()->json(compact('error'))
    ->header('Authenticate: xBasic realm', 'fake');
  }
 }

 /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function index()
 {
  //
 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function store(Request $request)
 {
  //
 }

 /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show($id)
 {
  //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, $id)
 {
  //
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy($id)
 {
  //
 }
}