<?php

namespace Mirror\Core\Accounts\Entities;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use LaravelDoctrine\ORM\Notifications\Notifiable;
use Mirror\Core\Accounts\RegisteredEvent;
use Mirror\Core\BaseEntity;

class User extends BaseEntity implements Authenticatable, CanResetPassword
{
    use Notifiable;

    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string|null $remember_token = null;
    private Carbon $created_at;
    private Carbon $updated_at;

    public function __construct(
        string $name,
        string $email,
        string $password,
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = Hash::make($password);
    }

    public function getKey(): int
    {
        return $this->id;
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): int
    {
        return $this->id;
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken(): string|null
    {
        return $this->remember_token;
    }

    public function setRememberToken($value): void
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }

    public function getEmailForPasswordReset(): string
    {
        return $this->email;
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    public static function register(string $name, string $email, string $password): self
    {
        $user = new self($name, $email, $password);

        $user->raise(new RegisteredEvent($user));

        return $user;
    }

    public function resetPassword(string $password): void
    {
        $this->password = Hash::make($password);
        $this->remember_token = Str::random(60);
    }

    public function getEmailAddress(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
