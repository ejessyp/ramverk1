<?php

namespace Anax\View;

/**
 * Render plain content.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}
// transfer the json object to an array using true parameter
$content_array = json_decode($content, true);
// Produce the bbox four points for openstreetmap
$left = $content_array["latitude"] - 0.008;
$right = $content_array["latitude"] + 0.008;
$top = $content_array["longitude"] - 0.008;
$down = $content_array["longitude"] + 0.008;

?>
<h1>Map</h1>
<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.openstreetmap.org/export/embed.html?bbox=<?=$top?>%2C<?=$left?>%2C<?=$down?>%2C<?=$right?>&amp;layer=mapnik&amp;marker=<?= $content_array['latitude'] ?>,<?= $content_array['longitude'] ?>" style="border: 1px solid black"></iframe>
<a href="<?=$content_array["link"] ?>">Click here to see the bigger map.</a>
<pre <?= classList($classes) ?>><?= $content ?></pre>
