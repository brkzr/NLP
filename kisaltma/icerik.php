    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>Metin Giriniz:</h1>
      </div>
      <form role="form">
        <div class="form-group">
          <textarea class="form-control" id="text1" name="text1" title="Metni Giriniz." rows="12"><?php 
            if(isset($_GET['text1'] )){echo $_GET['text1'];}
            ?></textarea>
        </div>
        <div class="konum">
          <button id="buton1" type="submit"  class="btn btn-primary btn-lg">Kısaltma Ara &raquo;</button>
        </div>
      </form> 
    </div>

<?php if(isset($_GET['text1'] )){
    echo '<div class="container">
      <h2 class="sub-header">Kısaltmalar</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Kısaltma</th>
                  <th>Nerede Bulundu</th>
                  <th>Uzun Hali</th>
                </tr>
              </thead>
              <tbody>'; }
?>


    <?php 

      setlocale(LC_ALL, 'tr_TR.UTF-8'); //türkçeye ayarladık
      $kisaltma = array(); //global array
      $long = array();     //global array
      $short = array();    //global array

      if(isset($_GET['text1'] )){

        //Tüm büyük harfli kelimeleri bul 
        function isAbbrevation($sentence, $index){
          $i =0;
          $control = true;
          foreach ($sentence as $string) {
            if($index[$i]==1){
              if(mb_strtoupper($string, 'utf-8') == $string){
                GLOBAL $kisaltma;
                $kisaltma[]=$string;
              }
            }
            $i++;
          }
        }//end-func

        //kısaltmanın uzun halini text içinde arama
        function findComplateSenstenceForAbbreviation($text,$abbreviation){

          $k= 0;
          $uzun ="";

          for ($j=0; $j <count($text) ; $j++) { 
            
            for ($i=0; $i < mb_strlen($abbreviation,'utf-8'); $i++) {
              $rest = mb_substr($abbreviation,$i,1,'utf-8');

              if($rest == mb_substr($text[$j+$k],0,1,'utf-8')){

                $uzun .= $text[$j+$k]." ";
                $k++;            
              }
            }
            if($k == mb_strlen($abbreviation,'utf-8')){
              GLOBAL $long;
              $long[]=$uzun;
              GLOBAL $short;
              $short[]=$abbreviation;
            }
            $uzun ="";
            $k=0;
          }
        }//END -FUNC
        
        $cumle = $_GET['text1'];
        //cümleleri ayıran regex
        $parts = spliti("[ .',;]+", $cumle);

        $isCapital = array_fill(0,count($parts), 0);

        //find upper case
        $i=0;
        foreach ($parts as $string) {   
            if(isset($string[0])){
            if(mb_strtoupper($string[0], 'utf-8') == $string[0] && !preg_match('/^[0-9]*$/',$string)){
                $isCapital[$i] =  1;
            }
            $i ++;
          }
        }

        //fonksiyon çağrıldı
        isAbbrevation($parts,$isCapital);

        //fonksiyon çağrıldı
        foreach ($kisaltma as $key) {
          findComplateSenstenceForAbbreviation($parts,$key);
        }  

        //print_r($long);
        //echo $long[1];
        //print_r($short);

        for ($i=0; $i <count($kisaltma) ; $i++) { 
          $temp = "#";
          if(isset($long[$i])){
            $temp2 = (string) $short[$i];
            if(strcmp($kisaltma[$i],$short[$i])==0){
              $temp = $long[$i];
            }
          }
          echo "<tr>
                  <td>$i</td>
                  <td>$kisaltma[$i]</td>
                  <td>Metin içinde</td>
                  <td>$temp</td>
                </tr>";
        }

      }
    ?>

    <?php if(isset($_GET['text1'] )){
          echo  '</tbody>
        </table>
      </div>
    </div>'; } ?>   