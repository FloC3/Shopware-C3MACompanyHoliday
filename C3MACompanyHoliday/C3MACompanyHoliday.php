<?php
/**
 * Created by PhpStorm.
 * User: zinnecker
 * Date: 18.12.2018
 * Time: 10:02
 */

namespace C3MACompanyHoliday;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Shopware\Components\Theme\LessDefinition;

/**
 * Class C3MACompanyHoliday
 * @package C3MACompanyHoliday
 */
class C3MACompanyHoliday extends Plugin
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'preparePlugin',
            'Theme_Compiler_Collect_Plugin_Less' => 'onCollectPluginLess',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onPostDispatchFrontend'
        ];
    }

    /**
     * install plugin
     *
     * @param InstallContext $context
     */
    public function install(InstallContext $context)
    {
        parent::install($context);
    }

    /**
     * @param UpdateContext $context
     */
    public function update(UpdateContext $context)
    {
        $context->scheduleClearCache(UpdateContext::CACHE_LIST_ALL);
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(UninstallContext $context)
    {
        $context->scheduleClearCache(UninstallContext::CACHE_LIST_ALL);
    }

    /**
     * {@inheritdoc}
     */
    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
    }

    /**
     * prepare plugin
     */
    public function preparePlugin()
    {
        $this->registerTemplateDir();
    }

    /**
     * register template
     */
    private function registerTemplateDir()
    {
        $this->container->get('Template')->addTemplateDir($this->getPath() . '/Resources/Views/');
    }

    /**
     * do this for each frontend page
     *
     * @param \Enlight_Event_EventArgs $args
     */
    public function onPostDispatchFrontend(\Enlight_Event_EventArgs $args)
    {
        /** @var \Enlight_Controller_Action $controller */
        $controller = $args->getSubject();
        $view = $controller->View();

        $config = Shopware()
            ->Container()
            ->get('shopware.plugin.cached_config_reader')
            ->getByPluginName('C3MACompanyHoliday');

        $view->assign('C3MACompanyHoliday', $config);
    }

    /**
     * @return LessDefinition
     */
    public function onCollectPluginLess()
    {
        return new LessDefinition(
            [],
            [$this->getPath() . '/Resources/Views/frontend/_public/src/less/all.less']
        );
    }
}