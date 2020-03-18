<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Saque;

class SaquesPendentes extends Notification implements ShouldQueue
{
    use Queueable;

    public $saque;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($saque)
    {
        $this->saque = $saque;
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
                    ->line($this->saque->user->nome.', fez um pedido de saque no valor de R$'.$this->saque->valor.'!')
                    ->action('Saques Pendentes', route('saque.pendentes'))
                    ->line('Verifique os dados e faça o pagamento!');
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
        'icone' => 'retweet',
        'titulo' => 'Novo pedido de saque',
        'texto' => $this->saque->user->nome.', fez um pedido de saque no valor de R$'.$this->saque->valor.'!',
        'url' => route('saque.pendentes')
        ];
    }
}
