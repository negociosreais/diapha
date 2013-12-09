<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Diapha</title>
    </head>
    <body>

        <table border="0" width="550" cellpadding="0" cellspacing="0" style="max-width:550px;border-top:4px solid #1c5c06;font:12px arial,sans-serif;margin:0 auto; color: #999999">
            <tbody>
                <tr>
                    <td>  
                        <h1 style="font:bold 23px arial;margin:5px 0">
                            <img src="<?= base_url() . TEMPLATE; ?>/img/logoPortal.png" height="50" align="absmiddle" />
                        </h1>
                        <div style="font:13px arial,sans-serif;width:580px;">
                            <?= $usuario['nm_usuario']; ?> solicitou sua adição como usuário do Diapha (portal de transparência de sua cidade). Colabore por uma cidade mais transparente.

                            <p>
                                Prezado(a),<br>
                                <br>
                                Eu gostaria de adicioná-lo ao perfil da empresa <?= $nm_empresa; ?> no Diapha.<br>
                                Ass.: <?= $usuario['nm_usuario']; ?>
                            </p>

                            <div style="margin-top:15px;margin-bottom:10px;border-bottom:1px solid #ddd;line-height:1px">&nbsp;</div>

                            <table cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div style="font:13px arial,sans-serif;width:540px">
                                                Para aceitar clique o botão abaixo, ou copie e cole a o endereço no navegador.
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:15%;padding: 10px 20px 0 0">
                                            <table border="0" cellpadding="6" cellspacing="1" align="">
                                                <tbody>
                                                    <tr>
                                                        <td align="center" valign="middle" bgcolor="#FFE86C" background="<?= base_url(); ?>/template/img/bg_button.png" style="background:url('<?= base_url(); ?>/template/img/bg_button.png') repeat-x scroll 100% 0 #ffe86c;background-color:#ffe86c;border:1px solid #e8b463;border-radius:4px">
                                                            <div style="padding-right:10px;padding-left:10px">
                                                                <a href="<?= $link; ?>" target="_blank">
                                                                    <span style="font-size:12px;font-family:Arial;font-weight:bold;color:#333333;white-space:nowrap;display:block">Aceitar</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="<?= $link; ?>" style="font:11px arial,sans-serif;"><?= $link; ?></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>

                            <br>
                            <div style="margin-top:5px;border-bottom:2px solid #ddd;line-height:2px">&nbsp;</div>
                            <br>
                            <p><strong>Por que se conectar ao Diapha pode ser uma boa ideia?</strong></p>
                            <p>Monitore todas ocorrências relacionadas ao órgão em que você atua. Você estará colaborando com sua cidade para que juntos possamos fazer dela um lugar melhor pra se viver.</p>
                            
                            
                            <div style="margin-top:6px;border-bottom:2px solid #ddd;line-height:3px">&nbsp;</div>
                        </div>

                        <p style="width:550px;margin:3px auto;font:10px arial,sans-serif;color:#999">
                            © 2013, Diapha 
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

    </body>
</html>