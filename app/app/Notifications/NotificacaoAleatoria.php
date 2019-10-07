<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotificacaoAleatoria extends Notification implements ShouldQueue
{
    use Queueable;
    public $icone;
    public $titulo;
    public $texto;
    public $url;
    public $url_texto;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($icone,$titulo,$texto,$url,$url_texto)
    {
        $this->icone = $icone;
        $this->titulo = $titulo;
        $this->texto = $texto;
        $this->url = $url;
        $this->url_texto = $url_texto;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Olá!')
                    ->subject($this->titulo.' - WACORNER')
                    ->line($this->texto)
                    ->action($this->url_texto, $this->url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
        'icone' => $this->icone,
        'titulo' => $this->titulo,
        'texto' => $this->texto,
        'url' => $this->url
        ];
    }
}
