 <?php
 
 /*$stylesheet = <<<EOD
        <link href="dyn_men_style.css" rel="stylesheet" type="text/css">
EOD;
 
 echo $stylesheet;*/
 
$menu = array(
  'home'  => array('text'=>'Home',  'url'=>'?p=home'),
  'away'  => array('text'=>'Away',  'url'=>'?p=away'),
  'about' => array('text'=>'About', 'url'=>'?p=about'),
); 

//print_r(array_values($menu));

class CNavigation {
  public static function GenerateMenu($items, $class) {
    $html = "<nav class='$class'>\n";
    foreach($items as $item) {
      $html .= "<a href='{$item['url']}'>{$item['text']}</a>\n";
    }
    $html .= "</nav>\n";
  }
};

echo CNavigation::GenerateMenu($menu, 'navbar');