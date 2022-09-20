<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MensagemTesteMail extends Mailable
{
    use Queueable, SerializesModels;
    private $pdf;
    private $nome;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf,$nome)
    {
        $this->pdf = $pdf;
        $this->nome = $nome;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.mensagem-email')
            ->subject("Envio do Orçamento".substr(time(),0,5))
            ->attachData($this->pdf,$this->nome."-".date('d')."-".date('m')."-".date('Y')."-".substr(time(),0,5).".pdf" , ['mime' => 'application/pdf']);
    }
}
