<?php


function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function isTwigTemplateName($name)
{
    return endsWith($name, 'twig');
}