<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Saque;

class ConfirmacaoSaque extends Notification implements ShouldQueue
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
        return ['mail','database'];
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
                    ->subject('Confirmação de Saque - WACORNER')
                    ->line($this->saque->user->nome.', seu saque no valor de R$'.$this->saque->valor.', já foi pago, dentro de até 72h já estara disponivel na sua conta, caso não aparece esse pagamento, entre em contato pelo E-mail: wacornerstats@gmail.com.')
                    ->line('Obrigado pela confiança!');
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
        'icone' => 'usd',
        'titulo' => 'Confirmação de Saque',
        'texto' => $this->saque->user->nome.', seu saque no valor de R$'.$this->saque->valor.', já foi pago, dentro de até 72h já estara disponivel na sua conta, caso não aparece esse pagamento, entre em contato pelo E-mail: wacornerstats@gmail.com.',
        'url' => '#'
        ];
    }
}
