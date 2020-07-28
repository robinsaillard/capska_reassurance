<?php

declare(strict_types=1);

namespace Capska\CapskaReassurance\Repository;

use Doctrine\ORM\EntityRepository;
use Capska\CapskaReassurance\Entity\ReassuranceImage;

/**
 * Class ReassuranceImageRepository
 * @package Capska\Module\CapskaReassurance\Repository
 */
class ReassuranceImageRepository extends EntityRepository
{
    /**
     * @param $imageId
     * @param $imageName
     */
    public function upImage($imageId, $imageName)
    {
        $image = $this->findOneBy(['id_image' => $imageId]);
        if (!$image) {
            $image = new ReassuranceImage();
        }
        $image->setImageName($imageName);

        $em = $this->getEntityManager();
        $em->persist($image);
        $em->flush();
    }

    /**
     * @param ReassuranceImage $supplierExtraImage
     */
    public function deleteExtraImage(ReassuranceImage $image)
    {
        $em = $this->getEntityManager();
        if ($image) {
            $em->remove($image);
            $em->flush();
        }
    }
}