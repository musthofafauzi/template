<?php
echo _menu_vertical($menus);

function _menu_vertical($menus, $level = -1, $id='')
{
	$output = '';
	if (!empty($menus))
	{
		$highlight = menu_parent_ids(@$_GET['menu_id'], $menus);
		if ($level == -1)
		{
			$output = call_user_func(__FUNCTION__, menu_parse($menus), ++$level);
		}else
		if (empty($level))
		{
			global $Bbc;
			if (empty($Bbc))
			{
				$Bbc = new stdClass;
			}
			if (empty($Bbc->menu_vertical))
			{
				$Bbc->menu_vertical = 1;
			}else{
				$Bbc->menu_vertical++;
			}
			$id = 'menu_v'.$Bbc->menu_vertical;
			$out = '';
			foreach ($menus as $menu)
			{
				$sub = call_user_func(__FUNCTION__, $menu['child'], ++$level, $id);
				$act = in_array($menu['id'], $highlight) ? ' active' : '';
				$alt = trim(strip_tags($menu['title']));
				if (!empty($sub))
				{
					$out .= '<a href="#'.$id.$level.'" class="list-group-item'.$act.'" data-toggle="collapse" data-parent="#'.$id.'" title="'.$alt.'">'.$menu['title'].' <span class="caret down"></span></a>';
					$out .= $sub;
				}else{
					// $out .= '<a href="'.$menu['link'].'" class="list-group-item'.$act.'" data-parent="#'.$id.'" title="'.$alt.'">'.$menu['title'].'</a>';
          $out .= 
          '<li class="'.$act.'"data-parent="#'.$id.'" title="'.$alt.'"> 
          <a class="admin_link" href="'.$menu['link'].'">
            <i class="fa fa-folder"></i> <span>'.$menu['title'].'</span>
          </a>
        </li>';
				}
			}
            $output = '<ul class="sidebar-menu" data-widget="tree" id="'.$id.'">'.$out.'</ul>';
		}else {
			$id .= $level;
			$out = '';
			$in  = '';
			foreach ($menus as $menu)
			{
				$sub = call_user_func(__FUNCTION__, $menu['child'], ++$level, $id);
				$act = in_array($menu['id'], $highlight) ? ' active' : '';
				$alt = trim(strip_tags($menu['title']));
				if ($act)
				{
					$in = ' in';
				}
				if (!empty($sub))
				{
					// $out .= '<a href="#'.$id.$level.'" class="list-group-item'.$act.'" data-toggle="collapse" data-parent="#'.$id.'" title="'.$alt.'">'.$menu['title'].' <span class="caret down"></span></a>';
					$out .= $sub;
				}else {
					// s$out .= '<a href="'.$menu['link'].'" class="list-group-item'.$act.'" data-parent="#'.$id.'" title="'.$alt.'">'.$menu['title'].'</a>';
					$out .= 
          '<li class="'.$act.'"data-parent="#'.$id.'" title="'.$alt.'"> 
          <a class="admin_link" href="'.$menu['link'].'">
            <i class="fa fa-folder"></i> <span>'.$menu['title'].'</span>
          </a>
        </li>';
				      }
			}
			$output = '<div id="'.$id.'" class="collapse'.$in.' list-group-submenu">'.$out.'</div>';
		}
	}
	return $output;
}