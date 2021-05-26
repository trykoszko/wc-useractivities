<?php

namespace Trykoszko\Twig;

/**
 * A class for Twig extension
 * Global Twig variables and Twig functions can be defined here
 */
class Main
{
    public $twig;
    public $loader;

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader(USERACTIVITIES_ROOT_DIR . 'templates');
        $twig = new \Twig\Environment($this->loader);

        $twig = $this->registerGlobals($twig);
        $twig = $this->registerFunctions($twig);

        $this->twig = $twig;
    }

    protected function registerGlobals($twig)
    {
        $twig->addGlobal('textdomain', TEXTDOMAIN);
        $twig->addGlobal('wpData', [
            'adminPostUrl' => esc_url( \admin_url('admin-post.php') )
        ]);

        return $twig;
    }

    protected function registerFunctions($twig)
    {
        $translate = new \Twig\TwigFunction('__', function ($text) {
            return \translate($text, TEXTDOMAIN);
        });
        $twig->addFunction($translate);

        $echoNonceField = new \Twig\TwigFunction('nonceField', function ($text) {
            echo \wp_nonce_field($text);
        });
        $twig->addFunction($echoNonceField);

        return $twig;
    }

    public function render($template, $data)
    {
        echo $this->twig->render("$template.twig", $data);
    }
}
