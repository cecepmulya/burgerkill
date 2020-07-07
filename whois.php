<form method=GET action="<?php htmlentities(basename(_FILE_)); ?>">
<input type=text name="q" value="<?php echo htmlentities($_REQUEST["q"]); ?>">
<input type=submit value="WHOIS">
</form>
<pre><?php
/*
 * whois.php
 */

main();

function main(){

  $domain = $_REQUEST['q'];

  if (!$domain) {
    return FALSE;
  }
  
  if (!is_valid_domain_name($domain)) {
   echo "Invalid query";
   return FALSE;
  }

  if (strlen($domain) < 4) {
    echo "No domain name is that short.";
    return FALSE;
  }

  if (strlen($domain) > 80) {
    echo "Too long.";
   return FALSE;
  }

  //echo '$ whois ' . htmlentities($domain) . "\r\n";
  $whois = shell_exec("whois '" . addslashes($domain) . "'");
  print_r($whois);
}

function is_valid_domain_name($domain_name) {
  // Thanks to http://stackoverflow.com/a/4694816
  return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
    && preg_match("/^.{1,253}$/", $domain_name) //overall length check
    && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
}
