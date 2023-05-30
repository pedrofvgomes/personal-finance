<?php
declare(strict_types=1);

class Account {
    public int $id;
    public string $username;
    public string $email;
    public string $name;
    public int $balance;
    public DateTime $datecreated;

    public function __construct(int $id, string $username, string $email, string $name, int $balance, DateTime $datecreated) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
        $this->balance = $balance;
        $this->datecreated = $datecreated;
    }

    public static function login(PDO $db, string $usernameOrEmail, string $password): ?Account {
        try {
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
                    $account['name'],
                    intval($account['balance']),
                    new DateTime($account['datecreated'])
                );
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Handle the exception
            // Log or display an error message
            return null;
        }
    }

    public static function signup(PDO $db, string $username, string $email, string $password): ?int {
        try {
            $stmt = $db->prepare('SELECT count(*)
            FROM Account
            WHERE username = ? OR email = ?');

            $stmt->execute([$username, $email]);

            $count = $stmt->fetchColumn();

            if (!$count) {
                $stmt = $db->prepare('INSERT INTO Account (username, email) VALUES (?, ?)');

                $stmt->execute([$username, $email]);

                return intval($db->lastInsertId());
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Handle the exception
            // Log or display an error message
            return null;
        }
    }
}
?>