<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Diapha</title>
    </head>
    <body>
        <table border="0" width="550" cellpadding="0" cellspacing="0" style="max-width:550px;border-top:4px solid #00cbff;font:12px arial,sans-serif;margin:0 auto;color:#999999">
            <tbody>
                <tr>
                    <td>  
                        <h1 style="font:bold 23px arial;margin:5px 0">
                            <img src="<?= base_url() . TEMPLATE; ?>/img/logoPortal.png" align="absmiddle" />
                        </h1>
                        <div style="font:13px arial,sans-serif;width:580px;">

                            <table cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div style="font:13px arial,sans-serif;width:540px">

                                                <?= $conteudo; ?>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div style="margin-top:6px;border-bottom:2px solid #ddd;line-height:3px">&nbsp;</div>
                        </div>

                        <p style="width:550px;margin:3px auto;font:10px arial,sans-serif;color:#999">
                            © 2013, Diapha <br><br>
                            Deseja cancelar o recebimento de notificações? <a href="<?=site_url('usuario/cancelar_notificacoes?cd=' . md5($id_usuario) . '&em=' . $ds_email); ?>">Clique aqui.</a>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

    </body>
</html>