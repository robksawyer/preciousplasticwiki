<?php
/* IpbWiki Paypal MediaWiki extension
** IpbWiki (c) 2006
** Installation Instructions: http://www.ipbwiki.com/IpbWiki_Paypal_Extension
*/

$wgExtensionCredits['parserhook'][] = array(
      'name' => 'IpbWiki PayPal',
      'version' => '1.0.2',
      'author' => 'Peter De Decker',
      'url' => 'https://www.ipbwiki.com/IpbWiki_Paypal_Extension',
      'description' => 'Creates a PayPal button, which leads user to your PayPal-Donation-Site'
);

$wgExtensionFunctions[] = "wfPayPalExtension";

function wfPayPalExtension() {
   global $wgParser;
   global $ipbwiki_paypal;
   # register the extension with the WikiText parser
   $wgParser->setHook( "paypal", "renderPayPal" );

   $ipbwiki_paypal = array();
   # CHANGE THE LINES BELOW TO REFLECT TO YOUR PAYPAL BUTTONS!!! (there's no limit on the number of buttons you define)
   $ipbwiki_paypal[1] = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="FSV3SUVDJVJE2">
<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
</form>';

}

# The callback function for converting the input text to HTML output
function renderPayPal( $input, $argv ) {
   global $ipbwiki_paypal;
   global $wgAuth;
   $pos_space=strpos($input,' ');
   if (!$pos_space) {
       if (is_numeric($input)) {  // format <paypal>number</paypal>
           $part1 = $input;
           $part2 = '';
           if (!$ipbwiki_paypal[$part1]) {
               print_r ('warning, specified paypal button not found, defaulting to button 1');
               $part1 = 1;
               $part2 = $input;
           }
       } else {                   // format <paypal>text</paypal> & format <paypal></paypal>
           $part1 = 1;
           $part2 = $input;
       }
   } else {                       // format <paypal>number text</paypal>
       $part1=substr($input,0,$pos_space);
       $part2=substr($input,$pos_space+1);
       if (is_numeric($part1)) {
           if (!$ipbwiki_paypal[$part1]) {
               print_r ('warning, specified paypal button not found, defaulting to button 1');
               $part1 = 1;
           }
       } else {                 // format <paypal>text</paypal>
           $part1 = 1;
           $part2 = $input;
       }
   }
   $form=$ipbwiki_paypal[$part1];
   // if the ipbwiki interface is available, then use the clean function which is defined there, otherwise just clean the necessities...
   if (class_exists ('ipbwiki')) {
       $input = $wgAuth->ipbwiki->ipbwiki->clean_value ($part2);
   } else {
       $part2 = str_replace( ">"            , "&gt;"          , $part2 );
       $part2 = str_replace( "<"            , "&lt;"          , $part2 );
       $part2 = str_replace( "\""           , "&quot;"        , $part2 );
       $part2 = str_replace( "!"            , "&#33;"         , $part2 );
       $part2 = str_replace( "'"            , "&#39;"         , $part2 );
       $input = $part2;
   }
   $output = $form.$input;
   return $output;
}
