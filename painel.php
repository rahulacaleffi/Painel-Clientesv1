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
        
    <h2>Meus chamados</h2> 
                    
                    
<table id="rounded-corner" summary="2007 Major IT Companies' Profit">
    <thead>
    	<tr>
        	<th scope="col" class="rounded-company"></th>
            <th scope="col" class="rounded">Chamado</th>
            <th scope="col" class="rounded">Data</th>
            <th scope="col" class="rounded">Serviço</th>
            <th scope="col" class="rounded">Descrição</th>
            <th scope="col" class="rounded">Editar</th>
            <th scope="col" class="rounded-q4">Excluir</th>
        </tr>
    </thead>
    
    <tbody>
        
        <?php
                        $ver_chamados=$conn->prepare('SELECT * FROM chamados WHERE id_cliente = :pid ORDER BY data DESC');
                        $ver_chamados->bindValue('pid',$row['id']);
                        $ver_chamados->execute();
                        while ($rowChamado=$ver_chamados->fetch()) {
                        
            ?>
    	<tr>
        	
            
            
            <td><input type="checkbox" name="check[]" /></td>
            <td><?php echo $rowChamado['id']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($rowChamado['data'])) ?></td>
            <td><?php
                $ver_chamados2=$conn->prepare('SELECT * FROM servicos WHERE id=:pid');
                        $ver_chamados2->bindValue('pid',$rowChamado['servico']);
                        $ver_chamados2->execute();
                        $rowChamado2=$ver_chamados2->fetch();
                        echo $rowChamado2['nome'];
            ?></td>
            <td><?php echo substr($rowChamado['descricao'], 0, 15)."..."; ?></td>
            

            <td><a href="painel.php?chamado=<?php echo $rowChamado['id']; ?>"><img src="images/user_edit.png" alt="" title="" border="0" /></a></td>
            <td><a href="painel.php?apagarcham=<?php echo $rowChamado['id']; ?>" class="ask"><img src="images/trash.png" alt="" title="" border="0" /></a></td>
            
        </tr>
        
        <?php
                }
            ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="rounded-foot-left"><em>
            <?php
                if (isset($_GET['apagarcham'])&& isset($_SESSION['login'])) {
                    $id=$_GET['apagarcham'];
                    $excluirchamado=$conn->prepare('DELETE FROM chamados WHERE id = :pid');
                    $excluirchamado->bindValue(':pid', $id);
                    $excluirchamado->execute();
                    echo "<meta http-equiv=\"refresh\" content=0;url=\"painel.php?sucessoexcluir\">";
                }



                if (isset($_GET['chamado'])&& isset($_SESSION['login'])) {
                    $id=$_GET['chamado'];
                    $ver_chamados=$conn->prepare('SELECT * FROM chamados WHERE id=:pid');
                    $ver_chamados->bindValue('pid',$id);
                    $ver_chamados->execute();
                    $rowCham=$ver_chamados->fetch();

                
            ?>    
            <div class="form" style="max-width: 450px;">
         <form action="painel.php" method="post" class="niceform">
         
                <fieldset style="max-width: 450px;">
                    <dl>
                        <dt><label for="descricao">Descriçao:</label></dt>
                        <dd><textarea name="descricao" style="width: 300px; height: 75px;"><?php echo $rowCham['descricao']; ?></textarea></dd>
                    </dl>
                    <dl>
                        <dt><label for="nome">Nome:</label></dt>
                        <dd><input type="text" name="nome" id="nome" size="34" value="<?php echo $rowCham['nome']; ?>" /></dd>
                    </dl>
                    <input type="hidden" name="id" value="<?php echo $rowCham['id']; ?>">
                    <dl>
                        <dt><label for="telefone">Telefone:</label></dt>
                        <dd><input type="text" name="telefone" id="telefone" size="34" value="<?php echo $rowCham['telefone']; ?>" /></dd>
                    </dl>

                     <dl class="submit">
                    <input type="submit" name="alterarchamado" value="Alterar" />
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form>
         </div>
         <section id="alterarchamado">
         <?php
            }
            if (isset($_POST['alterarchamado']) && isset($_SESSION['login'])) {
                $descricao=$_POST['descricao'];
                $nome=$_POST['nome'];
                $telefone=$_POST['telefone'];
                $id=$_POST['id'];
                $grava3=$conn->prepare('UPDATE chamados SET nome = :pnome, descricao = :pdescricao, telefone = :ptelefone WHERE id = :pid');
                $grava3->bindValue(':pid',$id);
                $grava3->bindValue(':pdescricao',$descricao);
                $grava3->bindValue(':pnome',$nome);
                $grava3->bindValue(':ptelefone',$telefone);
                $grava3->execute();
                echo "<meta http-equiv=\"refresh\" content=0;url=\"painel.php?sucessoalterar\">";
                
            }
         ?>
         </section>

            </em></td>
            <td class="rounded-foot-right">&nbsp;</td>

        </tr>
    </tfoot>
