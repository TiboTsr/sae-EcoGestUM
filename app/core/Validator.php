<?php

namespace App\Core;

/**
 * Classe de validation serveur pour formulaires et données
 */
class Validator
{
    private array $errors = [];

    /**
     * Valide une adresse email
     */
    public function email(string $email, string $fieldName = 'email'): self
    {
        if (empty($email)) {
            $this->errors[] = "{$fieldName} est requis.";
            return $this;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "{$fieldName} n'est pas valide.";
        }
        return $this;
    }

    /**
     * Valide un mot de passe (min 8 caractères, au moins 1 chiffre et 1 lettre)
     */
    public function password(string $password, string $fieldName = 'password'): self
    {
        if (empty($password)) {
            $this->errors[] = "{$fieldName} est requis.";
            return $this;
        }
        if (strlen($password) < 8) {
            $this->errors[] = "{$fieldName} doit contenir au moins 8 caractères.";
            return $this;
        }
        if (!preg_match('/[0-9]/', $password)) {
            $this->errors[] = "{$fieldName} doit contenir au moins 1 chiffre.";
            return $this;
        }
        if (!preg_match('/[a-zA-Z]/', $password)) {
            $this->errors[] = "{$fieldName} doit contenir au moins 1 lettre.";
            return $this;
        }
        return $this;
    }

    /**
     * Valide qu'un champ n'est pas vide
     */
    public function required(string $value, string $fieldName = 'field'): self
    {
        if (empty(trim($value))) {
            $this->errors[] = "{$fieldName} est requis.";
        }
        return $this;
    }

    /**
     * Valide la longueur minimale
     */
    public function minLength(string $value, int $min, string $fieldName = 'field'): self
    {
        if (strlen($value) < $min) {
            $this->errors[] = "{$fieldName} doit contenir au moins {$min} caractères.";
        }
        return $this;
    }

    /**
     * Valide la longueur maximale
     */
    public function maxLength(string $value, int $max, string $fieldName = 'field'): self
    {
        if (strlen($value) > $max) {
            $this->errors[] = "{$fieldName} ne doit pas dépasser {$max} caractères.";
        }
        return $this;
    }

    /**
     * Valide qu'une valeur est dans une liste autorisée
     */
    public function in(mixed $value, array $allowed, string $fieldName = 'field'): self
    {
        if (!in_array($value, $allowed, true)) {
            $this->errors[] = "{$fieldName} n'est pas valide.";
        }
        return $this;
    }

    /**
     * Valide qu'une valeur est numérique
     */
    public function numeric(mixed $value, string $fieldName = 'field'): self
    {
        if (!is_numeric($value)) {
            $this->errors[] = "{$fieldName} doit être un nombre.";
        }
        return $this;
    }

    /**
     * Valide qu'une valeur est un entier
     */
    public function integer(mixed $value, string $fieldName = 'field'): self
    {
        if (!is_int($value) && !ctype_digit((string)$value)) {
            $this->errors[] = "{$fieldName} doit être un entier.";
        }
        return $this;
    }

    /**
     * Valide qu'une URL est valide
     */
    public function url(string $url, string $fieldName = 'url'): self
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->errors[] = "{$fieldName} n'est pas une URL valide.";
        }
        return $this;
    }

    /**
     * Retourne vrai si validation réussie (pas d'erreurs)
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Retourne le tableau des erreurs
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Retourne les erreurs comme chaîne (pour affichage rapide)
     */
    public function getErrorsAsString(string $separator = ', '): string
    {
        return implode($separator, $this->errors);
    }

    /**
     * Ajoute une erreur personnalisée
     */
    public function addError(string $message): self
    {
        $this->errors[] = $message;
        return $this;
    }
}
?>
