<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class MailController extends Controller {
    public $subject = "Default Subject";
    public $to = "";

    function __construct($subject, $to) {
      $this->subject = $subject;
      $this->to = $to;
    }

   public function basic_email() {
      $data = array('name'=>"Virat Gandhi");
      print(env("MAIL_FROM_ADDRESS"));
    Mail::send([],['name','Ripon Uddin Arman'],function($message){
        $message->to('maximiliano.olivera@dualbootpartners.com')->subject($this->subject);
        $message->from('angelotunado02@gmail.com','LearnDo');
    });
   }
   public function html_email_confirm_account($uid) {
      $link = 'http://' . env("APP_FRONTEND_DOMAIN_URL") . "/activate/" . $uid;
      $data = array('link'=> $link);
      Mail::send(['html' => "accountConfirmation"], $data, function($message) {

         $message->to($this->to, 'Tutorials Point')->subject
            ($this->subject);
         $message->from('angelotunado02@gmail.com','LearnDo');
      });
   }
   public function attachment_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
   }
}
