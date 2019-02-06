<?php

namespace ContactUs\Service;

use ContactUs\Filter\ContactUsFilter;
use ContactUs\Mapper\ContactUsMapper;
use Interop\Container\ContainerInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

/**
 * Class ContactUsServiceFactory
 *
 * @package ContactUs\Service
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUsServiceFactory
{
    /**
     * @param  ContainerInterface $container
     *
     * @return ContactUsService
     */
    public function __invoke(ContainerInterface $container)
    {
        // Create pagination object
        $contactUsMapper   = $container->get(ContactUsMapper::class);
        $select            = $contactUsMapper->getPaginationSelect();
        $pagination        = new Paginator((
            new DbSelect(
                $select,
                $contactUsMapper->getAdapter(),
                $contactUsMapper->getResultSetPrototype()
            )
        ));

        return new ContactUsService(
            $container->get(ContactUsFilter::class),
            $container->get(ContactUsMapper::class),
            $pagination
        );
    }
}