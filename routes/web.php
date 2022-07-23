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
    
    // Route::get("/orcamentos/administrador","App\Http\Controllers\Admin\HomeController@orcamentosAdministrador")->name("admin.orcamentos");
    // Route::get("/orcamentos/corretores/administrador","App\Http\Controllers\Admin\HomeController@outherorcamentos")->name("admin.outherorcamentos");
    Route::get("/orcamentos/corretor/especifico/ver","App\Http\Controllers\Admin\HomeController@corretorOrcamentoEspecifico")->name("corretor.especifico.orcamento.table");
    Route::get("/comissoes/apagar","App\Http\Controllers\Admin\HomeController@comissoesAPagar")->name("comissoes.apagar");
    Route::get("/home/comissoes","App\Http\Controllers\Admin\HomeController@comissoes")->name("home.comissoes");
    Route::get("/home/premiacao","App\Http\Controllers\Admin\HomeController@premiacoes")->name("home.premiacoes");
    Route::get("/listartarefas","App\Http\Controllers\Admin\HomeController@listarTarefasHome")->name("home.listarTarefasHome");
    Route::get("/listarclientes","App\Http\Controllers\Admin\HomeController@listarClientesHome")->name("home.listarClientesHome");
    
    Route::get("/home/pesquisa","App\Http\Controllers\Admin\HomeController@searchHome")->name("admin.home.search");
    Route::post("/home/pesquisa","App\Http\Controllers\Admin\HomeController@storeSearch")->name("admin.home.search.post");

    Route::get("/home/relatorio","App\Http\Controllers\Admin\HomeController@relatorio")->name("home.relatorio");
    Route::post("/home/relatorio","App\Http\Controllers\Admin\HomeController@criarRelatorio")->name("home.relatorio.post");
    
    Route::get("/colaborador/{id}/detalhes","App\Http\Controllers\Admin\HomeController@detalhesColaborador")->name("home.administrador.colaborador");





    Route::resource("corretora","App\Http\Controllers\Admin\CorretoraController");


    /** Cotacao */
    Route::get("/cotacao/orcamento/{id}","App\Http\Controllers\Admin\CotacaoController@orcamento")->name("cotacao.orcamento");
    Route::post("/cotacao/orcamento","App\Http\Controllers\Admin\CotacaoController@montarPlano")->name("cotacao.montarPlanos");
    Route::get("/cotacao/contrato/{id}","App\Http\Controllers\Admin\CotacaoController@contrato")->name("cotacao.contrato");

    // Route::post("/cotacao/montarValores","App\Http\Controllers\Admin\CotacaoController@montarValores")->name("contrato.montarValores");
    Route::post("/cotacao/cadastrarContrato","App\Http\Controllers\Admin\CotacaoController@storeContrato")->name("contrato.store");
    Route::post("/cotacao/montarValoresFormularioAcomodacao","App\Http\Controllers\Admin\CotacaoController@montarValoresFormularioAcomodacao")->name("contrato.montarValoresFormularioAcomodacao");

    Route::get("/cotacao/contrato/comissao/{id_cliente}","App\Http\Controllers\Admin\CotacaoController@detalhesDoContratoComissoes")->name("cotacao.comissao.detalhes");

    Route::get("/criar/pdf/{id_orcamento}/{id_cidade}/{plano_id}/{coparticipacao}/{odonto}/{operadora_id}/{administradora_id}","App\Http\Controllers\Admin\CotacaoController@criarPDF")->name("cotacao.pdf");
    

    Route::get("/corretores","App\Http\Controllers\Admin\CorretoresController@index")->name("corretores.index");
    Route::get("/corretores/create","App\Http\Controllers\Admin\CorretoresController@create")->name("corretores.create");
    Route::post("/corretores/store","App\Http\Controllers\Admin\CorretoresController@store")->name("corretores.store");
    Route::get("/corretores/{id}/edit","App\Http\Controllers\Admin\CorretoresController@edit")->name("corretores.edit");
    Route::put("/corretores/{id}/update","App\Http\Controllers\Admin\CorretoresController@update")->name("corretores.update");
    Route::delete("/corretores/deletar/{id}","App\Http\Controllers\Admin\CorretoresController@destroy")->name("corretores.destroy");    

    Route::get("/corretores/comissao/{id}","App\Http\Controllers\Admin\ComissoesCorretoresConfiguracoesController@index")->name('comissao.corretores.index');
    Route::get("/corretores/cadastrar/comissao/{id}","App\Http\Controllers\Admin\ComissoesCorretoresConfiguracoesController@create")->name('comissao.corretores.cadastrar');
    Route::post("/corretores/comissao/store","App\Http\Controllers\Admin\ComissoesCorretoresConfiguracoesController@store")->name('comissao.corretores.store');
    Route::get("/corretores/{id_corretor}/detalhes/{id_plano}/{id_administradora}","App\Http\Controllers\Admin\ComissoesCorretoresConfiguracoesController@detalhes")->name('comissao.corretores.detalhes');

    Route::get("/corretores/premiacao/{id}","App\Http\Controllers\Admin\PremiacaoCorretoresConfiguracoesController@index")->name('premiacao.corretores.index');
    Route::get("/corretores/cadastrar/premiacao/{id}","App\Http\Controllers\Admin\PremiacaoCorretoresConfiguracoesController@create")->name('premiacao.corretores.cadastrar');
    Route::post("/corretores/premiacao/store","App\Http\Controllers\Admin\PremiacaoCorretoresConfiguracoesController@store")->name('premiacao.corretores.store');
    //Route::get("/corretores/{id_corretor}/detalhes/{id_plano}/{id_administradora}","App\Http\Controllers\Admin\PremiacaoCorretoresConfiguracoesController@detalhes")->name('premiacao.corretores.detalhes');




    
    Route::resource("operadora","App\Http\Controllers\Admin\OperadoraController");
    Route::resource("administradora","App\Http\Controllers\Admin\AdministradoraController");

    /** VENDAS  */
    // Route::get("/vendas/operadora","App\Http\Controllers\Admin\VendasController@operadora")->name("vendas.operadora");
    // Route::post("/vendas/operadora/store","App\Http\Controllers\Admin\VendasController@storeoperadora")->name("vendas.operadora.store");
    // Route::get("/vendas/administradora","App\Http\Controllers\Admin\VendasController@administradora")->name("vendas.administradora");
    // Route::get("/vendas/{id}/edit","App\Http\Controllers\Admin\VendasController@editar")->name("vendas.editar");
    

    // Route::any("/relatorios/index","App\Http\Controllers\Admin\RelatorioController@index")->name("relatorio.index");    


    /** Tabela */
    Route::get("/tabela","App\Http\Controllers\Admin\TabelaController@index")->name("tabela.index");
    Route::post("/tabela","App\Http\Controllers\Admin\TabelaController@store")->name("tabela.store");
    Route::post("/tabela/search","App\Http\Controllers\Admin\TabelaController@pesquisar")->name("tabela.pesquisar");
    Route::get("/tabela/search","App\Http\Controllers\Admin\TabelaController@search")->name("tabela.search");

    Route::post("/tabelas/pegar/cidades/administradoras","App\Http\Controllers\Admin\TabelaController@pegarCidadeAdministradora")->name("cidades.administradoras.pegar");
    Route::post("/tabela/orcamento/alterar","App\Http\Controllers\Admin\TabelaController@edit")->name("tabela.edit.valor");

    
  
    

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
    



    /** Tabela de preços quando escolher a administradora pegar as cidades via AJAX*/
    Route::post("/cidades/pegar","App\Http\Controllers\Admin\CidadeController@pegarCidade")->name("cidades.pegar");

    

    /** Em orçamentos quando escolher a cidade mostras as administradoras via AJAX*/
    Route::post("/cidades/pegar/operadoras","App\Http\Controllers\Admin\CidadeController@pegarOperadorasViaCidade")->name("cidades.pegar.operadoras");

    /** Fim Cidades */

    /** Profile */    


    Route::get("/profile/{id}","App\Http\Controllers\Admin\UserController@getUser")->name("profile.getUser");
    Route::put("/profile/{id}","App\Http\Controllers\Admin\UserController@setUser")->name("profile.setUser");

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
    Route::post("/cliente/existe","App\Http\Controllers\Admin\ClienteController@clienteExisteAjax")->name("cliente.existe");

    Route::post("/clientes/definirStatus","App\Http\Controllers\Admin\ClienteController@definirStatus")->name("clientes.definirStatus");
    Route::post("/clientes/mudarStatus","App\Http\Controllers\Admin\ClienteController@mudarStatus")->name("clientes.mudarStatus");
    Route::get("/clientes/corretores","App\Http\Controllers\Admin\ClienteController@clientesCorretores")->name("clientes.corretores");
    Route::get("/clientes/dos/corretores","App\Http\Controllers\Admin\ClienteController@pegarClientesCorretores")->name("clientes.pegarClientesCorretores");
    Route::post("/clientes/contrato/sem/orcamento","App\Http\Controllers\Admin\ClienteController@contratoSemOrcamento")->name("clientes.contratoSemOrcamento");
    
    Route::post("/cliente/searchclienteAjax","App\Http\Controllers\Admin\ClienteController@searchclienteAjax")->name("cliente.searchclienteAjax");

    
    
    
    
    
    
    

    
    
    Route::post("/cliente/listarPorEtiqueta","App\Http\Controllers\Admin\ClienteController@listarPorEtiqueta")->name("cliente.listarPorEtiqueta");
    Route::post("/cliente/listarPorEtiquetaAll","App\Http\Controllers\Admin\ClienteController@listarPorEtiquetaAll")->name("cliente.listarPorEtiquetaAll");
    Route::get("/contratos","App\Http\Controllers\Admin\ClienteController@listarContratos")->name("contratos.index");
    

    /** Fim Cliente */


    /** Tarefa */
    Route::get("/clientes/{id}/tarefa","App\Http\Controllers\Admin\TarefaController@agendaTarefa")->name("clientes.agendarTarefa");
    Route::post("/clientes/tarefas/store","App\Http\Controllers\Admin\TarefaController@cadastrarTarefa")->name("clientes.cadastrarTarefa");
    Route::post("/clientes/fullcalendar/especifico","App\Http\Controllers\Admin\TarefaController@clienteTarefaEspecifica")->name("cliente.tarefaEspecifica");
    Route::put("/clientes/alterar/tarefa","App\Http\Controllers\Admin\TarefaController@alterarClienteTarefaEspecifica")->name("cliente.alterarClienteTarefaEspecifica");
    Route::post("/clientes/eventdrop/edit","App\Http\Controllers\Admin\TarefaController@tarefaEventDropEdit")->name("cliente.eventdrop.edit");
    Route::post("/clientes/deletar","App\Http\Controllers\Admin\TarefaController@deletarCliente")->name("cliente.deletarCliente");
    Route::get("/tarefas/proximas","App\Http\Controllers\Admin\TarefaController@tarefasProximo03Dias")->name("cliente.tarefas.proximas");
    Route::get("/tarefas/atrasadas","App\Http\Controllers\Admin\TarefaController@clienteTarefasAtrasadasHome")->name("tarefa.clienteTarefasAtrasadasHome");
    Route::post("/cliente/clientesemtarefa","App\Http\Controllers\Admin\TarefaController@clienteSemTarefaAjax")->name("cliente.semtarefasajax");
    Route::post("/cliente/clientestarefaatrasadas","App\Http\Controllers\Admin\TarefaController@clienteTarefasAtrasadasAjax")->name("cliente.tarefasatrasadasajax");
    Route::post("/cliente/tarefaMudarStatusAjax","App\Http\Controllers\Admin\TarefaController@mudarStatusTarefaAjax")->name("cliente.mudarStatusTarefaAjax");
    Route::post("/cliente/tarefasRealizadasAjax","App\Http\Controllers\Admin\TarefaController@tarefasRealizadasAjax")->name("tarefa.tarefasRealizadas");

    /** Fim Tarefa */




    /** Comissoes */
    
    Route::get("comissoes","App\Http\Controllers\Admin\ComissoesController@index")->name("comissoes.index");
    Route::get("comissoes/{id}/detalhes","App\Http\Controllers\Admin\ComissoesController@detalhes")->name("comissoes.detalhes");
    Route::post("comissoes/mudarStatus","App\Http\Controllers\Admin\ComissoesController@mudarStatus")->name("comissoes.mudarStatus");
    Route::post("comissoes/mudarStatus/premiacao","App\Http\Controllers\Admin\ComissoesController@mudarStatusPremiacao")->name("comissoes.mudarStatusPremiacao");
    
    Route::post("comissoes/mudarStatusCorretora","App\Http\Controllers\Admin\ComissoesController@mudarStatusCorretora")->name("comissoes.mudarStatusCorretora");
    Route::post("comissoes/mudarStatus/premiacaoCorretora","App\Http\Controllers\Admin\ComissoesController@mudarStatusCorretoraPremiacao")->name("comissoes.mudarStatusCorretoraPremiacao");


    /** Fim Comissoes */



});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


