<?php

function adminer_object()
{
	// required to run any plugin
	include_once "./plugins/plugin.php";

	// autoloader
	foreach (glob("plugins/*.php") as $filename) {
		include_once "./$filename";
	}

	// enable extra drivers just by including them
	//~ include "./plugins/drivers/simpledb.php";

	$plugins = array(
		// specify enabled plugins here
		new AdminerFrames(),
		new ConsoleSyncPlugin()
	);

	/* It is possible to combine customization and plugins:
				class AdminerCustomization extends AdminerPlugin {
				}
				return new AdminerCustomization($plugins);
				*/

	return new AdminerPlugin($plugins);
}

// include original Adminer or Adminer Editor
// Note: Renaming it to adminer.php will cause a bug, so we use the file's original name
// https://sourceforge.net/p/adminer/discussion/960418/thread/cb0a7ff1/
// https://github.com/onecentlin/laravel-adminer/issues/4
// https://github.com/vrana/adminer/pull/313
include "./adminer-4.8.0-en.php";
?>