<?php

namespace App\DTO;

use App\ImmutableValue\Language;
use Symfony\Component\Validator\Constraints as Assert;

class Onboarding
{
    /**
     * @var array<Language>
     */
    #[Assert\Count(min: 1, minMessage: 'You must select at least one language.')]
    private array $languages = [Language::English];

    /**
     * @return array<Language>
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        $this->languages[] = $language;

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        $key = array_search($language, $this->languages);
        if (false !== $key) {
            unset($this->languages[$key]);
        }

        return $this;
    }

    /**
     * @param array<Language> $languages
     */
    public function setLanguages(array $languages): self
    {
        $this->languages = $languages;

        return $this;
    }
}
