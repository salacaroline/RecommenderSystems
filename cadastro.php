<?php
#criar isso no elastic


$filename = 'texto.txt';
$fp = fopen($filename, 'r');
$perfil = array();

// Add each line to an array
if ($fp)
{
    $array = explode(",", fread($fp, filesize($filename)));
}
$k = 0;
for ($i = 1;$i < 11;$i++)
{

    $rand_keys = array_rand($array);

    $perfil[$k] = $array[$rand_keys];
    $k++;

}

?>

<!------ https://bootsnipp.com/snippets/0BDPG ---------->

<!DOCTYPE html>
<head>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

  <link rel="stylesheet" type="text/css" href="css/css.css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
  <body>

    <form id="Form1" class="form-horizontal" action="nova_pagina.php" method="get" autocomplete="off"  >
        <fieldset>
            <div class="panel panel-primary">
                <div class="panel-heading">Cadastro de Usuário</div>
                  <div class="panel-body">


                      <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="Nome">Nome Completo: <h11>*</h11></label>
                        <div class="col-md-8">
                        <input id="nome" name="nome" placeholder="" class="form-control input-md" required="" type="text">
                        </div>
                    </div>



                        <!-- Text input-->
                    <div class="form-group">
                      <label class="col-md-2 control-label" for="prependedtext">Email: <h11>*</h11></label>
                        <div class="col-md-5">
                          <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input id="email" name="email" class="form-control" placeholder="email@email.com" required="" type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
                          </div>
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="col-md-2 control-label" for="textinput">Senha: <h11>*</h11></label>
                      <div class="col-md-2">
                        <input id="senha" name="senha" placeholder="" class="form-control input-md" type="password">
                      </div>
                  </div>

                    <div class="form-group">
                      <label class="col-md-2 control-label" for="textinput">Instituição: </label>
                        <div class="col-md-4">
                          <input id="instituicao" name="instituicao" placeholder="" class="form-control input-md" type="text">
                        </div>
                    </div>
                   

                  <!-- Multiple Radios (inline) -->

                  

                   <div class="form-group">
                      <label class="col-md-4 control-label" for="exampleFormControlSelect1">Você conhece a área de Interação Humano-Computador?<h11>*</h11></label>
                      <div class="col-md-2">
                      <select class="form-control" id="conhecoIHC" name="conhecoIHC" placeholder="Selecione uma opção" required="">
                        <option value=""></option>
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                      </select>
                    
                    </div>
                    </div>

                  <div class="form-group">
                    <div class="col-md-2 control-label">
                            <p class="help-block"><h11>*</h11> Campo Obrigatório </p>
                    </div>
                  </div>

                </div>
              </div>




        <fieldset>
        <div class="panel panel-primary">
          <div class="panel-heading">Termos de Interesse</div>

              <div class="panel-body">
                <div class="form-group">

                  <div class="col-md-2 control-label">
                    <p class="help-block"><h11>*</h11> Selecione 5 termos </p>
                  </div>
                </div>


                  <label>
                    <input type="checkbox" name="fruit[]" value="<?php echo $perfil[0]; ?>"  />
                    <font color="#000000"><?php echo $perfil[0]; ?></font>
                    <span></span>
                  </label><br>
                  <label>
                    <input type="checkbox" name="fruit[]" value="<?php echo $perfil[1]; ?>" />
                    <font color="#000000"><?php echo $perfil[1]; ?></font>
                    <span></span>
                  </label><br>
                  <label>
                    <input type="checkbox" name="fruit[]" value="<?php echo $perfil[2]; ?>"  />
                    <font color="#000000"><?php echo $perfil[2]; ?></font>
                    <span></span>
                  </label><br>
                  <label>
                    <input type="checkbox" name="fruit[]" value="<?php echo $perfil[3]; ?>"  />
                    <font color="#000000"><?php echo $perfil[3]; ?></font>
                    <span></span>
                  </label><br>
                  <label>
                    <input type="checkbox" name="fruit[]" value="<?php echo $perfil[4]; ?>"  />
                    <font color="#000000"><?php echo $perfil[4]; ?></font>
                    <span></span>
                  </label><br>
                  <label>
                    <input type="checkbox" name="fruit[]" value="<?php echo $perfil[5]; ?>"  />
                    <font color="#000000"><?php echo $perfil[5]; ?></font>
                    <span></span>
                  </label><br>
                  <label>
                    <input type="checkbox" name="fruit[]" value="<?php echo $perfil[6]; ?>"  />
                    <font color="#000000"><?php echo $perfil[6]; ?></font>
                    <span></span>
                  </label><br>
                  <label>
                    <input type="checkbox" name="fruit[]" value="<?php echo $perfil[7]; ?>"  />
                    <font color="#000000"><?php echo $perfil[7]; ?></font>
                    <span></span>
                  </label><br>
                  <label>
                    <input type="checkbox" name="fruit[]" value="<?php echo $perfil[8]; ?>"  />
                    <font color="#000000"><?php echo $perfil[8]; ?></font>
                    <span></span>
                  </label><br>
                  <label>
                    <input type="checkbox" name="fruit[]" value="<?php echo $perfil[9]; ?>"  />
                    <font color="#000000"><?php echo $perfil[9]; ?></font>
                    <span></span>
                  </label><br>
                  <br />
              <textarea rows="4" cols="50" name="txt1" id="txt1" style="color:#808080"  readonly></textarea>

              <input type="hidden" value="" id="parametros" name="parametros"
        <br />
        <br />
        <br />
        <div class="col-md-8">
          <button id="Cadastrar" name="Cadastrar" type='button' class="btn btn-success" onclick = "GetSelected()" >Cadastrar</button>
          <button id="Cancelar" name="Cancelar" class="btn btn-danger" type="Reset">Cancelar</button>
        </div>
      </div>
     </div>


          <script type="text/javascript">
            var frutas = document.getElementsByName("fruit[]");
            var txt1 = document.getElementById("txt1");


            frutas = [].slice.apply(frutas);
            var listCheckedOptions = frutas.filter(function (fruta, indice) {
                return fruta.checked;
            }).sort(function (fruta, indice) {
                return fruta.dataset.order;
            });


            function addToList(checkObj, outputObj) {
              //Remove do array caso o elemento já esteja inserido
              var count=0;
              if (listCheckedOptions.indexOf(checkObj) >= 0) {
                listCheckedOptions.splice(listCheckedOptions.indexOf(checkObj), 1);

              } else {
                if (listCheckedOptions.length > 4) {
                  alert("Máx de 5 elementos selecionados!");
                  return checkObj.checked = false;
                }


                listCheckedOptions.push(checkObj);

              }

              if (!checkObj.checked) {
                checkObj.parentNode.querySelector('span').innerHTML = '';
                delete checkObj.dataset.order;
              }
              return updateValores(outputObj);
            }

            var updateValores = function (outputObj) {
              outputObj.value = ""; //Limpa o textarea
              outputObj.value = listCheckedOptions.map(function (o) {
                return o.value;
              }).join(','); //Adiciona no textarea

              listCheckedOptions.forEach(function (fruta, indice) {
                var span = fruta.parentNode.querySelector('span');
                fruta.dataset.order = indice + 1;
                span.innerHTML = indice + 1;
              });

              return;
            }
            frutas.forEach(function (fruta, indice) {
              fruta.onclick = function () {
                addToList(this, txt1);
              };
            });

            updateValores(txt1);

            function GetSelected() {
              var count=0;
              let text = txt1.value;
             var check= document.getElementsByName("fruit[]");
             var nome = document.getElementById("nome").value;
             var email = document.getElementById("email").value;
             var senha = document.getElementById("senha").value;

              for (var i = 0; i < check.length; i++) {
                if(check[i].checked){
                      ++count;
                }

              }
               var conhecoIHC = document.getElementById("conhecoIHC");
              
              if (count<5){
                alert("Mín de 5 elementos selecionados!");
                return false;
              }else if(conhecoIHC.selectedIndex == 0){
                alert("Selecione sim ou não");
                return false;
              }else if(nome.length == 0 || email.length == 0 || senha == 0){
                alert("Campos obrigatório precisam ser preenchidos!");
                return false;
              }else{

                document.getElementById("parametros").value = encodeURI(text.replace('\\n', ''));
                document.getElementById("Form1").submit();
              }



            }

            //document.getElementById("parametros").value = selected.join(",");

            </script>


      </form>
  </body>

</html>
