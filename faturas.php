<?php session_start();
    if(!isset($_SESSION['login'])){
        header('location:index.php');
    }
    if(isset($_GET['logout'])){
        session_destroy();
        header('location:index.php');
    }
//     error_reporting(0);
// @ini_set('display_errors', 0);
    require_once "connect.php";
    $ver_login=$conn->prepare('SELECT * FROM clientes WHERE id = :pid');
    $ver_login->bindValue(':pid',$_SESSION['login']);
    $ver_login->execute();
    $row=$ver_login->fetch();
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Área do Cliente - IntraZone</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="clockp.js"></script>
<script type="text/javascript" src="clockh.js"></script> 
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="ddaccordion.js"></script>
<link rel="icon" type="image/x-icon" href="img/logo.png" />
<link rel="icon" type="image/png" href="img/logo.png" />
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>

<script type="text/javascript" src="jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
</script>

<script language="javascript" type="text/javascript" src="niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />

</head>

<body>
<div id="main_container">

	<div class="header">
    <div class="logo"><a href="painel.php"><img src="img/logoantigopequeno.png" style="width: 150px;" alt="" title="" border="0" /></a></div>
    
    <div class="right_header">Bem vindo <?php echo $row['nome']; ?>, <a href="https://www.intrazone.com.br">Visitar site</a> | <a href="#" class="messages">(<?php 
    $ver_mensagens=$conn->prepare('SELECT * FROM mensagens WHERE id_cliente = :pid');
        $ver_mensagens->bindValue(':pid',$_SESSION['login']);
        $ver_mensagens->execute();
        echo $ver_mensagens->rowCount(); 
        ?>) Mensagens</a> | <a href="painel.php?logout" class="logout">Logout</a></div>
    <div id="clock_a"></div>
    </div>
    
    <div class="main_content">
    
                    <div class="menu">
                    <ul>
                    <li><a class="current" href="painel.php">Início</a></li>
                    <li><a href="servicos.php">Serviços<!--[if IE 7]><!--></a><!--<![endif]-->
                    <!--[if lte IE 6]><table><tr><td><![endif]-->
                        <ul>
                        <li><a href="" title="">Consultar serviços</a></li>
                        <li><a href="" title="">Contratar serviços</a></li>
                        <li><a href="" title="">Verificar serviços contratados</a></li>
                        </ul>
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
                    
                    <li><a href="faturas.php">Faturas<!--[if IE 7]><!--></a><!--<![endif]-->
                    <!--[if lte IE 6]><table><tr><td><![endif]-->
                        
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
                    <li><a href="conta.php">Minha conta<!--[if IE 7]><!--></a><!--<![endif]-->
                    <!--[if lte IE 6]><table><tr><td><![endif]-->
                    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                    </li>
                    <li><a href="">Contato</a></li>
                    </ul>
                    </div> 
                    
                    
                    
                    
    <div class="center_content">  
    
    <?php
        if (isset($_GET['sucessoalterar'])) {
            echo "<div class=\"valid_box\" align=\"center\">
        Chamado alterado com sucesso
     </div>";
        }
    ?><?php
        if (isset($_GET['sucessoexcluir'])) {
            echo "<div class=\"valid_box\" align=\"center\">
        Chamado excluído com sucesso
     </div>";
        }
    ?>
    
    <div class="left_content">
    
    		<div class="sidebar_search">
            <form>
            <input type="text" name="" class="search_input" value="Buscar" onclick="this.value=''" />
            <input type="image" class="search_submit" src="images/search.png" />
            </form>            
            </div>
    
            <div class="sidebarmenu">
            
                <a class="menuitem submenuheader" href="">Nossos serviços</a>
                <div class="submenu">
                    <ul>
                    <?php 
                        $ver_servicos=$conn->prepare('SELECT * FROM servicos ORDER BY nome ASC');
                        $ver_servicos->execute();
                        while ($rowServicos=$ver_servicos->fetch()) {
                            echo "<li><a href=\"servicos.php?s=".$rowServicos['id']."\">".$rowServicos['nome']."</a></li>";
                        }
                    ?>
                    </ul>
                </div>
                    
            </div>
            
            
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h3>Guia Rápido</h3>
                <img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
                <p>
                    Seja bem vindo à mais nova área do cliente IntraZone. Selecione o conteúdo desejado no menu para contratar um novo serviço, ou acompanhe suas faturas por meio da aba faturas. Em caso de dúvidas, preencha o formulário disponibilizado no final da página.
                </p>                
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>
            
            <div class="sidebar_box">
                <div class="sidebar_box_top"></div>
                <div class="sidebar_box_content">
                <h4>Importante</h4>
                <img src="images/notice.png" alt="" title="" class="sidebar_icon_right" />
                <p>
                    A partir de 01/01/2019 todos os recibos, faturas, chamados e contato serão acessados somente por esse portal.
                </p>                
                </div>
                <div class="sidebar_box_bottom"></div>
            </div>
            
             
            
              
    
    </div>  
    
    <div class="right_content">            
        
    <h2>Página em construção</h2> 

    </div> <!--end of right content -->  
        
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    
    <div class="footer">
    
    	<div class="left_footer">Área do Cliente | IntraZone Web Design e Software - <a href="https://www.intrazone.com.br">IntraZone.com.br</a></div>
    	<div class="right_footer"><a href="https://www.intrazone.com.br"><img src="img/logoantigopequeno.png" style="width: 80px; filter: grayscale();" alt="" title="" border="0" /></a></div>
    
    </div>

</div>		
</body>