<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\invoice;
class Add_invoice extends Notification
{
    use Queueable;
    private $invoices;
    private $type;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(invoice $invoices,$type)
    {
        $this->invoices = $invoices;
        $this->type =$type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        if($this->type == 1){
        return [

            //'data' => $this->details['body']
            'id'=> $this->invoices->id,
            'title'=>'تم اضافة فاتورة جديد بواسطة :',
            'user'=> Auth::user()->name,
        ];
        }
        if($this->type == 2){
            return [

                //'data' => $this->details['body']
                'id'=> $this->invoices->id,
                'title'=>'تم ارشفه فاتورة جديد بواسطة :',
                'user'=> Auth::user()->name,
            ];
            }
        if($this->type == 3){
            return [

                //'data' => $this->details['body']
                'id'=> $this->invoices->id,
                'title'=>'تم تعديل علي الفاتورة  بواسطة :',
                    'user'=> Auth::user()->name,
            ];
        }
        if($this->type == 4){
            return [

                //'data' => $this->details['body']
                'id'=> $this->invoices->id,
                'title'=>'تم تغير حاله دفع فاتورة الي مدفوعه  بواسطة :',
                    'user'=> Auth::user()->name,
            ];
        }
        if($this->type == 5){
            return [

                //'data' => $this->details['body']
                'id'=> $this->invoices->id,
                'title'=>'تم تغير حاله دفع فاتورة الي مدفوعه جزئيا  بواسطة :',
                    'user'=> Auth::user()->name,
            ];
        }

    }
}
