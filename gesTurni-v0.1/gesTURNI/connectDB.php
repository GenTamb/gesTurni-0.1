<?php

define ('INDIRIZZO','localhost');
define ('UTENTE','root');
define ('PASSWORD',"");
define ('DB','turni');


mysql_connect(INDIRIZZO,UTENTE,PASSWORD);
mysql_select_db(DB);
?>