</table>

	 <a href="#abrirchamadosec" class="bt_green"><span class="bt_green_lft"></span><strong>Abrir chamado</strong><span class="bt_green_r"></span></a>
     <a href="#" class="bt_red"><span class="bt_red_lft"></span><strong>Apagar</strong><span class="bt_red_r"></span></a> 
     
     
        <!-- <div class="pagination">
        <span class="disabled"><< prev</span><span class="current">1</span><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a>…<a href="">10</a><a href="">11</a><a href="">12</a>...<a href="">100</a><a href="">101</a><a href="">next >></a>
        </div>  -->
     
     <!-- <h2>Warning Box examples</h2>
      
     <div class="warning_box">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.
     </div>
     
     <div class="error_box">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.
     </div>   -->
           
     <h2 id="abrirchamadosec">Abrir chamado</h2>
     
         <div class="form">
         <form action="painel.php" method="post" class="niceform" enctype="multipart/form-data">
         
                <fieldset>
                    
                    <dl>
                        <dt><label for="nome">Nome:</label></dt>
                        <dd><input type="text" name="nome" id="" size="54" value="<?php echo $row['nome']; ?>" /></dd>
                    </dl><dl>
                        <dt><label for="telefone">Telefone:</label></dt>
                        <dd><input type="text" name="telefone" id="" size="54" /></dd>
                    </dl>
                    
                    
                    <dl>
                        <dt><label for="servico">Serviço:</label></dt>
                        <dd>
                            <select size="1" name="servico" id="">
                                <option value="0">Selecione</option>
                                <?php 
                                    $ver_servicos=$conn->prepare('SELECT * FROM servicos ORDER BY nome ASC');
                                    $ver_servicos->execute();
                                    while ($rowServicos=$ver_servicos->fetch()) {
                                        echo "<option value=\"".$rowServicos['id']."\">".$rowServicos['nome']."</option>";
                                    }
                                ?>
                            </select>
                        </dd>
                    </dl>
                    <!-- <dl>
                        <dt><label for="interests">Select tags:</label></dt>
                        <dd>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Web design</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Business</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Simple</label>
                            <input type="checkbox" name="interests[]" id="" value="" /><label class="check_label">Clean</label>
                        </dd>
                    </dl> -->
                    
                    <dl>
                        <dt><label for="color">Prioridade</label></dt>
                        <dd>
                            <input type="radio" name="prioridade" id="" value="1" /><label class="check_label">Baixa</label>
                            <input type="radio" name="prioridade" id="" value="2" /><label class="check_label">Média</label>
                            <input type="radio" name="prioridade" id="" value="3" /><label class="check_label">Alta</label>
                        </dd>
                    </dl>
                    
                    
                    
                    <dl>
                        <dt><label for="upload">Enviar foto (opcional):</label></dt>
                        <dd><input type="file" name="arquivo" id="upload" /></dd>
                    </dl>
                    
                    <dl>
                        <dt><label for="comments">Descrição:</label></dt>
                        <dd><textarea name="comments" id="comments" rows="5" cols="36"></textarea></dd>
                    </dl>
                    
                    <dl>
                        <dt><label></label></dt>
                        <dd>
                            <input type="checkbox" name="interests[]" id="" value="" required="required" /><label class="check_label">Eu aceito com os <a href="#">Termos &amp; Condições</a></label>
                        </dd>
                    </dl>
                    
                     <dl class="submit">
                    <input type="submit" name="abrirchamado" id="submit" value="Enviar" />
                     </dl>
                     
                     
                    
                </fieldset>
                
         </form>
         </div>  
        <?php
            if (isset($_POST['abrirchamado'])&& isset($_SESSION['login'])) {
                $id_cliente=$row['id'];
                $nome=$_POST['nome'];
                $telefone=$_POST['telefone'];
                $servico=$_POST['servico'];
                $prioridade=$_POST['prioridade'];
                $upload=$_POST['arquivo'];
                $descricao=$_POST['comments'];


                $grava2=$conn->prepare('INSERT INTO chamados (id, id_cliente, servico, descricao, prioridade, img, telefone, nome) VALUES (NULL, :pid, :pservico, :pdescricao, :pprioridade, :pimg, :ptelefone, :pnome)');

                $grava2->bindValue(':pid',$id_cliente);
                $grava2->bindValue(':pservico',$servico);
                $grava2->bindValue(':pdescricao',$descricao);
                $grava2->bindValue(':pprioridade',$prioridade);
                $grava2->bindValue(':ptelefone',$telefone);
                $grava2->bindValue(':pnome',$nome);

                if (!empty($_FILES['arquivo']['name'])) {
                //img
            $_UP['pasta'] = 'img/';
            // Tamanho máximo do arquivo (em Bytes)
            $_UP['tamanho'] = 1024 * 1024 * 3; // 3Mb
            // Array com as extensões permitidas
            $_UP['extensoes'] = array('jpg', 'png', 'gif', 'jpeg');
            // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
            $_UP['renomeia'] = false;
            // Array com os tipos de erros de upload do PHP
            $_UP['erros'][0] = 'Não houve erro';
            $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
            $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
            $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
            $_UP['erros'][4] = 'Não foi feito o upload do arquivo';
            // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
            if ($_FILES['arquivo']['error'] != 0) {
              die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']]);
              exit; // Para a execução do script
            }
            // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
            // Faz a verificação da extensão do arquivo
            $extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
            if (array_search($extensao, $_UP['extensoes']) === false) {
              echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
              exit;
            }
            // Faz a verificação do tamanho do arquivo
            if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
              echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
              exit;
            }
            // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
            // Primeiro verifica se deve trocar o nome do arquivo
            if ($_UP['renomeia'] == true) {
              // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
              $nome_final = md5(time()).$extensao;
            } else {
              // Mantém o nome original do arquivo
              $nome_final = $_FILES['arquivo']['name'];
            }

            //====
            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
                $grava2->bindValue(':pimg',$nome_final);
            }
            }


            $grava2->execute();
                
            
                $ver_chamados22=$conn->prepare('SELECT * FROM servicos WHERE id=:pid');
                        $ver_chamados22->bindValue('pid',$servico);
                        $ver_chamados22->execute();
                        $rowChamado22=$ver_chamados22->fetch();
                        $servico=$rowChamado22['nome'];
            

            $para= "rahula@intrazone.com.br";
                                    $assunto= "Chamado - Painel IntraZone";

                                    $corpo = "<strong> Chamado feito pelo painel </strong><br><br>";
                                    $corpo .= "<strong> Nome: </strong> $nome";
                                    $corpo .= "<br><strong> Telefone: </strong> $telefone";
                                    $corpo .= "<br><strong> Email: </strong> ".$row['email']."";
                                    $corpo .= "<br><strong> Prioridade (1 a 3): </strong> $prioridade";
                                    $corpo .= "<br><strong> Serviço: </strong> $servico";
                                    $corpo .= "<br><strong> Mensagem: </strong> $descricao";
                                    $corpo .= "<br><strong> Print: </strong> http://clientes.intrazone.com.br/img/$nome_final";
        
                                    $header= "Content-Type: text/html; charset= utf-8\n";
                                    $header.="From: $email Reply-to: $email\n";
        
                                    mail($para,$assunto,$corpo,$header);
                
                echo "<meta http-equiv=\"refresh\" content=0;url=\"painel.php\">";
                echo"<script type='text/javascript'>";

                echo "alert('Chamado aberto com sucesso');";

            echo "</script>";
            }

        ?>
     
     </div><!-- end of right content-->
            
                    
  </div>   <!--end of center content -->               
                    
                    
    
    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    
    <div class="footer">
    
    	<div class="left_footer">Área do Cliente | IntraZone Web Design e Software - <a href="https://www.intrazone.com.br">IntraZone.com.br</a></div>
    	<div class="right_footer"><a href="https://www.intrazone.com.br"><img src="img/logoantigopequeno.png" style="width: 80px; filter: grayscale();" alt="" title="" border="0" /></a></div>
    
    </div>

</div>		
</body>