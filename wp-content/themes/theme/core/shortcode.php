<?php
function embeg_html($atts) {
    extract(shortcode_atts
        (array('url' => '', 'width' => '', 'height' => ''), $atts)
    );
    $return .= '<iframe width="' . $width . '" height="' . $height . '" frameborder="no" scrolling="auto" src="' . $url . '"></iframe>';
    return $return;
}

add_shortcode('embeg', 'embeg_html');