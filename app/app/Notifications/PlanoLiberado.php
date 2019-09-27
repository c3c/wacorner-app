<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PlanoLiberado extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $user;
    private $plano;

    public function __construct($user,$plano)
    {
        $this->user = $user;
        $this->plano = $plano;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject('Plano '.$this->plano.' liberado - Wacorner')
            ->line('Seu plano '.$this->plano.' foi liberado com sucesso.')
            ->action('Acesse seu painel', url(config('app.url')))
            ->line('Após o termino do seu plano, você deve ir em NOVO PLANO, e adquirir outro para continuar utilizando o sistema, ou você pode adquirir antes do termino do seu plano, com isso será adicionado o numero de dias do novo plano.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
