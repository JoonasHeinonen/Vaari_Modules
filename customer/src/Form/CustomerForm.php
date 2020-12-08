<?php
/**
 * @file
 * @author Joonas Heinonen
 * Contains \Drupal\customer\Form\CustomerForm.
 * Please include this file under your
 * expenses(module_root_folder)/src/Form
 */
namespace Drupal\customer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


// http://karimboudjema.com/en/drupal/20181013/create-custom-form-form-api-drupal-8

class CustomerForm extends FormBase {
    /**
     * Returns a unique string identifying the form.
     *
     * The returned ID should be a unique string that can be a valid PHP function
     * name, since it's used in hook implementation names such as
     * hook_form_FORM_ID_alter().
     *
     * @return string
     *   The unique string identifying the form.
     */

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'customer_customer_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['description'] = array(
            '#type' => 'item',
            '#markup' => $this->t('Enter a new customer for the Vaari CRM database'),
        );

        $form['values'] = array(
            '#prefix' => '<section style="background-color: black;">',
            '#suffix' =>'</section>',
        );

        $form['values']['div_0'] = array(
            '#prefix' => '<div style="display:flex;flex-flow:colomn wrap;">',
            '#id'     => 'div_1',
            '#suffix' => '</div>',
        );

        $form['values']['div_0']['el_0']['customer_name'] = array(
            '#type' => 'textfield',
            '#title' => 'Customer Name',
            '#description' => 'Name for the customer company.',
            '#size' => 30,
            '#required' => TRUE
        );

        $form['values']['div_0']['el_1']['customer_legal_entity_type'] = array(
            '#type' => 'select',
            '#title' => 'Legal Entity Type',
            '#description' => 'The legal entity type for the customer company.',
            '#default_value' => 0,
            '#options' => array(
                'TMI' => t('Tmi.'),
                'AY'  => t('Ay'),
                'KY'  => t('Ky'),
                'OY'  => t('Oy'),
                'OYJ' => t('Oyj'),
            ),
            '#required' => TRUE
        );

        $form['values']['customer_email'] = array(
            '#type' => 'textfield',
            '#title' => 'Customer Email',
            '#description' => 'The corresponsive email for the customer company.',
            '#size' => 60,
            '#required' => TRUE
        );

        $form['values']['customer_description'] = array(
            '#type' => 'textarea',
            '#title' => 'Customer Description',
            '#description' => 'Short description of the customer and the industry.',
            '#required' => TRUE
        );

        $form['values']['customer_website'] = array(
            '#type' => 'url',
            '#title' => t('Customer\'s Website (Optional)'),
            '#size' => 30,
        );

        $form['values']['submit_customer'] = array(
            '#type' => 'submit',
            '#value' => t('Submit new customer'),
        );

        return $form;
    }

    /**
     * Validates the customer email 
     * and optional customer website.
     * 
     * @param array $form
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     * 
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);

        $email = $form_state->getValue('customer_email');
        $website = $form_state->getValue('customer_website');

        /**
         * Check first if the customer website is provided.
         */
        if ($website != null) {
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
                $form_state->setErrorByName('customer_website', $this->t('The website provided for the customer is not valid.'));
            }
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set an error for the form element with a key of "title".
            $form_state->setErrorByName('customer_email', $this->t('The email must contain local part, \'@\' and domain.'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {

        $this->messenger->addMessage('customer_name: '.$form_state->getValue('customer_name'));
        $this->messenger->addMessage('customer_email: '.$form_state->getValue('customer_email'));
        $this->messenger->addMessage('customer_description: '.$form_state->getValue('customer_description'));
        $this->messenger->addMessage('customer_website: '.$form_state->getValue('customer_website'));
    
        // Redirect to home
        $form_state->setRedirect('<front>');
        return;
    }
}
?>