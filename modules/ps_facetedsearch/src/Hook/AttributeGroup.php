<?php
/**
 * 2007-2019 PrestaShop.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\Module\FacetedSearch\Hook;

use Language;
use Tools;

class AttributeGroup extends AbstractHook
{
    const AVAILABLE_HOOKS = [
        'actionAttributeGroupDelete',
        'actionAttributeGroupSave',
        'displayAttributeGroupForm',
        'displayAttributeGroupPostProcess',
    ];

    /**
     * After save Attributes group
     *
     * @param array $params
     */
    public function actionAttributeGroupSave(array $params)
    {
        if (empty($params['id_attribute_group']) || Tools::getValue('layered_indexable') === false) {
            return;
        }

        $this->database->execute(
            'DELETE FROM ' . _DB_PREFIX_ . 'layered_indexable_attribute_group
            WHERE `id_attribute_group` = ' . (int) $params['id_attribute_group']
        );
        $this->database->execute(
            'DELETE FROM ' . _DB_PREFIX_ . 'layered_indexable_attribute_group_lang_value
            WHERE `id_attribute_group` = ' . (int) $params['id_attribute_group']
        );

        $this->database->execute(
            'INSERT INTO ' . _DB_PREFIX_ . 'layered_indexable_attribute_group (`id_attribute_group`, `indexable`)
VALUES (' . (int) $params['id_attribute_group'] . ', ' . (int) Tools::getValue('layered_indexable') . ')'
        );

        foreach (Language::getLanguages(false) as $language) {
            $seoUrl = Tools::getValue('url_name_' . (int) $language['id_lang']);

            if (empty($seoUrl)) {
                $seoUrl = Tools::getValue('name_' . (int) $language['id_lang']);
            }

            $this->database->execute(
                'INSERT INTO ' . _DB_PREFIX_ . 'layered_indexable_attribute_group_lang_value
                (`id_attribute_group`, `id_lang`, `url_name`, `meta_title`)
                VALUES (
                ' . (int) $params['id_attribute_group'] . ', ' . (int) $language['id_lang'] . ',
                \'' . pSQL(Tools::link_rewrite($seoUrl)) . '\',
                \'' . pSQL(Tools::getValue('meta_title_' . (int) $language['id_lang']), true) . '\')'
            );
        }
        $this->module->invalidateLayeredFilterBlockCache();
    }

    /**
     * After delete attribute group
     *
     * @param array $params
     */
    public function actionAttributeGroupDelete(array $params)
    {
        if (empty($params['id_attribute_group'])) {
            return;
        }

        $this->database->execute(
            'DELETE FROM ' . _DB_PREFIX_ . 'layered_indexable_attribute_group
            WHERE `id_attribute_group` = ' . (int) $params['id_attribute_group']
        );
        $this->database->execute(
            'DELETE FROM ' . _DB_PREFIX_ . 'layered_indexable_attribute_group_lang_value
            WHERE `id_attribute_group` = ' . (int) $params['id_attribute_group']
        );
        $this->module->invalidateLayeredFilterBlockCache();
    }

    /**
     * Post process attribute group
     *
     * @param array $params
     */
    public function displayAttributeGroupPostProcess(array $params)
    {
        $this->module->checkLinksRewrite($params);
    }

    /**
     * Attribute group form
     *
     * @param array $params
     *
     * @return string
     */
    public function displayAttributeGroupForm(array $params)
    {
        $values = [];
        $isIndexable = $this->database->getValue(
            'SELECT `indexable`
            FROM ' . _DB_PREFIX_ . 'layered_indexable_attribute_group
            WHERE `id_attribute_group` = ' . (int) $params['id_attribute_group']
        );

        // Request failed, force $isIndexable
        if ($isIndexable === false) {
            $isIndexable = true;
        }

        if ($result = $this->database->executeS(
            'SELECT `url_name`, `meta_title`, `id_lang` FROM ' . _DB_PREFIX_ . 'layered_indexable_attribute_group_lang_value
            WHERE `id_attribute_group` = ' . (int) $params['id_attribute_group']
        )) {
            foreach ($result as $data) {
                $values[$data['id_lang']] = ['url_name' => $data['url_name'], 'meta_title' => $data['meta_title']];
            }
        }

        $this->context->smarty->assign([
            'languages' => Language::getLanguages(false),
            'default_form_language' => (int) $this->context->controller->default_form_language,
            'values' => $values,
            'is_indexable' => (bool) $isIndexable,
        ]);

        return $this->module->render('attribute_group_form.tpl');
    }
}
