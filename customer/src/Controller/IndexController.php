<?php
/**
 * @file
 * @author Joonas Heinonen
 * Contains \Drupal\customer\Controller\IndexController.
 * Please include this file under your
 * expenses(module_root_folder)/src/Controller
 */
namespace Drupal\customer\Controller;

class IndexController {
    /**
     * Returns the index page for the customer module.
     * 
     * @return array
     * A simple renderable array.
     */
    public function showIndex() {
        $element = array(
            '#type' => 'markup',
            '#markup' => 'Hello world!',
        );

        return $element;
    }
}
?>