<?php
function genererMenu($links) {
    echo '<ul>';

    $currentPage = rtrim($_SERVER['REQUEST_URI'], '/');

    foreach ($links as $label => $url) {
        $urlNormalized = rtrim($url, '/');
        $activeClass = ($currentPage === $urlNormalized) ? 'class="active"' : '';
        echo "<li $activeClass><a href=\"$url\">$label</a></li>";
    }

    echo '</ul>';
}
?>