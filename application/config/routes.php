<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'diapha/diapha/relatos';
$route['404_override'] = '';



$route['temp/corrige_validade'] = 'temp/corrige_validade';
$route['teste'] = 'temp/teste';
$route['mkDir'] = 'temp/mkDir';
$route['rmDir'] = 'temp/rmDir';
$route['teste'] = 'temp/clipping';

/**
 * Portal
 */
$route['portal']                      = "diapha/diapha/relatos";
$route['portal/quem_somos']           = "portal/estatico/quem_somos";
$route['portal/arp']                  = "portal/estatico/arp";
$route['portal/consultores']          = "portal/estatico/consultores";
$route['portal/servicos']             = "portal/estatico/servicos";
$route['portal/representantes']       = "portal/estatico/representantes";
$route['portal/email_marketing']      = "portal/estatico/email_marketing";
$route['portal/banner_site']          = "portal/estatico/banner_site";
$route['portal/contato']              = "portal/estatico/contato";
$route['portal/enviar_mensagem']      = "portal/estatico/enviar_mensagem";
$route['portal/termos_servico']       = "portal/estatico/termos_servico";
$route['portal/contrato_servico']     = "portal/estatico/contrato_servico";
$route['portal/confirma_cadastro']    = "portal/estatico/confirma_cadastro";
$route['portal/boas_vindas']          = "portal/estatico/boas_vindas";
$route['portal/estimativa_preco']     = "portal/estatico/estimativa_preco";
$route['portal/destaque_ajax']        = "portal/inicial/destaque_ajax";
$route['portal/selecionar_perfil']    = "portal/estatico/selecionar_perfil";
$route['portal/selecionar_perfil/fb']    = "portal/estatico/selecionar_perfil";
//$route['portal/selecionar_perfil/fb'] = "portal/estatico/selecionar_perfil2";
$route['portal/nao_encontrei']        = "portal/estatico/nao_encontrei";


/**
 * Login
 */
$route['login']              = "login/logon";
$route['login/autenticar']   = "login/autenticar";
$route['logoff']             = "login/logoff";
$route['esqueci_senha']      = "login/esqueci_senha";
$route['sem_acesso']         = "login/sem_acesso";
$route['sem_acesso_servico'] = "login/sem_acesso_servico";
$route['portal/login/autenticar_mobile']   = "login/autenticar_mobile";

/**
 * Cidade
 */
$route['cidade/combo']        = "cidade/cidade/combo";
$route['estados']             = "cidade/cidade/estados";
$route['cidades/(:any)']       = "cidade/cidade/cidades/$1";
$route['cidades/(:any)/(:any)']= "cidade/cidade/cidades/$1/$2";

/**
 * Usuário
 */
$route['usuario/listar']                      = "usuario/usuario/listar";
$route['usuario/listar/(:num)']               = "usuario/usuario/listar/$1";
$route['usuario/cadastrar']                   = "usuario/usuario/cadastrar";
$route['usuario/inserir']                     = "usuario/usuario/inserir";
$route['usuario/(:num)/editar']               = "usuario/usuario/editar/$1";
$route['usuario/atualizar']                   = "usuario/usuario/atualizar";
$route['usuario/atualizar_preferencias']      = "usuario/usuario/atualizar_preferencias";
$route['usuario/(:num)/deletar']              = "usuario/usuario/deletar/$1";
$route['usuario/meus_dados']                  = "usuario/usuario/meus_dados";
$route['usuario/preferencias']                = "usuario/usuario/preferencias";
$route['usuario/checa_existe_login']          = "usuario/usuario/checa_existe_login";
$route['usuario/checa_existe_email']          = "usuario/usuario/checa_existe_email";
$route['usuario/migrar_vendedores']           = "usuario/usuario/migrar_vendedores";
$route['usuario/migrar_orgaoes']           = "usuario/usuario/migrar_orgaoes";
$route['usuario/criar_relacionamentos_vendedor']= "usuario/usuario/criar_relacionamentos_vendedor";
$route['usuario/criar_relacionamentos_orgao']= "usuario/usuario/criar_relacionamentos_orgao";
$route['usuario/editar_foto']                    = "usuario/usuario/editar_foto";
$route['usuario/atualizar_foto']                 = "usuario/usuario/atualizar_foto";
$route['usuario/atualizar_atendimento_online']   = "usuario/usuario/atualizar_atendimento_online";
$route['usuario/cancelar_notificacoes']       = "usuario/usuario/cancelar_notificacoes";


/**
 * Inicial
 */
$route['inicial'] = "inicial/inicial";
$route['restrito'] = "inicial/inicial";

/**
 * Perfil
 */
$route['perfilv']     = "inicial/perfil/vendedor";
$route['perfilc']     = "inicial/perfil/orgao";

/**
 * Portlets
 */
$route['portlets/ultimos_acessos']    = "inicial/portlets/ultimos_acessos";
$route['portlets/produtos_interesse'] = "inicial/portlets/produtos_interesse";
$route['portlets/diapha']             = "inicial/portlets/diapha";
$route['portlets/notificacoes']       = "inicial/portlets/notificacoes";
$route['portal/portlets/diapha']      = "portal/portlets/produtos_destaque";
$route['portlets/equipe']             = "inicial/portlets/equipe";
$route['portlets/creditos']           = "inicial/portlets/creditos";
$route['portlets/oportunidades']      = "inicial/portlets/oportunidades";
$route['portlets/ep']                 = "inicial/portlets/estimativas";
$route['portlets/usuarios_online']    = "inicial/portlets/usuarios_online";

/**
 * Orgao
 */
