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
        $results = db_query('SELECT * FROM {customer}');

        $header = array(t('ID'), t('Customer Name'), t('Customer Email'),  t('Legal Entity Type'), t('Description'), t('Website'), t('Uploaded by'));
        $rows = array();

        foreach($results as $result) {
            $rows[] = array(
                $result->id,
                $result->customer_name,
                $result->customer_email,
                $result->customer_legal_entity_type,
                $result->customer_description,
                $result->customer_website,
                $result->uploading_user,
            );
        }

        return theme('table', array('header' => $header, 'rows' => $rows));
    }
}
?>