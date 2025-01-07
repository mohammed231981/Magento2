<?php declare(strict_types = 1);

namespace Sandbox\Post\Api\Data;

/**
 * Interface PostInterface
 */
interface PostInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;


    /**
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void;


    /**
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;


}
