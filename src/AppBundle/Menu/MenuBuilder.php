<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 14/02/18
 * Time: 12:36
 */

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;
    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options): \Knp\Menu\ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', array('route' => 'homepage'));
        // ... add more children

        return $menu;
    }
}
