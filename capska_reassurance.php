<?php

use Capska\CapskaReassurance\Menu\TabManager;
use Capska\CapskaReassurance\Entity\ReassuranceImage;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\Builder\FormBuilder;


/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Capska_reassurance extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'capska_reassurance';
        $this->tab = 'others';
        $this->version = '1.0.0';
        $this->author = 'Robin Saillard';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Reassurance Capska');
        $this->description = $this->l('Module d\'affichage des réassurances sur la page d\'accueil');

        $this->confirmUninstall = $this->l('Êtes-vous sûr de vouloir supprimer ce module ? ');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        
        
        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() && 
            TabManager::addTab('AdminReassuranceImage', 'Test', 'capska_reassurance', 'AdminTools', 'storage') && 
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        

        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitCapska_reassuranceModule')) == true) {
            $this->postProcess();
        }
        $link = Context::getContext()->link;
        
        $url = $link->getAdminLink('AdminReassuranceImageFormClass');
        $this->context->smarty->assign('url', $url);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
 
        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {

    }
    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Enter a valid email address'),
                        'name' => 'CAPSKA_REASSURANCE_ACCOUNT_EMAIL',
                        'label' => $this->l('Email'),
                    ),
                    array(
                        'type' => 'password',
                        'name' => 'CAPSKA_REASSURANCE_ACCOUNT_PASSWORD',
                        'label' => $this->l('Password'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'CAPSKA_REASSURANCE_LIVE_MODE' => Configuration::get('CAPSKA_REASSURANCE_LIVE_MODE', true),
            'CAPSKA_REASSURANCE_ACCOUNT_EMAIL' => Configuration::get('CAPSKA_REASSURANCE_ACCOUNT_EMAIL', 'contact@prestashop.com'),
            'CAPSKA_REASSURANCE_ACCOUNT_PASSWORD' => Configuration::get('CAPSKA_REASSURANCE_ACCOUNT_PASSWORD', null),
        );
    }

    /**
     * Save form data. 
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayHome()
    {
        /* Place your code here. */
    }


        public function test(array $params)
    {
        /** @var ReassuranceImageRepository $img_repo */
        $img_repo = $this->get(
            'capska.capskareassurance.repository.image_repository'
        );

        $translator = $this->getTranslator();
        /** @var FormBuilderInterface $formBuilder */
        $formBuilder = $params['form_builder'];
        // we add to the Symfony form an `upload_image_file` field that will be used by BO user to upload image files
        $formBuilder
            ->add('upload_image_file', FileType::class, [
                'label' => $translator->trans('Upload image file', [], 'Modules.CaspkaReassurance'),
                'required' => false,
            ]);

        /** @var ReassuranceImage $image */
        $image = $img_repo->findOneBy(['id_image' => $params['id']]);
        if ($image && file_exists(_PS_SUPP_IMG_DIR_ . $image->getImageName())) {
            // When an image is already registered for this supplier, we add to the Symfony an
            // 'image_file' to provide a preview input to BO user and also provide a "delete button"
            $formBuilder
                ->add('image_file', CustomContentType::class, [
                    'required' => false,
                    'template' => '@Modules/capska_reassurance/src/View/upload_image.html.twig',
                    'data' => [
                        'supplierId' => $params['id'],
                        'imageUrl' => self::SUPPLIER_EXTRA_IMAGE_PATH . $image->getImageName(),
                    ],
                ]);
        }

    }

    /**
     * @param array $params
     */
    private function uploadImage(array $params): void
    {
        /** @var ImageUploaderInterface $image */
        $image = $this->get(
            'capska.capskareassurance.uploader.image_uploader'
        );

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $params['form_data']['upload_image_file'];

        if ($uploadedFile instanceof UploadedFile) {
            $image->upload($params['id'], $uploadedFile);
        }
    }

}
