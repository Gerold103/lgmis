<div class="image-container" style="width: 850px">
	<img class="menu-img-up" src=<?php echo '"'.Link::Get($link_to_service_images).'menu_image_up.jpg"'; ?> >
	<div class="image-content" style="top: 10px; width: 100%;" align="center">

		<div class="image-container" style="width: 100%;" align="center">
			<img src=<?php echo '"'.Link::Get($link_to_service_images).'Logo.png"'; ?> width="85px">
			<div class="image-content" style="top: 35%; width: 100%; color: white;" align="center">
				<p style="width: 60%;"><font class="company_name"><?php echo Language::CompanyName(); ?></font></p>
			</div>
		</div>

		<div class="btn-group btn-group-justified" style="position: relative; top: 25px; width: 70%; z-index: 100;" role="group" aria-label="Justified button group">
			<a href=<?php echo '"'.Link::Get($link_to_articles_mod).'"'; ?> class="btn btn-default btn-sm" role="button"><?php echo Language::PublicMenu('articles'); ?></a>
			<a href=<?php echo '"'.Link::Get($link_to_about_us_mod).'"'; ?> class="btn btn-default btn-sm" role="button"><?php echo Language::PublicMenu('about_us'); ?></a>
			<a href=<?php echo '"'.Link::Get($link_to_contacts_mod).'"'; ?> class="btn btn-default btn-sm" role="button"><?php echo Language::PublicMenu('contacts'); ?></a>
			<a href=<?php echo '"'.Link::Get($link_to_directions_mod).'"'; ?> class="btn btn-default btn-sm" role="button"><?php echo Language::PublicMenu('directions'); ?></a>
			<a href=<?php echo '"'.Link::Get($link_to_projects_mod).'"'; ?> class="btn btn-default btn-sm" role="button"><?php echo Language::PublicMenu('projects'); ?></a>
		</div>
		<a href="http://lgmis.cs.msu.ru/redmine" border="0" target="_blank" style="z-index: 200;"><img border="0" style="z-index: 200;" src=<?php echo '"'.Link::Get($link_to_service_images).'Rocket.png"'; ?> height="120px" class="rocket"></a>

	</div>
</div>

<?php

?>