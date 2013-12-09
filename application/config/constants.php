<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('DESCRICAO_SISTEMA', "Portal ARP");
define('EMAIL', 'contato@portalarp.com.br');
define('TEMPLATE', 'template-2012');

define('FB_APPID', '481048095304254');
define('FB_SECRET', '916ba2948c16032f9fed21625472658d');

/**
 * Listas 
 */
define('STATUS', serialize(array('Ativo'=>'Ativo','Inativo'=>'Inativo')));
define('TPO_CREDITO', serialize(array("Mensal" => "Mês(es)","Trimestral" => "Trimestre(s)","Semestral" => "Semestre(s)","Anual" => "Ano(s)")));
define('TPO_DOCUMENTO', serialize(array(""=>"","Ata" => "Ata", "Portfólio" => "Portfólio", "Diário Oficial da União" => "Diário Oficial da União", "Ofício" => "Ofício", "Termo de Referência" => "Termo de Referência","Carta de Inexigibilidade"=>"Carta de Inexigibilidade")));
define('TPO_FILTRO', serialize(array("Federal" => "Federal", 
                                     "Estadual" => "Estadual", 
                                     "Municipal" => "Municipal", 
                                     "Sistema 'S'" => "Sistema 'S'", 
                                     "Compra direta" => "Compra direta",
                                     "Inexibilidade" => "Inexibilidade",
                                     "Carta convite" => "Carta convite")));
define('DPN', serialize(array("gov", "org", "edu", "unb", "b", "jus", "leg", "mil", "embrapa")));
define('ORDEM_PRODUTOS', serialize(array("Mais visitados" => "Mais visitados", "Menor preço" => "Menor preço", "Maior preço" => "Maior preço", "Mais novos no site" => "Mais novos no site", "Nome A-Z"=>"Nome A-Z", "Nome Z-A"=>"Nome Z-A")));
define('PERFIS', serialize(array(""=>"[ Selecione o perfil ]","Editor"=>"Editor", "Colaborador"=>"Colaborador", "Gestor"=>"Gestor")));
define('ALFABETO' , serialize(array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","U","V","W","X","Y","Z")));
define('UF', serialize(array(           ""   => "",
                                        "AC" => "Acre",
                                        "AL" => "Alagoas",
                                        "AP" => "Amapa",
                                        "AM" => "Amazonas",
                                        "BA" => "Bahia",
                                        "CE" => "Ceara",
                                        "DF" => "Distrito Federal",
                                        "ES" => "Espirito Santo",
                                        "GO" => "Goias",
                                        "MA" => "Maranhao",
                                        "MT" => "Mato Grosso",
                                        "MS" => "Mato Grosso do Sul",
                                        "MG" => "Minas Gerais",
                                        "PA" => "Para",
                                        "PB" => "Paraiba",
                                        "PR" => "Parana",
                                        "PE" => "Pernambuco",
                                        "PI" => "Piaui",
                                        "RJ" => "Rio de Janeiro",
                                        "RN" => "Rio Grande do Norte",
                                        "RS" => "Rio Grande do Sul",
                                        "RO" => "Rondonia",
                                        "RR" => "Roraima",
                                        "SC" => "Santa Catarina",
                                        "SP" => "Sao Paulo",
                                        "SE" => "Sergipe",
                                        "TO" => "Tocantins")));


/* End of file constants.php */
/* Location: ./application/config/constants.php */