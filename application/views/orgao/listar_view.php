<div class="grid_19">


    <div class="caixa">

        <h1 class="tituloCaixa">ÓRGÃO PÚBLICO</h1>
        <? showStatus(); ?>

        <table width="100%">

            <tr>
                <td colspan="7">
                    <fieldset class="form busca">
                        <legend>Busca</legend>
                        <form name="busca" action="<?= site_url('orgao/buscar'); ?>" method="GET">
                            <table width="100%">
                                <tr>
                                    <td><label>Órgão: </label></td>
                                    <td><input type="text" name="nm_orgao" size="30" /></td>
                                    <td><label>Representante: </label></td>
                                    <td><input type="text" name="nm_representante" size="30" /></td>

                                    <td></td>
                                </tr>
                                <tr>
                                    <td><label>Cidade/UF: </label></td>
                                    <td><input type="text" name="nm_cidade" size="30" /></td>
                                    <td><label>Data de Cadastro: </label></td>
                                    <td colspan="4">
                                        <input type="text" name="dt_inicio" size="10" /> à
                                        <input type="text" name="dt_fim" size="10" />
                                    </td>
                                    <td align="right"><button name="btn_buscar" class="btn btn-success">Buscar</button></td>
                                </tr>

                            </table>
                        </form>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <td>
                    <table width="100%" class="lista">
                        <tr>
                            <th width="40">&nbsp;</th>
                            <th align="left">Órgão</th>
                            <th align="left">E-mail</th>
                            <th align="left" width="50">Cidade/UF</th>
                            <th align="center" width="40">Cadastro</th>
                            
                            <th align="center" width="60">Acesso até</th>
                            
                            <th width="75">&nbsp;</th>
                        </tr>

                        <?
                        if (count($dados) > 0) :

                            foreach ($dados as $dado) :

                                $class = "";
                                if ($dado['st_status'] == "Inativo"):
                                    $class = ' class="statusInativo"';
                                endif;

                                list($dt_cadastro, $hr_cadastro) = split(" ", $dado['dt_cadastro']);
                                ?>

                                <tr <?= $class; ?>>
                                    <td>
                                        <a href="<?= site_url('orgao/editar_logo'); ?>?id_orgao=<?= $dado['id_orgao']; ?>" id="botaoAddFoto" title="Clique para a editar a logomarca.">
                                            <?
                                            if ($dado['nm_logo'] != ''):
                                                ?>
                                                <img src="<?= base_url() . "arquivos/logos/" . $dado['nm_logo']; ?>" height="49" class="img-polaroid" />
                                                <?
                                            else:
                                                ?>

                                                <img src="<?= base_url() . TEMPLATE . "/img/logoGovernoP.jpg" ?>" class="img-polaroid" />
                                            <?
                                            endif;
                                            ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?= $dado['nm_orgao']; ?><br>
                                        <small>
                                            <?= $dado['nm_representante']; ?><br>
                                            <?= $dado['nr_telefone']; ?>
                                        </small>
                                        <?
                                        if ($dado['cd_confirmacao'] != '' && $dado['st_status'] != "Inativo"):
                                            echo "<div id='alerta'><a href='" . site_url('c/confirmar_cadastro/' . $dado['cd_confirmacao']) . "'>Pendente confirmação</a></div>";
                                        endif;
                                        ?>
                                    </td>

                                    <td>
                                        <?= $dado['ds_email']; ?>
                                    </td>
                                    <td>
                                        <?= $dado['nm_cidade'] . "/" . $dado['nm_estado'] ?>
                                    </td>

                                    <td align="center">
                                        <?= formataDate($dt_cadastro, "-"); ?>
                                    </td>
                                    
                                    <td align="center">
                                        <?= formataDate($dado['dt_acesso_fim'], "-"); ?>
                                    </td>

                                    <td valign="middle" align="center">

                                        <div class="btn-group">
                                            <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" title="Opções">
                                                Opções
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" style="left: -100px">
                                                <li>
                                                    <a href="<?= site_url('usuario/listar') . "?e=orgao&i=" . $dado['id_orgao']; ?>">
                                                        Usuários
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= site_url('orgao/' . $dado['id_orgao'] . '/editar'); ?>">
                                                        Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:confirmaApagar('<?= site_url('orgao/' . $dado['id_orgao'] . '/deletar'); ?>')">
                                                        Excluir
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </td>


                                </tr>
                                <?
                            endforeach;

                        else :
                            ?>

                            <tr>
                                <td>
                                    <span class='legenda'>Nenhum registro!</span>
                                </td>
                            </tr>


                        <? endif; ?>
                    </table>

                </td>
            </tr>
            <tr>
                <td>
                    <div class="paginacao">
                        <?= $this->pagination->create_links(); ?>
                    </div>
                </td>
            </tr>


        </table>

    </div>

</div>