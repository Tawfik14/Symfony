<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\Email(message: "L'adresse email '{{ value }}' n'est pas valide.")]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    private ?string $lastname = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    private ?string $firstname = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotNull(message: "La date de naissance est obligatoire.")]
    private ?\DateTimeInterface $dob = null;

    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\Choice(choices: ['Homme', 'Femme', 'Autre'], message: "Le genre doit être 'Homme', 'Femme' ou 'Autre'.")]
    private ?string $gender = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank(message: "Le pseudo est obligatoire.")]
    private ?string $pseudo = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    // ✅ Getter et Setter pour ID
    public function getId(): ?int { return $this->id; }

    // ✅ Gestion de l'email
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    // ✅ Gestion du mot de passe
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }

    // ✅ Gestion du nom
    public function getLastname(): ?string { return $this->lastname; }
    public function setLastname(string $lastname): self { $this->lastname = $lastname; return $this; }

    // ✅ Gestion du prénom
    public function getFirstname(): ?string { return $this->firstname; }
    public function setFirstname(string $firstname): self { $this->firstname = $firstname; return $this; }

    // ✅ Gestion de la date de naissance
    public function getDob(): ?\DateTimeInterface { return $this->dob; }
    public function setDob(\DateTimeInterface $dob): self { $this->dob = $dob; return $this; }

    // ✅ Gestion du genre
    public function getGender(): ?string { return $this->gender; }
    public function setGender(string $gender): self { $this->gender = $gender; return $this; }

    // ✅ Gestion du pseudo
    public function getPseudo(): ?string { return $this->pseudo; }
    public function setPseudo(string $pseudo): self { $this->pseudo = $pseudo; return $this; }

    // ✅ Gestion des rôles
    public function getRoles(): array {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER'; // Assure qu'au moins "ROLE_USER" est présent
        return array_unique($roles);
    }

    public function setRoles(array $roles): self { 
        $this->roles = $roles; 
        return $this; 
    }

    // ✅ Identification de l'utilisateur par email ou pseudo
    public function getUserIdentifier(): string {
        return $this->email ?? $this->pseudo;
    }

    // ✅ Symfony attend parfois un getUsername()
    public function getUsername(): string {
        return $this->pseudo ?? $this->email;
    }

    // ✅ Effacer les informations sensibles (Symfony Security)
    public function eraseCredentials(): void {}

    // ✅ Permet d'afficher facilement un utilisateur sous forme de chaîne
    public function __toString(): string {
        return $this->firstname . ' ' . $this->lastname;
    }
}

