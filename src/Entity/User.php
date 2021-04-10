<?php

namespace App\Entity;

use App\Exception\ItemNotFoundException;
use App\Service\HashServiceInterface;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    use UserTrait;

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var DateTime|null
     */
    private $updatedAt;

    /**
     * @var ArrayCollection
     */
    private $items;

    public static function createFromCredentials(
        string $username,
        string $password,
        UserPasswordEncoderInterface $userPasswordEncoder
    ): self {
        $user = new User();
        $user->username = $username;
        $user->items = new ArrayCollection();
        $user->createdAt = new DateTimeImmutable('now');
        $user->updatedAt = new DateTimeImmutable('now');
        $user->changePassword($password, $userPasswordEncoder);
        return $user;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function changeUsername(string $username)
    {
        $this->username = $username;
    }

    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function changePassword(string $password, UserPasswordEncoderInterface $userPasswordEncoder): void
    {
        $this->password = $userPasswordEncoder->encodePassword($this, $password);
    }

    /**
     * @return Collection|Item[]
     */
    public function items(): Collection
    {
        return $this->items;
    }

    public function addItem(string $itemData, HashServiceInterface $hashService): void
    {
        $criteria = new Criteria();
        $criteria->andWhere(Criteria::expr()->eq('data', $itemData));

        if ($this->items()->matching($criteria)->isEmpty()) {
            $this->items()->add(Item::createFromData($this, $itemData, $hashService));
            $this->updatedAt = new DateTimeImmutable('now');
        }
    }

    public function updateItem(int $id, string $data, HashServiceInterface $hashService): void
    {
        $criteria = new Criteria();
        $criteria->andWhere(Criteria::expr()->eq('id', $id));
        $items = $this->items()->matching($criteria);

        foreach($items as $item) {
            $item->changeData($data, $hashService);
            $this->updatedAt = new DateTimeImmutable('now');
            return;
        }

        throw new ItemNotFoundException();
    }

    public function removeItem(int $id): void
    {
        $criteria = new Criteria();
        $criteria->andWhere(Criteria::expr()->eq('id', $id));
        $items = $this->items()->matching($criteria);

        foreach($items as $item) {
            $this->items()->removeElement($item);
            $this->updatedAt = new DateTimeImmutable('now');
            return;
        }

        throw new ItemNotFoundException();
    }
}
