<?php

class CNavigation {
		public static function GenerateMenu($menu, $class) {
    		if(isset($menu['callback'])) {
      			$items = call_user_func($menu['callback'], $menu['items']);
    		}
    		$html = "<nav class='$class'>\n";
    		foreach($items as $item) {
      			$html .= "<a href='{$item['url']}' class='{$item['class']}'>{$item['text']}</a>\n";
    		}
    		$html .= "</nav>\n";
    		return $html;
		}
}

function modifyNavbar($items) {
	$ref = isset($_GET['p']) && isset($items[$_GET['p']]) ? $_GET['p'] : null;
	if($ref) {
		$items[$ref]['class'] .= 'selected'; 
	}
	return $items;
}