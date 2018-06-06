<?php

namespace Core;

/**
 * @author Sueliton
 */
class Redirect {
    public static function route($url) {
        return header("Location: {$url}");
    }
}
