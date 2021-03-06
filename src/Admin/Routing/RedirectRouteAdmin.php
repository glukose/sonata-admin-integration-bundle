<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SonataAdminIntegrationBundle\Admin\Routing;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\DoctrinePHPCRAdminBundle\Form\Type\TreeModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Cmf\Bundle\RoutingBundle\Model\Route;

class RedirectRouteAdmin extends Admin
{
    protected $translationDomain = 'CmfSonataAdminIntegrationBundle';

    /**
     * Root path for the route parent selection.
     *
     * @var string
     */
    protected $routeRoot;

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('path', 'text');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group_location', ['class' => 'col-md-3'])
                ->add(
                    'parentDocument',
                    TreeModelType::class,
                    ['choice_list' => [], 'select_root_node' => true, 'root_node' => $this->routeRoot]
                )
                ->add('name', TextType::class)
            ->end()

            ->with('form.group_target', ['class' => 'col-md-9'])
                ->add('routeName', TextType::class, ['required' => false])
                ->add('uri', TextType::class, ['required' => false])
                ->add(
                    'routeTarget',
                    TreeModelType::class,
                    ['choice_list' => [], 'required' => false, 'root_node' => $this->routeRoot]
                )
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', 'doctrine_phpcr_nodename');
    }

    public function setRouteRoot($routeRoot)
    {
        $this->routeRoot = $routeRoot;
    }

    public function getExportFormats()
    {
        return array();
    }

    public function toString($object)
    {
        return $object instanceof Route && $object->getId()
            ? $object->getId()
            : $this->trans('link_add', array(), 'SonataAdminBundle')
        ;
    }
}