$route['orgao/listar']                     = "orgao/orgao/listar";
$route['orgao/buscar']                     = "orgao/orgao/buscar";
$route['orgao/cadastrar']                      = "orgao/orgao/cadastrar";
$route['portal/orgao/cadastrar']           = "orgao/orgao/cadastrar";

$route['orgao/inserir']                        = "orgao/orgao/inserir";
$route['orgao/(:num)/editar']                  = "orgao/orgao/editar/$1";
$route['orgao/(:num)/atualizar']               = "orgao/orgao/atualizar/$1";
$route['orgao/(:num)/deletar']                 = "orgao/orgao/deletar/$1";
$route['orgao/editar_logo']                    = "orgao/orgao/editar_logo";
$route['orgao/checa_existe_login']             = "orgao/orgao/checa_existe_login";
$route['orgao/checa_existe_email']             = "orgao/orgao/checa_existe_email";
$route['c/confirmar_cadastro/(:any)']          = "orgao/orgao/confirmar_cadastro/$1";

/**
 * Compra / Perfil
 */
$route['orgaos']                  = "orgao/perfil/estados";
$route['orgaos/(:any)']           = "orgao/perfil/cidades/$1";

/**
 * Convite
 */
$route['c/a']                       = "convite/convite/aceitar";
$route['convidar']                  = "convite/convite/convidar";
$route['enviar_convite']            = "convite/convite/enviar_convite";
$route['enviar_convites_antigos']   = "convite/convite/enviar_convites_antigos";

/**
 * Post
 */
$route['post/visualizar']                  = "post/post/visualizar";
$route['post/inserir']                     = "post/post/inserir";
$route['post/deletar']                     = "post/post/deletar";
$route['post/comentar']                    = "post/post/comentar";
$route['post/seguir']                      = "post/post/seguir";
$route['post/deletar_comentario']          = "post/post/deletar_comentario";
$route['portal/post/mobile/listar']               = "post/mobile/listar";
$route['portal/post/mobile/comentarios']          = "post/mobile/comentarios";
$route['portal/post/mobile/inserir_post']         = "post/mobile/inserir_post";
$route['portal/post/mobile/deletar_post']         = "post/mobile/deletar_post";
$route['portal/post/mobile/inserir_comentario']   = "post/mobile/inserir_comentario";
$route['portal/post/mobile/deletar_comentario']   = "post/mobile/deletar_comentario";
$route['portal/post/mobile/seguir']               = "post/mobile/seguir";

/**
 * Notificações
 */
$route['portal/notificacao/mobile/listar']       = "notificacao/mobile/listar";
$route['portal/notificacao/mobile/lido']         = "notificacao/mobile/lido";
$route['portal/notificacao/exibir_popup']        = "notificacao/notificacao/exibir_popup";
$route['portal/notificacao/ler_popup']           = "notificacao/notificacao/ler_popup";
$route['notificacao/lido']                       = "notificacao/notificacao/lido";
$route['notificacao/qtd_notificacoes']           = "notificacao/notificacao/qtd_notificacoes";

/**
 * Diapha
 */
$route['relatos/(:any)/(:any)']            = "diapha/diapha/relatos/$1/$2";
$route['cidade/(:any)']                    = "diapha/diapha/relatos/$1";
$route['diapha/meusrelatos']               = "diapha/diapha/meusrelatos";
$route['diapha/meusrelatos/(:any)']        = "diapha/diapha/meusrelatos/$1";
$route['lista/adicionar_ajax']             = "diapha/diapha/lista_adicionar_ajax";

/*
 * Gráficos
 */
$route['grafico/colunas']                  = "diapha/grafico/colunas";
$route['grafico/por_categoria']            = "diapha/grafico/por_categoria";
$route['grafico/por_categoria_json']       = "diapha/grafico/por_categoria_json";
$route['grafico/por_ano']                  = "diapha/grafico/por_ano";
$route['grafico/por_ano_json']             = "diapha/grafico/por_ano_json";

/**
 * Relato Categoria
 */
$route['relato/categoria/listar']                      = "diapha/relato_categoria/listar";
$route['relato/categoria/cadastrar']                   = "diapha/relato_categoria/cadastrar";
$route['relato/categoria/inserir']                     = "diapha/relato_categoria/inserir";
$route['relato/categoria/(:num)/editar']               = "diapha/relato_categoria/editar/$1";
$route['relato/categoria/atualizar']                   = "diapha/relato_categoria/atualizar";
$route['relato/categoria/(:num)/deletar']              = "diapha/relato_categoria/deletar/$1";
$route['relato/categoria/json']                        = "diapha/relato_categoria/json";
$route['relato/categoria/android/json']                = "diapha/relato_categoria/android_json";

/**
 * Relato
 */
$route['diapha/relato/cadastrar']                      = "diapha/relato/cadastrar";
$route['diapha/relato/inserir']                        = "diapha/relato/inserir";
$route['diapha/relato/xml']                            = "diapha/relato/xml"; 
$route['diapha/relato/json']                           = "diapha/relato/json"; 
$route['diapha/relato/android/json']                   = "diapha/relato/android_json"; 
$route['relato/(:any)/detalhes']                       = "diapha/relato/detalhes/$1";
$route['relato/detalhes']                              = "diapha/relato/detalhes/$1";
$route['relato/alterar_status']                        = "diapha/relato/alterar_status";
$route['relato/apoio']                                 = "diapha/relato/apoiar";

/**
 * Proposta
 */
$route['proposta/cadastrar']                           = "diapha/proposta/cadastrar";
$route['proposta/salvar']                              = "diapha/proposta/salvar";
$route['proposta/detalhes']                            = "diapha/proposta/detalhes";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
