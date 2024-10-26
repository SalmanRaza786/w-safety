<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Nette\Utils\Html;
use SMSGlobal\Credentials;
use SMSGlobal\Resource\Sms;

// class OtpViaMailSmsNotification extends Notification
class OtpViaMailSmsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','sms'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {


        return (new MailMessage())
            ->subject('Verification Code')
            ->greeting('Dear user')
            ->line('verification code is mentioned below. It will expire after 10 minutes.')
            ->line(new HtmlString(' <div style="letter-spacing: 1rem;  text-align: center; width: 200px; padding: 10px 20px; padding-right: 0px; border-radius: 0.5rem; margin: 0 auto; font-weight: 700; font-size: 24px; background-color: gray; color: white">' . $this->mailData['otp'] . '</div>'))
            ->replyTo(['Customer Care' => 'customercare@bdc.ae']);

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toSms()
    {
        $contact =$this->mailData['stdData']['data']['mobileno'];
        $otpText ="Dear " . $this->mailData['stdData']['data']['studname'] .",\nYour BDC verification code is " . $this->mailData['otp'] . " \nFor more details visit https://www.bdc.ae or call 8002354272";
        $isUseSmsGlobal = env('Is_USE_SMS_GLOBAL');
        if($isUseSmsGlobal==true){
        return Http::get('https://api.smsglobal.com/http-api.php?action=sendsms&user=quwsoxno&password=pR9gUDSq&from=BELHASA-DC&to=' . $contact . '&text=' . $otpText);
        }else{
        return Http::get('https://sms.bdc.ae/api/send?api_token='.env('SMS_API_TOKEN').'&traffic_id='.$this->mailData['trafficId'].'&phone='.$contact.'&message='.$otpText.'&purpose='.$this->mailData['purpose']);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
