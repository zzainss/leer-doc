<?php
//cambiar por el nombre del archivo a leer
$filename = "x.doc";
//corre y lee el doc
if ( file_exists($filename) ) { 
    if ( ($fh = fopen($filename, 'r')) !== false ) { 
        $headers = fread($fh, 0xA00); 
        # 1 = (ord(n)*1) ; Document has from 0 to 255 characters 
        $n1 = ( ord($headers[0x21C]) - 1 ); 
        # 1 = ((ord(n)-8)*256) ; Document has from 256 to 63743 characters 
        $n2 = ( ( ord($headers[0x21D]) - 8 ) * 256 ); 
        # 1 = ((ord(n)*256)*256) ; Document has from 63744 to 16775423 characters 
        $n3 = ( ( ord($headers[0x21E]) * 256 ) * 256 ); 
        # (((ord(n)*256)*256)*256) ; Document has from 16775424 to 4294965504 haracters 
        $n4 = ( ( ( ord($headers[0x21F]) * 256 ) * 256 ) * 256 ); 
        # Total length of text in the document 
        $textLength = ($n1 + $n2 + $n3 + $n4); 
        $extracted_plaintext = fread($fh, $textLength); 
        # if you want the plain text with no formatting, do this 
        # if you want to see your paragraphs in a web page, do this 
        $texto= nl2br($extracted_plaintext); 
    //cuenta el numero de palabras en el texto
    //se puede cambiar $extracted_plaintext por $texto y agrega los espacios al contador 
        echo "<br><br>Hay ".str_word_count($extracted_plaintext, 0). " palabras en la cadena <br><br>'$extracted_plaintext'";
 
        //guardo las palabras en un array	
        $array_cadena = str_word_count($extracted_plaintext, 1);
        //saco cada elemento del array 
        foreach ($array_cadena as $palabra) {
            echo $palabra . " ";
        }
    } 
} 
?>