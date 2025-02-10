<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function get_user()
    {
        $query = DB::table("users")
            // ->select("users.*", "roles.name as roles_name")
            ->select("users.*")
            ->join("model_has_roles", "users.id", "=", "model_has_roles.model_id")
            ->join("roles", "model_has_roles.role_id", "=", "roles.id")
            ->whereNotIn("roles.name", ["developer", "superadmin"])
            ->distinct()->get();
        return $query;
    }

    public static function get_user_roles(int $user_id)
    {
        $query = DB::table("model_has_roles")
            ->select("roles.name", "roles.id")
            ->join("roles", "model_has_roles.role_id", "=", "roles.id")
            ->whereRaw("model_id='$user_id'")
            ->get()->toArray();

        return $query;
    }


    public static function insert_user(array $datas, array $roles)
    {
        try {
            $query = self::create($datas);
            $last_id = $query->id;
            $user = self::find($last_id);
            $user->assignRole($roles);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public static function update_user(int $id, array $datas, array $roles = [])
    {
        try {
            self::where("id", $id)
                ->update($datas);
            if ($roles) {
                $user = self::find($id);
                $user->syncRoles($roles);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function delete_user(int $id)
    {
        try {
            $user = self::find($id);
            $user->syncRoles([]);

            self::where("id", $id)
                ->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function get_visible_user()
    {
        $query = User::select("users.name", "users.id")
            ->join("model_has_roles", "users.id", "=", "model_has_roles.model_id")
            ->join("roles", "model_has_roles.role_id", "=", "roles.id")
            ->whereRaw("roles.name NOT IN ('developer', 'superadmin')")->get();
        return $query;
    }


    public static function getUserByRole($roleName = 'dokter', $search = null)
    {
        $query = DB::table("users")
            ->select("users.id", "users.name", "users.username")
            ->join("model_has_roles", "users.id", "=", "model_has_roles.model_id")
            ->join("roles", "model_has_roles.role_id", "=", "roles.id")
            ->where("roles.name", $roleName)
            ->whereNotIn("roles.name", ["developer", "superadmin"]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.username', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }
}
