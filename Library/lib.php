<?php


/**
 * xss対策
 * @param arr $arr
 * @return arr $post
 */
function html_special_chars($arr) {
    foreach ($arr as $key => $item) {
        $post[$key] = htmlspecialchars($item);
    }
    return $post;
}

?>