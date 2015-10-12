<?php
	if (isset($menu) || ($menu != '')) echo $menu;
    else {
?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href=<?php echo '"'.$link_to_admin.'"'; ?> >LGMIS</a>
            </div>

            <ul class="nav navbar-nav">
                <li><p class="navbar-text"><?php echo Language::Word('welcome').', <b>'.$_SESSION['user_login']; ?></b></p></li>
                <li>
                    <form class="navbar-form navbar-left" method="post" action=<?php echo '"'.$link_to_utility_authorization.'"'; ?> >
                        <button type="submit" class="btn btn-default" name="exit"><?php echo Language::Word('logout'); ?></button>
                    </form>
                </li>

<?php
                if ((!isset($on_start_page)) || ($on_start_page == false) || isset($_POST['prev_page']) || isset($prev_page) && ($prev_page != '')) {
?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo Language::Word('actions'); ?><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
<?php
                    if ((!isset($on_start_page)) || ($on_start_page == false)) { 
?>
                        <li><?php echo OnStartAdminPage(); ?></li> 
<?php
                    }
                    if (isset($_POST['prev_page'])) {
?>
                        <li><?php echo OnPreviousPage($_POST['prev_page']); ?></li>
<?php
                    } else if (isset($prev_page) && ($prev_page != '')) {
?>
                        <li><?php echo OnPreviousPage($prev_page); ?></li>
<?php 
                    }
?>
                    </ul>
                </li>
<?php
                }
?>
                <li>
                    <form class="navbar-form navbar-left" method="post" action=<?php echo '"'.$link_to_admin_user.'"'; ?> >
                        <input class="btn btn-default" name="full" type="submit" value=<?php echo '"'.Language::Word('my page').'"'; ?> >
                        <input type="hidden" name="type" value=<?php echo '"'.User::$type.'"'; ?> >
                        <input type="hidden" name="id" value=<?php echo '"'.User::FetchByLogin($_SESSION['user_login'])->id.'"'; ?> >
                        <input type="hidden" name="prev_page" value=<?php echo '"'.$_SERVER['REQUEST_URI'].'"'; ?> >
                    </form>
                </li>
                <li>
                    <form class="navbar-form navbar-left dropdown" method="post" action="">
                        <div class="input-group">
                            <input style="min-width: 300px;" id="glob_search_input" placeholder=<?php echo '"'.Language::Word('start to insert something').'"'; ?> onkeyup="showGlobalSearch(this);" class="form-control" aria-haspopup="true" name="search" type="text">
                            <ul id="glob_search_list" class="dropdown-menu" role="menu" style="display: none; overflow: scroll; max-height: 300px;">
                            </ul>
                            <span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span></span>
                            <!--<button type="button" class="btn btn-default">Test</button>-->
                        </div>
                    </form>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a style="margin: 0px; padding: 0px;" href=<?php echo '"'.$link_to_utility_interceptor.'?lang=rus"'; ?> ><img class="lang_flag" src=<?php echo '"'.$link_to_service_images.'rus_flag.png"'; ?> ></a></li>
                <li><a style="margin: 0px; padding: 0px;" href=<?php echo '"'.$link_to_utility_interceptor.'?lang=eng"'; ?> ><img class="lang_flag" src=<?php echo '"'.$link_to_service_images.'eng_flag.png"'; ?> ></a></li>
            </ul>
        </div><!-- /.container-fluid -->
    </nav>
<?php
    }
?>