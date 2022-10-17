<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\User;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        

        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {

            $event->menu->addIn('prospeccao', [
                'text' => 'Prospecção',
                'label'       => $event->qteLeeds(),
                'label_color' => 'success',
                'url' => 'admin/leads/prospeccao',
                'icon'    => 'fas fa-user',
                'classes'  => 'text-white'
                        
            ],[
                
                "text" => "Plantão de Vendas",
                "url" => "",
                'icon'    => 'fab fa-salesforce',
                'classes'  => 'text-white',
                'label'       => 0,
                'label_color' => 'danger',
                    
            ]);

            $event->menu->addIn('clientes',[
                "text" => "Pessoa Fisica",
                "url" => "admin/clientes/pf",
                'icon'    => 'fas fa-list',
                'classes' => 'text-white',
                'label'       => $event->qtdClientePF(),
                'label_color' => 'success',    
            ],[
                "text" => "Pessoa Juridica",
                "url" => "admin/clientes/pj",
                'icon'    => 'fa fa-file-signature',
                'classes' => ' text-white',
                'label'       => $event->qtdClietePJ(),
                'label_color' => 'primary',   

            ]);

            $event->menu->addIn('contratos_pf',
                [
                    "text" => "Pendentes",
                    "url" => "admin/contratos/pf/pendentes",
                    'icon'    => 'fas fa-ellipsis-h',
                    'classes' => 'text-white',
                    'label'       => $event->qtdContratosPF(),
                    'label_color' => 'primary',     
                ],
                [
                    "text" => "Finalizados",
                    "url" => "",
                    'icon'    => 'fas fa-thumbs-up',
                    'classes' => 'text-white',
                    'label'       => 0,
                    'label_color' => 'danger',     
                ]
        );



            // if($event->userAuthenticate()->admin) {
            //     $event->menu->addIn('orcamento', [
            //         'text' => 'Cadastrar Orçamentos',
            //         'icon' => "fas fa-plus",
            //         'url' => route('orcamento.index')
                    
            //     ],[
            //         'text' => 'Meus Orçamentos',
            //         'icon' => "fas fa-list",
            //         'url' => route('orcamento.admin.show',$event->userAuthenticate()->id),
            //     ],[
            //         'text' => 'Orçamentos Corretores',
            //         'icon' => "fas fa-clipboard-list",
            //         'url' => route('orcamentos.por.corretores',[$event->userAuthenticate()->corretora_id,$event->userAuthenticate()->id]),
            //     ]);
            // } else {
            //     $event->menu->addIn('orcamento', [
            //         'text' => 'Cadastrar Orçamento',
            //         'icon' => "fas fa-plus",
            //         'url' => route('orcamento.index'),
            //     ],[
            //         'text' => 'Meus Orçamentos',
            //         'icon' => "fas fa-list",
            //         'url' => route('orcamento.corretor.show',$event->userAuthenticate()->id),
            //     ]);
            // }
        });
        
    }
}
