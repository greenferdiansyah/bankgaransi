<?php echo buildMenu(0, $menus, $active_menu);?>
<!-- <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-small-cap">PERSONAL</li>
                        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard <span class="label label-rouded label-themecolor pull-right">4</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="index.html">Minimal </a></li>
                                <li><a href="index2.html">Analytical</a></li>
                                <li><a href="index3.html">Demographical</a></li>
                                <li><a href="index4.html">Modern</a></li>
                            </ul>
</li>
</ul> -->
        
<?php
function buildMenu($parent, $menu, $active_menu)
{
   $html = "";
   if (isset($menu['parents'][$parent]))
   {
	  //EDITED OJAN
      if($menu['parents'][$parent]==$menu['parents'][0]){
            $ul_class       = "";
            $ul_expand      = "";
            $ul_id          = "id='sidebarnav'";
            $hide_span      = 'hide-menu';

        }else{
            $ul_id          = "";
            $ul_class       = "collapse";
            $ul_expand      = "aria-expanded='false'";
            $hide_span      = '';
        }   
	  //$menu['parents'][$parent]==$menu['parents'][0]?$cls_ul_tree = "data-widget='tree'":$cls_ul_tree = "";
      
	  $html .= "<ul $ul_id class='$ul_class' $ul_expand>\n";
	  
	  $menu['parents'][$parent]==$menu['parents'][0]?$html.= "<li class='nav-devider'></li><li class='nav-small-cap'>MAIN NAVIGATION</li>":$html.= "";
	  
       foreach ($menu['parents'][$parent] as $itemId)
       {
          if(!isset($menu['parents'][$itemId]))
          {
			 $active = '';
			 if($menu['id'][$itemId]['url']==$active_menu){$active = 'active';}
					
			 $html .= "<li class='$active'><a href='#".$menu['id'][$itemId]['url']."' id='menu-".$menu['id'][$itemId]['url']."'  class='waves-effect  waves-dark'><i class='".$menu['id'][$itemId]['icon']."'></i><span class='$hide_span'>&nbsp;".
			 $menu['id'][$itemId]['menuname']."</span></a></li>";

          }
          if(isset($menu['parents'][$itemId]))
          {
			
			$active = '';
			foreach($menu['id'] as $key){
				if($key['url'] ==$active_menu && $menu['id'][$itemId]['id']== $key['parent']){$active = 'active';}
			}
			
             $html .=  '<li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="'.$menu['id'][$itemId]['icon'].'">
                                </i><span class="hide-menu">&nbsp;'. $menu['id'][$itemId]['menuname'].'</span></a>';
			
             $html .= buildMenu($itemId, $menu,$active_menu);
             $html .= "</li>";
          }
       }
       $html .= "</ul>";
   }
   return $html;
}
?>