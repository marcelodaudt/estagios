<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Estagio;
use PDF;

class enviar_analise_academica_mail extends Mailable
{
    use Queueable, SerializesModels;
    private $estagio;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Estagio $estagio)
    {
        $this->estagio = $estagio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$to = [$this->estagio->email,config('mail.reply_to.address')];
        $to = 'marcelo.daudt@usp.br';
              
        $subject = $this->estagio->nome . ' - RESULTADO DO PARECER DE MÉRITO - Seção de Estágios - ECA-USP';

        $pdf = PDF::loadView('pdfs.parecer', ['estagio'=>$this->estagio]);

        return $this->view('emails.enviar_analise_academica')
                    ->to($to)
                    ->subject($subject)
                    ->attachData($pdf->output(), 'parecer.pdf')
                    ->with([
                        'estagio' => $this->estagio,
                    ]);
    }
}
