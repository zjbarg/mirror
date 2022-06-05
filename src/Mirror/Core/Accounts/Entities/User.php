<?php

namespace Mirror\Core\Accounts\Entities;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mirror\Core\Accounts\Events\PasswordReset;
use Mirror\Core\Accounts\Events\Registered;
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
        $user = new self;
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);

        $user->raise(new Registered($user));

        return $user;
    }

    public function resetPassword(string $password): void
    {
        $this->password = Hash::make($password);
        $this->remember_token = Str::random(60);

        $this->raise(new PasswordReset($this));
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
