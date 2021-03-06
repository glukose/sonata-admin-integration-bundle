<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SonataAdminIntegrationBundle\Admin\Routing\Extension;

use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;

/**
 * Admin extension to add routes tab to content implementing the
 * RouteReferrersInterface.
 *
 * @author David Buchmann <mail@davidbu.ch>
 */
class RouteReferrersExtension extends AbstractAdminExtension
{
    private $formGroup;
    private $formTab;

    public function __construct($formGroup = 'form.group_routes', $formTab = 'form.tab_routing')
    {
        $this->formGroup = $formGroup;
        $this->formTab = $formTab;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        if ($formMapper->hasOpenTab()) {
            $formMapper->end();
        }

        $formMapper
            ->tab($this->formTab)
                ->with('form.group_routes', ['translation_domain' => 'CmfSonataAdminIntegrationBundle'])
                    ->add(
                        'routes',
                        CollectionType::class,
                        ['label' => false],
                        [
                            'edit' => 'inline',
                            'inline' => 'table',
                        ]
                    )
                ->end()
            ->end()
        ;
    }
}
