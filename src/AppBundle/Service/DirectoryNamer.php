<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Document;
use AppBundle\Entity\User;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class DirectoryNamer implements DirectoryNamerInterface
{
    /**
     * Returns the name of a directory where files will be uploaded.
     *
     * Directory name is formed based on user ID and media type
     *
     * @param                 $object
     * @param PropertyMapping $mapping
     *
     * @return string
     */
    public function directoryName($object, PropertyMapping $mapping):string
    {
        /** @var Calendar $calendar */
        $calendar = $object->getCalendar();

        /** @var User $user */
        $user = $calendar->getUser();

        return $user->getUsername().'/'.$calendar->getYear().'/';
    }
}
