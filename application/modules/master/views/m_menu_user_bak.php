
   <div class="cat__menu-left__inner id='sidebar' class='sidebar' ">
        <?php echo buildMenu(0, $menus, $active_menu);?>
    </div>

<?php
function buildMenu($parent, $menu, $active_menu)
{
 
   $html = "";
   if (isset($menu['parents'][$parent]))
   {
	  
	  $menu['parents'][$parent]==$menu['parents'][0]?$cls_ul = "cat__menu-left__list cat__menu-left__list--root":$cls_ul = "cat__menu-left__list";
      
	  $html .= "<ul class='$cls_ul'>\n";
	  
	  
       foreach ($menu['parents'][$parent] as $itemId)
       {
          if(!isset($menu['parents'][$itemId]))
          {
			 $active = '';

			 if($menu['id'][$itemId]['url']==$active_menu){$active = 'cat__menu-left__item--active';}
			 	if($menu['id'][$itemId]['parent']==0){
             	  	$html .= 	"<li class='cat__menu-left__item $active' id='".$menu['id'][$itemId]['url']."' data-toggle='ajax' >
			                        <a href='main#".$menu['id'][$itemId]['url']."'>
			                            <span class='cat__menu-left__icon ".$menu['id'][$itemId]['icon']."'></span>
			                            ".$menu['id'][$itemId]['menuname']."
			                        </a>
		                    	</li>";
		        }else{
		           	$html .= 	"<li class='cat__menu-left__item $active' id='".$menu['id'][$itemId]['url']."' data-toggle='ajax'>
			                        <a href='main#".$menu['id'][$itemId]['url']."'>
			                            <span class='cat__menu-left__icon'>".$menu['id'][$itemId]['icon']."</span>
			                            ".$menu['id'][$itemId]['menuname']."
			                        </a>
			                    </li>";         
		        }

		        if($menu['id'][$itemId]['divider']==1){
		        	$html.='<li class="cat__menu-left__divider"><!-- --></li>';
		        }
          }

          if(isset($menu['parents'][$itemId]))
          {
			
			$active = '';
			foreach($menu['id'] as $key){
				if($key['url'] ==$active_menu && $menu['id'][$itemId]['id']== $key['parent']){$active = 'cat__menu-left__item--active cat__menu-left--colorful--default cat__menu-left__submenu--toggled';}
			}
			
			 	$html .="<li class='cat__menu-left__item cat__menu-left__submenu $active'>\n
			 				<a href='javascript:void(0);'>\n
			 					<span class='cat__menu-left__icon ".$menu['id'][$itemId]['icon']."'></span>\n
			 					".$menu['id'][$itemId]['menuname']."\n
			 				</a>\n";		
			
             $html .= buildMenu($itemId, $menu,$active_menu);
             $html .= "</li> \n";
          }
       }
       $html .= "</ul> \n";
   }
   return $html;
}
?>