<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminNotification extends Notification
{
    use Queueable;
    public $data;
    public $action_name;

    /**
     * 
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $action_name)
    {
        $this->data = $data;
        $this->action_name = $action_name;
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
        return [
            'create_time' => \Carbon\Carbon::now(),
            'user' => auth()->user(),
            'data' => $this->data,
            'action_name' => $this->action_name,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
