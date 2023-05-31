<?php
declare(strict_types=1);

class Account {
    public int $id;
    public string $username;
    public string $email;
    public ?string $name;
    public ?int $balance;
    public ?DateTime $datecreated;

    public function __construct(int $id, string $username, string $email, ?string $name = null, ?int $balance = null, ?DateTime $datecreated = null) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
        $this->balance = $balance;
        $this->datecreated = $datecreated;
    }

    public static function login(PDO $db, string $usernameOrEmail, string $password): ?Account {
        $stmt = $db->prepare('SELECT id, username, email, name, balance, datecreated
        FROM Account
        WHERE (username = ? OR email = ?) AND password = ?');

        $stmt->execute([$usernameOrEmail, $usernameOrEmail, $password]);

        $account = $stmt->fetch();

        if ($account) {
            return new Account(
                intval($account['id']),
                $account['username'],
                $account['email'],
                $account['name'] ?? null,
                intval($account['balance']) ?? null,
                isset($account['datecreated']) ? new DateTime($account['datecreated']) : null
            );
        } else {
            return null;
        }
    }

    public static function signup(PDO $db, string $username, string $email, string $password): ?Account
    {
        $stmt = $db->prepare('select count(*) from Account where username = ? or email = ?');
        $stmt->execute([$username, $email]);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            $stmt = $db->prepare("
            insert into Account (username, email, password)
            values (?, ?, ?)
        ");

            $stmt->execute([$username, $email, $password]);

            $accountId = intval($db->lastInsertId());

            $account = new Account(
                $accountId,
                $username,
                $email
            );

            return $account;
        }

        return null;
    }

    // Getter functions
    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function getBalance(): ?int {
        return $this->balance;
    }

    public function getDateCreated(): ?DateTime {
        return $this->datecreated;
    }

    // Setter functions
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setName(?string $name): void {
        $this->name = $name;
    }

    public function setBalance(?int $balance): void {
        $this->balance = $balance;
    }

    public function setDateCreated(?DateTime $datecreated): void {
        $this->datecreated = $datecreated;
    }
}
?>
