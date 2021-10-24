<?php

namespace tuefekci\helpers;

/**
* Template Class
*
* This class offers function and helpers for working with templates.
*
* @author Giacomo Tüfekci
* @package tuefekci\helpers
*/
class Templates
{

    /**
     * Render
     *
     * This is a simple function to render "php templates".
     *
     * @param string $templatePath path to template file to render.
     * @param string $data data which gets inserted into the template.
     * @return string rendered template
     */
    public static function render(string $templatePath, array $data = array())
    {

        if (!files::exists($templatePath) || !is_file($templatePath)) {
            throw new \Exception('Template: '.$templatePath.' does not exists or is not a file.');
        }

        extract($data);

        try {
            $level = ob_get_level();
            ob_start();
            include $templatePath;
            $content = ob_get_clean();
            return $content;
        } catch (\Throwable $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $e;
        }
    }
}
