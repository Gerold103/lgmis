<?php
	if (isset($menu) || ($menu != '')) echo $menu;
    else {
        $menu = '
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <a class="navbar-brand" href="'.$link_to_admin.'">LGMIS</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
              <ul class="nav navbar-nav">
                <li><p class="navbar-text">Добро пожаловать, <b>'.$_SESSION['user_login'].'</b></p></li>
                <li>
                    <form class="navbar-form navbar-left" method="post" action="'.$link_to_utility_authorization.'">
                        <button type="submit" class="btn btn-default" name="exit">Выйти</button>
                    </form>
                </li>';

                if ((!isset($on_start_page)) || ($on_start_page == false) || isset($_POST['prev_page']) || isset($prev_page) && ($prev_page != '')) {
                    $menu .= '<li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Действия <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">';
                    if ((!isset($on_start_page)) || ($on_start_page == false)) {
                        $menu .=  '<li>'.OnStartAdminPage().'</li>'; 
                    }
                    if (isset($_POST['prev_page'])) {
                        $menu .= '<li>'.OnPreviousPage($_POST['prev_page']).'</li>';
                    } else if (isset($prev_page) && ($prev_page != '')) {
                        $menu .= '<li>'.OnPreviousPage($prev_page).'</li>';
                    }
                    $menu .= '</ul>
                    </li>';
                }

                $menu .= '<li>
                            <form class="navbar-form navbar-left" method="post" action="'.$link_to_admin_user.'">
                                <input class="btn btn-default" name="full" type="submit" value="Моя страница">
                                <input type="hidden" name="type" value="'.User::$type.'">
                                <input type="hidden" name="id" value="'.User::FetchByLogin($_SESSION['user_login'])->id.'">
                                <input type="hidden" name="prev_page" value="'.$_SERVER['REQUEST_URI'].'">
                            </form>
                        </li>';
              $menu .= '</ul>
          </div><!-- /.container-fluid -->
        </nav>';
        echo $menu;
    }
?>