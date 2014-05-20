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
                  <th>Kısaltmalar</th>
                  <th>Nerede Bulundu</th>
                  <th>Uzun Hali Olabilicek Kelimeler</th>
                </tr>
              </thead>
              <tbody>'; }
?>


    <?php

      setlocale(LC_ALL, 'tr_TR.UTF-8'); //türkçeye ayarladık
      $kisaltma = array(); //global array
      $long = array();     //global array
      $short = array();    //global array
      $index = 0;          //global variable
      $abbreviationQuery =array();  //global array
      $sentenceQuery =array();      //global array

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
        function findComplateSenstenceForAbbreviation ($abbreviation){
          GLOBAL $index;
          GLOBAL $abbreviationQuery;
          GLOBAL $sentenceQuery;
          GLOBAL $cumle;
          GLOBAL $con;

          $regex = "/[ ]";
          for ($i=0; $i < mb_strlen($abbreviation,'utf-8'); $i++) { 
            if($i==0) {
              $regex .= "([".mb_substr($abbreviation,$i,1,'utf-8')."][a-z|ı|ü|ş|ç|ğ|ö]*)";
            } else if ($i ==  mb_strlen($abbreviation,'utf-8') - 1) { 
               $regex .= "(( [a-z|ı|ü|ş|ç|ğ|ö]*)* [".mb_substr($abbreviation,$i,1,'utf-8')."][a-z|ı|ü|ş|ç|ğ|ö|.]*)";
            } else { 
               $regex .= "(( [a-z|ı|ü|ş|ç|ğ|ö]*)* [".mb_substr($abbreviation,$i,1,'utf-8')."][a-z|ı|ü|ş|ç|ğ|ö|.]*)?"; 
              }               
          }

          $regex .="/u";
          $matches =0;

          //regex execution 
          preg_match_all($regex,$cumle,$matches);
          //print_r($matches[0]);

          foreach ($matches[0] as $value) {
            GLOBAL $long;
            $long[$index]=$value;;
            GLOBAL $short;
            $short[$index]=$abbreviation;
            $index++;
          }
        }
        
        $cumle = "æ ";
        $cumle .= $_GET['text1'];
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
        } // END-FUNC

        //fonksiyon çağrıldı
        isAbbrevation($parts,$isCapital);

        $unique = array_unique($kisaltma);
        
        //fonksiyon çağrıldı
        foreach ($unique as $key) {
          findComplateSenstenceForAbbreviation($key);
        }  

        $temp ="";
        $m=0;

        //buraya tekrar bakılacak 
        for ($i=0; $i <count($kisaltma) ; $i++) { 
          for ($j=0; $j < count($long) ; $j++) { 

            if(strcmp($kisaltma[$i],$short[$j])==0){
              $temp .= "$long[$j] <br>";
              //echo "$long[$j] <br>";
            }            
          }
          echo "<tr>
                  <td>$i</td>
                  <td>$kisaltma[$i]</td>
                  <td>Metin içinde</td>
                  <td>$temp</td>
                </tr>"; 
          $temp = ""; 
          $m=$i;        
        }

        //DB Conncection
        $conn = mysql_connect("localhost","root","") or die(mysql_error());
        mysql_select_db("nlp") or die(mysql_error());

        //türkçe karakter çekme problemi çözüldü
        mysql_set_charset('utf8', $conn);

        // Get all the data from the "example" table
        for ($i=0; $i <count($parts); $i++) { 
          
          //sorgudaki binasy SQL de case sensetive i aktif eder.
          $result = mysql_query("SELECT * FROM list WHERE binary abbreviation =\"".$parts[$i]."\"") or die(mysql_error());  

          while($row = mysql_fetch_array($result)) {
            $abbreviationQuery[]= $row['abbreviation'];
            $sentenceQuery[]= $row['sentence'];
          }          
        }

        mysql_close($conn);
 
        //--------------------------------------------------
        for ($i=0; $i <count($abbreviationQuery) ; $i++) { 
        $m ++;

          echo "<tr>
                  <td>$m</td>
                  <td>$abbreviationQuery[$i]</td>
                  <td>Veri Tabanı</td>
                  <td>$sentenceQuery[$i]</td>
                </tr>";             
        }
       //--------------------------------------------------

      }
    ?>




    <?php if(isset($_GET['text1'] )){
          echo  '</tbody>
        </table>
      </div>
    </div>'; } ?>   