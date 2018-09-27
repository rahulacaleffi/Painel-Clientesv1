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
                    <li><a href="contato.php">Contato</a></li>
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
                   <a href="https://www.intrazone.com.br/webmail"><img src="images/webmail.png" style="max-width: 100px;"></a> 
            </div>
            
            <br>
            <br>
            
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
        
    <h2>Serviços contratados</h2> 


    <table id="rounded-corner" summary="Serviços contratados">
    <thead>
        <tr>
            <th scope="col" class="rounded">Serviço</th>
            <th scope="col" class="rounded">Valor</th>
            <th scope="col" class="rounded">Documento</th>
        </tr>
    </thead>
    
    <tbody>
        
        <?php
                        $ver_chamados=$conn->prepare('SELECT * FROM servico_cliente WHERE id_cliente = :pid');
                        $ver_chamados->bindValue('pid',$row['id']);
                        $ver_chamados->execute();
                        while ($rowChamado=$ver_chamados->fetch()) {
                        
            ?>
        <tr>
            
            
            <td><?php
                $ver_chamados2=$conn->prepare('SELECT * FROM servicos WHERE id=:pid');
                        $ver_chamados2->bindValue('pid',$rowChamado['id_servico']);
                        $ver_chamados2->execute();
                        $rowChamado2=$ver_chamados2->fetch();
                        echo $rowChamado2['nome'];
            ?></td>
            <td><?php echo $rowChamado['valor']; ?></td>
            

            <td><a <?php if ($rowChamado['documento']!=null) {echo "href=\"documentos/".$rowChamado['documento']; } ?>"><img src="images/photo.png" alt="" title="" border="0" /></a></td>
            
        </tr>
        
        <?php
                }
            ?>
    </tbody>
    <tfoot>
        
    </tfoot>
</table>
              <br>      
              <br>      
              <br>      
    <h2>Serviços oferecidos pela IntraZone</h2>

    <?php
        $ver_servicos2=$conn->prepare('SELECT * FROM servicos ORDER BY nome ASC');
                        $ver_servicos2->execute();
                        while ($rowServicos=$ver_servicos2->fetch()) {
                            echo "<h4>".$rowServicos['nome']."</h4>";
                            echo "<h5>".$rowServicos['descricao']."</h5>";
                            if ($rowServicos['valor']==null) {
                                echo "<h5> Valor: ".$rowServicos['valor_texto']."</h5>";
                            }else{
                                echo "<h5> Valor: ".$rowServicos['valor']."</h5>";
                            }
                            echo "<a href=\"servicos.php?contratar=".$rowServicos['id']."\" class=\"bt_green\"><span class=\"bt_green_lft\"></span><strong>Contratar</strong><span class=\"bt_green_r\"></span></a>";
                            echo "<br>";
                            echo "<br>";
                            echo "<br><hr>";

                            
                        }
    ?>

    </div> <!--end of right content -->  
         <?php
            if (isset($_GET['contratar'])&&isset($_SESSION['login'])) {
                $id_cliente=$row['id'];
                $id_servico=$_GET['contratar'];
                $ver_chamados23=$conn->prepare('SELECT * FROM servicos WHERE id=:pid');
                        $ver_chamados23->bindValue('pid',$id_servico);
                        $ver_chamados23->execute();
                        $rowChamado23=$ver_chamados23->fetch();

                $grava23=$conn->prepare('INSERT INTO servico_cliente (id_cliente, id_servico, valor) VALUES (:pid_cliente, :pid_servico, :pvalor)');
                $grava23->bindValue(':pid_cliente',$id_cliente);
                $grava23->bindValue(':pid_servico',$id_servico);
                if ($rowChamado23['valor']!=null) {
                    $grava23->bindValue(':pvalor',$rowChamado23['valor']);
                }else{
                    $grava23->bindValue(':pvalor',$rowChamado23['valor_texto']);
                }
                
                $grava23->execute();

                echo "<meta http-equiv=\"refresh\" content=0;url=\"servicos.php\">";
                echo"<script type='text/javascript'>";

                echo "alert('Serviço adicionado com sucesso. Aguarde até o documento ser anexado');";

            echo "</script>";
            }
         ?>   
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    
    <div class="footer">
    
    	<div class="left_footer">Área do Cliente | IntraZone Web Design e Software - <a href="https://www.intrazone.com.br">IntraZone.com.br</a></div>
    	<div class="right_footer"><a href="https://www.intrazone.com.br"><img src="img/logoantigopequeno.png" style="width: 80px; filter: grayscale();" alt="" title="" border="0" /></a></div>
    
    </div>

</div>		
</body>