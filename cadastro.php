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

              <input type="hidden" value="" id="parametros" name="parametros">
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
            function cript() {
              var MD5 = function(d){var r = M(V(Y(X(d),8*d.length)));return r.toLowerCase()};function M(d){for(var _,m="0123456789ABCDEF",f="",r=0;r<d.length;r++)_=d.charCodeAt(r),f+=m.charAt(_>>>4&15)+m.charAt(15&_);return f}function X(d){for(var _=Array(d.length>>2),m=0;m<_.length;m++)_[m]=0;for(m=0;m<8*d.length;m+=8)_[m>>5]|=(255&d.charCodeAt(m/8))<<m%32;return _}function V(d){for(var _="",m=0;m<32*d.length;m+=8)_+=String.fromCharCode(d[m>>5]>>>m%32&255);return _}function Y(d,_){d[_>>5]|=128<<_%32,d[14+(_+64>>>9<<4)]=_;for(var m=1732584193,f=-271733879,r=-1732584194,i=271733878,n=0;n<d.length;n+=16){var h=m,t=f,g=r,e=i;f=md5_ii(f=md5_ii(f=md5_ii(f=md5_ii(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_ff(f=md5_ff(f=md5_ff(f=md5_ff(f,r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+0],7,-680876936),f,r,d[n+1],12,-389564586),m,f,d[n+2],17,606105819),i,m,d[n+3],22,-1044525330),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+4],7,-176418897),f,r,d[n+5],12,1200080426),m,f,d[n+6],17,-1473231341),i,m,d[n+7],22,-45705983),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+8],7,1770035416),f,r,d[n+9],12,-1958414417),m,f,d[n+10],17,-42063),i,m,d[n+11],22,-1990404162),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+12],7,1804603682),f,r,d[n+13],12,-40341101),m,f,d[n+14],17,-1502002290),i,m,d[n+15],22,1236535329),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+1],5,-165796510),f,r,d[n+6],9,-1069501632),m,f,d[n+11],14,643717713),i,m,d[n+0],20,-373897302),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+5],5,-701558691),f,r,d[n+10],9,38016083),m,f,d[n+15],14,-660478335),i,m,d[n+4],20,-405537848),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+9],5,568446438),f,r,d[n+14],9,-1019803690),m,f,d[n+3],14,-187363961),i,m,d[n+8],20,1163531501),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+13],5,-1444681467),f,r,d[n+2],9,-51403784),m,f,d[n+7],14,1735328473),i,m,d[n+12],20,-1926607734),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+5],4,-378558),f,r,d[n+8],11,-2022574463),m,f,d[n+11],16,1839030562),i,m,d[n+14],23,-35309556),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+1],4,-1530992060),f,r,d[n+4],11,1272893353),m,f,d[n+7],16,-155497632),i,m,d[n+10],23,-1094730640),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+13],4,681279174),f,r,d[n+0],11,-358537222),m,f,d[n+3],16,-722521979),i,m,d[n+6],23,76029189),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+9],4,-640364487),f,r,d[n+12],11,-421815835),m,f,d[n+15],16,530742520),i,m,d[n+2],23,-995338651),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+0],6,-198630844),f,r,d[n+7],10,1126891415),m,f,d[n+14],15,-1416354905),i,m,d[n+5],21,-57434055),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+12],6,1700485571),f,r,d[n+3],10,-1894986606),m,f,d[n+10],15,-1051523),i,m,d[n+1],21,-2054922799),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+8],6,1873313359),f,r,d[n+15],10,-30611744),m,f,d[n+6],15,-1560198380),i,m,d[n+13],21,1309151649),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+4],6,-145523070),f,r,d[n+11],10,-1120210379),m,f,d[n+2],15,718787259),i,m,d[n+9],21,-343485551),m=safe_add(m,h),f=safe_add(f,t),r=safe_add(r,g),i=safe_add(i,e)}return Array(m,f,r,i)}function md5_cmn(d,_,m,f,r,i){return safe_add(bit_rol(safe_add(safe_add(_,d),safe_add(f,i)),r),m)}function md5_ff(d,_,m,f,r,i,n){return md5_cmn(_&m|~_&f,d,_,r,i,n)}function md5_gg(d,_,m,f,r,i,n){return md5_cmn(_&f|m&~f,d,_,r,i,n)}function md5_hh(d,_,m,f,r,i,n){return md5_cmn(_^m^f,d,_,r,i,n)}function md5_ii(d,_,m,f,r,i,n){return md5_cmn(m^(_|~f),d,_,r,i,n)}function safe_add(d,_){var m=(65535&d)+(65535&_);return(d>>16)+(_>>16)+(m>>16)<<16|65535&m}function bit_rol(d,_){return d<<_|d>>>32-_}


              var senha = document.getElementById("senha");
              var hs = MD5(senha.value);
              senha.value = hs;
            }

            function GetSelected() {
              var count=0;
              let text = txt1.value;
             var check= document.getElementsByName("fruit[]");
             var nome = document.getElementById("nome").value;
             var email = document.getElementById("email").value;
             var senha = document.getElementById("senha").value;
              cript();
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
