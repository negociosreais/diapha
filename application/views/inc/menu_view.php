<!-- MENU VERTICAL -->
<script type="text/javascript">

    //SuckerTree Vertical Menu 1.1 (Nov 8th, 06)
    //By Dynamic Drive: http://www.dynamicdrive.com/style/

    var menuids=["suckertree1"] //Enter id(s) of SuckerTree UL menus, separated by commas

    function buildsubmenus(){
        for (var i=0; i < menuids.length; i++){
            var ultags=document.getElementById(menuids[i]).getElementsByTagName("ul")
            for (var t=0; t<ultags.length; t++){
                ultags[t].parentNode.getElementsByTagName("a")[0].className="subfolderstyle"
                if (ultags[t].parentNode.parentNode.id==menuids[i]) //if this is a first level submenu
                    ultags[t].style.left=ultags[t].parentNode.offsetWidth+"px" //dynamically position first level submenus to be width of main menu item
                else //else if this is a sub level submenu (ul)
                    ultags[t].style.left=ultags[t-1].getElementsByTagName("a")[0].offsetWidth+"px" //position menu to the right of menu item that activated it
                ultags[t].parentNode.onmouseover=function(){
                    this.getElementsByTagName("ul")[0].style.display="block"
                }
                ultags[t].parentNode.onmouseout=function(){
                    this.getElementsByTagName("ul")[0].style.display="none"
                }
            }
            for (var t=ultags.length-1; t>-1; t--){ //loop through all sub menus again, and use "display:none" to hide menus (to prevent possible page scrollbars
                ultags[t].style.visibility="visible"
                ultags[t].style.display="none"
            }
        }
    }

    if (window.addEventListener)
        window.addEventListener("load", buildsubmenus, false)
    else if (window.attachEvent)
        window.attachEvent("onload", buildsubmenus)

</script>


<div class="caixa">

    <h1 class="tituloCaixa">MENU</h1>

    <div class="suckerdiv">
        <ul id="suckertree1">

            <?
            /**
             * Admin
             */
            if (checa_permissao(array('admin'), true)):
                ?>

                <li>
                    <a href='<?= site_url('usuario/listar'); ?>'>Usuários</a>
                </li>
                <li>
                    <a href='#'>Órgãos</a>
                    <ul>
                        <li>
                            <a href='<?= site_url('orgao/listar'); ?>'>Visualizar</a>
                        </li>
                        <li>
                            <a href='<?= site_url('orgao/cadastrar'); ?>'>Cadastrar</a>
                        </li>
                        <li>
                            <a href='<?= site_url('usuario/listar?e=orgao'); ?>'>Usuários</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href='<?= site_url('relato/categoria/listar'); ?>'>Categorias</a>
                </li>


                <!--<li>
                    <a href='#'>Planos</a>
                    <ul>
                        <li>
                            <a href='<?= site_url('plano/listar'); ?>'>Visualizar</a>
                        </li>
                        <li>
                            <a href='<?= site_url('plano/cadastrar'); ?>'>Cadastrar</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href='#'>Faturas</a>
                    <ul>
                        <li>
                            <a href='<?= site_url('fatura/listar'); ?>'>Visualizar</a>
                        </li>
                        <li>
                            <a href='<?= site_url('fatura/cadastrar'); ?>'>Cadastrar</a>
                        </li>
                    </ul>
                </li>-->

                <?
            endif;
            ?>

        </ul>
    </div>

</div>