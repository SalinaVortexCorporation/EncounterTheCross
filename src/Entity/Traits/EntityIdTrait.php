<?php
/**
 * @Author: jwamser
 * @CreateAt: 2/25/23
 * Project: EncounterTheCross
 * File Name: AbstractEntity.php
 */

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use UuidFactory;

/**
 * @link https://titouangalopin.com/posts/4dzpjwHfpm0eqvNt9G0trK/auto-increment-is-the-devil-using-uuids-in-symfony-and-doctrine Why UUID & INT for our ID fields
 * @link https://medium.com/@galopintitouan/auto-increment-is-the-devil-using-uuids-in-symfony-and-doctrine-71763721b9a9 Why UUID & INT for our ID fields - (Medium)
 *
 * Using INT & UUID for the ID connections will allow better performance.
 * The idea here is that we will use INT as the AutoIncrement ID and then each will still
 * have a UUID.
 *
 * We will use the INT for joins in our queries as this is a performance boost. But in
 * public view we will display out the uuid.
 *
 * There are some additional tools we can implement/use to allow url friendly uuid's.
 * TODO: Create the UUID utility tools or use sluggable extension?
 */
trait EntityIdTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", options: ["unsigned" => true])]
    protected ?int $id;

    #[ORM\Column(type: "uuid", unique: true)]
    protected ?Uuid $rowPointer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\PrePersist]
    public function getRowPointer(): Uuid
    {
        return $this->rowPointer;
    }

    public function getBase32RowPointer(): string
    {
        return UuidFactory::getBase32RowPointer($this->rowPointer);
    }

    public function getRowPointerFromBase32(string $base): ?Uuid
    {
        return UuidFactory::getRowPointerFromBase32($base);
    }
}