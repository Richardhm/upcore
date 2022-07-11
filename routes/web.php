<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Route::middleware('auth')->prefix("admin")->group(function(){
    
    /** Dashboard */

    Route::get("/","App\Http\Controllers\Admin\HomeController@index")->name("admin.home");
    Route::get("/orcamentos/administrador","App\Http\Controllers\Admin\HomeController@orcamentosAdministrador")->name("admin.orcamentos");
    Route::get("/orcamentos/corretores/administrador","App\Http\Controllers\Admin\HomeController@outherorcamentos")->name("admin.outherorcamentos");
    Route::get("/orcamentos/corretor/especifico/ver","App\Http\Controllers\Admin\HomeController@corretorOrcamentoEspecifico")->name("corretor.especifico.orcamento.table");
    Route::get("/comissoes/apagar","App\Http\Controllers\Admin\HomeController@comissoesAPagar")->name("comissoes.apagar");
    Route::get("/comissoes/areceber","App\Http\Controllers\Admin\HomeController@areceber")->name("comissoes.areceber");
    
    


    Route::resource("corretora","App\Http\Controllers\Admin\CorretoraController");


    /** Cotacao */
    Route::get("/cotacao/orcamento/{id}","App\Http\Controllers\Admin\CotacaoController@orcamento")->name("cotacao.orcamento");
    Route::post("/cotacao/orcamento","App\Http\Controllers\Admin\CotacaoController@montarPlano")->name("cotacao.montarPlanos");
    Route::get("/cotacao/contrato/{id}","App\Http\Controllers\Admin\CotacaoController@contrato")->name("cotacao.contrato");

    // Route::post("/cotacao/montarValores","App\Http\Controllers\Admin\CotacaoController@montarValores")->name("contrato.montarValores");
    Route::post("/cotacao/cadastrarContrato","App\Http\Controllers\Admin\CotacaoController@storeContrato")->name("contrato.store");
    Route::post("/cotacao/montarValoresFormularioAcomodacao","App\Http\Controllers\Admin\CotacaoController@montarValoresFormularioAcomodacao")->name("contrato.montarValoresFormularioAcomodacao");




    Route::get("/corretores","App\Http\Controllers\Admin\CorretoresController@index")->name("corretores.index");
    Route::get("/corretores/create","App\Http\Controllers\Admin\CorretoresController@create")->name("corretores.create");
    Route::post("/corretores/store","App\Http\Controllers\Admin\CorretoresController@store")->name("corretores.store");
    Route::get("/corretores/{id}/edit","App\Http\Controllers\Admin\CorretoresController@edit")->name("corretores.edit");
    Route::put("/corretores/{id}/update","App\Http\Controllers\Admin\CorretoresController@update")->name("corretores.update");
    Route::delete("/corretores/deletar/{id}","App\Http\Controllers\Admin\CorretoresController@destroy")->name("corretores.destroy");    


    
    Route::resource("operadora","App\Http\Controllers\Admin\OperadoraController");
    Route::resource("administradora","App\Http\Controllers\Admin\AdministradoraController");

    /** VENDAS  */
    Route::get("/vendas/operadora","App\Http\Controllers\Admin\VendasController@operadora")->name("vendas.operadora");
    Route::post("/vendas/operadora/store","App\Http\Controllers\Admin\VendasController@storeoperadora")->name("vendas.operadora.store");
    Route::get("/vendas/administradora","App\Http\Controllers\Admin\VendasController@administradora")->name("vendas.administradora");
    Route::get("/vendas/{id}/edit","App\Http\Controllers\Admin\VendasController@editar")->name("vendas.editar");
    

    Route::any("/relatorios/index","App\Http\Controllers\Admin\RelatorioController@index")->name("relatorio.index");    


    /** Tabela */
    Route::get("/tabela","App\Http\Controllers\Admin\TabelaController@index")->name("tabela.index");
    Route::post("/tabela","App\Http\Controllers\Admin\TabelaController@store")->name("tabela.store");
    Route::post("/tabela/search","App\Http\Controllers\Admin\TabelaController@pesquisar")->name("tabela.pesquisar");
    Route::get("/tabela/search","App\Http\Controllers\Admin\TabelaController@search")->name("tabela.search");

    Route::post("/tabelas/pegar/cidades/administradoras","App\Http\Controllers\Admin\TabelaController@pegarCidadeAdministradora")->name("cidades.administradoras.pegar");
    
    /**************************************************** Orcamentos *************************************************************/


        /****************************************************  Menu Cadastro  *******************************************************/
        
        /** Tela de Cadastrar Orcamento - Tela de Cadastro - view => admin.pages.orcamento.index */
        //Route::get("/orcamento/create","App\Http\Controllers\Admin\OrcamentoController@index")->name("orcamento.index");//tela de cadastro do orcamento

        // Route::get("/orcamento","App\Http\Controllers\Admin\OrcamentoController@index")->name("orcamento.index");




        /** Cadastrar Orcamento Montar Plano Via Ajax */
        // Route::post("/orcamentos/planos","App\Http\Controllers\Admin\OrcamentoController@montarPlano")->name("orcamento.planos");
        /****************************************************  Menu Cadastro  *******************************************************/

        /****************************************************  Menu Meus Orçamentos *************************************************/

        /** Listar Orcamentos do Administrador Logado - view => admin.pages.orcamento.administrador.listar-orcamento-administrador */
        // Route::get("/orcamentos/administrador/{id_admin}","App\Http\Controllers\Admin\OrcamentoController@listarAdministrador")->name("orcamento.admin.show");

        /** Administrador && Corretor Visualizar os orcamentos de um cliente Especifico - URL - admin/orcamentos/cliente/5 - View => admin.pages.orcamento.administrador.listar-orcamento-por-cliente  */
        // Route::get("/orcamentos/cliente/{id_cliente}","App\Http\Controllers\Admin\OrcamentoController@listarOrcamentoPorCliente")->name("orcamento.detalhes");

        /** Administrador && Corretor Ver Detalhe do orcamento de um Cliente URL - orcamentos/ver/orcamento/5 View => admin.pages.orcamento.administrador.listar-orcamento-por-id-orcamento */
        // Route::get("/orcamentos/ver/orcamento/{id_orcamento}","App\Http\Controllers\Admin\OrcamentoController@showOrcamentoUnico")->name("orcamentos.show.detalhe"); 

        /** Corretor ve listagem de seus orcamentos listagem de cliente - URL => orcamentos/corretor/3  */
        //Route::get("/orcamentos/corretor/{id_corretor}","App\Http\Controllers\Admin\OrcamentoController@listarCorretor")->name("orcamento.corretor.show"); 

        /****************************************************  Fim Menu Meus Orçamentos *************************************************/

        /********************************************** Menu Orçamentos Corretores *****************************************************/
            
        /** Administrador visualizar orcamentos dos corretores da corretora - URL - orcamentos/1/corretor/1 VIEW => admin.pages.orcamento.administrador.listar-corretores-por-corretora  */
        // Route::get("/orcamentos/{id_corretora}/corretor/{id_administrador}","App\Http\Controllers\Admin\OrcamentoController@orcamentosCorretoresDaCorretora")->name("orcamentos.por.corretores");

        /** Administrador ver orçamento de um determinado corretor - URL - orcamentos/2/visualizar - View => admin.pages.orcamento.administrador.listar-orcamento-corretor-especifico */
        // Route::get("/orcamentos/{id_corretor}/visualizar","App\Http\Controllers\Admin\OrcamentoController@listarOrcamentoPorCorretor")->name("orcamento.por.corretor");
    
        /** Administrador ver orçamento especifico do corretor - URL - orcamentos/1/detalhe - View => admin.pages.orcamento.administrador.listar-orcamento-detalhe-corretor  */
        // Route::get("/orcamentos/{id_orcamento}/detalhe","App\Http\Controllers\Admin\OrcamentoController@listarOrcamentoDetalhe")->name("orcamento.detalhe.corretor");

        /********************************************** Fim Menu Orçamentos Corretores *****************************************************/


        /** Editar valor abrir modal da pagina via AJAX em admin/tabela/search */
        // Route::post("/orcamento/alterar","App\Http\Controllers\Admin\OrcamentoController@edit")->name("orcamento.edit.valor");

        /** Mudar Status da Tag Via AJAX */
        // Route::post("/orcamentos/mudar/status","App\Http\Controllers\Admin\OrcamentoController@mudarStatusEtiqueta")->name("orcamentos.mudar.etiqueta");

        /** Criar PDF */
        Route::get("/criar/pdf/{id_orcamento}/{id_cidade}/{plano_id}/{coparticipacao}/{odonto}/{operadora_id}/{administradora_id}","App\Http\Controllers\Admin\OrcamentoController@criarPDF")->name("orcamento.pdf");

    /**************************************************** Fim Orcamentos *********************************************************/
    

    /** Etiquetas */
    Route::get("/etiquetas","App\Http\Controllers\Admin\EtiquetasController@index")->name("etiquetas.index");
    Route::get("/etiquetas/cadastrar","App\Http\Controllers\Admin\EtiquetasController@cadastrar")->name("etiquetas.cadastrar");
    Route::post("/etiquetas/store","App\Http\Controllers\Admin\EtiquetasController@store")->name("etiquetas.store");

    Route::get("/etiquetas/editar/{id}","App\Http\Controllers\Admin\EtiquetasController@edit")->name("etiquetas.edit");
    Route::delete("/etiquetas/deletar/{id}","App\Http\Controllers\Admin\EtiquetasController@deletar")->name("etiquetas.destroy");

    Route::put("/etiquetas/{id}/update","App\Http\Controllers\Admin\EtiquetasController@update")->name("etiquetas.update");
    Route::get("/etiqueta/{id}","App\Http\Controllers\Admin\EtiquetasController@listarPorEtiquetaEspefifica")->name("home.listarPorEtiquetaEspecifica");

   

    /** Cidades */
    Route::get("/cidades","App\Http\Controllers\Admin\CidadeController@index")->name('cidades.index');
    Route::get("/cidades/cadastrar","App\Http\Controllers\Admin\CidadeController@cadastrar")->name('cidades.cadastrar');
    Route::get("/cidades/vincular/{cidade}","App\Http\Controllers\Admin\CidadeController@vincular")->name('cidades.vincular');
    Route::post("/cidades/{cidade}/vincular","App\Http\Controllers\Admin\CidadeController@vincularAdministradora")->name("cidade.vincular.administradora");
    Route::post("/cidades/store","App\Http\Controllers\Admin\CidadeController@store")->name('cidades.store');
    Route::delete("/cidades/destroy/{id}","App\Http\Controllers\Admin\CidadeController@destroy")->name("cidades.destroy");
    Route::any("/cidades/pesquisar","App\Http\Controllers\Admin\CidadeController@search")->name('cidades.pesquisar');



    /** Tabela de preços quando escolher a administradora pegar as cidades via AJAX*/
    Route::post("/cidades/pegar","App\Http\Controllers\Admin\CidadeController@pegarCidade")->name("cidades.pegar");

    

    /** Em orçamentos quando escolher a cidade mostras as administradoras via AJAX*/
    Route::post("/cidades/pegar/operadoras","App\Http\Controllers\Admin\CidadeController@pegarOperadorasViaCidade")->name("cidades.pegar.operadoras");

    /** Fim Cidades */

    /** Profile */    


    Route::get("/profile/{id}","App\Http\Controllers\Admin\UserController@getUser")->name("profile.getUser");
    Route::put("/profile/{id}","App\Http\Controllers\Admin\UserController@setUser")->name("profile.setUser");

    Route::get("/contratos","App\Http\Controllers\Admin\ContratoController@index")->name("contratos.index");
    //Route::post("/contratos/pessoa_fisica","App\Http\Controllers\Admin\ContratoController@cadastrarPF")->name("contrato.cadastrarPF");
    //Route::post("/contratos/sem_orcamento/pessoa_fisica","App\Http\Controllers\Admin\ContratoController@montarContratoSemOrcamento")->name("contrato.montarContratoSemOrcamento");
    //Route::post("/contratos/store/pf","App\Http\Controllers\Admin\ContratoController@cadastrarContratoSemOrcamento")->name("contrato.cadastrarPFSemOrcamento");
    


    /** Fim Profile */

    /** Planos */


    Route::get("/planos","App\Http\Controllers\Admin\PlanoController@index")->name("plano.index");
    
    Route::get("/planos/cadastrar","App\Http\Controllers\Admin\PlanoController@create")->name("plano.create");
    Route::post("/planos","App\Http\Controllers\Admin\PlanoController@store")->name("plano.store");
    Route::delete("/planos/{id}","App\Http\Controllers\Admin\PlanoController@delete")->name("plano.delete");

    Route::get("/planos/vincular/{id}","App\Http\Controllers\Admin\PlanoController@vincular")->name("plano.vincular");
    Route::post("/planos/{administradora}/vincular","App\Http\Controllers\Admin\PlanoController@vincularAdministradoras")->name("plano.administradora.vincular");

    /** Fim Planos */

    /** Cliente */
    Route::get("/clientes","App\Http\Controllers\Admin\ClienteController@index")->name('clientes.index');
    Route::get("/clientes/cadastrar","App\Http\Controllers\Admin\ClienteController@create")->name("clientes.cadastrar");
    Route::get("/cliente/orcamento/{id}","App\Http\Controllers\Admin\ClienteController@clienteOrcamento")->name("cliente.orcamento");
    Route::get("/cliente/contrato/{id}","App\Http\Controllers\Admin\ClienteController@clienteContrato")->name("cliente.contrato");
    Route::post("/clientes/store","App\Http\Controllers\Admin\ClienteController@store")->name("clientes.store");
    Route::post("/clientes/definirStatus","App\Http\Controllers\Admin\ClienteController@definirStatus")->name("clientes.definirStatus");
    Route::post("/clientes/mudarStatus","App\Http\Controllers\Admin\ClienteController@mudarStatus")->name("clientes.mudarStatus");
    Route::get("/clientes/corretores","App\Http\Controllers\Admin\ClienteController@clientesCorretores")->name("clientes.corretores");
    Route::get("/clientes/dos/corretores","App\Http\Controllers\Admin\ClienteController@pegarClientesCorretores")->name("clientes.pegarClientesCorretores");
    Route::post("/clientes/contrato/sem/orcamento","App\Http\Controllers\Admin\ClienteController@contratoSemOrcamento")->name("clientes.contratoSemOrcamento");
    Route::get("/clientes/{id}/tarefa","App\Http\Controllers\Admin\ClienteController@agendaTarefa")->name("clientes.agendarTarefa");
    Route::post("/clientes/tarefas/store","App\Http\Controllers\Admin\ClienteController@cadastrarTarefa")->name("clientes.cadastrarTarefa");
    Route::post("/clientes/fullcalendar/especifico","App\Http\Controllers\Admin\ClienteController@clienteTarefaEspecifica")->name("cliente.tarefaEspecifica");
    Route::put("/clientes/alterar/tarefa","App\Http\Controllers\Admin\ClienteController@alterarClienteTarefaEspecifica")->name("cliente.alterarClienteTarefaEspecifica");
    Route::post("/clientes/deletar","App\Http\Controllers\Admin\ClienteController@deletarCliente")->name("cliente.deletarCliente");
    Route::post("/clientes/eventdrop/edit","App\Http\Controllers\Admin\ClienteController@tarefaEventDropEdit")->name("cliente.eventdrop.edit");
    Route::post("/cliente/listarPorEtiqueta","App\Http\Controllers\Admin\ClienteController@listarPorEtiqueta")->name("cliente.listarPorEtiqueta");
    Route::post("/cliente/listarPorEtiquetaAll","App\Http\Controllers\Admin\ClienteController@listarPorEtiquetaAll")->name("cliente.listarPorEtiquetaAll");
    

    /** Fim Cliente */


    /** Comissoes */
    
    Route::get("comissoes","App\Http\Controllers\Admin\ComissoesController@index")->name("comissoes.index");
    Route::get("comissoes/{id}/detalhes","App\Http\Controllers\Admin\ComissoesController@detalhes")->name("comissoes.detalhes");
    Route::post("comissoes/mudarStatus","App\Http\Controllers\Admin\ComissoesController@mudarStatus")->name("comissoes.mudarStatus");
    



    /** Fim Comissoes */



});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


